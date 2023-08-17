<?php
require_once 'app/utils/Cipher.php';

class AuthMiddleware
{
    public static function handle()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        if (isset($_COOKIE['remember_token'])) {
            $rememberToken = $_COOKIE['remember_token'];

            $user_id = Cipher::getUserIdFromRememberToken($rememberToken);

            if ($user_id == null) {
                return false;
            }

            $user = User::where(['id' => $user_id]);
            if ($user == null) {
                return false;
            }

            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['first_name'] = $user[0]['first_name'];
            $_SESSION['last_name'] = $user[0]['last_name'];
            return true;
        }

        return false;
    }

    public static function fail()
    {
        $redirect_url = "http://localhost/expense-management-miniproject/login";
        header("Location: " . $redirect_url);
        return;
    }
}
