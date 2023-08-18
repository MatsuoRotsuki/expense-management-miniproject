<?php
require_once 'app/routes/Router.php';

class App
{
    public function __construct()
    {
        try {
            Router::run();
        } catch (\Throwable $th) {
            // require_once 'app/views/404.php';
            echo $th->getMessage();
        }
    }
}
