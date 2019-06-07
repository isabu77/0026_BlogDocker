<?php
namespace App;

/**
 * classe PaginatedQuery : gestion d'une pagination de requête à la base (articles)
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
    private $nbPage;

    /**
     * @var int 
     * @access private
     */
    private $currentpage;

    /**
     * @var class
     * @access private
     */
    private $postTable;
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
        $this->postTable = new $this->classe();  //  PostTable
    }

    /**
     * getContent : retourne la liste des éléments d'une page
     * @param void
     * @return array
     */
    public function getItems():?array
    {
         // nb d'articles de la catégorie $id
        $fct = $this->queryCount;
        $nbpost = $this->postTable->$fct($this->id);

        $this->nbPage = ceil($nbpost / $this->perPage);
        if ((int)$_GET["page"] > $this->nbPage) {
            return null;
        }

        if (isset($_GET["page"])) {
            $this->currentpage = (int)$_GET["page"];
        } else {
            $this->currentpage = 1;
        }       
        $offset = ($this->currentpage - 1) * $this->perPage;
 
        // lecture des articles de la page dans la base
        $fct = $this->query;
        return $this->postTable->$fct($this->perPage, $offset, $this->id);
    }

    /**
     * getNavHTML : affiche le menu de pagination en html
     * @param void
     * @return void
     */
    public function getNavHTML(){

        for ($i = 1; $i <= $this->nbPage; $i++){
            $class = $this->currentpage == $i ? " active" : "";
            $url = $i == 1 ? $this->url : $this->url . "?page=" . $i; 
        
            echo '<li class="page-item'. $class .'"><a class="page-link" href="'. $url .'">'. $i .'</a></li>';
        }

    }
}
