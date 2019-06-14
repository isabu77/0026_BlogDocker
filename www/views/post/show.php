<?php
use App\Model\PostTable;
/*
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */
$id = (int)$params['id'];
$slug = $params['slug'];

// Connexion à la base
$postTable = new PostTable();

// lecture de l'article îd dans la base (objet Post)
/**
 * @var Post|false
 */
$post = $postTable->getPost($id);

if (!$post) {
    throw new \exception("Aucun article ne correspond à cet Id");
}

// vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
 if ($post->getSlug() !== $slug){
    $url = $router->url('post', ['id' => $id, 'slug' => $post->getSlug()]);
    // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
    http_response_code(301);
    header('Location:' . $url);
    exit();
}

$categories = $postTable->getCategoriesOfPost($id);

$title = "Article " . $post->getName();

?>

<div class="text-muted text-center pb-5 mb-5">
    <p>Article <big><?= $id ?></big></p>
    <p>Slug : <big><?= $post->getSlug() ?></big></p>

    <p>Date : <big><?= $post->getCreatedAtDMY() ?></big></p>

    <?php foreach ($categories as $key => $category) :
        if ($key > 0) {
            echo ', ';
        }
        $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
        ?><a href="<?= $category_url ?>"><?= $category->getName() ?></a><?php
    endforeach ?>
</div>

<p class="mx-4 text-justify"><?= nl2br(htmlspecialchars($post->getContent())) ?></p>