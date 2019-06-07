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
     * @var string
     * @access private
     */
    private $instanceClasse;
    
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
    public function getPages()
    {
        $fct = $this->queryCount;
        $nbItems = $this->instanceClasse->$fct($this->id);

        return ceil($nbItems / $this->perPage);
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

        if ($currentPage > $this->getPages()) {
            // page inexistante : page 1
            //throw new \Exception ("pas de page");
            header('location: ' . $this->url);
            exit();
        }

        $offset = ($currentPage - 1) * $this->perPage;

        // lecture des éléments de la page dans la base
        $fct = $this->query;
        return $this->instanceClasse->$fct($this->perPage, $offset, $this->id);
    }

    /**
     * Retourne les lignes du menu de pagination en html
     * @param void
     * @return string
     */
    public function getNavHTML(): string
    {
        $navHtml = "";
        $currentPage = $this->getCurrentPage();

        for ($i = 1; $i <= $this->getPages(); $i++) {
            $class = $currentPage == $i ? " active" : "";
            $url = $i == 1 ? $this->url : $this->url . "?page=" . $i;

            $navHtml .= '<li class="page-item' . $class . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
        }
        return $navHtml;
    }

    /**
     * retourne un tableau [noPage => url, ...] de pages
     * @param void
     * @return [noPage => url, ...] 
     */
    public function getNav(): array
    {
        $navArray = [];
        for ($i = 1; $i <= $this->getPages(); $i++) {
            $url = $i == 1 ? $this->url : $this->url . "?page=" . $i;
            $navArray[$i] = $url;
        }
        return $navArray;
    }
}
