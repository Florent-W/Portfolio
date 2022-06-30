<?php
/***
 * Classe des livres
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once __DIR__ . "/../php/Conf/Connexion.php";
Connexion::init_pdo();

class Livre
{
    private $numLivre;
    private $titre;
    private $auteur;
    private $numEmprunteur;
    private $idGenre;

    // Getter d'un livre
    public function getNumLivre()
    {
        return $this->numLivre;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function getNumEmprunteur()
    {
        return $this->numEmprunteur;
    }

    public function getIdGenre()
    {
        return $this->idGenre;
    }

    // Setter d'un livre
    public function setNumLivre($numLivre)
    {
        $this->numLivre = $numLivre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    public function setNumEmprunteur($numEmprunteur)
    {
        $this->numEmprunteur = $numEmprunteur;
    }

    public function setIdGenre($idGenre)
    {
        $this->idGenre = $idGenre;
    }

    // Constructeur d'un livre
    public function __construct($numLivre = NULL, $titre = NULL, $auteur = NULL, $numEmprunteur = NULL, $idGenre = NULL)
    {
        if (!is_null($numLivre) && !is_null($titre) && !is_null($auteur) && !is_null($numEmprunteur) && !is_null($idGenre)) {
            $this->numLivre = $numLivre;
            $this->titre = $titre;
            $this->auteur = $auteur;
            $this->numEmprunteur = $numEmprunteur;
            $this->idGenre = $idGenre;
        }
    }

    /***
     * Sélectionne les livres qui sont disponibles
     * @return tabResults Le tableau contenant les livres qui n'ont pas été empruntés
     */
    public static function selectionLivresDisponibles()
    {
        try {
            $sql = "SELECT numLivre, titre FROM livres WHERE numEmprunteur IS NULL";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute();
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Sélectionne les livres disponibles avec un genre
     * @return tabResults Le tableau contenant les livres qui sont disponibles
     */
    public static function selectionLivresDisponiblesParGenre($id_genre)
    {
        try {
            $sql = "SELECT numLivre, titre FROM livres INNER JOIN genres ON livres.id_genre = genres.id_genre WHERE numEmprunteur IS NULL AND genres.id_genre = :id_genre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('id_genre' => $id_genre));
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Sélectionne les livres empruntés
     * @return tabResults Le tableau contenant les livres qui ne sont pas disponibles
     */
    public static function selectionLivresEmpruntes()
    {
        try {
            $sql = "SELECT livres.numLivre, livres.titre, livres.numEmprunteur, adherents.prenom AS prenomAdherent, adherents.nom AS nomAdherent FROM livres INNER JOIN adherents ON livres.numEmprunteur = adherents.numAdherent WHERE numEmprunteur IS NOT NULL";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute();
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Sélectionne les livres empruntés avec un genre
     * @return tabResults Le tableau contenant les livres qui ne sont pas disponibles
     */
    public static function selectionLivresEmpruntesParGenre($id_genre)
    {
        try {
            $sql = "SELECT livres.numLivre, livres.titre, livres.numEmprunteur, adherents.prenom AS prenomAdherent, adherents.nom AS nomAdherent FROM livres INNER JOIN genres ON livres.id_genre = genres.id_genre INNER JOIN adherents ON livres.numEmprunteur = adherents.numAdherent WHERE numEmprunteur IS NOT NULL AND genres.id_genre = :id_genre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('id_genre' => $id_genre));
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Sélectionne les livres empruntés pour un adhérent
     * @param numAdherent numéro de l'adhérent
     * @return tabResults Le tableau contenant les livres empruntés par l'adhérent
     */
    public static function selectionLivresEmpruntesParAdherent($numAdherent)
    {
        try {
            $sql = "SELECT numLivre, titre, auteur FROM livres INNER JOIN adherents ON livres.numEmprunteur = adherents.numAdherent WHERE livres.numEmprunteur IS NOT NULL AND adherents.numAdherent = :numAdherent";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numAdherent' => $numAdherent));
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            $tabResults['nombreLivre'] = $req_prep->rowCount();
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Sélectionne les livres empruntés pour un adhérent
     * @param numAdherent numéro de l'adhérent
     * @return tabResults Le tableau contenant les livres empruntés par l'adhérent
     */
    public static function selectionLivresEmpruntesParAdherentParGenre($numAdherent, $idGenre)
    {
        try {
            $sql = "SELECT numLivre, titre, auteur FROM livres INNER JOIN genres ON livres.id_genre = genres.id_genre INNER JOIN adherents ON livres.numEmprunteur = adherents.numAdherent WHERE livres.numEmprunteur IS NOT NULL AND adherents.numAdherent = :numAdherent AND livres.id_genre = :idGenre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numAdherent' => $numAdherent, 'idGenre' => $idGenre));
            $tabResults = $req_prep->fetchAll(PDO::FETCH_ASSOC);
            $tabResults['nombreLivre'] = $req_prep->rowCount();
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

    /***
     * Ajoute un livre
     * @param titreLivre Le titre du livre
     * @param auteurLivre L'auteur du livre
     * @param $idGenreLivre L'id du genre du livre
     */
    public static function insererLivre($titreLivre, $auteurLivre, $idGenreLivre)
    {
        try {
            $sql = "INSERT INTO livres (titre, auteur, id_genre) VALUES (:titre, :auteur, :id_genre)";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('titre' => $titreLivre, 'auteur' => $auteurLivre, 'id_genre' => $idGenreLivre));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de l'insertion dans la base de données.");
        }
    }


    /***
     * Enlève un livre
     * @param numLivre Le numéro du livre
     */
    public static function supprimerLivre($numLivre)
    {
        try {
            $sql = "DELETE FROM livres WHERE numLivre = :numLivre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numLivre' => $numLivre));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la suppression d'un livre dans la base de données.");
        }
    }

    /***
     * Rend les livres avant la suppression d'un adhérent (Mise à jour du statut des livres d'un adhérent vers disponible)
     * @param $numAdherent Le numéro d'un adhérent
     */
    public static function miseAJourAdherentRendreLivres($numAdherent)
    {
        try {
            $sql = "UPDATE livres SET numEmprunteur = NULL WHERE numEmprunteur = :numEmprunteur";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numEmprunteur' => $numAdherent));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la mise à jour dans la base de données.");
        }
    }

    /***
     * Mise à jour du statut du livre vers disponible
     * @param numLivre Le numéro du livre
     */
    public static function miseAJourLivreEmprunterVersDisponible($numLivre)
    {
        try {
            $sql = "UPDATE livres SET numEmprunteur = NULL WHERE numLivre = :numLivre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numLivre' => $numLivre));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la mise à jour dans la base de données.");
        }
    }

    /***
     * Mise à jour du statut du livre vers emprunter, le numéro de l'adhérent qui a emprunté est ajouté
     * @param numLivre Le numéro du livre
     * @param numAdherent Le numéro de l'adhérent
     */
    public static function miseAJourLivreDisponibleVersEmprunter($numLivre, $numAdherent)
    {
        try {
            $sql = "UPDATE livres SET numEmprunteur = :numEmprunteur WHERE numLivre = :numLivre AND :numEmprunteur IN (select numAdherent from adherents)";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numEmprunteur' => $numAdherent, 'numLivre' => $numLivre));
            $nb_ligne_maj = $req_prep->rowCount();

            if ($nb_ligne_maj == 0) { // Si il n'y a pas de ligne mise à jour, il y a un message d'erreur
                echo json_encode('Aucun adhérent n\'a cet identifiant.', JSON_UNESCAPED_UNICODE);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la mise à jour dans la base de données.");
        }
    }
}