<?php

/**
 * @see https://github.com/pronamic/woocommerce-subscriptions/tree/main/.github/scripts
 */

$productSlug = getenv('PRODUCT_SLUG');

function fail(string $message): void {
  // Write to stderr so it shows up in the workflow log instead of being
  // redirected into $GITHUB_OUTPUT together with the package JSON.
  fwrite(STDERR, $message . PHP_EOL);
  exit(1);
}

function doRequest(string $endpoint, string $method = 'GET', ?string $body = null) {
  $accessToken = getenv('ACCESS_TOKEN');
  $accessTokenSecret = getenv('ACCESS_TOKEN_SECRET');

  if (! $accessToken || ! $accessTokenSecret) {
    fail('Missing ACCESS_TOKEN and/or ACCESS_TOKEN_SECRET. Check the repository/organization secrets.');
  }

  $data = [
    'host' => parse_url($endpoint, PHP_URL_HOST),
    'request_uri' => parse_url($endpoint, PHP_URL_PATH),
    'method' => $method,
  ];

  if ($body) {
    $data['body'] = $body;
  }

  $signature = hash_hmac('sha256', json_encode($data), $accessTokenSecret);
  $query = http_build_query(['token' => $accessToken, 'signature' => $signature]);

  // -w appends the HTTP status code so we can distinguish auth/server errors
  // from an empty body. -s silences progress, output is the body + status.
  $command = sprintf(
    'curl -s -w "\n%%{http_code}" -X %s %s -H %s -H %s %s',
    $method,
    $body ? '--data ' . escapeshellarg($body) : '',
    escapeshellarg('Authorization: Bearer ' . $accessToken),
    escapeshellarg('X-Woo-Signature: ' . $signature),
    escapeshellarg($endpoint . '?' . $query),
  );

  $output = [];
  $exitCode = 0;
  exec($command, $output, $exitCode);

  if ($exitCode !== 0) {
    fail(sprintf('curl request to %s failed with exit code %d.', $endpoint, $exitCode));
  }

  $httpStatus = (int) array_pop($output);
  $rawBody = implode("\n", $output);

  if ($httpStatus < 200 || $httpStatus >= 300) {
    fail(sprintf(
      'Request to %s returned HTTP %d. Response: %s',
      $endpoint,
      $httpStatus,
      $rawBody !== '' ? $rawBody : '(empty body)',
    ));
  }

  $decoded = json_decode($rawBody);

  if (json_last_error() !== JSON_ERROR_NONE) {
    fail(sprintf(
      'Failed to decode JSON response from %s: %s. Response: %s',
      $endpoint,
      json_last_error_msg(),
      $rawBody !== '' ? $rawBody : '(empty body)',
    ));
  }

  return $decoded;
}

if (! $productSlug) {
  fail('Missing PRODUCT_SLUG. Pass the plugin slug via the action `slug` input.');
}

$subscriptions = doRequest(
  endpoint: 'https://woocommerce.com/wp-json/helper/1.0/subscriptions',
  method: 'GET',
);

$subscription = array_reduce(
  (array) $subscriptions,
  fn ($carry, $subscription) => $subscription->zip_slug === $productSlug ? $subscription : $carry,
  null
);

if (! $subscription) {
  $availableSlugs = array_filter(array_map(
    fn ($subscription) => $subscription->zip_slug ?? null,
    (array) $subscriptions,
  ));
  sort($availableSlugs);

  fail(sprintf(
    "Cannot find subscription for slug '%s'.%s",
    $productSlug,
    $availableSlugs
      ? ' Available slugs on this account: ' . implode(', ', $availableSlugs)
      : ' No subscriptions were returned for this account (check the access token and that the subscription is active).',
  ));
}

$productId = $subscription->product_id;

$payload = [
  $productId => [
    'product_id' => $productId,
    'file_id' => '',
  ],
];

$response = doRequest(
  endpoint: 'https://woocommerce.com/wp-json/helper/1.0/update-check',
  method: 'POST',
  body: json_encode(['products' => $payload]),
);

if (! isset($response->{$productId})) {
  fail(sprintf(
    'update-check did not return package data for product ID %s. Response: %s',
    $productId,
    json_encode($response),
  ));
}

echo json_encode($response->{$productId});
