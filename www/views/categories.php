<?php
use App\Model\CategoryTable;

/**
 * fichier qui génère la vue pour l'url /categories
 * 
 */
$title = "Catégories";

// Connexion à la base
$categoryTable = new CategoryTable();

// lecture des catégories dans la base 
$categories = $categoryTable->getCategories();

?>

<ul>
    <?php foreach ($categories as $category) : ?>
    <a href="/category/<?= $category->getId() ?>" ><li>categorie <?= " " . $category->getId() . " - ". $category->getName() . " : " . $category->getSlug()?></li></a>
    <?php endforeach; ?>
</ul>

