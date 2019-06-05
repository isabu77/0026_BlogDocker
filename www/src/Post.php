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

    /**
     *  id
     *  @return : int
     **/
    public function getId(): int
    {
        return ($this->id);
    }

    /**
     *  date de création
     *  @return : string
     **/
    public function getCreatedAt(): string
    {
        return (new \DateTime($this->created_at))->format('d/m/Y h:i');
    }

    /**
     *  slug
     *  @return : string
     **/
    
    public function getSlug(): string
    {
        return ((string)$this->slug);
    }

    /**
     *  name
     *  @return : string
     **/
    public function getName(): string
    {
        return ((string)$this->name);
    }

    /**
     *  extrait du contenu
     *  @return : string
     **/
    public function getExcerptContent(): string
    {
        return (substr($this->content, 0, 100));
    }

    /**
     *  contenu
     *  @return : string
     **/
    public function getContent(): string
    {
        return ((string)$this->content);
    }

    
}
