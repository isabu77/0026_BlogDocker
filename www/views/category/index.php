<?php
use App\Model\PostTable;
use App\Model\CategoryTable;
/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * 
 */
$id = (int)$params['id'];

// Connexion à la base
$categoryTable = new CategoryTable();
$postTable = new PostTable();

// lecture de la catégorie îd dans la base (objet Category)
$category = $categoryTable->getCategory($id);

$title = "Catégorie : " . $category->getName();

// nb d'articles de la catégorie $id
$nbpost = $postTable->getNbPostOfCategory($id);

$perPage = 8;
$nbPage = ceil($nbpost / $perPage);

if ((int)$_GET["page"] > $nbPage) {
    header('location: /category/?1');
    exit();
}
if (isset($_GET["page"])) {
    $currentpage = (int)$_GET["page"];
} else {
    $currentpage = 1;
}
$offset = ($currentpage - 1) * $perPage;


// lecture des articles de la page dans la base
$posts = $postTable->getPostsOfCategory($id, $perPage, $offset);


?>

<p>Catégorie <big><?= $id ?></big></p>
<p>Slug : <big><?= $category->getSlug() ?></big></p>

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
                    <h5 class="card-title">Article <?= $post->getId() . "- ". $post->getName() ?></h5>
                    <p class="card-text"><?= $post->getExcerptContent() ?>...</p>
                </div>
                <a href="/article/<?= $post->getId() ?>" class="text-center pb-2">lire plus</a>
                <div class="card-footer text-muted">
                    <?= ($post->getCreatedAt())   ?>
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
            <li class="page-item<?= $class ?>"><a class="page-link" href="/category/<?=$id?>/<?= $uri ?>"><?= $i ?></a></li>
        <?php endfor ?>
    </ul>
</nav>
