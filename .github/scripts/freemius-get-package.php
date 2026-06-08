<?php

/**
 * Fetch the latest Freemius version and a signed download URL for a plugin.
 *
 * Expects the following environment variables:
 *   FREEMIUS_USER_ID, FREEMIUS_PUBLIC_KEY, FREEMIUS_SECRET_KEY,
 *   FREEMIUS_LICENSE_KEY, FREEMIUS_PLUGIN_ID, FREEMIUS_SITE_URL
 *
 * Writes `version`, `download_url` and `install_id` to $GITHUB_OUTPUT.
 */

$user_id     = getenv("FREEMIUS_USER_ID");
$public_key  = getenv("FREEMIUS_PUBLIC_KEY");
$secret_key  = getenv("FREEMIUS_SECRET_KEY");
$license_key = getenv("FREEMIUS_LICENSE_KEY");
$plugin_id   = getenv("FREEMIUS_PLUGIN_ID");

function base64url_encode($input) {
    return str_replace("=", "", strtr(base64_encode($input), "+/", "-_"));
}

function freemius_api($scope, $scope_id, $public, $secret, $path, $method = "GET", $body = null) {
    $bases = [
        "user"    => "/users/$scope_id",
        "install" => "/installs/$scope_id",
    ];
    $resource = "/v1" . $bases[$scope] . "/" . ltrim($path, "/");

    $date         = gmdate("r");
    $content_md5  = "";
    $content_type = "";
    if (in_array($method, ["POST", "PUT"]) && $body) {
        $content_type = "application/json";
        $content_md5  = md5($body);
    }

    $string_to_sign = implode("\n", [$method, $content_md5, $content_type, $date, $resource]);
    $sig  = base64url_encode(hash_hmac("sha256", $string_to_sign, $secret));
    $auth = "FS $scope_id:$public:$sig";

    $headers = ["Authorization: $auth", "Date: $date"];
    if ($body) $headers[] = "Content-Type: application/json";

    $ch = curl_init("https://api.freemius.com" . $resource);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($body) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    $code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ["code" => $code, "body" => json_decode($result)];
}

function freemius_signed_url($scope_id, $public, $secret, $resource) {
    $date = gmdate("r");
    $string_to_sign = implode("\n", ["GET", "", "", $date, $resource]);
    $sig  = base64url_encode(hash_hmac("sha256", $string_to_sign, $secret));
    $auth = "FS $scope_id:$public:$sig";

    return "https://api.freemius.com" . $resource .
        "?is_premium=true" .
        "&authorization=" . urlencode($auth) .
        "&auth_date=" . urlencode($date);
}

// 1. Get latest version from tags
$res = freemius_api("user", $user_id, $public_key, $secret_key, "plugins/$plugin_id/tags.json");
if ($res["code"] !== 200 || !isset($res["body"]->tags[0])) {
    fwrite(STDERR, "Failed to fetch tags\n");
    exit(1);
}
$latest = $res["body"]->tags[0];
$version = $latest->version;
echo "Latest version: $version\n";

// 2. Delete any pre-existing installs for this URL so we do not accumulate
//    one record per CI run. Freemius does not allow updating a stale install
//    without its (unstored) credentials, so we delete and recreate.
$site_url = getenv("FREEMIUS_SITE_URL");
$res = freemius_api("user", $user_id, $public_key, $secret_key,
    "plugins/$plugin_id/installs.json?search=" . urlencode($site_url));
if ($res["code"] === 200 && !empty($res["body"]->installs)) {
    $needle = rtrim(preg_replace("#^https?://#", "", $site_url), "/");
    foreach ($res["body"]->installs as $i) {
        $haystack = rtrim(preg_replace("#^https?://#", "", $i->url ?? ""), "/");
        if ($haystack !== $needle) continue;
        $del = freemius_api("user", $user_id, $public_key, $secret_key,
            "plugins/$plugin_id/installs/{$i->id}.json", "DELETE");
        if (!in_array($del["code"], [200, 204])) {
            fwrite(STDERR, "Warning: failed to delete stale install {$i->id}: " . json_encode($del["body"]) . "\n");
        } else {
            echo "Deleted stale install: {$i->id}\n";
        }
    }
}

// 3. Register an install to get download credentials
$install_data = json_encode([
    "url"         => $site_url,
    "title"       => "CI",
    "version"     => $version,
    "license_key" => $license_key,
    "is_premium"  => true,
    "language"    => "en-US",
]);

$res = freemius_api("user", $user_id, $public_key, $secret_key,
    "plugins/$plugin_id/installs.json", "POST", $install_data);

if (!in_array($res["code"], [200, 201]) || !isset($res["body"]->id)) {
    fwrite(STDERR, "Failed to register install: " . json_encode($res["body"]) . "\n");
    exit(1);
}

$install_id = $res["body"]->id;
$install_pk = $res["body"]->public_key;
$install_sk = $res["body"]->secret_key;
echo "Install registered: $install_id\n";

// 4. Generate signed download URL
$download_url = freemius_signed_url(
    $install_id, $install_pk, $install_sk,
    "/v1/installs/$install_id/updates/latest.zip"
);

// 5. Write outputs
$output = getenv("GITHUB_OUTPUT");
file_put_contents($output, "version=$version\n", FILE_APPEND);
file_put_contents($output, "download_url=$download_url\n", FILE_APPEND);
file_put_contents($output, "install_id=$install_id\n", FILE_APPEND);
