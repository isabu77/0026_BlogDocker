<?php
namespace App\Model;

/**
 *  Classe Category : une catégorie du blog 
 **/
class Category
{
    private $id;
    private $name;
    private $slug;

    /**
     *  id
     *  @return int
     **/
    public function getId(): int
    {
        return ($this->id);
    }

    /**
     *  name
     *  @return string
     **/
    public function getName(): string
    {
        return ((string)$this->name);
    }

    /**
     *  slug
     *  @return string
     **/
    public function getSlug(): string
    {
        return ($this->slug);
    }
}
