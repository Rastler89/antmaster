<?php
$config = array(
    "curve_name" => "prime256v1",
    "private_key_type" => OPENSSL_KEYTYPE_EC,
);

$res = openssl_pkey_new($config);
if (!$res) {
    echo "Error: openssl_pkey_new failed. Errors:\n";
    while ($msg = openssl_error_string()) {
        echo $msg . "\n";
    }
    exit;
}

openssl_pkey_export($res, $privKey);
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

echo "VAPID Keys generated (PEM format):\n";
echo "PRIVATE:\n" . $privKey . "\n";
echo "PUBLIC:\n" . $pubKey . "\n";

// Convert to Base64Url for WebPush
// Note: minishlink uses a specific format, we might need to convert the point.
