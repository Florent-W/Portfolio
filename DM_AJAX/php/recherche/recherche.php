<?php
/***
 * Fichier php appelé qui permettra de sélectionner tous les adhérents et les livres pour l'accueil de la médiathèque
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once '../../model/Adherent.php';
require_once '../../model/Livre.php';
require_once '../../model/Genre.php';

$liste_adherents = Adherent::selectionAdherents(); // Appel de la liste des adhérents
foreach ($liste_adherents as $nombreAdherent => $adherent) {
    if(!isset($_GET['idGenre']) || $_GET['idGenre'] == 'Tous') {
        $liste_adherents[$nombreAdherent]['livreEmpruntes'] = Livre::selectionLivresEmpruntesParAdherent($adherent['numAdherent']); // On ajoute les livres empruntés pour chaque adhérent
    } else {
        $liste_adherents[$nombreAdherent]['livreEmpruntes'] = Livre::selectionLivresEmpruntesParAdherentParGenre($adherent['numAdherent'], $_GET['idGenre']); // On ajoute les livres empruntés pour chaque adhérent par genre
    }
}

// Si l'id du genre n'est pas demandé, on affiche tous les livres
if(!isset($_GET['idGenre']) || $_GET['idGenre'] == 'Tous') {
    $tab_resultats = array($liste_adherents, Livre::selectionLivresDisponibles(), Livre::selectionLivresEmpruntes(), Genre::selectionGenres());
} else {
    $tab_resultats = array($liste_adherents, Livre::selectionLivresDisponiblesParGenre($_GET['idGenre']), Livre::selectionLivresEmpruntesParGenre($_GET['idGenre']), Genre::selectionGenres());
}
echo json_encode($tab_resultats);