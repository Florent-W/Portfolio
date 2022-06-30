<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=portfolio', 'root', 'root',  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); // Connexion à la base de données
        $reponse = $bdd->prepare("SET lc_time_names = 'fr_FR'"); // Conversion date en français
        $reponse->execute();
        $reponse->fetch();
        $reponse->closeCursor();
    } catch (Exception $erreur) {
        die('erreur : ' . $erreur->getMessage());
    }
    ?>