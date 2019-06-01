<?php
namespace App;

// Classe principale d'accès à la base de données
class Modele
{
    private $pdo;

    // constructeur : connexion à la base
    public function __construct()
    {
        $this->pdo = new \PDO(
            "mysql:dbname=" .
                getenv('MYSQL_DATABASE') . ";host=" .
                getenv('MYSQL_HOST') . ";charset=UTF8",
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }

    // retourne un objet PDO de connexion à la base
    public function getPdo(): object
    {
        return (new PDO(
            "mysql:dbname=" .
                getenv('MYSQL_DATABASE') . ";host=" .
                getenv('MYSQL_HOST') . ";charset=UTF8",
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        ));
    }

    // retourne le nombre total de posts dans la table post
    public function getNbPost(): int
    {
        return ($this->pdo->query('SELECT count(id) FROM post')->fetch()[0]);
    }

    // retourne tous les articles d'une page de $perPage articles à partir de l'article $offset
    public function getPosts(int $perPage, int $offset): object
    {
        return ((object)$this->pdo->query("SELECT * FROM post 
        ORDER BY id 
        LIMIT {$perPage} 
        OFFSET {$offset}")
            ->fetchAll(\PDO::FETCH_OBJ));
    }

    // retourne un article recherché par son id
    public function getPost(int $id): object
    {
        return ((object)$this->pdo->query("SELECT * FROM post 
        WHERE id = {$id}")
            ->fetch(\PDO::FETCH_OBJ));
    }

    // retourne les catégories
    public function getCategories(): object
    {
        return ((object)$this->pdo->query(
            "SELECT * FROM category"
        )
            ->fetchAll(\PDO::FETCH_OBJ));
    }

    // retourne la catégories recherché par son id
    public function getCategory(int $id): object
    {
        return ((object)$this->pdo->query(
            "SELECT * FROM category WHERE id = {$id}"
        )
            ->fetch(\PDO::FETCH_OBJ));
    }
}
