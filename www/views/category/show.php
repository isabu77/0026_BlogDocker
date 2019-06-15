<?php
use App\PaginatedQuery;
use App\Model\CategoryTable;
use App\Model\Post;
use App\Connection;

/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * 
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

//============= correction JULIEN ======================================== 
// tableau des ids des articles
$ids = array_map(function (Post $post) {
    return $post->getId();
}, $posts);
$categories = Connection::getPDO()
->query("SELECT c.*, pc.post_id
        FROM post_category pc 
        LEFT JOIN category c on pc.category_id = c.id
        WHERE post_id IN (" . implode(', ', $ids) . ")")
->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);

// puis tableau des ids des posts triés par id contenant l'objet Post
$postById = [];
foreach ($posts as $post) {
    $postById[$post->getId()] = $post;
}

// puis on remplit la propriété de chaque post du tableau précédent 
foreach ($categories as $category) {
    $postById[$category->post_id]->setCategory($category);
}
//===========================================================================

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