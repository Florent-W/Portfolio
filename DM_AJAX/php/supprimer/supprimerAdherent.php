<?php
/***
 * Fichier php appelé qui permettra de supprimer un adhérent avec l'Ajax
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once('../../model/Adherent.php');
require_once('../../model/Livre.php');

if (isset($_GET['numAdherent'])) {
    Livre::miseAJourAdherentRendreLivres($_GET['numAdherent']); // Les livres empruntés par l'adhérent sont rendus
    Adherent::supprimerAdherent($_GET['numAdherent']); // Suppression de l'adhérent si un numéro est bien appelé
}
