<?php
$basepath = dirname(__dir__) . DIRECTORY_SEPARATOR; // contient /var/www/

require_once $basepath . 'vendor/autoload.php';


$router = new App\Router($basepath . 'views');
$router->get('/', 'index', 'home')
        ->get('/categories', 'categories', 'categories')
        ->get('/article/[*:slug]-[i:id]', 'post/post', 'post')
        ->run();

