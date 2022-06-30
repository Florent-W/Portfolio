<?php
/***
 * Classe Connexion permettant de se connecter avec pdo à la base de données
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once 'Conf.php';

/***
 * Classe Connexion
 */
class Connexion
{
    public static $pdo;

    /***
     * Permet de se connecter à la base de données avec pdo
     */
    public static function init_pdo()
    {
        $hostname = Conf::getHostname();
        $database = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database", $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            die(" : Problème lors de la connexion à la base de données.");
        }
    }

    /***
     * Permet d'utiliser pdo et la base de données
     * @return mixed $pdo
     */
    public static function pdo() {
        return self::$pdo;
    }
}