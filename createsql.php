<?php
// utilisation de FAKER
// require the Faker autoloader
require_once 'vendor/autoload.php';

$pdo = new PDO('mysql:dbname=blog;host=172.17.0.2;charset=UTF8', 'bloguser', 'blogpwd');

// desactive la verification des clés étrangères pour pouvoir vider les tables
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
// reactive la verification des clés étrangères
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

/** @var Faker */
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create('fr_FR');
// '{$faker}' : variable dans une chaine de caractères
// sentence : crée une phrase de 5 mots
$posts = [];
$categories = [];

// remplir la table post avec 50 articles
for ($i=0; $i < 50 ; $i++){
    $pdo->exec("INSERT INTO post 
    SET name='{$faker->sentence()}', 
    slug='{$faker->slug}', 
    content='{$faker->paragraphs(rand(3,15), true)}', 
    created_at='{$faker->date} {$faker->time}'");
    $posts[]= $pdo->lastInsertId();
}

// remplir la table category avec 10 categories
for ($i=0; $i < 10 ; $i++){
    $pdo->exec("INSERT INTO category 
    SET name='{$faker->sentence(3, false)}', 
    slug='{$faker->slug}'");
    $categories[]= $pdo->lastInsertId();
}

// remplir la table de liaison
foreach ($posts as $post){
    $rdncategorie = $faker->randomElements($categories, 1);
    // $rdncategorie contient une seule case d'un id pris au hasard dans le tableua $categories
    foreach ($rdncategorie as $categorie){
        $pdo->exec("INSERT INTO post_category
        SET post_id={$post}, 
        category_id={$categorie}");
    }
}
$pwd = password_hash($password,PASSWORD_BCRYPT);
//$faker->password()

// remplir la table user avec 10 users
for ($i=0; $i < 20 ; $i++){
    $pdo->exec("INSERT INTO user 
    SET username='{$faker->username()}', 
    password='{$pwd}'");
}

echo 'terminé';
//dd($faker);


// generate data by accessing properties
//echo $faker->name . ' --- ';
  // 'Lucy Cechtelar';
//echo $faker->address . ' --- ';
  // "426 Jordy Lodge
  // Cartwrightshire, SC 88120-6700"
//echo $faker->text . ' --- ';



