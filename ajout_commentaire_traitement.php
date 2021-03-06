<?php
if($type_commentaire == "commentaire") {
    if (isset($_POST['ajout_commentaire']) and isset($_SESSION['pseudo']) and isset($_POST['id_news'])) { // Traitement ajout commentaire
        $commentaire = $_POST['ajout_commentaire'];

        $reponse = $bdd->prepare('INSERT INTO commentaire (id_utilisateur, contenu, id_news, date_commentaire) VALUES (:id_utilisateur, :contenu, :id_news, :date_commentaire)');
        $reponse->execute(array('id_utilisateur' => $_SESSION['id'], 'contenu' => $commentaire, 'id_news' => $_POST['id_news'], 'date_commentaire' => date(("Y-m-d H:i:s"))));

        $reponse->closeCursor();
    ?>
        <script>
            document.location.href = '/portfolio/news/<?php echo $_POST['url']; ?>-<?php echo $_POST['id_news']; ?>'; // Redirection nouvelle url
        </script>
    <?php
    }
}