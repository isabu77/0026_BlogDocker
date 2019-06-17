<?php
namespace App\Controller;

use \App\Model\Post;
use \App\Model\CategoryTable;

/**
 * www/src/controller/PostController.php
 */

class TwigController
{
    /**
     * Controlleur de la page Home : affiche le rendu de all.twig (ancien index)
     */
    public function index()
    {
        $paginatedQuery = new \App\PaginatedQuery(
            'getNbPost',
            'getPosts',
            'App\Model\PostTable',
            "/test"
        );
        /**
         *  @var $post
         * tableau d'objets Post
         *  
         */
        $posts = $paginatedQuery->getItems();
        /**
         *  @var $postById
         * tableau d'objets Post dont la propriété $catégories est lue dans la base
         */
        $postById = CategoryTable::getInstance()::getCategoriesOfPosts($posts);

        // initialistation de Twig : moteur de template PHP
        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__dir__)) . '/twig/');
        $twig = new \Twig\Environment($loader);
        echo $twig->render(
            'index.twig',
            [
                'postsById' => $postById,
                'paginate' => $paginatedQuery->getNavHtml()
            ]
        );
    }
}
