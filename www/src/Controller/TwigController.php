<?php
namespace App\Controller;
use \App\Connection;
use \App\Model\Post;
use \App\Model\Category;
class TwigController
{
    public function index()
    {
        $paginatedQuery = new \App\PaginatedQuery(
            'getNbPost', 'getPosts', 'App\Model\PostTable', "/test");
        $posts = $paginatedQuery->getItems();
        $ids = array_map(function (Post $post) {
            return $post->getId();
        }, $posts);
        
        
        $categories = Connection::getPDO()
                        ->query("SELECT c.*, pc.post_id
                                FROM post_category pc 
                                LEFT JOIN category c on pc.category_id = c.id
                                WHERE post_id IN (" . implode(',', $ids) . ")")
                        ->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);
        
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategory($category);
        }
        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__dir__)).'/twig/');
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