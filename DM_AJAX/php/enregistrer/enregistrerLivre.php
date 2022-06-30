<?php
/***
 * Fichier php appelé en Ajax qui permettra d'insérer un nouveau livre
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once('../../model/Livre.php');
echo ($_GET['idGenreLivre']);
if(isset($_GET['titreLivre']) && isset($_GET['auteurLivre']) && isset($_GET['idGenreLivre'])) { // Si le formulaire a bien été complété, le livre est inséré
    Livre::insererLivre($_GET['titreLivre'], $_GET['auteurLivre'], $_GET['idGenreLivre']);
}