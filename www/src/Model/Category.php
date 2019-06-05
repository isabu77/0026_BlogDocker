<?php
namespace App\Model;

// Classe Category : une catégorie du blog
class Category 
{
    private $id;
    private $name;
    private $slug;

    // slug
    public function getSlug(): string
    {
        return ($this->slug);
    }

    // name
    public function getName(): string
    {
        return ($this->name);
    }

    // id
    public function getId(): int
    {
        return ($this->id);
    }
}
