<?php
namespace App\Model;

// Classe principale d'accès à la table category
class CategoryTable
{
    private $connect;

    public function __construct()
    {
        $this->connect = Connect::getInstance();
    }
    /**
     *  retourne le nombre total de categories dans la table category
     **/
    // 
    public function getNbCategory(): int
    {
        return ($this->connect->executeQuery('SELECT count(id) FROM category')->fetch()[0]);
    }

    /*
     * retourne toutes les categories
     *  
     */
    public function getCategories(): array
    {
        $categories = $this->connect->executeQuery(
            "SELECT * FROM category"
        )
            ->fetchAll(\PDO::FETCH_CLASS, Category::class);
        return ($categories);
    }

    /*
     * retourne la catégorie recherchée par son id
     *  
     */
    public function getCategory(int $id): object
    {
        $category = $this->category = $this->connect->executeQuery(
            "SELECT * FROM category WHERE id = {$id}"
        );
        $category->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $category = $category->fetch();

        return ($category);
    }
}
