<?php
/**
 * fichier qui génère la vue pour l'url /categories
 * 
 */
$title = "Catégories";

// Connexion à la base
$categoryTable = new App\CategoryTable();

// lecture des catégories dans la base 
$categories = $categoryTable->getCategories();

?>

<ul>
    <?php foreach ($categories as $category) : ?>
         <li>categorie <?= " " . $category->getId() . " - ". $category->getName() . " : " . $category->getSlug()?></li>
    <?php endforeach; ?>
</ul>