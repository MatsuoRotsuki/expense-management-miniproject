<?php
require_once 'app/utils/Cipher.php';
require_once 'app/middlewares/Middleware.php';

class AuthMiddleware implements Middleware
{
    public function handle()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return;
        }

        if (isset($_COOKIE['remember_token'])) {
            $rememberToken = $_COOKIE['remember_token'];

            $user_id = Cipher::getUserIdFromRememberToken($rememberToken);

            if ($user_id == null) {
                $this->fail();
                return;
            }

            $user = User::where(['id' => $user_id]);
            if ($user == null) {
                $this->fail();
                return;
            }

            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['first_name'] = $user[0]['first_name'];
            $_SESSION['last_name'] = $user[0]['last_name'];
            return;
        }

        $this->fail();
        return;
    }

    public function fail()
    {
        $redirect_url = "http://localhost/expense-management-miniproject/login";
        header("Location: " . $redirect_url);
        return;
    }
}
