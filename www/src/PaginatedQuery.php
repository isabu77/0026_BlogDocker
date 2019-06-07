<?php
namespace App;

/**
 * classe PaginatedQuery : gestion d'une pagination de requête à la base (éléments d'une classe)
 */
class PaginatedQuery
{
    /**
     * @var string 
     * @access private
     */
    private $classe;
    /**
     * @var string 
     * @access private
     */
    private $queryCount;
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
     * @var int 
     * @access private
     */
    private $nbItems;
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
     * @var int 
     * @access private
     */
    private $id;

    /**
     * constructeur
     */
    public function __construct(string $queryCount, string $query, string $classe, string $url, int $id = null, int $perPage = 12)
    {
        $this->classe = $classe;
        $this->queryCount = $queryCount;
        $this->query = $query;
        $this->url = $url;
        $this->id = $id;
        $this->perPage = $perPage;
        $this->instanceClasse = new $this->classe();  //  instanceClasse
    }

    /**
     * retourne le nb de pages
     */
    public function getNbPages(): float
    {
        if ($this->nbItems === null) {
            $fct = $this->queryCount;
            $this->nbItems = $this->instanceClasse->$fct($this->id);
        }

        return ceil($this->nbItems / $this->perPage);
    }

    /**
     * retourne le nb de pages
     */
    public function getCurrentPage()
    {
        return URL::getPositiveInt('page', 1);
    }

    /**
     * Retourne la liste des éléments d'une page
     * @param void
     * @return array
     */
    public function getItems(): ?array
    {
        $currentPage = $this->getCurrentPage();

        if ($currentPage > $this->getNbPages()) {
            // page inexistante : page 1
            //throw new \Exception ("pas de page");
            header('location: ' . $this->url);
            exit();
        }
        if ($this->items === null) {
            $offset = ($currentPage - 1) * $this->perPage;

            // lecture des éléments de la page dans la base
            $fct = $this->query;
            $this->items =  $this->instanceClasse->$fct($this->perPage, $offset, $this->id);
        }
        return ($this->items);
    }

        /**
     * retourne un tableau [noPage => url, ...] de pages
     * @param void
     * @return [noPage => url, ...] 
     */
    public function getNav(): array
    {
        $navArray = [];
        for ($i = 1; $i <= $this->getNbPages(); $i++) {
            $url = $i == 1 ? $this->url : $this->url . "?page=" . $i;
            $navArray[$i] = $url;
        }
        return $navArray;
    }
    
    /**
     * Retourne les lignes du menu de pagination en html
     * @param void
     * @return string
     */
    public function getNavHTML(): string
    {
        $urls = $this->getNav();
        $navHtml = "";
        $currentPage = $this->getCurrentPage();

        foreach ($urls as $key => $url) {
            $class = $currentPage == $key ? " active" : "";
            $navHtml .= "<li class='page-item{$class}'><a class='page-link' href='{$url}'>{$key}</a></li>";
        }
        return $navHtml;
    }


}
