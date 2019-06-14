<?php
use App\PaginatedQuery;
use App\Model\CategoryTable;
use App\Model\PostTable;

/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * 
 */
$id = (int)$params['id'];
$slug = $params['slug'];

// Connexion à la base
// lecture de la catégorie îd dans la base (objet Category)
$categoryTable = new CategoryTable();
$category = $categoryTable->getCategory($id);
$postTable = new PostTable();

if (!$category) {
    throw new \exception("Aucune catégorie ne correspond à cet Id");
}

$uri = $router->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);

// vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
if ($category->getSlug() !== $slug) {
    // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
    http_response_code(301);
    header('Location:' . $uri);
    exit();
}

// Connexion à la base
// lecture des articles de la catégorie par son îd dans la base 
$paginatedQuery = new PaginatedQuery('getNbPost', 'getPosts', 'App\Model\PostTable', $uri, $category->getId());
$posts = $paginatedQuery->getItems();

$title = "Catégorie " . $category->getId() . " : " . $category->getName();

?>

<p>Slug : <big><?= $category->getSlug() ?></big></p>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row">
    <?php
    foreach ($posts as $post) {
        //$categories = $postTable->getCategoriesOfPost($post->getId());
        require dirname(__DIR__) . '/post/card.php';
    }
    ?>
</section>

<?= $paginatedQuery->getNavHTML(); ?>