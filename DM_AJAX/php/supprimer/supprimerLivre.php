<?php
/***
 * Fichier php appelé qui permettra de supprimer un livre avec l'Ajax
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once '../../model/Livre.php';

if (isset($_GET['numLivre'])) {
    Livre::supprimerLivre($_GET['numLivre']); // Suppression du livre désigné si il y a un bien un numéro de livre
}
