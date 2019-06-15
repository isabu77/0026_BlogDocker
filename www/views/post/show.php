<?php
use App\Model\PostTable;
/*
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */

$id = (int)$params['id'];
$slug = $params['slug'];

// lecture de l'article dans la base (objet Post) par son id
/**
 * @var Post|false
 */
$postTable = PostTable::getInstance();
$post = $postTable->getPost($id);

if (!$post) {
    throw new \exception("Aucun article ne correspond à cet Id");
}

// vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['id' => $id, 'slug' => $post->getSlug()]);
    // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
    http_response_code(301);
    header('Location:' . $url);
    exit();
}

$title = "Article " . $post->getName();

?>

<div class="text-muted text-center pb-5 mb-5">
    <p>Article <big><?= $id ?></big></p>
    <p>Date : <big><?= $post->getCreatedAtDMY() ?></big></p>

    <?php foreach ($post->getCategories() as $key => $category) :
        $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
        ?>
        <li class="list-group-item bg-light"><a class="card-link" href="<?= $category_url ?>"><?= $category->getName() ?></a></li>
    <?php endforeach ?>
</div>

<p class="mx-4 text-justify"><?= nl2br(htmlspecialchars($post->getContent())) ?></p>