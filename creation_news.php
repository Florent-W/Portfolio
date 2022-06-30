<?php
$title = "Création de news";
include('Header.php');
?>

<body class="background">
    <div class="container container-bordure animated fadeInRight bg-white">
        <div class="row">
            <form class="form" id="creation_news" method="post" enctype="multipart/form-data" style="margin-top:50px; margin-bottom: 50px; padding-left: 50px; padding-right: 50px;">
                <h1 class="text-dark">Création de news</h1>
                <hr> <!-- Trait -->
                <?php if (isset($_SESSION['pseudo'])) { // Si l'utilisateur est connecter, il peut modifier un article
                ?>
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" value="<?php if (!empty($_POST['titre'])) echo $_POST['titre'] ?>" required onchange="controleTexteInput(this, 'titreIndication', 'titre')" class="form-control"> <!-- On conserve les valeurs au cas où il y a une erreur dans l'envoi -->
                        <label id="titreIndication" class="text-danger"><?php if (isset($_POST['titre']) and empty($_POST['titre'])) echo "Veuillez choisir un titre" ?></label> <!-- Indication titre, il sera indiqué si le texte n'a pas de caractère ou le formulaire a déjà été soumis mais qu'il y a une erreur -->
                    </div>
                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col">

                                <script>
                                    var nom_contenu = 'contenu';
                                </script>
                                <?php
                                include('bouton_bb_code.php');
                                ?>

                            </div>
                        </div>
                        <textarea name="contenu" id="contenu" required oninput="previsualisationContenu()" onchange="controleTexteInput(this, 'contenuIndication', 'contenu')" class="form-control" rows="5"><?php if (!empty($_POST['contenu'])) {
                                                                                                                                                                                                                    echo $_POST['contenu'];
                                                                                                                                                                                                                } ?></textarea>
                        <label id="contenuIndication" class="text-danger"><?php if (isset($_POST['contenu']) and empty($_POST['contenu'])) echo "Veuillez choisir un contenu"; ?></label> <!-- Indication contenu, il sera indiqué si le texte n'a pas de caractère ou le formulaire a déjà été soumis mais qu'il y a une erreur -->
                        <hr>
                        <div name="previsualisationContenu" id="previsualisationContenu" style="white-space: pre-wrap;"></div>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <select class="form-control" name="categorie" id="categorie" required onchange="controleTexteInput(this, 'categorieIndication', 'categorie')" class="form-control">
                            <!-- Selection catégorie de l'article -->
                            <?php $reponse = $bdd->prepare('SELECT nom FROM categorie ORDER BY id');
                            $reponse->execute();
                            while ($donnees = $reponse->fetch()) { ?>
                                <option value="<?php echo $donnees['nom']; ?>" <?php if (isset($_POST['categorie']) and $_POST['categorie'] == $donnees['nom']) echo 'selected="selected"'; ?>><?php echo $donnees['nom']; ?></option> <!-- Les différentes options du select -->
                            <?php }

                            $reponse->closeCursor(); ?>
                        </select>
                        <label id="categorieIndication" class="text-danger"><?php if (isset($_POST['categorie']) and empty($_POST['categorie'])) echo "Veuillez choisir une catégorie"; ?></label> <!-- Indication categorie, il sera indiqué si le texte n'a pas de caractère ou le formulaire a déjà été soumis mais qu'il y a une erreur -->
                    </div>

                    <div class="form-group">
                        <label for="bandeaux">Bannière (non obligatoire)</label> <!-- La bannière est placé au début des articles -->
                        <div class="input-group">
                            <!-- Upload de bannière -->
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept=".jpg, .png, .bmp, .gif" name="bandeaux" id="inputGroupFile02" onchange="controleTexteInput(this, 'banniereIndication', 'miniature')" aria-describedby="inputGroupFileAddon02"> <!-- Si un fichier a été choisi, l'événement onchange permettra de montrer le nom du fichier sur le label d'information -->
                                <label id="banniereIndication" class="custom-file-label" for="inputGroupFile02">Choisir fichier</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="miniature">Miniature</label>
                        <div class="input-group">
                            <!-- Upload de miniature -->
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept=".jpg, .png, .bmp, .gif" name="miniature" id="inputGroupFile01" required onchange="controleTexteInput(this, 'miniatureIndication', 'miniature')" aria-describedby="inputGroupFileAddon01"> <!-- Si un fichier a été choisi, l'événement onchange permettra de montrer le nom du fichier sur le label d'information -->
                                <label id="miniatureIndication" class="custom-file-label" for="inputGroupFile01">Choisir fichier</label>
                            </div>
                        </div>
                    </div>

                    <!-- On passe l'id de l'auteur -->
                    <?php
                    $pseudo = null;

                    if (isset($_SESSION['pseudo'])) {
                        $pseudo = $_SESSION['pseudo'];
                    }

                    $reponse2 = $bdd->prepare('SELECT id, statut FROM utilisateurs WHERE utilisateurs.pseudo = :pseudo'); // Récupération de l'id et de son statut
                    $reponse2->execute(array('pseudo' => $pseudo));
                    $donnees2 = $reponse2->fetch();
                    ?>
                    <input type="hidden" name="auteur" id="auteur" value="<?php echo $donnees2['id']; ?>">

                    <!-- On récupère le statut de l'utilisateur et si le statut de l'utilisateur est suffisant, on approuve la news, sinon la news est rédigé mais il faudra l'approuver après -->
                    <input type="hidden" name="article_approuver" id="article_approuver" value="<?php if ($donnees2['statut'] == "Administrateur") {
                                                                                                    echo 1;
                                                                                                } else {
                                                                                                    echo 0;
                                                                                                }; ?>">
                    <?php
                    $reponse2->closeCursor();
                    ?>

                    <button type="submit" id="btn_envoi" class="btn btn-success">Envoyer</button>
                <?php } else if (!isset($_SESSION['pseudo'])) {
                ?><div class="alert alert-warning" role="alert" style="margin-top: 10px;">Veuillez vous <a href="/portfolio/connexion.php">connecter</a> pour écrire un article.</div> <?php
                                                                                                                                                                            }    ?>
            </form>
        </div>
    </div>

    <?php
    include('footer.php');
    include('upload_image.php');
    include('ajout_url.php');
    include('ajout_tableau.php');
    include('ajout_video.php');

    if (!empty($_POST['titre']) and !empty($_POST['contenu']) and !empty($_POST['auteur']) and !empty($_POST['categorie']) and isset($_POST['article_approuver']) and !empty($_FILES['miniature']['tmp_name'])) { // Traitement
        $titre = $_POST['titre'];
        $url = EncodageTitreEnUrl($titre);
        $contenu = $_POST['contenu'];
        $categorie = $_POST['categorie'];
        $article_approuver = $_POST['article_approuver'];
        $nom_miniature = $_FILES['miniature']['name'];

        $tailleImage = getimagesize($_FILES['miniature']['tmp_name']); // Récupération taille de l'image uploadée
        $largeur = $tailleImage[0];
        $hauteur = $tailleImage[1];
        $largeur_miniature = 300; // Largeur de la future miniature
        $hauteur_miniature = $hauteur / $largeur * 300;

        $type_image = 'miniature'; // Recupère le nom de l'image (formulaire) pour indiquer quel type de fichier on va récupérer, miniature
        include('image_traitement.php');

        if (!empty($_FILES['bandeaux']['tmp_name'])) { // On regarde si une bannière à été ajoutée
            $nom_banniere = $_FILES['bandeaux']['name']; // Si il y a un nom, cela sera bien mis dans la base de donnees

            $tailleImage = getimagesize($_FILES['bandeaux']['tmp_name']); // Récupération taille de l'image uploadée
            $largeur = $tailleImage[0];
            $hauteur = $tailleImage[1];
            if ($largeur > 2500) { // On redimensionne
                redimensionImage($largeur, $hauteur, 2500, 2500);
            } else {
                $largeur_miniature = $largeur;
                $hauteur_miniature = $hauteur;
            }

            $type_image = 'bandeaux'; // Recupère le nom de l'image (formulaire) pour indiquer quel type de fichier on va récupérer, miniature, bien penser à mettre le nom du dossier pour le nom de l'input
            include('image_traitement.php');
        } else { // Si une image n'a pas été mise
            $nom_banniere = null;
        }

        $reponse = $bdd->prepare('INSERT INTO article (titre, contenu, nom_categorie, nom_miniature, date_creation, url
, id_auteur, approuver, nom_banniere) VALUES (:titre, :contenu, :categorie, :nom_miniature, :date_creation, :url, :id_auteur, :article_approuver, :nom_banniere)'); // Insertion news
        $reponse->execute(array('titre' => $titre, 'contenu' => $contenu, 'categorie' => $categorie, 'nom_miniature' => $nom_miniature, 'date_creation' => date("Y-m-d H:i:s"), 'url' => $url, 'id_auteur' => $_POST['auteur'], 'article_approuver' => $article_approuver, 'nom_banniere' => $nom_banniere));
    ?>
        <script>
           document.location.href = 'index.php'; // Redirection nouvelle url
        </script>

    <?php
    }
?>
</body>