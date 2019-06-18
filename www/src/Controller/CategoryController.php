<?php
namespace App\Controller;
use App\Model\Table\CategoryTable;

class CategoryController extends Controller
{
    /**
     * toutes les catégories
     */
    public function all()
    {
        // lecture des catégories dans la base 

        $paginatedController = new PaginatedController(
            'getNbCategory',
            'getCategories',
            'App\Model\Table\CategoryTable',
            $this->getRouter()->url("categories"),
            null,
            10
        );
        $categories = $paginatedController->getItems();
        $title = "Catégories";

        $this->render(
            "category/all",
            [
                "title" => $title,
                "categories" => $categories,
                "paginate" => $paginatedController->getNavHTML()
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
        $paginatedController = new PaginatedController(
            'getNbPost',
            'getPosts',
            'App\Model\Table\PostTable',
            $uri,
            $category->getId()
        );
        $posts = $paginatedController->getItems();

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
                "paginate" => $paginatedController->getNavHTML()
            ]
        );
    }
}
