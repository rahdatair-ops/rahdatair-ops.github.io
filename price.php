
<?php
header('Content-Type: application/json; charset=utf-8');

$url = 'https://api1.tabdeal.org/r/api/v1/depth?symbol=USDTIRT';

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_HTTPHEADER => ['Accept: application/json']
]);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($result === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode(['error' => 'API unavailable']);
    exit;
}

$data = json_decode($result, true);

if (!isset($data['asks'][0][0])) {
    http_response_code(502);
    echo json_encode(['error' => 'Invalid API response']);
    exit;
}

echo json_encode(['price' => $data['asks'][0][0]]);
