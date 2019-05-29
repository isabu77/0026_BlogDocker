<?php
// utilisation de FAKER
// require the Faker autoloader
require_once '/var/www/vendor/autoload.php';

$pdo = new PDO('mysql:dbname=blog;host=blog.mysql;charset=UTF8', 'userblog', 'blogpwd');

// CREATION des TABLES
$pdo->exec("CREATE TABLE post(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT(650000) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY(id) )");

$pdo->exec("CREATE TABLE category(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    PRIMARY KEY(id) ) ");

$pdo->exec("CREATE TABLE user(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id) ) ");

$pdo->exec("CREATE TABLE post_category(
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(post_id, category_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES post (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,
    CONSTRAINT fk_category
        FOREIGN KEY (category_id)
        REFERENCES category (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT  ) ") ;

// VIDAGE des tables
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
for ($i=0; $i < 5 ; $i++){
    $pdo->exec("INSERT INTO category 
    SET name='{$faker->sentence(3, false)}', 
    slug='{$faker->slug}'");
    $categories[]= $pdo->lastInsertId();
}

// remplir la table de liaison
foreach ($posts as $post){
    $rdncategorie = $faker->randomElements($categories, 2);
    // $rdncategorie contient une seule case d'un id pris au hasard dans le tableua $categories
    foreach ($rdncategorie as $categorie){
        $pdo->exec("INSERT INTO post_category
        SET post_id={$post}, 
        category_id={$categorie}");
    }
}

$pwd = password_hash('admin',PASSWORD_BCRYPT);

// remplir la table user avec 1 user
$pdo->exec("INSERT INTO user SET username='admin', password='{$pwd}'");
