<?php

class Router {
    public static $routes = array();

    public static function init() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        static::$routes["GET"] = array();
        static::$routes["POST"] = array();
        static::$routes["PUT"] = array();
        static::$routes["DELETE"] = array();
    }

    /**
     * Add a route to the router.
     *
     * @param string $method The HTTP method (e.g., GET, POST, PUT, DELETE).
     * @param string $path The path for the route.
     * @param callable $callback The callback function to handle the route.
     */
    public static function addRoute(string $method, string $path, callable $callback) {
        $method = strtoupper($method);
        static::$routes[$method][$path] = $callback;
    }

    /**
     * Dispatch a route.
     *
     * @param string $method The HTTP method (e.g., GET, POST, PUT, DELETE).
     * @param array $uri The URI to dispatch.
     */
    public static function dispatch(string $method, string $uri) {
        $method = strtoupper($method);
        $uri = explode("/", $uri);
        $uri = array_slice($uri, API_ROUTE_INDEX);
        $uri = "/" . implode("/", $uri);

        if ($uri == "/") {
            header("HTTP/1.0 200 OK");
            echo json_encode([
                "message" => "Welcome to the API",
                "method" => $method,
                "routes" => static::$routes
            ]);
            return;
        }

        if (!isset(static::$routes[$method][$uri])){
            header("HTTP/1.0 404 Not Found");
            echo json_encode([
                "message" => "Route not found : '$uri'",
                "method" => $method,
                "routes" => static::$routes
            ]);
            return;
        }

        call_user_func(static::$routes[$method][$uri]);
    }
}

?>
