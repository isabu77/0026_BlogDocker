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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity    ="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<body>
<section class="sectionHome">
		<h1>Le BLOG</h1>
		<h2>Welcome!</h2>
	</section>
    <section id="posts">
	<?php foreach($posts as $value) : ?>
		<article class="post">
        <h2><?= $value['id'] . '-' . $value['name']; ?></h2>
        <h3><?= $value['slug']; ?></h3>
			<p><?= $value['content']; ?></p>
		</article>
	<?php endforeach; ?>
</section>

   
</body>
</html>

