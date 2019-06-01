<?php
namespace App;

// Classe Category : une catégorie du blog
class Category
{
    private $Category;
    public function __construct(object $Category)
    {
        $this->Category = $Category;
    }

    // slug
    public function getSlug(): string
    {
        return ((string)$this->Category->slug);
    }

    // name
    public function getName(): string
    {
        return ((string)$this->Category->name);
    }
    
    // id
    public function getId(): string
    {
        return ((string)$this->Category->id);
    }
}
