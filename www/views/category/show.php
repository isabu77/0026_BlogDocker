<?php
use App\PaginatedQuery;
use App\Model\CategoryTable;

/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * (Lire plus...)
 */
$id = (int)$params['id'];
$slug = $params['slug'];

// lecture de la catégorie îd dans la base (objet Category)
$categoryTable = CategoryTable::getInstance();
$category = $categoryTable::getCategory($id);

if (!$category) {
    throw new \exception("Aucune catégorie ne correspond à cet Id");
}

// vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
if ($category->getSlug() !== $slug) {
    $url = $router->url(
        'category',
        [
            'id' => $id,
            'slug' => $category->getSlug()
        ]
    );
    // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
    http_response_code(301);
    header('Location:' . $uri);
    exit();
}

$title = "Catégorie " . $category->getId() . " : " . $category->getName();

// lecture des articles de la catégorie par son id dans la base 
$uri = $router->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
$paginatedQuery = new PaginatedQuery('getNbPost', 'getPosts', 'App\Model\PostTable', $uri, $category->getId());
$posts = $paginatedQuery->getItems();

/**
 *  @var $postById
 * Tableau d'objets Post
 * dont la propriété  $catégories est lue dans la base
 *  
 */
 
$postById = $categoryTable::getCategoriesOfPosts($posts);

?>

<p>Slug : <big><?= $category->getSlug() ?></big></p>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row">
    <?php /** @var Post::class $post */
    foreach ($postById as $post) {
        require dirname(__DIR__) . '/post/card.php';
    }
    ?>
</section>

<?php
echo $paginatedQuery->getNavHTML(); 