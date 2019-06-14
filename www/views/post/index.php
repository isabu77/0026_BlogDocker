<?php
use App\PaginatedQuery;
use App\Model\PostTable;

/**
 * fichier qui génère la vue pour l'url /
 * 
 */
$uri = $router->url("home");
$paginatedQuery = new PaginatedQuery('getNbPost', 'getPosts', 'App\Model\PostTable', $uri);
$posts = $paginatedQuery->getItems();
$postTable = new PostTable();

if ($posts == null) {
    // page inexistante : page 1
    header('location: /');
    exit();
}
// tableau des objets posts
$postById = [];
foreach ($posts as $post) {
    $postById[$post->getId()] = $post;
    $categories = $postTable->getCategoriesOfPost($post->getId());
        $postById[$post->getId()]->setCategories($categories);
}
//dd($postById);

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