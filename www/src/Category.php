<?php
namespace App;
require_once 'Modele.php';

// Classe Category : une catégorie du blog
class Category extends Modele
{
     private $category;
    public function __construct(object $Category = null)
    {
        $this->category = $Category;
    }

    // slug
    public function getSlug(): string
    {
        return ((string)$this->category->slug);
    }

    // name
    public function getName(): string
    {
        return ((string)$this->category->name);
    }

    // id
    public function getId(): string
    {
        return ((string)$this->category->id);
    }

    // retourne les catégories
    public function getCategories(): object
    {
        $categories = (object)$this->executeQuery(
            "SELECT * FROM category"
        )
            ->fetchAll(\PDO::FETCH_OBJ);
        return ($categories);
    }

    // retourne la catégories recherchée par son id
    public function getCategory(int $id): object
    {
        $this->category = (object)$this->executeQuery(
            "SELECT * FROM category WHERE id = {$id}"
        )
            ->fetch(\PDO::FETCH_OBJ);
        return ($this->category);
    }
}
