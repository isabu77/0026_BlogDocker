<?php
namespace App;

use \App\Controller\RouterController;

class App{

    private static $_instance;
    
    public $title;

    private $router;
    private $startTime;

    public static function getInstance()
    {
        if (is_null(self::$_instance)){
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load()
    {
        if (getenv("ENV_DEV")) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
        
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
    }

    public function getRouter(string $basePath = '/var/www')
    {
        if (is_null($this->router)){
            $this->router = new Controller\RouterController($basePath . 'views');
        }
        return $this->router;

    }

    public function setStartTime()
    {
        $this->startTime = microtime(true);

    }

    public function getDebugTime()
    {
        return number_format((microtime(true) - $this->startTime)*1000, 2);
    }
}