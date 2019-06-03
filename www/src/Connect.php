<?php
namespace App;

// Classe principale d'accès à la base de données (singleton)
class Connect
{
    /**
     * @var Connect
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * @var pdo
     * @access private
     * @private
     */
    private static $pdo;

    /**
     * Constructeur de la classe
     *
     * @param void
     * @return void
     */
    private function __construct()
    { }

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Connect
     */
    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new Connect();
        }

        return self::$_instance;
    }
    /**
     *  retourne un objet PDO de connexion à la base
     **/

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

    /**
     *  Exécute une requête SQL éventuellement paramétrée
     **/

    public function executeQuery($sql, $params = null)
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
