<?php
use App\Model\PostTable;

define("GENERATE_TIME_START", microtime(true));

$basepath = dirname(__dir__) . DIRECTORY_SEPARATOR; // contient /var/www/

require_once $basepath . 'vendor/autoload.php';
if (getenv("ENV_DEV")) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
// $basepath = /var/www/

$numPage = \App\URL::getPositiveInt("page");
if ($numPage !== null) {
    if ($numPage == 1) {
        $uri = explode('?', $_SERVER["REQUEST_URI"])[0];
        $get = $_GET;
        // retirer "page=" de l'url
        unset($get["page"]);
        $query = http_build_query($get);
        if (!empty($query)) {
            $uri = $uri . '?' . $query;
        }
        http_response_code(301);
        header('location: ' . $uri);
        exit();
    }
}

// définition des routes 
$router = new App\Router($basepath . 'views');
$router->get('/', 'post/index', 'home')
    ->get('/categories', 'category/index', 'categories')
    ->get('/contact', 'contact', 'contact')
    ->get('/article/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->run();
