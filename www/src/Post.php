<?php
namespace App;

require_once 'Modele.php';

// Classe Post : un article du blog , hérite de la classe Modele
class Post extends Modele
{
    private $post;

    public function __construct(object $post = null)
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

    // retourne le nombre total de posts dans la table post
    public function getNbPost(): int
    {
        return ($this->executeQuery('SELECT count(id) FROM post')->fetch()[0]);
    }

    // retourne tous les articles d'une page de $perPage articles à partir de l'article $offset
    public function getPosts(int $perPage, int $offset): object
    {
        $posts = (object)$this->executeQuery("SELECT * FROM post 
        ORDER BY id 
        LIMIT {$perPage} 
        OFFSET {$offset}")
            ->fetchAll(\PDO::FETCH_OBJ);

        return ($posts);
    }

    // retourne un article recherché par son id
    public function getPost(int $id): object
    {
        $this->post = (object)$this->executeQuery("SELECT * FROM post 
        WHERE id = {$id}")
            ->fetch(\PDO::FETCH_OBJ);

        return ($this->post);
    }
}
