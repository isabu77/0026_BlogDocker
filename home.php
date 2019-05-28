<?php
    $pdo = new PDO('mysql:dbname=blog;host=172.17.0.2;charset=UTF8', 'bloguser', 'blogpwd');
	// $sql = "SELECT COUNT(id) FROM `post`";
	// $statement = $pdo->prepare($sql);
    // $statement->execute(); 

    // nb de pages : nb total / 10
    $pagination = $pdo->query('SELECT count(id) FROM `post`')->fetch()[0] /10;
    //$pagination = $pdo->query('SELECT count(id) as nbid FROM `post`')->fetch() /10;
    
    if (null != $_GET['page'] && intval($_GET['page']) > 0 && $_GET['page'] <= $pagination){
        $start = 10 * $_GET['page'] - 10;
    }else{
            if (null != $_GET['page'] && !intval($_GET['page']) || $_GET['page'] > $pagination){
                $message = "page introuvable";
                $posts = [];
            }
            $start = 0;
        }

        // liste des 10 posts de la page choisie :
        // $sql = "SELECT * FROM `post` ORDER BY `id` LIMIT 10 OFFSET " . 
        //          ( ($_GET['page'] == 1)? (0) : (($_GET['page']-1)*10)) ;
        $sql = "SELECT * FROM post ORDER BY id LIMIT 10 OFFSET {$start}" ; 

        $statement = $pdo->prepare($sql);
        $statement->execute(); 
        $posts = $statement->fetchAll(); // ici renvoie un tableau 
        //$rec = $statement->fetchAll(PDO::FETCH_OBJ); // PDO::FETCH_OBJ pour avoir un objet
    // }else{
    //     $posts = [];
    // }
?>
<html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>le BLOG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

<body>
    <section class="sectionHome">
        <h1>Le BLOG Docker</h1>
    </section>
    <?php 
    //if (count($posts) <= 0){
    if ($message){
            echo '<h2 class="alert-message">Page introuvable</h2>';
    }else{?>
    <section id="posts">
        <?php 
   //for($i = 10 * ($_GET['page']-1) ; $i < 10 * $_GET['page'] ; $i++) { 
   // for($i = 0 ; $i < count($posts) ; $i++) { 
       foreach($posts as $post) : ?>
        <article class="post">
            <p class="titre"><?= $post['id'] . '-' . $post['name']; ?></p>
            <p class="slug"><?= $post['slug']; ?></p>
            <p class="content"><?= substr((String)$post['content'],0,150) . '...'; ?></p>
        </article>
        <?php endforeach ?>
    </section>
    <?php } ?>
    <footer>
        <div>
            <nav>
                <ul>
                    <?php for ($i = 1 ; $i <= $pagination; $i++) :  ?>
                    <li><a href="/?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>
                </ul>
            </nav>
        </div>
    </footer>


</body>

</html>