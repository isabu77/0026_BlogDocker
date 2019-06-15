<?php
use App\PaginatedQuery;
use App\Model\CategoryTable;

/**
 * fichier qui génère la vue pour l'url /
 * (Home)
 */

$uri = $router->url("home");
$paginatedQuery = new PaginatedQuery('getNbPost', 'getPosts', 'App\Model\PostTable', $uri);
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

?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row">
    <?php /** @var Post::class $post */
    foreach ($postById as $post) {
        require 'card.php';
    }
    ?>
</section>
<?php
echo $paginatedQuery->getNavHTML(); 