<?php
namespace App\Model;

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
    public function getName()
    {
        return ((string)$this->name);
    }

    /**
     *  slug
     *  @return string
     **/

    public function getSlug()
    {
        return ((string)$this->slug);
    }

    /**
     *  date de création
     *  @return  \DateTime
     **/
    public function getCreatedAt()
    {
        return (new \DateTime($this->created_at));
    }
    /**
     *  date de création
     *  @return : string
     **/
    public function getCreatedAtDMY()
    {
        return (new \DateTime($this->created_at))->format('d/m/Y h:i');
    }

    /**
     *  contenu
     *  @return string
     **/
    public function getContent()
    {
        return ((string)$this->content);
    }

    
}
