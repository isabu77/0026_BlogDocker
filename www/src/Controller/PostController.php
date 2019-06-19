<?php
namespace App\Controller;
use App\Model\Table\CategoryTable;
use App\Model\Table\PostTable;
use App\Model\Entity\Category;
use App\Model\Entity\Post;

class PostController extends Controller
{
    /**
     * constructeur
     */
    public function __construct()
    {
        // crée une instance de la classe PostTable dans la propriété $this->post
        // $this->post est créée dynamiquement
        $this->loadModel('post');
    }

    /**
     * tous les articles
     */
    public function all()
    {
        //==============================  correction AFORMAC
        // $this->post contient une instance de la classe PostTable
        $paginatedQuery = new PaginatedQueryController(
            $this->post,
            $this->generateUrl('post')
        );
        $posts = $paginatedQuery->getItems();

        $title = 'Mon Blog en MVC';

        $this->render('post/all', [
            'posts' => $posts,
            'paginate' => $paginatedQuery->getNavHTML(),
            'title' => $title
        ]);
        
        return;
    //==============================  correction AFORMAC FIN


        
        //============================= MON CODE
        /**
         * fichier qui génère la vue pour l'url /
         * (Home)
         */

        $uri = $this->getRouter()->url("home");
        $paginatedController = new PaginatedController(
            'getNbPost',
            'getPosts',
            'App\Model\Table\PostTable',
            $uri
        );
        /**
         *  @var $post
         * tableau d'objets Post
         *  
         */
        $posts = $paginatedController->getItems();

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
            'paginate' => $paginatedController->getNavHTML(),
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
