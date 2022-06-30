<script>
    /***
     * Fonction qui prend en paramètre un input et le nom de l'indication du message de l'input et va dire si il est rempli ou non via le javascript avec du texte et de la couleur
     * @param input
     * @param nomInputInfo
     * @param typeInput
     */
    function controleTexteInput(input, nomInputInfo, typeInput) {
        var inputInfo = document.getElementById(nomInputInfo);

        if (input.value.length == 0) { // Si le texte n'a pas été complété, on dit qu'il n'a pas été rempli
            if (typeInput == "titre") { // Selon le type de l'input, la phrase sera changée
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un titre";
            } else if (typeInput == "contenu") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un contenu";
            } else if (typeInput == "date") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir une date";
            } else if (typeInput == "categorie") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir une catégorie";
            } else if (typeInput == "miniature") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un image";
            } else if (typeInput == "commentaire") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez écrire un commentaire";
            } else if (typeInput == "pseudo") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un pseudo";
            } else if (typeInput == "mdp") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un mot de passe";
            } else if (typeInput == "mail") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir un e-mail";
            } else if (typeInput == "choix_news") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir une news";
            } else if (typeInput == "choix_page") {
                inputInfo.className = "text-danger";
                inputInfo.innerText = "Veuillez choisir une page";
            }

        } else { // Sinon on affiche de la couleur pour indiquer que le texte à été rempli ainsi que du texte
            // input.className = "form-control" + " bg-success";

            if (typeInput == "titre") { // Selon le type de l'input, la phrase sera changée
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le titre a été rempli";
            } else if (typeInput == "contenu") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le contenu a été rempli";
            } else if (typeInput == "date") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le date a été remplie";
            } else if (typeInput == "categorie") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le catégorie a été remplie";
            } else if (typeInput == "miniature") {
                inputInfo.innerText = input.files[0].name;
            } else if (typeInput == "commentaire") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le commentaire a été écrit";
            } else if (typeInput == "pseudo") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le nom a été rempli";
            } else if (typeInput == "mdp") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "Le mot de passe a été rempli";
            } else if (typeInput == "mail") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "L'adresse e-mail a été remplie";
            } else if (typeInput == "choix_news") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "La news a été choisie";
            } else if (typeInput == "choix_page") {
                inputInfo.className = "text-success";
                inputInfo.innerText = "La page a été choisie";
            }
        }
    }

    /***
     * Fonction qui prend en paramètre un textarea, un champ et prend la valeur du textarea et le copie dans le champ
     * @param idTextArea
     * @param idChamp
     */
    function copieText(idTextArea, idChamp) {
        var textArea = document.getElementById(idTextArea);
        var champ = document.getElementById(idChamp);

        champ.value = textArea.value;
    }

    /***
     * Fonction qui prend en paramètre une valeur, un champ et prend la valeur et la copie dans le champ
     * @param value
     * @param idChamp
     */
    function remplirChamp(value, idChamp) {
        var champ = document.getElementById(idChamp);

        champ.value = value;
    }

    // Fonction qui va remplir les champs pour les modifications de news
    function remplirChampModificationArticle(valueId, valueTitre, valueContenu, valueCategorie, valueUrlSupprimerArticle) {

        var champId = document.getElementById('id');
        var champTitre = document.getElementById('titre');
        var champContenu = document.getElementById('contenu');
        var champCategorie = document.getElementById('categorie');
        var champSupprimerLien = document.getElementById('supprimerArticle');

        champId.value = valueId;
        champTitre.value = valueTitre;
        champContenu.innerText = valueContenu;
        champCategorie.value = valueCategorie;
        champSupprimerLien.href = valueUrlSupprimerArticle;
    }


    // Fonction qui prend en paramètre les differentes balises et les rajoutes dans un formulaire (pour le bbcode)
    function ajoutClickBBcodeFormulaire(debutBalise, finBalise, idTextArea) {

        var textareaFormulaire = document.getElementById(idTextArea);

        // Position texte selectionner
        var startSelection = textareaFormulaire.value.substring(0, textareaFormulaire.selectionStart);
        var currentSelection = textareaFormulaire.value.substring(textareaFormulaire.selectionStart, textareaFormulaire.selectionEnd);
        var endSelection = textareaFormulaire.value.substring(textareaFormulaire.selectionEnd);

        textareaFormulaire.value = startSelection + debutBalise + currentSelection + finBalise + endSelection;
    }

    function previsualisationContenu() {
        $('#contenu').on('change', function () { // On met le contenu dans la prévisualisation
            $('#previsualisationContenu').empty();
            contenuTexteHtml = remplacerBaliseParBBCodePrevisualisation($('#contenu').val());
            $('#previsualisationContenu').append(contenuTexteHtml); // On replace le contenu dans la prévisualisation
        });
    }

    // Pour réveler un texte
    function revelerTexte() {
        $(document).ready(function () {
            $(".revelerTexte").fadeIn(900);
        });
    }

    // Fonction pour remplacer certaines balises pour le tableau
    function remplacerBaliseParBBCode(contenu) {
        contenu = contenu.replace(/<table(.+?)>/, '[Tableau]');
        contenu = contenu.replace(/<\/table>/, '[/Tableau]');

        contenu = contenu.replace(/<thead(.+?)>/, '[TableauDebut]');
        contenu = contenu.replace(/<\/thead>/, '[/TableauDebut]');

        contenu = contenu.replace(/<th scope="col">/g, '[TableauEntréeColonne]');
        contenu = contenu.replace(/<\/th>/g, '[/TableauEntréeColonne]');

        contenu = contenu.replace(/<th scope="row">/g, '[TableauEntréeLigne]');
        contenu = contenu.replace(/<\/th>/g, '[/TableauEntréeLigne]');

        contenu = contenu.replace(/<tbody>/, '[TableauCorps]');
        contenu = contenu.replace(/<\/tbody>/, '[/TableauCorps]');

        contenu = contenu.replace(/<tr>/g, '[TableauLigne]');
        contenu = contenu.replace(/<\/tr>/g, '[/TableauLigne]');

        contenu = contenu.replace(/<td>/g, '[TableauColonne]');
        contenu = contenu.replace(/<\/td>/g, '[/TableauColonne]');

        contenu = contenu.replace(/<input name="inputEntree" id="inputEntree" type="text" value="">/g, '[TableauEntrée][/TableauEntrée]');
        contenu = contenu.replace(/<input name="inputEntree" id="inputEntree" type="text" value="(.+?)">/g, '[TableauEntrée]$1[/TableauEntrée]');

        // contenu = contenu.replace(/<input(.+?)>/g, '[TableauEntrée]');

        return contenu;
    }

    // Fonction pour remplacer certaines balises
    function remplacerBaliseParBBCodePrevisualisation(contenu) {
        contenu = contenu.replace(/<table(.+?)>/, '[Tableau]');
        contenu = contenu.replace(/<\/table>/, '[/Tableau]');

        contenu = contenu.replace(/<thead(.+?)>/, '[TableauDebut]');
        contenu = contenu.replace(/<\/thead>/, '[/TableauDebut]');

        contenu = contenu.replace(/<th scope="col">/g, '[TableauEntréeColonne]');
        contenu = contenu.replace(/<\/th>/g, '[/TableauEntréeColonne]');

        contenu = contenu.replace(/<th scope="row">/g, '[TableauEntréeLigne]');
        contenu = contenu.replace(/<\/th>/g, '[/TableauEntréeLigne]');

        contenu = contenu.replace(/<tbody>/, '[TableauCorps]');
        contenu = contenu.replace(/<\/tbody>/, '[/TableauCorps]');

        contenu = contenu.replace(/<tr>/g, '[TableauLigne]');
        contenu = contenu.replace(/<\/tr>/g, '[/TableauLigne]');

        contenu = contenu.replace(/<td>/g, '[TableauColonne]');
        contenu = contenu.replace(/<\/td>/g, '[/TableauColonne]');

        contenu = contenu.replace(/<input name="inputEntree" id="inputEntree" type="text" value="">/g, '[TableauEntrée][/TableauEntrée]');
        contenu = contenu.replace(/<input name="inputEntree" id="inputEntree" type="text" value="(.+?)">/g, '[TableauEntrée]$1[/TableauEntrée]');

        contenu = contenu.replace(/\[i\]/g, "<em>");
        contenu = contenu.replace(/\[\/i\]/g, "</em>");

        // gras
        contenu = contenu.replace(/\[b\]/g, "<strong>");
        contenu = contenu.replace(/\[\/b\]/g, "</strong>");

        // souligne
        contenu = contenu.replace(/\[u](.+?)\[\/u]/g, "<u>$1</u>");

        // citation
        contenu = contenu.replace("[citation]", "<blockquote class=\"blockquote\">");
        contenu = contenu.replace("[/citation]", "</blockquote>");

        // texte centré
        contenu = contenu.replace(/\[center](.+?)\[\/center]/sg, "<div style=\"text-align: center;\">$1</div>");
        contenu = contenu.replace("[center]", "<div style=\"text-align: center;\">");
        contenu = contenu.replace("[/center]", "</div>");

        // texte à gauche
        contenu = contenu.replace("[gauche]", "<div style=\"text-align: left;\">");
        contenu = contenu.replace("[/gauche]", "</div>");

        // texte à droite
        contenu = contenu.replace("[droite]", "<div style=\"text-align: right;\">");
        contenu = contenu.replace("[/droite]", "</div>");

        // liste
        contenu = contenu.replace(/\[liste\]/g, "<ul>");
        contenu = contenu.replace(/\[\/liste\]/g, "</ul>");

        // élément liste
        contenu = contenu.replace(/\[elementliste\]/g, "<li style=\"list-style-position: inside;\">");
        contenu = contenu.replace(/\[\/elementliste\]/g, "</li>");

        // Galerie
        contenu = contenu.replace(/\[gallery\]/g, "<div id='lightGallery' class='gallery'>");
        contenu = contenu.replace(/\[\/gallery\]/g, "</div>");

        // Image
        contenu = contenu.replace("[image]", "<img class=img-fluid src=");
        contenu = contenu.replace("[/image]", "></img>");

        // Image serveur
        contenu = contenu.replace(/\[image2=(.+?)\](.+?)\[\/image2]/g, "<div data-title='Title 1' data-desc='Description 1' data-responsive-src='/portfolio/images/$2' data-src='/portfolio/images/$2' style='display:inline;'> <a href='#'><img class='img-fluid lazy' style='float: $1; margin:10px; width: auto; height: auto; max-width: 900px; max-height: 900px;' src='/portfolio/images/$2'></a></div>"); // Recherche pour enlever la balise ainsi que recuperer l'alignement

        // Icone serveur
        contenu = contenu.replace(/\[icone=(.+?)]\[\/icone]/g, "<img class='img-fluid' style='margin:10px; width: auto; height: auto; max-width: 900px; max-height: 900px;' src='/icones/$1'>"); // Recherche pour enlever la balise ainsi que recuperer le nom de l'image

        // lien
        contenu = contenu.replace("[lien]", "<a href='");
        contenu = contenu.replace("[/lien]", "'>");

        // Texte du lien
        contenu = contenu.replace("[texteLien]", "");
        contenu = contenu.replace("[/texteLien]", "</a>");

        // Video
        contenu = contenu.replace("[video]", "<iframe width=280 height=180 class=video-commentaire frameborder=0 allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen src=");
        contenu = contenu.replace("[/video]", " ></iframe>");

        // Remplacer url youtube par une url d'integration
        contenu = contenu.replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/");

        // Taille
        contenu = contenu.replace(/\[taille=(.+?)]/g, '<div style="font-size: $1;">'); // Recherche pour enlever la balise ainsi que recuperer la taille
        contenu = contenu.replace(/\[\/taille]/g, '</div>');

        // Titre
        contenu = contenu.replace(/\[titre=(.+?)]/g, '<div class="$1">'); // Recherche pour enlever la balise ainsi que recuperer le titre
        contenu = contenu.replace(/\[\/titre]/g, '</div>');

        // Couleur
        contenu = contenu.replace(/\[couleur=(.+?)]/g, '<div style="color: $1;">'); // Recherche pour enlever la balise ainsi que recuperer la couleur
        contenu = contenu.replace(/\[\/couleur]/g, '</div>');

        // Couleur de fond
        contenu = contenu.replace(/\[couleurfond=(.+?)]/g, '<div style="background-color: $1;">'); // Recherche pour enlever la balise ainsi que recuperer la couleur de fond
        contenu = contenu.replace(/\[\/couleurfond]/g, '</div>');
        // contenu = contenu.replace(/<input(.+?)>/g, '[TableauEntrée]');

        return contenu;
    }

    function autoCompletion(idInput, categorieRecherche) {
        $(function () { // Fonction autocompletion
            $.widget("custom.catcomplete", $.ui.autocomplete, { // Création des catégories
                _create: function () {
                    this._super();
                    this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
                },
                _renderMenu: function (ul, items) {
                    var that = this,
                        currentCategory = "";
                    $.each(items, function (index, item) {
                        var li;
                        if (item.category != currentCategory) {
                            ul.append("<li class='ui-autocomplete-category'><strong>" + item.category + "</strong>");
                            currentCategory = item.category;
                        }
                        li = that._renderItemData(ul, item);
                        if (item.category) {
                            li.attr("aria-label", item.category + " : " + item.label);
                        }
                    });
                }
            });

            $('#' + idInput).catcomplete({
                source: function (request, response) {
                    recherche = $('#' + idInput).val();
                    // $('#' + idInput).val().split('"').pop(), // On récupère la valeur de l'input de recherche, le dernier mot dans l'input sera cherhcé
                    $.ajax({
                        url: "/portfolio/recherche_autocompletion.php",
                        data: {
                            recherche: recherche, // Les données post envoyés à la page de traitement
                            categorieRecherche: categorieRecherche
                        },
                        type: "post",
                        dataType: "json",
                        error: function () {
                            console.log("Aucun résultat");
                        },
                        success: function (donnees) {
                            response($.map(donnees, function (item) {
                                return {
                                    image: item.image,
                                    url: item.url,
                                    date: item.date,
                                    id: item.id,
                                    value: item.value,
                                    category: item.category
                                }
                            }));
                        }
                    });
                },
                minLength: 1,
                delay: 2,

                open: function () {
                    if (idInput == "recherche") {
                        $("ul.ui-menu").width($(this).innerWidth()); // Si c'est l'input recherche navbar, on met la taille de l'autocomplétion
                    }
                },
                select: function (event, ui) { // Quand on sélectionne un résultat, on va vers sa page
                    if (ui.item.category == "Articles") { // Vers page des articles
                        document.location.href = "news/" + ui.item.url + "-" + ui.item.id;
                    }
                }
            })
                .data('custom-catcomplete')._renderItem = function (ul, item) { // On ajoute les images pour les résultats
                if (item.category == "Articles") { // Si c'est un article, on change la présentation et l'url
                    return $('<li></li>')
                        .data('ui-item-autocomplete', item)
                        .append('<div><img src="/portfolio/Articles/' + item.date + '/' + item.url + '/miniature/' + item.image + '" onerror="this.oneerror=null; this.src="/portfolio/1.png"; class="img-fluid" style="width:30%; height: auto; max-width:50 px; max-height:150px; background-color:transparent;">' + '     ' + item.value + '</div>') // image
                        .appendTo(ul)
                }
            }

        });
    }

    // Script pour changer de page avec les fleches ou un swipe
    function changerPage(lienPagePrecendente, lienPageSuivante, nbPagePrecedente, nbPageSuivante) {
        $(document).on("keydown", function (e) {
            if (!$(e.target).is(":input") && (($('#ajout_commentaire').val() == "") || !document.getElementById('#ajout_commentaire'))) { // Si l'utilisateur n'est pas dans un input, on peut changer de page
                if (nbPagePrecedente > 0) // On regarde si il y a une page précédente
                {
                    if (e.which == "37") { // Si la flèche gauche est appuyé, on va à la page précédente
                        document.location.href = lienPagePrecendente;
                    }
                }
                if (nbPageSuivante > 0) {
                    if (e.which == "39") // Si la flèche droite est appuyé, on va à la page suivante
                    {
                        document.location.href = lienPageSuivante;
                    }
                }
            }
        });
        $('body').each(function (e) {
            delete Hammer.defaults.cssProps.userSelect; // Pour laisser le copié coller
            var hammertime = new Hammer(this);
            if (!$(e.target).is(":input") && (($('#ajout_commentaire').val() == "") || !document.getElementById('#ajout_commentaire'))) { // Si l'utilisateur n'est pas dans un input, on peut changer de page
                if (nbPagePrecedente > 0) // On regarde si il y a une page précédente
                {
                    hammertime.on('swipeleft', function (ev) { // Si un swipe gauche, on va à la page précédente
                        if (ev.pointerType === 'touch') {
                            document.location.href = lienPagePrecendente;
                        }
                    });
                }
                if (nbPageSuivante > 0) {
                    hammertime.on('swiperight', function (ev) { // Si un swipe droite, on va à la page précédente
                        if (ev.pointerType === 'touch') {
                            document.location.href = lienPageSuivante;
                        }
                    })
                }
            }
        });
    }

    // Permet de jouer un son avec un hover
    function jouerSonBruitage() {
        $(document).ready(function () {
            $("a.liste-item-sans-bordure, a.liste-item-news").hover(function () { // Pour jouer son
                    document.getElementById('audio_bouton').pause();
                    var promise = document.getElementById('audio_bouton').play();
                    if (promise) {
                        //Older browsers may not return a promise, according to the MDN website
                        promise.catch(function (error) {
                            console.error(error);
                        });
                    }
                    document.getElementById('audio_bouton').muted = false;
                },
                function () {
                    document.getElementById('audio_bouton').load();
                });
        });
    }

    // Fonction qui prend en paramètre un contenu et va le mettre dans un champ
    function modifierContenuChamp(idContenu, idChamp) {

        var contenuChamp1 = $("#" + idContenu).html();
        $("#" + idChamp).text(contenuChamp1);
    }

    // Fonction qui va ajouter le contenu d'un commentaire ainsi que son id dans le lien du formulaire et affiche le formulaire de modif
    function ajoutModificationCommentaire(idContenu, idChamp, idFormulaireCommentaire, idCommentaire, idFormulaireAjoutCommentaire) {

        modifierContenuChamp(idContenu, idChamp);
        var valeurActionFormulaireAvant = $('#' + idFormulaireCommentaire).attr('action');

        $("#" + idFormulaireCommentaire).attr('action', valeurActionFormulaireAvant + '&id_commentaire=' + idCommentaire); // Passe l'id du commentaire à la valeur du formulaire
        $('#' + idFormulaireCommentaire).show(); // Rend visible le formulaire
        $('#' + idFormulaireAjoutCommentaire).hide(); // Rend caché l'autre formulaire

        $("html, body").animate({
            scrollTop: $('#' + idFormulaireCommentaire).offset().top
        }, "slow"); // Scrolling vers le formulaire de modification
    }

    // Fonction qui va faire apparaitre un formulaire et en caché un autre
    function changementMenu(idFormulaireACacher, idFormulaireAFaireApparaitre) {
        $('#' + idFormulaireAFaireApparaitre).show(); // Rend visible le formulaire
        $('#' + idFormulaireACacher).hide(); // Rend caché l'autre formulaire
    }
</script>