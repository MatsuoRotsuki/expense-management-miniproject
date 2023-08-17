<?php
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/DashboardController.php';
require_once 'app/controllers/ExpenseController.php';
require_once 'app/middlewares/AuthMiddleware.php';

class Route
{
    private static $routes = [];

    public static function get($uri, $action)
    {
        self::$routes[] = ['GET', $uri, $action];
    }

    public static function post($uri, $action)
    {
        self::$routes[] = ['POST', $uri, $action];
    }

    public static function put($uri, $action)
    {
        self::$routes[] = ['PUT', $uri, $action];
    }

    public static function delete($uri, $action)
    {
        self::$routes[] = ['DELETE', $uri, $action];
    }

    public static function middleware($middlewareClass)
    {
        $lastRouteIndex = count(self::$routes) - 1;
        self::$routes[$lastRouteIndex]['middleware'] = $middlewareClass;
    }

    public static function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            [$routeMethod, $routeUri, $action] = $route;

            $routeUri = "/expense-management-miniproject" . $routeUri;

            if ($routeMethod === $method &&  self::matchUrl($routeUri, $uri)) {
                $middlewareClass = $route['middleware'] ?? null;
                if ($middlewareClass) {
                    $middleware = new $middlewareClass();
                    if ($middleware->handle() === false) {
                        $middleware->fail();
                        return;
                    }
                }

                [$controller, $method] = $action;
                $newController = new $controller;
                $parameters = self::extractParameters($routeUri, $uri);
                call_user_func([$newController, $method], ...$parameters);
                return;
            }
        }
    }

    private static function matchUrl($routeUrl, $requestedUrl)
    {
        $routeParts = explode('/', $routeUrl);
        $requestedParts = explode('/', $requestedUrl);

        if (count($routeParts) !== count($requestedParts)) {
            return false;
        }

        for ($i = 0; $i < count($routeParts); $i++) {
            if ($routeParts[$i] !== $requestedParts[$i] && !self::isParameter($routeParts[$i])) {
                return false;
            }
        }

        return true;
    }

    private static function isParameter($part)
    {
        return strpos($part, ':') === 0;
    }

    private static function extractParameters($routeUrl, $requestedUrl)
    {
        $parameters = [];
        $routeParts = explode('/', $routeUrl);
        $requestedParts = explode('/', $requestedUrl);

        for ($i = 0; $i < count($routeParts); $i++) {
            if (self::isParameter($routeParts[$i])) {
                $parameterName = ltrim($routeParts[$i], ':');
                $parameters[$parameterName] = $requestedParts[$i];
            }
        }

        return $parameters;
    }
}
