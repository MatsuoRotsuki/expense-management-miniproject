<?php
require_once 'app/core/Controller.php';
require_once 'app/models/User.php';
require_once 'app/utils/Validation.php';
require_once 'app/utils/Cipher.php';

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_POST['loginSubmit'])) {
            // Validation
            if (!Validation::validate([
                $_POST['email'] => '/^[\w.-]+@[\w.-]+\.\w+$/', // format email
                $_POST['password'] => '/^.{7,}$/',             // string length > 7
            ])) {
                $this->view('login', ['errorMessage' => 'Invalid field exists!']);
                return;
            }

            // Find user exist
            $user = User::where(['email' => $_POST['email'], 'password' => $_POST['password']]);
            if ($user == null) {
                $this->view('login', ['errorMessage' => 'User not found!']);
                return;
            }

            // set cookie
            $rememberToken = Cipher::generateRememberToken($user[0]['id']);
            setcookie("remember_token", $rememberToken, time() + (86400 * 30), "/"); // Thời hạn: 30 ngày

            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['first_name'] = $user[0]['first_name'];
            $_SESSION['last_name'] = $user[0]['last_name'];
            header("Location: dashboard");
            return;
        }

        $this->view('login');
        return;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        setcookie("remember_token", "", time() - 3600, "/");

        $redirect_url = "http://localhost/expense-management-miniproject/login";
        header("Location: " . $redirect_url);
        exit();
    }

    public function signup()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            header("Location: dashboard");
            return;
        }

        if (isset($_POST['signupSubmit'])) {
            // Validation
            if ($_POST['password'] != $_POST['confirmpassword']) {
                $this->view('signup', ['errorMessage' => 'Password and confirm password do not match!']);
                return;
            }

            if (!Validation::validate([
                $_POST['email'] => '/^[\w.-]+@[\w.-]+\.\w+$/', // format email
                $_POST['password'] => '/^.{7,}$/',             // string length > 7
                $_POST['confirmpassword'] => '/^.{7,}$/',             // string length > 7
                $_POST['firstname'] => '/^.{1,}$/',
                $_POST['lastname'] => '/^.{1,}$/'
            ])) {
                $this->view('signup', ['errorMessage' => 'Invalid field exists!']);
                return;
            }


            $user = User::where(['email' => $_POST['email']]);

            if ($user) {
                $this->view('signup', ['errorMessage' => 'Email already exists!']);
                return;
            }


            // Create new account
            $newUser = User::create([
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'first_name' => $_POST['firstname'],
                'last_name' => $_POST['lastname'],
            ]);

            $_SESSION['email'] = $newUser['email'];
            $_SESSION['user_id'] = $newUser['id'];
            header("Location: dashboard");
            return;
        }

        $this->view('signup');
    }
}
