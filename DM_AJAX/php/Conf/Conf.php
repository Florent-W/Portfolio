<?php
/***
 * Classe Conf permettant d'effectuer et de changer la configuration de la connexion
 * @author Florent Weltmann
 * @date Janvier 2022
 */

    class Conf {
        private static $database = array(
            'hostname' => 'db5002762296.hosting-data.io',
            'database' => 'dbs2203941',
            'login'    => 'dbu359354',
            'password' => 'Wiigen91A'
        );

        static public function getLogin() {
            return self::$database['login'];
        }

        static public function getHostname() {
            return self::$database['hostname'];
        }

        static public function getDatabase() {
            return self::$database['database'];
        }

        static public function getPassword() {
            return self::$database['password'];
        }
    }