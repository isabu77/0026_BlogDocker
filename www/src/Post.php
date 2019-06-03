<?php
namespace App;

/**
 *  Classe Post : un article du blog 
 **/
class Post 
{
    private $id;
    private $name;
    private $slug;
    private $created_at;
    private $content;

    // id
    public function getId(): int
    {
        return ($this->id);
    }
       /**
     *  date de création
     **/
    public function getCreatedAt(): string
    {
        return (new \DateTime($this->created_at))->format('d/m/Y h:i');
    }

    /**
     *  slug
     **/
    
    public function getSlug(): string
    {
        return ((string)$this->slug);
    }

    /**
     *  name
     **/
    public function getName(): string
    {
        return ((string)$this->name);
    }

    /**
     *  extrait du contenu
     **/
    public function getExcerptContent(): string
    {
        return (substr($this->content, 0, 100));
    }

    /**
     *  contenu
     **/
    public function getContent(): string
    {
        return ((string)$this->content);
    }

    
}
