<?php
require_once 'app/core/Controller.php';
require_once 'app/models/User.php';
require_once 'app/utils/Validation.php';
require_once 'app/utils/Cipher.php';

class AuthController extends Controller
{
    public function login()
    {
        session_start();
        if (isset($_POST['loginSubmit'])) {
            // Validation
            $errors = Validation::validate($_POST, [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255|min:7',
            ]);

            if (count($errors) > 0) {
                $this->view('login', ['errorMessage' => $errors[0]]);
                return;
            }

            // Find user exist
            $user = User::where(['email' => $_POST['email']]);
            if ($user == null) {
                $this->view('login', ['errorMessage' => 'User not found!']);
                return;
            }
            if (!password_verify($_POST['password'], $user[0]['password'])) {
                $this->view('login', ['errorMessage' => 'Incorrect password']);
                return;
            }

            // set cookie
            if (isset($_POST['rememberMe'])) {
                $rememberToken = Cipher::generateRememberToken($user[0]['id']);
                setcookie("remember_token", $rememberToken, time() + (86400 * 30), "/"); // Thời hạn: 30 ngày
            }

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
        if (isset($_POST['signupSubmit'])) {
            // Validation
            $errors = Validation::validate($_POST, [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255|min:7',
                'confirmpassword' => 'required|max:255|min:7',
                'firstname' => 'required|max:255|min:1',
                'lastname' => 'required|max:255|min:1',
            ]);

            if (count($errors) > 0) {
                $this->view('signup', ['errorMessage' => $errors[0]]);
                return;
            }

            if ($_POST['password'] != $_POST['confirmpassword']) {
                $this->view('signup', ['errorMessage' => 'Password and confirm password do not match!']);
                return;
            }

            $user = User::where(['email' => $_POST['email']]);

            if ($user) {
                $this->view('signup', ['errorMessage' => 'Email already exists!']);
                return;
            }

            $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Create new account
            $newUser = User::create([
                'email' => $_POST['email'],
                'password' => $hashPassword,
                'first_name' => $_POST['firstname'],
                'last_name' => $_POST['lastname'],
            ]);

            $_SESSION['email'] = $newUser['email'];
            $_SESSION['user_id'] = $newUser['id'];
            $_SESSION['first_name'] = $newUser['first_name'];
            $_SESSION['last_name'] = $newUser['last_name'];
            header("Location: dashboard");
            return;
        }

        $this->view('signup');
    }
}
