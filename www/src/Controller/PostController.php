<?php
namespace App\Controller;

use App\PaginatedQuery;
use App\Model\CategoryTable;
use App\Model\PostTable;

class PostController extends Controller
{
    /**
     * tous les articles
     */

    public function all()
    {

        /**
         * fichier qui génère la vue pour l'url /
         * (Home)
         */

        $uri = $this->getRouter()->url("home");
        $paginatedQuery = new PaginatedQuery(
            'getNbPost',
            'getPosts',
            'App\Model\PostTable',
            $uri
        );
        /**
         *  @var $post
         * tableau d'objets Post
         *  
         */
        $posts = $paginatedQuery->getItems();

        if ($posts == null) {
            // page inexistante : page 1
            header('location: /');
            exit();
        }

        $title = 'Mon Blog en MVC';

        /**
         *  @var $postById
         * tableau d'objets Post dont la propriété $catégories est lue dans la base
         */

        $postById = CategoryTable::getInstance()::getCategoriesOfPosts($posts);

        $this->render('post/all', [
            'posts' => $postById,
            'paginate' => $paginatedQuery->getNavHTML(),
            'title' => $title
        ]);
    }

    /**
     * un seul article
     */
    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];

        // lecture de l'article dans la base (objet Post) par son id
        /**
         * @var Post|false
         */
        $postTable = PostTable::getInstance();
        $post = $postTable->getPost($id);

        if (!$post) {
            throw new \exception("Aucun article ne correspond à cet Id");
        }

        // vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
        if ($post->getSlug() !== $slug) {
            $url = $this->getRouter()->url('post', ['id' => $id, 'slug' => $post->getSlug()]);
            // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
            http_response_code(301);
            header('Location:' . $url);
            exit();
        }

        $title = "Article " . $post->getName();

        $this->render('post/show', [
            'post' => $post,
            'title' => $title
        ]);
    }
}
