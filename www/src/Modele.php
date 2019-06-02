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
    private function getBdd(): object
    {
        if ($this->pdo == null) {
            $this->pdo = new \PDO(
                "mysql:dbname=" .
                    getenv('MYSQL_DATABASE') . ";host=" .
                    getenv('MYSQL_HOST') . ";charset=UTF8",
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD')
            );
        }
        return ($this->pdo);
    }

    // Exécute une requête SQL éventuellement paramétrée
    protected function executeQuery($sql, $params = null)
    {
        if ($params == null) {
            $resultat = $this->getBdd()->query($sql);    // exécution directe
        } else {
            $resultat = $this->getBdd()->prepare($sql);  // requête préparée
            $resultat->execute($params);
        }
        return $resultat;
    }

    

    
}
