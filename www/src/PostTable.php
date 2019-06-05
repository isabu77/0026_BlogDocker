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
        return ($this->connect->executeQuery("SELECT count(id) FROM post")->fetch()[0]);
    }

    /*
     * retourne tous les articles d'une page de $perPage articles à partir de l'article $offset
     *  
     */
    public function getPosts(int $perPage, int $offset): array
    {
        $statement = $this->connect->executeQuery("SELECT * FROM post 
        ORDER BY id 
        LIMIT {$perPage} 
        OFFSET {$offset}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $posts = $statement->fetchAll();

        return $posts;
    }
    /**
     *  retourne le nombre total de posts dans la table post
     **/
    // 
    public function getNbPostOfCategory(int $idCategory): int
    {
        $statement = $this->connect->executeQuery("SELECT count(id) FROM post 
         WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ");
        return $statement->fetch()[0];
    }

    /*
     * retourne tous les articles d'une catégorie , d'une page de $perPage articles à partir de l'article $offset
     *  
     */
    public function getPostsOfCategory(int $idCategory, int $perPage, int $offset): array
    {
        $statement = $this->connect->executeQuery("SELECT * FROM post 
        WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ORDER BY id 
        LIMIT {$perPage} 
        OFFSET {$offset}
        ");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $posts = $statement->fetchAll();

        return $posts;
    }

    /*
     * retourne un article recherché par son id
     *  
     */

    public function getPost(int $id): Post
    {
        $statement = $this->connect->executeQuery("SELECT * FROM post 
        WHERE id = {$id}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $post = $statement->fetch();

        return ($post);
    }
}
