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
<nav class="Page navigation">
    <ul class="pagination justify-content-center">
        <?php 
            $navArray = $paginatedQuery->getNav();
            $currentPage = $paginatedQuery->getCurrentPage();
            for ($i = 1; $i <= count($navArray); $i++) :  ?>
        <?php $class = $currentPage == $i ? " active" : ""; ?>	       
        <?php $uri = $i == 1 ? "" : "?page=" . $i; ?>	        
            <li class="page-item<?= $class ?>"><a class="page-link" href="/<?= $uri ?>"><?= $i ?></a></li>	
        <?php endfor ?>	
</nav>