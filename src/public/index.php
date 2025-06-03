<?php

require_once __DIR__ . '/../core/Application.php'; // Applicationクラスを最初にロード

// オートローダーの登録
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../'; // srcディレクトリを基準にする
    $classPath = str_replace('\\', '/', $class) . '.php'; // 名前空間の区切りをパス区切りに変換

    // 'App' 名前空間を 'app' ディレクトリにマッピング
    if (strpos($classPath, 'App/') === 0) {
        $classPath = str_replace('App/', 'app/', $classPath);
    }
    // 'Core' 名前空間を 'core' ディレクトリにマッピング
    if (strpos($classPath, 'Core/') === 0) {
        $classPath = str_replace('Core/', 'core/', $classPath);
    }

    if (file_exists($baseDir . $classPath)) {
        require_once $baseDir . $classPath;
    }
});

// アプリケーションの初期化
$app = new Core\Application();

// ルーティングの設定
$app->router->get('/', 'HomeController@index');
$app->router->get('/users', 'HomeController@users');
$app->router->get('/add-user', 'HomeController@addUser');
$app->router->post('/add-user', 'HomeController@addUser');

$app->run();