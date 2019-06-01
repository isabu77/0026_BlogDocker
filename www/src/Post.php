<?php
namespace App;

// Classe Post : un article du blog
class Post
{
    private $post;
    public function __construct(object $post)
    {
        $this->post = $post;
    }


    // date de création
    public function getCreatedAt(): string
    {
        return (new \DateTime($this->post->created_at))->format('d/m/Y h:i');
    }

    // slug
    public function getSlug(): string
    {
        return ((string)$this->post->slug);
    }

    // name
    public function getName(): string
    {
        return ((string)$this->post->name);
    }

    // extrait du contenu 
    public function getExcerptContent(): string
    {
        return (substr($this->post->content, 0, 100));
    }

    // contenu entier
    public function getContent(): string
    {
        return ((string)$this->post->content);
    }
}
