<?php
use App\Model\PostTable;
/*
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */
$id = (int)$params['id'];

// Connexion à la base
$postTable = new PostTable();

// lecture de l'article îd dans la base (objet Post)
$post = $postTable->getPost($id);

$title = "Article " . $post->getName();

?>

<p>Article <big><?= $id ?></big></p>
<p>Slug : <big><?= $post->getSlug() ?></big></p>

<p>Date : <big><?= $post->getCreatedAtDMY() ?></big></p>

<p><?= $post->getContent() ?></p>