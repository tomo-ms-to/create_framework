<?php

namespace Core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app; // 静的プロパティでインスタンスを保持

    public function __construct()
    {
        self::$app = $this; // インスタンスを静的プロパティに保存
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}