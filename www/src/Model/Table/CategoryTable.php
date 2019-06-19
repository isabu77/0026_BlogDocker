<?php
namespace App\Model\Table;

use App\Model\Entity\Category;
use App\Model\Entity\Post;

/**
 *  Classe CategoryTable : accès à la table category 
 **/
class CategoryTable extends Table
{
    /**
     * L'objet unique CategoryTable
     * @var $_instance
     * @access private
     * @static
     */
    private static $_instance = null;

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
            ->fetchAll(\PDO::FETCH_CLASS, Category::class);

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

    //==============================  correction AFORMAC
    /**
     * lecture de toutes les catégories d'une page
     */
    public function allByLimit(int $limit, int $offset)
    {

        $categories = $this->query("SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset}", null);

        return $categories;
    }

    /**
     * lecture d'une category par son id
     */
    public function getCategoryById(int $id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id={$id}", null, true);
    }

    /**
     * lecture des catégories de plusieurs articles
     */
    public function allInId(string $ids)
    {
        return $this->query("SELECT c.*, pc.post_id
        FROM post_category pc 
        LEFT JOIN category c on pc.category_id = c.id
        WHERE post_id IN (" . $ids . ")");
    }
}
