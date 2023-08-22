<?php
class Cipher
{
    private static $key = 'abcd1234';
    private static $ivlen = 16;
    private static $algo = 'AES-256-CBC';

    public static function generateRememberToken($userId)
    {
        $plaintext = strval($userId);
        $iv = random_bytes(self::$ivlen);
        $ciphertext = openssl_encrypt($plaintext, self::$algo, self::$key, 0, $iv);
        $rememberToken = base64_encode($iv . $ciphertext);
        return $rememberToken;
    }

    public static function getUserIdFromRememberToken($ciphertext)
    {
        $rememberToken = base64_decode($ciphertext);
        $iv = substr($rememberToken, 0, self::$ivlen);
        $ciphertext = substr($rememberToken, self::$ivlen);
        $userId = openssl_decrypt($ciphertext, self::$algo, self::$key, 0, $iv);
        return $userId;
    }
}
