<?php
require_once 'app/routes/Route.php';

class Router
{
    private static $instance;

    private function __construct()
    {
        Route::get('/', ['AuthController', 'login']);
        Route::get('/login', ['AuthController', 'login']);
        Route::get('/signup', ['AuthController', 'signup']);
        Route::post('/login', ['AuthController', 'login']);
        Route::post('/signup', ['AuthController', 'signup']);

        Route::post('/logout', ['AuthController', 'logout']);
        Route::get('/logout', ['AuthController', 'logout']);

        Route::get('/dashboard', ['DashboardController', 'show']);
        Route::middleware('AuthMiddleware');

        Route::get('/expense/:id', ['ExpenseController', 'show']);
        Route::middleware('AuthMiddleware');

        Route::get('/create-expense', ['ExpenseController', 'createForm']);
        Route::middleware('AuthMiddleware');

        Route::post('/create-expense', ['ExpenseController', 'store']);
        Route::middleware('AuthMiddleware');

        Route::get('/update-expense/:id', ['ExpenseController', 'editForm']);
        Route::middleware('AuthMiddleware');

        Route::post('/update-expense/:id', ['ExpenseController', 'update']);
        Route::middleware('AuthMiddleware');

        Route::get('/delete-expense/:id', ['ExpenseController', 'delete']);
        Route::middleware('AuthMiddleware');
    }

    public static function run()
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        Route::handle();
        return;
    }
}
