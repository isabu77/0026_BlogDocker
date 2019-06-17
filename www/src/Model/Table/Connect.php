<?php
namespace App\Model\Table;

/**
 * Classe principale d'accès à la base de données (singleton)
 */
class Connect
{
    /**
     * L'objet unique Connect
     * @var $_instance
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * @var pdo
     * @access private
     * @static
     */
    private static $pdo;

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
     * @param void
     * @return \PDO
     **/
    private function getBdd(): \PDO
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
     * @param string $sql
     * @param [] $params
     * @return \PDO
     **/
    public function executeQuery(string $sql, $params = null)
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
