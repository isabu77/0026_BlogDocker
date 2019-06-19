<?php
namespace App\Controller;
use App\Model\Table\CategoryTable;

class CategoryController extends Controller
{
    /**
     * constructeur
     */
    public function __construct()
    {
        // crée une instance de la classe PostTable dans la propriété $this->post
        // $this->post est créée dynamiquement
        $this->loadModel('category');    
        
        $this->loadModel('post');
    }

    /**
     * toutes les catégories
     */
    public function all()
    {
        //==============================  correction AFORMAC
        // $this->post contient une instance de la classe PostTable
        $paginatedQuery = new PaginatedQueryController(
            $this->category,
            $this->generateUrl('categories')
        );
        $categories = $paginatedQuery->getItems();

        $title = "Catégories";

        $this->render('category/all', [
            'categories' => $categories,
            'paginate' => $paginatedQuery->getNavHTML(),
            'title' => $title
        ]);

        //==============================  correction AFORMAC FIN

/*         
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
*/
    }

    /**
     * une seule catégorie et ses articles
     */
    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];
        //==============================  correction AFORMAC
        $category = $this->category->getCategoryById($id);

        // les articles de la catégorie : $this->post n'existe pas !!!!!!
        $paginatedQuery = new PaginatedQueryController(
            $this->post,
            $this->generateUrl('category', ["id" => $category->getId(), "slug" => $category->getSlug()])
        );
        $postById = $paginatedQuery->getItems();



        //==============================  correction AFORMAC FIN

        // lecture de la catégorie id dans la base (objet Category)
        //$categoryTable = CategoryTable::getInstance();
        //$category = $categoryTable::getCategory($id);

        $title = $category->getName();

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedQuery->getNavHTML()
            ]
        );

        // lecture des articles de la catégorie par son id dans la base 
/*         $uri = $this->getRouter()->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
        $paginatedController = new PaginatedController(
            'getNbPost',
            'getPosts',
            'App\Model\Table\PostTable',
            $uri,
            $category->getId()
        );
        $posts = $paginatedController->getItems();
 */
        /**
         *  @var $postById
         * Tableau d'objets Post
         * dont la propriété  $catégories est lue dans la base
         *  
         */
/*
        $postById = $categoryTable::getCategoriesOfPosts($posts);

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedController->getNavHTML()
            ]
        );
 */    }
}
