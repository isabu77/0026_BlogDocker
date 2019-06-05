<?php
use App\Model\PostTable;
/*
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */
$id = (int)$params['id'];
/*
$slug = $params['slug'];
$title = "article " . $slug; */

// Connexion à la base
$postTable = new PostTable();

// lecture de l'article îd dans la base (objet Post)
$post = $postTable->getPost($id);

//dd($post);
$title = "Article " . $post->getName();


?>

<p>Article <big><?= $id ?></big></p>
<p>Slug : <big><?= $post->getSlug() ?></big></p>

<p>Date : <big><?= $post->getCreatedAt() ?></big></p>

<p><?= $post->getContent() ?></p>