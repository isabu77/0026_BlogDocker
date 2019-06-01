<?php
/**
 * fichier qui génère la vue pour l'url /
 * 
 */


$pdo = new PDO(
    "mysql:dbname=" .
        getenv('MYSQL_DATABASE') . ";host=" .
        getenv('MYSQL_HOST') . ";charset=UTF8",
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

$nbpost = $pdo->query('SELECT count(id) FROM post')->fetch()[0];
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
$posts = $pdo->query("SELECT * FROM post 
                    ORDER BY id 
                    LIMIT {$perPage} 
                    OFFSET {$offset}")
    ->fetchAll(PDO::FETCH_OBJ);
$title = 'Mon Super MEGA blog';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>
<section class="row">
    <?php foreach ($posts as $post) : ?>
        <?php $postObj = new App\Post($post); ?>
        <article class="col-3 mb-4 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $post->name ?></h5>
                    <p class="card-text"><?= $postObj->excerpt() ?>...</p>
                </div>
                <a href="/article/<?= $post->slug ?>-<?= $post->id ?>" class="text-center pb-2">lire plus</a>
                <div class="card-footer text-muted">
                    <?= ($postObj->getCreatedAt())   ?>
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