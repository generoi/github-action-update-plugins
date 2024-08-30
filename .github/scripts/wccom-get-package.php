<?php

/**
 * @see https://github.com/pronamic/woocommerce-subscriptions/tree/main/.github/scripts
 */

$productSlug = getenv('PRODUCT_SLUG');

function doRequest(string $endpoint, string $method = 'GET', string $body = null) {
  $accessToken = getenv('ACCESS_TOKEN');
  $accessTokenSecret = getenv('ACCESS_TOKEN_SECRET');

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
  $response = exec(sprintf(
    'curl -s -X %s %s -H %s -H %s %s',
    $method,
    $body ? '--data ' . escapeshellarg($body) : '',
    escapeshellarg('Authorization: Bearer ' . $accessToken),
    escapeshellarg('X-Woo-Signature: ' . $signature),
    escapeshellarg($endpoint.'?'.$query),
  ));
  return json_decode($response);
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
  echo 'Cannot find subscription'.PHP_EOL;
  exit(1);
}

$productId = $subscription->product_id;

$payload = [
  $productId => [
    'product_id' => $productId,
    'file_id' => '',
  ],
];

$body = json_encode([
  'products' => $payload,
]);

$response = doRequest(
  endpoint: 'https://woocommerce.com/wp-json/helper/1.0/update-check',
  method: 'POST',
  body: json_encode(['products' => $payload]),
);

echo json_encode($response->{$productId});
