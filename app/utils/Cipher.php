<?php
class Cipher
{
    private static $key = 'abcd1234';

    public static function generateRememberToken($userId)
    {
        $plaintext = strval($userId);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, self::$key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, self::$key, $as_binary = true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    public static function getUserIdFromRememberToken($ciphertext)
    {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, self::$key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, self::$key, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
        return null;
    }
}

// echo $ciphertext = Util::generateRememberToken(1);
// echo "\n";
// echo Util::getUserIdFromRememberToken($ciphertext);
