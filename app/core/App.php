<?php
require_once 'app/routes/Router.php';

class App
{
    public function __construct()
    {
        try {
            Router::run();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
