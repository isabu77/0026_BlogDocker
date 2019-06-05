<?php
namespace App\Model;

/**
 *  Classe PostTable : accès à la table post 
 **/
class PostTable
{
    /**
     * @var connect
     * @access private
     */
    private $connect;

    /**
     *  constructeur
     **/
    public function __construct()
    {
        $this->connect = Connect::getInstance();
    }
    /**
     *  retourne le nombre total de posts dans la table post
     * @param void
     * @return int
     **/
    public function getNbPost(): int
    {
        return ($this->connect->executeQuery("SELECT count(id) FROM post")->fetch()[0]);
    }

    /**
     * retourne tous les articles d'une page de $perPage articles à partir de l'article $offset
     * @param int
     * @param int
     * @return array
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
     *  retourne le nombre total de posts d'une catégorie dans la table post
     * @param int
     * @return int
     **/
    public function getNbPostOfCategory(int $idCategory): int
    {
        $statement = $this->connect->executeQuery("SELECT count(id) FROM post 
         WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ");
        return $statement->fetch()[0];
    }

    /**
     *  retourne tous les articles d'une catégorie dans la table post
     * @param int
     * @param int
     * @param int
     * @return int
     **/
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

    /**
     *  retourne un article recherché par son id dans la table post
     * @param int
     * @return int
     **/
    public function getPost(int $id): Post
    {
        $statement = $this->connect->executeQuery("SELECT * FROM post 
        WHERE id = {$id}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $post = $statement->fetch();

        return ($post);
    }
}
