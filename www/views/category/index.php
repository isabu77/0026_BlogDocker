<?php
use App\PaginatedQuery;

/**
 * fichier qui génère la vue pour l'url /categories
 * 
 */
$title = "Catégories";

// lecture des catégories dans la base 

$uri = $router->url("categories");
$paginatedQuery = new PaginatedQuery('getNbCategory', 'getCategories', 'App\Model\CategoryTable', $uri, null,  6);
$categories = $paginatedQuery->getItems();

if ($categories == null) {
    // page inexistante : page 1
    header('Location:' . $uri);
    exit();
}

?>

<ul>
    <?php foreach ($categories as $category) : ?>
        <a href="<?= $router->url('category', ['id' => $category->getId(), "slug" => $category->getSlug()]) ?>">
            <li>Categorie <?= " " . $category->getId() . " - " . $category->getName() ?></li>
        </a>
    <?php endforeach; ?>
</ul>

<?= $paginatedQuery->getNavHTML(); ?>