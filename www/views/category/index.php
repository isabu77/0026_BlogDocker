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

echo "<ul>";
foreach ($categories as $category) {
    $url = $router->url('category', ['id' => $category->getId(), "slug" => $category->getSlug()]);
    echo "<li><a href=\"{$url}\">{$category->getName()}</a></li>";
}
echo "</ul>";
echo $paginatedQuery->getNavHtml();
