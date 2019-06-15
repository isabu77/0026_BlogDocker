<?php
use App\PaginatedQuery;
use App\Model\PostTable;
use App\Model\Post;
use App\Connection;

/**
 * fichier qui génère la vue pour l'url /
 * 
 */
$uri = $router->url("home");
$paginatedQuery = new PaginatedQuery('getNbPost', 'getPosts', 'App\Model\PostTable', $uri);
$posts = $paginatedQuery->getItems();

if ($posts == null) {
    // page inexistante : page 1
    header('location: /');
    exit();
}

//============= correction JULIEN ======================================== 
// tableau des ids des articles
$ids = array_map(function (Post $post) {
    return $post->getId();
}, $posts);

// puis tableau des catégories associées aux posts de cette page
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
//dd($postById);

//===========================================================================

$title = 'Mon Super MEGA blog';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row">
    <?php foreach ($posts as $post) {
        //$categories = $postTable->getCategoriesOfPost($post->getId());
        require 'card.php';
    }
    ?>
</section>
<?= $paginatedQuery->getNavHTML(); ?>