<?php
namespace App\Model;

/**
 *  Classe CategoryTable : accès à la table category 
 **/
class CategoryTable
{
    /**
     * @var connect
     * @access private
     */
    private $connect;

    /**
     *  constructeur
     **/
    public function __construct()
    {
        $this->connect = Connect::getInstance();
    }

    /**
     *  retourne le nombre total de categories dans la table category
     * @param void
     * @return int
     **/
     public function getNbCategory(): int
    {
        return ($this->connect->executeQuery('SELECT count(id) FROM category')->fetch()[0]);
    }

    /**
     * retourne toutes les categories
     * @param void
     * @return array
     *  
     */
    public function getCategories(int $perPage, int $offset): array
    {
        $categories = $this->connect->executeQuery(
            "SELECT * FROM category LIMIT {$perPage} OFFSET {$offset}"
        )
            ->fetchAll(\PDO::FETCH_CLASS, Category::class);
        return ($categories);
    }

    /**
     * retourne la catégorie recherchée par son id
     * @param void
     * @return Category
     *  
     */
    public function getCategory(int $id): Category
    {
        $category = $this->category = $this->connect->executeQuery(
            "SELECT * FROM category WHERE id = {$id}"
        );
        $category->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $category = $category->fetch();

        return ($category);
    }
}
