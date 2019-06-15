<?php
namespace App\Model;

use Symfony\Component\VarDumper\Caster\ExceptionCaster;

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
     *  retourne le nombre total de posts d'une catégorie dans la table post
     * @param int
     * @return int
     *   SELECT count(id) FROM post 
     *   WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ");
     **/
    public function getNbPost(int $idCategory = null): int
    {
        if ($idCategory === NULL) {
            $statement = $this->connect->executeQuery("SELECT count(id) FROM post");
        } else {
            $statement = $this->connect->executeQuery("
            SELECT count(category_id) FROM post_category WHERE  category_id = {$idCategory}");
        }
        return $statement->fetch()[0];
    }

    /**
     *  retourne tous les articles d'une catégorie dans la table post
     * @param int
     * @param int
     * @param int
     * @return int
     **/
    public function getPosts(int $perPage, int $offset, int $idCategory = null): array
    {
        /* SELECT * FROM post 
        WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ORDER BY id 

        SELECT p.id, p.slug, p.name , p.content, p.created_at
            FROM post_category pc 
            JOIN post p ON pc.post_id = p.id 
            WHERE pc.category_id = {$idCategory}
        */
        if ($idCategory == null) {
            $statement = $this->connect->executeQuery("SELECT * FROM post as p
            ORDER BY created_at DESC
            LIMIT {$perPage} 
            OFFSET {$offset}");
        } else {
            $statement = $this->connect->executeQuery("SELECT * FROM post as p 
                JOIN post_category as pc ON pc.post_id = p.id 
                WHERE pc.category_id = {$idCategory}
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset} ");
        }
        
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $posts = $statement->fetchAll();
        /*
        foreach ($posts as $post) {
            $post->setCategories($this->getCategoriesOfPost($post->getId()));
        } */
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
        /**
         * @var Post|false
         */
        $post = $statement->fetch();
        $post->setCategories($this->getCategoriesOfPost($id));

        return ($post);
    }

    /**
     *  retourne toutes les catégories d'un article
     * @param int
     * @param int
     * @param int
     * @return int
     **/
    public function getCategoriesOfPost(int $idPost): array
    {
        $statement = $this->connect->executeQuery(
            "SELECT c.id, c.slug, c.name 
            FROM post_category pc 
            JOIN category c ON pc.category_id = c.id 
            WHERE pc.post_id = {$idPost}
            ORDER BY c.id 
            "
        );
        $statement->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $categories = $statement->fetchAll();

        return $categories;
    }
}
