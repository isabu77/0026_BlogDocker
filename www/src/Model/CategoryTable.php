<?php
namespace App\Model;

/**
 *  Classe CategoryTable : accès à la table category 
 **/
class CategoryTable
{
    /**
     * L'objet unique CategoryTable
     * @var $_instance
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * @var connect
     * @access private
     */
    private static $_connect = null;

    /**
     * Constructeur de la classe
     *
     * @return void
     * @access private
     */
    private function __construct()
    {
        if (self::$_connect == null)
            self::$_connect = Connect::getInstance();
    }

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return CategoryTable
     */
    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new CategoryTable();
        }

        return self::$_instance;
    }

    /**
     *  retourne le nombre total de categories dans la table category
     * @param void
     * @return int
     **/
    public static function getNbCategory(): int
    {
        return (self::$_connect->executeQuery('SELECT count(id) FROM category')->fetch()[0]);
    }

    /**
     * retourne toutes les categories
     * @param void
     * @return array
     *  
     */
    public static function getCategories(int $perPage, int $offset): array
    {
        $categories = self::$_connect->executeQuery(
            "SELECT * FROM category LIMIT {$perPage} OFFSET {$offset}"
        )
            ->fetchAll(\PDO::FETCH_CLASS, Category::class);
        return ($categories);
    }

    /**
     * retourne la catégorie recherchée par son id
     * @param void
     * @return Category
     *  
     */
    public static function getCategory(int $id): Category
    {
        $category = self::$_connect->executeQuery(
            "SELECT * FROM category WHERE id = {$id}"
        );
        $category->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $category = $category->fetch();

        return ($category);
    }

    /**
     * retourne un tableau d'objets Post
     * dont la propriété $catégories est lue dans la base
     * (correction de JULIEN )
     * @param array
     * @return array
     **/
    public static function getCategoriesOfPosts(array $posts): array
    {
        // tableau des ids des articles
        $ids = array_map(function (Post $post) {
            return $post->getId();
        }, $posts);

        $categories = self::$_connect->executeQuery(
            "SELECT c.*, pc.post_id
                FROM post_category pc 
                LEFT JOIN category c on pc.category_id = c.id
                WHERE post_id IN (" . implode(', ', $ids) . ")"
        )
            ->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);

        // puis tableau des ids des posts triés par id contenant l'objet Post
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }

        // puis on remplit la propriété de chaque post du tableau précédent 
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategory($category);
        }
        return $postById;
    }
}
