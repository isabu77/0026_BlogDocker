<?php
namespace App\Controller;
use \App\Model\Table\Table;
use App\URL;
//==============================  correction AFORMAC

/**
 * classe PaginatedQueryController : gestion d'une pagination avec requête à la base 
 * 
 */
class PaginatedQueryController
{
    /**
     * @var string 
     * @access private
     */
    private $classTable;

    /**
     * @var string 
     * @access private
     */
    private $query;

    /**
     * @var string 
     * @access private
     */
    private $url;

    /**
     * @var int 
     * @access private
     */
    private $perPage;
    /**
     * @var string
     * @access private
     */
    private $instanceClasse;

    /**
     * @var array
     * @access private
     */
    private $items;

    /**
     * constructeur
     * @param Table $classTable : classe de la Table
     * @param string $url : url de la page à afficher 
     * @param int $perPage : nb d'items par page
     */
    public function __construct(
        Table $classTable,
        string $url = null,
        int $perPage = 12
    ) {
        $this->classTable = $classTable;
        $this->url = $url;
        $this->perPage = $perPage;

    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getNbPages(): float
    {
        if ($this->count === null) {
            $this->count = $this->classTable->count()->nbrow;
        }
        return ceil($this->count / $this->perPage);
    }

    public function getNav(): array
    {
        $uri = $this->url;
        $nbPage = $this->getNbPages();
        $navArray = [];
        for ($i = 1; $i <= $nbPage; $i++) {
            // if($i == 1){
            //     $url = $uri;
            // }else{
            //     $url = $uri . "?page=" . $i;
            // }
            $url = $i == 1 ? $uri : $uri . "?page=" . $i;
            $navArray[$i] = $url;
        }
        return $navArray;
    }
    public function getNavHtml(): string
    {
        $urls = $this->getNav();
        $html = "";
        foreach ($urls as $key => $url) {
            $class = $this->getCurrentPage() == $key ? " active" : "";
            $html .= "<li class=\"page-item {$class}\"><a class=\"page-link\" href=\"{$url}\">{$key}</a></li>";
        }
        return <<<HTML
        <nav class="Page navigation">
            <ul class="pagination justify-content-center">
                {$html}
            </ul>
        </nav>
HTML;
    }
    /**
     * Retourne la liste des éléments d'une page
     * par appel de la méthode de requête de la classe fournies
     * @param void
     * @return array
     */
    public function getItems(): ?array
    {
        $currentPage = $this->getCurrentPage();
        $nbPage = $this->getNbPages();

        if ($currentPage > $nbPage) {
            // page inexistante : page 1
            throw new \Exception ("pas de page");
            //header('location: ' . $this->url);
            exit();
        }

        if ($this->items === null) {
            $offset = ($currentPage - 1) * $this->perPage;
            // lecture des éléments de la page dans la base
            $this->items = $this->classTable->allByLimit($this->perPage, $offset);

        }
        return ($this->items);
    }


}
