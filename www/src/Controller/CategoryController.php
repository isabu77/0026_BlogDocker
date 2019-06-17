<?php
namespace App\Controller;

use App\Model\CategoryTable;
use App\PaginatedQuery;

class CategoryController extends Controller
{
    /**
     * toutes les catégories
     */
    public function all()
    {
        // lecture des catégories dans la base 

        $paginatedQuery = new PaginatedQuery(
            'getNbCategory',
            'getCategories',
            'App\Model\CategoryTable',
            $this->getRouter()->url("categories"),
            null,
            10
        );
        $categories = $paginatedQuery->getItems();
        $title = "Catégories";

        $this->render(
            "category/all",
            [
                "title" => $title,
                "categories" => $categories,
                "paginate" => $paginatedQuery->getNavHTML()
            ]
        );
    }

    /**
     * une seule catégorie et ses articles
     */
    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];

        // lecture de la catégorie îd dans la base (objet Category)
        $categoryTable = CategoryTable::getInstance();
        $category = $categoryTable::getCategory($id);

        $title = 'categorie : ' . $category->getName();

        // lecture des articles de la catégorie par son id dans la base 
        $uri = $this->getRouter()->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
        $paginatedQuery = new PaginatedQuery(
            'getNbPost',
            'getPosts',
            'App\Model\PostTable',
            $uri,
            $category->getId()
        );
        $posts = $paginatedQuery->getItems();

        /**
         *  @var $postById
         * Tableau d'objets Post
         * dont la propriété  $catégories est lue dans la base
         *  
         */

        $postById = $categoryTable::getCategoriesOfPosts($posts);

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedQuery->getNavHTML()
            ]
        );
    }
}