<?php
/***
 * Classe contenant les appels à la table Genre
 * @author Florent Weltmann
 * @date Janvier 2022
 */

require_once __DIR__ . "/../php/Conf/Connexion.php";
Connexion::init_pdo();

class Genre
{
    /***
     * Sélectionne les genres
     * @return tabResults Le tableau contenant les genres
     */
    public static function selectionGenres()
    {
        try {
            $sql = "SELECT id_genre, nom_genre FROM genres";
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
     * Sélectionne un genre à partir d'un id
     * @param idGenre l'id du genre demandé
     * @return result le genre demandé
     */
    public static function selectionGenre($idGenre)
    {
        try {
            $sql = "SELECT id_genre, nom_genre FROM genres WHERE id_genre = :id_genre";
            $req_prep = Connexion::pdo()->prepare($sql);
            $req_prep->execute(array('id_genre' => $idGenre));
            $result = $req_prep->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }
}