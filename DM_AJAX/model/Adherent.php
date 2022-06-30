<?php
/***
 * Classe pour les adhérents
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once __DIR__ . "/../php/Conf/Connexion.php";
Connexion::init_pdo();

/***
 * Classe d'un adhérent
 */
class Adherent
{
    private $numAdherent;
    private $nom;
    private $prenom;
    private $livresEmpruntes;

    // Getter d'un adhérent
    public function getNumAdherent() {return $this->numAdherent;}
    public function getNom() {return $this->nom;}
    public function getPrenom() {return $this->prenom;}
    public function getLivresEmpruntes() {return $this->livresEmpruntes;}

    // Setter d'un adhérent
    public function setNumAdherent($numAdherent) {$this->numAdherent = $numAdherent;}
    public function setNom($nom) {$this->nom = $nom;}
    public function setPrenom($prenom) {$this->prenom = $prenom;}
    public function setLivresEmpruntes($livresEmpruntes) {$this->livresEmpruntes = $livresEmpruntes;}

    // Constructeur d'un adhérent
    public function __construct($numAdherent = NULL, $nom = NULL, $prenom = NULL) {
        if(!is_null($numAdherent) && !is_null($nom) && !is_null($prenom)) {
            $this->numAdherent = $numAdherent;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }
    }

    /***
     * Sélectionne les adhérents
     * @return tabResults Le tableau contenant les adhérents et leurs informations
     */
    public static function selectionAdherents()
    {
        try {
            $sql = "SELECT numAdherent, prenom, nom FROM adherents";
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
     * Ajoute un adhérent
     * @param prenom Le prénom de l'adhérent
     * @param nom Le nom de l'adhérent
     */
    public static function insererAdherent($prenom, $nom)
    {
        try {
            $sql = "INSERT INTO adherents (prenom, nom) VALUES (:prenom, :nom)";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('prenom' => $prenom, 'nom' => $nom));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de l'insertion dans la base de données.");
        }
    }

    /***
     * Enlève un adhérent
     * @param numAdherent Le numéro de l'adhérent
     */
    public static function supprimerAdherent($numAdherent)
    {
        try {
            $sql = "DELETE FROM adherents WHERE numAdherent = :numAdherent";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('numAdherent' => $numAdherent));
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la suppression d'un adhérent dans la base de données.");
        }
    }
}