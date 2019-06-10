<?php
use App\PaginatedQuery;

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

$title = 'Mon Super MEGA blog';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row">
    <?php foreach ($posts as $post) {
        require 'card.php';
    }
    ?>
</section>
<?= $paginatedQuery->getNavHTML(); ?>