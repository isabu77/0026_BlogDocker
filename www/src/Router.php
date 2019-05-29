<? 
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

    public function run():void
    {
       // regarde si une route matche dans les routes définies au-dessus
        $match = $this->router->match();

        if( is_array($match) ) {
            ob_start();  // démarre le cache
            $params = $match['params'];
            require $this->viewPath . DIRECTORY_SEPARATOR . $match['target'] . '.php';
            $content = ob_get_clean(); // récupère le cache
            require $this->viewPath . DIRECTORY_SEPARATOR . 'layout/default.php';
            exit();
        } else {
            // no route was matched
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            exit();
        }

    }
}