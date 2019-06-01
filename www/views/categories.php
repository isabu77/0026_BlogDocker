<?php
/**
 * fichier qui génère la vue pour l'url /categories
 * 
 */
$title = "Catégories";

// Connexion à la base
$modele = new App\Modele();

// lecture des catégories dans la base 
$categories = $modele->getCategories();

?>

<ul>
    <?php foreach ($categories as $category) : ?>
        <?php $categoryObj = new App\Category($category); ?>
        <li>categorie <?= " " . $category->id . " - ". $categoryObj->getName() . " : " . $categoryObj->getSlug()?></li>
    <?php endforeach; ?>
</ul>