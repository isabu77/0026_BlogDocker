<?php
namespace App;

use Faker\Provider\ka_GE\DateTime;

class Post
{
    private $post;
    public function __construct(object $post)
    {
        $this->post = $post;
    }

    public function excerpt(): string
    {
        return (substr($this->post->content, 0, 50));
    } 
    public function getCreatedAt(): string
    {
        return (new \DateTime($this->post->created_at))->format('d/m/Y h:i');
       
    }
}
