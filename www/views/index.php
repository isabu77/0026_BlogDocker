<?php
use App\Model\PostTable;
use App\Helpers\Text;

/**
 * fichier qui génère la vue pour l'url /
 * 
 */

$postTable = new PostTable();
$nbpost = $postTable->getNbPost();

$perPage = 12;
$nbPage = ceil($nbpost / $perPage);
if ((int)$_GET["page"] > $nbPage) {
    header('location: /');
    exit();
}
if (isset($_GET["page"])) {
    $currentpage = (int)$_GET["page"];
} else {
    $currentpage = 1;
}
$offset = ($currentpage - 1) * $perPage;

// lecture des articles de la page dans la base
$posts = $postTable->getPosts($perPage, $offset);

$title = 'Mon Super MEGA blog';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>
<section class="row">
    <?php foreach ($posts as $post) : ?>
        <article class="col-3 mb-4 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Article <?= $post->getId() . " - ". $post->getName() ?></h5>
                    <p class="card-text"><?= Text::excerpt($post->getContent(), 100) ?></p>
                </div>
                <a href="<?= $router->url('post', ['id' => $post->getId()]) ?>" class="text-center pb-2">lire plus</a>
                <div class="card-footer text-muted">
                    <?= ($post->getCreatedAtDMY())   ?>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</section>
<nav class="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $nbPage; $i++) : ?>
            <?php $class = $currentpage == $i ? " active" : ""; ?>
            <?php $uri = $i == 1 ? "" : "?page=" . $i; ?>
            <li class="page-item<?= $class ?>"><a class="page-link" href="/<?= $uri ?>"><?= $i ?></a></li>
        <?php endfor ?>
    </ul>
</nav>