<?php

namespace Core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            return '404 Not Found'; // 適切なエラーページなどをレンダリングしても良い
        }

        if (is_string($callback)) {
            // 例: 'HomeController@index' 形式の場合
            list($controllerName, $methodName) = explode('@', $callback);
            $controllerClass = 'App\\Controllers\\' . $controllerName;
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $methodName)) {
                    return call_user_func_array([$controllerInstance, $methodName], []);
                }
            }
        } elseif (is_array($callback)) {
            // 例: [Controller::class, 'method'] 形式の場合（今回はHomeController@indexで実装）
            // array($controllerInstance, $methodName) の形式
            $controller = new $callback[0]();
            return call_user_func_array([$controller, $callback[1]], []);
        } elseif (is_callable($callback)) {
            // クロージャの場合
            return call_user_func($callback);
        }

        $this->response->setStatusCode(500);
        return 'Internal Server Error';
    }
}