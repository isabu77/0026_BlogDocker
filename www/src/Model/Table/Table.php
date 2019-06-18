<?php
namespace App\Model\Table;
/**
 *  Classe Table : accès aux tables
 **/
class Table
{
    /**
     * @var connect
     * @access private
     */
    protected static $_connect = null;

    /**
     * Constructeur de la classe
     *
     * @return void
     * @access private
     */
    protected function __construct()
    {
        if (self::$_connect == null)
            self::$_connect = Connect::getInstance();
    }
}