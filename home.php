<?php
    $pdo = new PDO('mysql:dbname=blog;host=172.17.0.2;charset=UTF8', 'bloguser', 'blogpwd');
	$sql = "SELECT * FROM `post`";
	$statement = $pdo->prepare($sql);
	$statement->execute(); 
	$posts = $statement->fetchAll();

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
    if ($_GET['page'] < 1 || $_GET['page'] > 5){
        echo '<h2>page inconnue</h2>';
    }else{?>
    <section id="posts">
    <?php 
   for($i = 10 * ($_GET['page']-1) ; $i < 10 * $_GET['page'] ; $i++) { 

    ?>
        <article class="post">
            <p class="titre"><?= $posts[$i]['id'] . '-' . $posts[$i]['name']; ?></p>
            <p class="slug"><?= $posts[$i]['slug']; ?></p>
            <p class="content"><?= substr((String)$posts[$i]['content'],0,150) . '...'; ?></p>
        </article>
        <?php } }?>
    </section>

    <footer>
        <div>
            <nav>
                <ul>
                    <?php
                    for ($i = 0 ; $i < count($posts); $i += 10){
                     ?>
                        <li><a href="?page=<?= $i/10+1 ?>"><?= $i/10+1 ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </footer>


</body>

</html>