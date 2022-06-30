<?php
/***
 *  Fichier php appelé qui permettra de mettre à jour l'état du livre (emprunté ou disponible)
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once('../../model/Livre.php');

if(isset($_GET['numLivre'])&& isset($_GET['action'])) {
    if($_GET['action'] == "disponible") { // Mise à jour du livre vers disponible
        Livre::miseAJourLivreEmprunterVersDisponible($_GET['numLivre']);
    } else if($_GET['action'] == "emprunter" && isset($_GET['numAdherent'])) { // Mise à jour du livre vers emprunté
        if($_GET['numAdherent'] > 0) {
            Livre::miseAJourLivreDisponibleVersEmprunter($_GET['numLivre'], $_GET['numAdherent']);
        }
        else {
            echo json_encode('Numéro d\'adhérent trop petit');
        }
    }
}