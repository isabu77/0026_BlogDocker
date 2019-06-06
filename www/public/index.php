<?php
use App\Model\PostTable;

define ("GENERATE_TIME_START", microtime(true));

$basepath = dirname(__dir__) . DIRECTORY_SEPARATOR; // contient /var/www/

require_once $basepath . 'vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
// $basepath = /var/www/

if (isset($_GET["page"]) && ((int)$_GET["page"] <= 1 || !is_int((int)$_GET["page"]) || is_float($_GET["page"] + 0))) {
        // url /categories?page=1&parm2=pomme
        if ((int)$_GET["page"] == 1) {
            $uri = explode('?', $_SERVER["REQUEST_URI"])[0];
            $get = $_GET;
            unset($get["page"]);
            $query = http_build_query($get);
            if (!empty($query)) {
                $uri = $uri . '?' . $query;
            }
            http_response_code(301);
            header('location: ' . $uri);
            exit();
        } else {
            throw new Exception('numero de page non valide ;) petit pirate');
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