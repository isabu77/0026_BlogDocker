<?php
use App\PaginatedQuery;
use App\Model\CategoryTable;

/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * 
 */
$id = (int)$params['id'];
$slug = $params['slug'];

// Connexion à la base
$categoryTable = new CategoryTable();

// lecture de la catégorie îd dans la base (objet Category)
$category = $categoryTable->getCategory($id);

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
        require dirname(__DIR__) . '/post/card.php';
    }
    ?>
</section>
<?php
/**
 * 2 approches :
 * $pagination->getNavHTML();  --> html
 * OU
 * $pagination->getNav();  --> [i=>url, 2=>url]
 */
?>
<nav class="Page navigation">
    <ul class="pagination justify-content-center">
        <?= $paginatedQuery->getNavHTML(); ?>
    </ul>
</nav>