<?php
function decryptData($data) {
    $encryption_key = 'your_secret_key'; // Use the same secret key
    $cipher_method = 'aes-256-cbc';
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2); // Separate the encrypted data and IV
    return openssl_decrypt($encrypted_data, $cipher_method, $encryption_key, 0, $iv);
}
?>
