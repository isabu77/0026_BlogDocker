<?php
namespace App;

// Classe principale d'accès à la table post
class PostTable
{
    private $connect;

    public function __construct()
    {
        $this->connect = Connect::getInstance();
    }
    /**
     *  retourne le nombre total de posts dans la table post
     **/
    // 
    public function getNbPost(): int
    {
        return ($this->connect->executeQuery('SELECT count(id) FROM post')->fetch()[0]);
    }

    /*
     * retourne tous les articles d'une page de $perPage articles à partir de l'article $offset
     *  
     */
    public function getPosts(int $perPage, int $offset): array
    {
        $posts = $this->connect->executeQuery("SELECT * FROM post 
        ORDER BY id 
        LIMIT {$perPage} 
        OFFSET {$offset}")
            ->fetchAll(\PDO::FETCH_CLASS, Post::class);

        return $posts;
    }

    /*
     * retourne un article recherché par son id
     *  
     */

    public function getPost(int $id): Post
    {
        $post = $this->connect->executeQuery("SELECT * FROM post 
        WHERE id = {$id}");
        $post->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $post = $post->fetch();

        return ($post);
    }
}
