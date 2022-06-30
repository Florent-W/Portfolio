<div class="view">
    <?php
    $reponse = $bdd->prepare('SELECT article.id, article.url, article.nom_categorie, article.nom_miniature, article.contenu, article.titre, DATE_FORMAT(date_creation, "%Y/%M/%d/%Hh%i") AS date_article_dossier, DATE_FORMAT(date_creation, "%d %M %Y") AS date_article FROM article WHERE approuver = 1 ORDER BY id DESC LIMIT 15'); // Sélection des articles
    $reponse->execute();
    $reponse->closeCursor();

    if (!isset($_GET['page'])) { // Si on arrive sur l'accueil, la page selectionnée par défaut est la une
        $pageNewsSelectionner = 1;
    } else {
        $pageNewsSelectionner = $_GET['page'];
    }

    ?>

    <div id="fullpage" style="overflow-x: hidden">
        <div class="section fp-auto-height" style="margin-bottom: 1vw;" data-anchor="section_presentation">
            <h1 class="animate__animated animate__bounceInDown animate__delay-0.5s text-center text-dark">Florent
                Weltmann</h1>
            <h2 class="animate__animated animate__bounceInDown animate__delay-0.5s"><i>Actuellement en licence
                    Professionnelle Programmation Internet et Systèmes Mobiles, je
                    suis également développeur web en Alternance.</i></h2>
            <div class="row">


                <div class="border border-primary rounded animate__animated animate__bounceInDown animate__delay-0.5s"
                     data-aos="fade-down" style="border-radius: 5px;">
                    <h3 style="text-decoration: underline">Diplômes</h3>
                    <ul style="list-style-type: none;">
                        <li>Baccalauréat STI2D - Lycée L’Essouriau aux Ulis (91)</li>
                        <li>Brevet de Technicien Supérieur Services Informatiques aux
                            Organisations
                        </li>
                        <li>Licence Professionnelle Programmation Internet et Systèmes Mobiles à l'I.U.T. d'Orsay - En cours</li>
                    </ul>
                </div>

                <h3 style="text-decoration: underline"
                    class="animate__animated animate__bounceInDown animate__delay-0.5s" data-aos="fade-down">Expériences
                    Professionnelles</h3>
                <div class="col-md-3 col-xs-10 bg-white case-presentation animate__animated animate__bounceInDown animate__delay-0.5s border-case"
                     data-aos="fade-down">
                    <h4>Regiex – Les Mousquetaires</h4>
                    <h6>Stage : Une semaine en 2009</h6>
                    <h5>Stage d’une semaine dans la filiale chargé de la publicité du
                        groupement « Les Mousquetaires »</h5>
                </div>
                <div class="col-md-3 col-xs-10 bg-white case-presentation animate__animated animate__bounceInDown animate__delay-0.5s border-case"
                     data-aos="fade-down">
                    <h4>STIME – Les Mousquetaires</h4>
                    <h6>Stage au sein de l’équipe des Etudes Techniques : 29 Mai 2017 – 23 Juin 2017</h6>
                    <h5>Mission :
                        Ecritures et corrections de requêtes SQL dans la base de données
                        de développement de l’environnement Oracle</h5>
                </div>
                <div class="col-md-3 col-xs-10 bg-white case-presentation animate__animated animate__bounceInDown animate__delay-0.5s border-case"
                     data-aos="fade-down">
                    <h4>STIME – Les Mousquetaires</h4>
                    <h6>Stage au sein de l’équipe des Etudes Techniques : 19 Février 2018 – 30 Mars 2018</h6>
                    <h5>Missions :
                        Participation à la maintenance évolutive et corrective du progiciel
                        Finances Oracle PeopleSoft
                        Création et modification des écrans (interfaces)
                        Ecriture et modification de requêtes SQL</h5>
                </div>

                <div class="col-md-3 col-xs-10 bg-white case-presentation animate__animated animate__bounceInDown animate__delay-0.5s border-case2"
                     data-aos="fade-down">
                    <h4>Glitchworlds</h4>
                    <h6>Développement : 2020</h6>
                    <h5>Missions :
                        Création, développement et rédaction des articles de
                        Glitchworlds.com</h5>
                </div>

                <div class="col-md-3 col-xs-10 bg-white case-presentation animate__animated animate__bounceInDown animate__delay-0.5s border-case2"
                     data-aos="fade-down">
                    <h4>DSI de l'Ecole Polytechnique</h4>
                    <h6>Apprentissage au sein de l'équipe de développement web de l'Ecole Polytechnique : Septembre 2021
                        - Septembre 2022</h6>
                    <h5>Missions :
                        <div>Développement, modifications, création de pages sur le portail Pégase, un portail pour les
                            étudiants de l'école
                        </div>
                        <div>Développement et modification d'une interface pour le recensement des personnes à la
                            bibliothèque centrale
                        </div>
                        <div>Support pour les autres projets</div>
                    </h5>
                </div>

                <h3 data-aos="fade-down" style="text-decoration: underline">Compétences</h3>
                <div class="col-md-3 col-xs-6 bg-white case-presentation border-case" data-aos="fade-down">
                    <h4>Bureautique</h4>
                    <div>Powerpoint</div>
                    <div>Excel</div>
                    <div>Word</div>
                    <div>Sony Vegas</div>
                </div>
                <div class="col-md-3 col-xs-6 bg-white case-presentation border-case" data-aos="fade-down">
                    <h4>Progiciel de Gestion (ERP)</h4>
                    <div>Oracle PeopleSoft Finances</div>
                </div>
                <div class="col-md-3 col-xs-6 bg-white case-competences border-case" data-aos="fade-down">
                    <h3 style="text-decoration: underline" data-aos="fade-down">Langages Informatiques</h3>
                    <div class="animate__animated animate__backInRight animate__delay-1s">HTML</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">CSS</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">SQL</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">Javascript</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">Jquery</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">PHP</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">Bootstrap</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">C#</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">C++</div>
                    <div class="animate__animated animate__backInRight animate__delay-1s">Unity</div>
                    <div class="animate__animated animate__backInRight animate__delay-2s">En cours d'apprentissage du
                        React Native
                    </div>
                </div>
                <h3 style="text-decoration: underline" data-aos="fade-down">Langues</h3>
                <div class="d-flex justify-content-center">
                    <div class="col-md-3 col-xs-6 bg-white case-presentation" data-aos="fade-down"
                         style="border-radius: 3vh; border: solid; margin-left: 5%;">
                        <h4>Anglais (B2 - 860 TOEIC)</h4>
                    </div>
                    <div class="col-md-3 col-xs-6 bg-white case-presentation" data-aos="fade-down"
                         style="border-radius: 3vh; border: solid; margin-left: 5%;">
                        <h4>Espagnol (B1)</h4>
                    </div>
                </div>

                <h2 style="text-decoration: underline" data-aos="fade-down">Contact</h2>
                <div class="col-md-3 col-xs-6 bg-white d-flex case-info" data-aos="fade-down"
                     style="border-radius: 3vh; border: solid; margin-right: auto; margin-left: auto; margin-bottom: 3%; background-image: url('/portfolio/background/background131.jpg');">
                    <div>6 rue Ernest Cousseran
                        91470 Limours
                    </div>
                    <div>florent.weltmann@gmail.com</div>
                    <div>06 05 04 17 91</div>
                    <div><a href="http://glitchworlds.com/portfolio/">Portfolio</a></div>
                    <div><a href="http://glitchworlds.com/">Site Internet</a></div>
                    <h3>Objectif</h3>
                    <div>Développeur Informatique</div>
                </div>
            </div>
        </div>


        <?php
        $offsetPageNews = 20 * ($pageNewsSelectionner - 1); // Offset pour dire quand on commence à prendre les news

        if (isset($_GET['article_approuver'])) {
            $selection_article_approuver = $_GET['article_approuver']; // Si 1, les news selectionnées sont celles approuvés, sinon celle pas encore approuvés
        } else {
            $selection_article_approuver = 1;
        }

        $reponse = $bdd->prepare('SELECT COUNT(*) as nb_article FROM article WHERE approuver = :approuver');
        $reponse->bindValue('approuver', $selection_article_approuver, PDO::PARAM_INT);
        $reponse->execute();
        $donnees = $reponse->fetch();

        $nbNews = $donnees['nb_article']; // Nombre de news
        $reponse->closeCursor();

        $reponse = $bdd->prepare('SELECT article.id, article.url, article.nom_categorie, article.nom_miniature, article.contenu, article.titre, DATE_FORMAT(date_creation, "%Y/%M/%d/%Hh%i") AS date_article_dossier, DATE_FORMAT(date_creation, "%d %M %Y") AS date_article FROM article WHERE approuver = :approuver ORDER BY id ASC LIMIT 20 OFFSET :offsetPageNews'); // Sélection des news et formatage de la date à partir de la page de news selectionnée
        $reponse->bindValue('offsetPageNews', $offsetPageNews, PDO::PARAM_INT);
        $reponse->bindValue('approuver', $selection_article_approuver, PDO::PARAM_INT);
        $reponse->execute();

        $positionNews = 0; // On va voir quelle news à quelle place et une fois sur deux, elle sera en couleur

        while ($donnees = $reponse->fetch()) {
            // Liste news
            ?>

            <div class="section lien-article" data-anchor="section_<?php echo htmlspecialchars($donnees['url']); ?>"
                 id="<?php echo $positionNews + 1; ?>"
                 style="opacity: 0.85!important; background-size: cover; background-image: url('<?php echo '/portfolio/background/background' . $donnees['id'] . '.jpg'; ?>'); border: 0.3vw solid black;">
                <a href="news/<?php echo htmlspecialchars($donnees['url']); ?>-<?php echo htmlspecialchars($donnees['id']); ?>"
                   style="text-decoration-color: black; text-decoration: none;" class="display-5 fw-normal"><h2
                            class="animate__animated animate__backInLeft"><?php echo htmlspecialchars($donnees['titre']); ?></h2>
                </a>
                <img src="Articles/<?php echo $donnees['date_article_dossier']; ?>/<?php echo $donnees['url']; ?>/miniature/<?php echo $donnees['nom_miniature']; ?>"
                     onerror="this.oneerror=null; this.src='/portfolio/1.png';" alt="Miniature"
                     class="img-fluid img-news img-thumbnail" style="height: 300px; background-color:transparent;">
                <!-- Image à gauche et si image non trouvée, elle est remplacée par une image par défaut, titre à droite -->
                <p class="lead fw-normal animate__animated animate__backInRight animate__animated animate__backInLeft animate__delay-1s text-dark"><?php echo nl2br(tronquerTexte(remplacementBBCode(htmlspecialchars($donnees['contenu']), false, true), 140, "news/" . $donnees['url'] . "-" . $donnees['id'])); ?></p>
                <a href="news/<?php echo htmlspecialchars($donnees['url']); ?>-<?php echo htmlspecialchars($donnees['id']); ?>"
                   class="btn btn-outline-primary">Lire la suite</a>
            </div>

            <?php
            $positionNews++; // On augmente la position de news vu qu'on change de news
            ?>

            <?php
        }

        $reponse->closeCursor();
        ?>
    </div>
    <nav aria-label="navigation news" class="d-flex justify-content-center" style="margin-top: 20px;">
        <!-- Liste des pages de news -->
        <!-- Pagination -->
        <ul class="pagination pagination-circle">
            <?php
            $nbPageTotal = ceil($nbNews / 20); // Nombre de page de news que peut avoir le site à l'aide du nombre de news (20 news par page)

            if ($pageNewsSelectionner == 1) { // Si la page selectionnée est la une, on désactive le bouton précédent
                ?>
                <li class="page-item disabled">
                    <a class="page-link changement-page" aria-label="Previous" href="#" tabindex="-1">
                            <span aria-hidden="true">
                                <</span> <span class="sr-only">Précédent
                            </span> <!-- Précedent -->
                    </a>
                </li>
                <?php
            } else {
                ?>
                <li class="page-item">
                    <a class="page-link changement-page" aria-label="Previous"
                       href="/portfolio/index.php?page=<?php echo htmlspecialchars($pageNewsSelectionner) - 1; ?>">
                            <span aria-hidden="true">
                                <</span> <span class="sr-only">Précédent
                            </span> <!-- Précedent -->
                    </a>
                </li>
                <?php
            }

            for ($i = 1; $i <= $nbPageTotal; $i++) { // Parcours des pages

                if ($pageNewsSelectionner == $i) { // Si la page selectionnée est égale à la page du bouton, on rend la page du bouton active
                    ?>
                    <li class="page-item active">
                        <a class="page-link numero-page"
                           href="/portfolio/index.php?page=<?php echo htmlspecialchars($i); ?>"><?php echo htmlspecialchars($i); ?></a>
                    </li>
                    <?php
                } else { ?>
                    <li class="page-item">
                        <a class="page-link numero-page"
                           href="/portfolio/index.php?page=<?php echo htmlspecialchars($i); ?>"><?php echo htmlspecialchars($i); ?></a>
                    </li>
                <?php }
            }

            if ($pageNewsSelectionner == $nbPageTotal) { // Si la page selectionnée est la derniere, on désactive le bouton suivant
                ?>
                <li class="page-item disabled">
                    <a class="page-link changement-page" aria-label="Next" href="#" tabindex="-1">
                        <span aria-hidden="true">></span>
                        <span class="sr-only">Suivant</span> <!-- Suivant -->
                    </a>
                </li>
                <?php
            } else { ?>
                <li class="page-item">
                    <a class="page-link changement-page" aria-label="Next"
                       href="/portfolio/index.php?page=<?php echo htmlspecialchars($pageNewsSelectionner) + 1; ?>">
                        <span aria-hidden="true">></span>
                        <span class="sr-only">Suivant</span> <!-- Suivant -->
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <script>
        autoCompletion("recherche", "Articles");
    </script>
</div>