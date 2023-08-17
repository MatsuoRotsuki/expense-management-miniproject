<?php
require_once 'app/routes/Route.php';

class App
{
    public function __construct()
    {
        try {
            Route::get('/', ['AuthController', 'login']);
            Route::get('/login', ['AuthController', 'login']);
            Route::get('/signup', ['AuthController', 'signup']);
            Route::post('/login', ['AuthController', 'login']);
            Route::post('/signup', ['AuthController', 'signup']);

            Route::post('/logout', ['AuthController', 'logout']);
            Route::get('/logout', ['AuthController', 'logout']);

            Route::get('/dashboard', ['DashboardController', 'show']);
            Route::middleware('AuthMiddleware');

            Route::get('/expense/:id', ['ExpenseController', 'get']);
            Route::middleware('AuthMiddleware');

            Route::run();
        } catch (\Throwable $th) {
            // require_once 'app/views/404.php';
            echo $th->getMessage();
        }
    }

    // public function parseUrl()
    // {
    //     if (isset($_GET['url'])) {

    //         return explode('/', rtrim($_GET['url']));
    //     }
    // }
}
