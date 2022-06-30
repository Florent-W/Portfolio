<?php
/***
 * Fichier php appelé en Ajax qui permettra d'insérer un nouvel adhérent
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once('../../model/Adherent.php');

if(isset($_GET['prenom']) && isset($_GET['nom'])) { // Si le formulaire a bien été complété, l'adhérent est inséré
    Adherent::insererAdherent($_GET['prenom'], $_GET['nom']);
}