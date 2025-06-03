<?php

namespace App\Controllers;

use Core\Application; // Applicationクラスを使用するため
use App\Models\User; // Userモデルを使用するため

class HomeController
{
    public function index()
    {
        // ビューをレンダリング
        return $this->render('home', ['name' => 'World']);
    }

    public function users()
    {
        $users = (new User())->findAll(); // Userモデルから全ユーザーを取得
        return $this->render('users', ['users' => $users]);
    }

    public function addUser()
    {
        $requestBody = Application::$app->request->getBody();
        if (Application::$app->request->getMethod() === 'post') {
            $user = new User();
            $user->name = $requestBody['name'] ?? '';
            $user->email = $requestBody['email'] ?? '';
            
            if ($user->save()) {
                Application::$app->response->setStatusCode(302); // Redirect
                header('Location: /users');
                exit;
            } else {
                return "ユーザーの追加に失敗しました。";
            }
        }
        return $this->render('addUser');
    }


    protected function render(string $view, array $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once __DIR__ . '/../Views/layouts/main.php'; // レイアウトファイルのパス
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value; // 変数として展開
        }
        ob_start();
        include_once __DIR__ . '/../Views/' . $view . '.php';
        return ob_get_clean();
    }
}