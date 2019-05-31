<?php 
namespace App;

class Router{
    private $router;
    private $viewPath;
    public function __construct(string $viewPath) 
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();

    }

    public function get(string $uri, string $file, string $name):self
    {
        $this->router->map( 'GET', $uri, $file, $name);
        return($this); // pour enchainer les get à l'appel

    }

    // regarde si une route matche dans les routes définies au-dessus
    public function run(): void
    {
        $match = $this->router->match();
        ob_start(); // démarre le cache
        if (is_array($match)) {
             $params = $match['params'];
            require $this->pathToFile($match['target']);
        } else {
            // no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            require $this->pathToFile("layout/404");
        }
        $content = ob_get_clean(); // récupère le html du cache
        require $this->pathToFile("layout/default");
    }
    private function pathToFile(string $file): string
    {
        return $this->viewPath . DIRECTORY_SEPARATOR . $file . '.php';
    }
}