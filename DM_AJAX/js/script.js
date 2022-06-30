/***
 * Ce fichier s'occupe des scripts Javascript utilisés par la médiathèque
 * @author Florent Weltmann
 * @date Janvier 2022
 *
 */

let xhr = new XMLHttpRequest();
// Récupération de l'emplacement des adhérents et des livres dans le html
let div_adherents = document.getElementById("listeDivAdherents");
let div_livres_disponibles = document.getElementById("listeDivLivresDisponibles");
let div_livres_empruntes = document.getElementById("listeDivLivresEmpruntes");

// Chargement des adhérents et des livres
(function () {
    charger_contenu();
})();

/***
 * Callback après le chargement du contenu, il servira à traiter les données récupérées par l'Ajax et à les afficher
 */
function callback() {
    let xhrJSON = null;

    try {
        xhrJSON = JSON.parse(xhr.responseText); // Récupération via l'Ajax
    } catch (erreur) {
        document.getElementById('erreurMessage').innerText = xhr.responseText; // Ecriture du message d'erreur
        return; // Si erreur, arrêt de la fonction
    }

    // Construction des listes d'adhérents, de livres disponibles et de livres empruntés
    div_adherents.innerHTML = ''; // On vide les listes si elles ont déjà été remplies
    div_livres_disponibles.innerHTML = '';
    div_livres_empruntes.innerHTML = '';

    // Parcours des adhérents pour mettre leurs informations dans la liste d'adhérents, si il n'y a pas d'adhérent, il y a un message
    if (xhrJSON[0].length == 0) {
        div_adherents.insertAdjacentHTML('beforeend', '<li>Il n\'y aucun adhérent.</li>');
    }
    for (let adherent of xhrJSON[0]) {
        let li = document.createElement('li');
        li.innerText = adherent.numAdherent + ' - ' + adherent.prenom + ' ' + adherent.nom + ' (' + adherent.livreEmpruntes.nombreLivre + ' '
        if (adherent.livreEmpruntes.nombreLivre > 1) {
            li.innerText += 'emprunts' + ')';
        } else {
            li.innerText += 'emprunt' + ')';
        }
        li.innerHTML += " <button type='button' class='btn btn-danger bouton-supprimer' onclick='supprimerAdherent(" + adherent.numAdherent + ")'><i class=\"far fa-trash-alt\"></i></button>"; // Un bouton pour supprimer l'adhérent
        li.className = "champ";
        li.setAttribute("tabindex", -1);
        li.setAttribute("onclick", "charger_menu_adherent(this, " + JSON.stringify(adherent) + ")"); // Pour charger le menu des différents livres empruntés par l'adhérents

        div_adherents.appendChild(li);
    }

    // Parcours des livres disponibles pour mettre leurs informations dans la liste des livres disponibles
    if (xhrJSON[1].length == 0) {
        div_livres_disponibles.insertAdjacentHTML('beforeend', '<li>Il n\'y aucun livre disponible.</li>');
    }
    for (let livre_disponible of xhrJSON[1]) {
        let li = document.createElement('li');
        li.innerHTML = livre_disponible.numLivre + ' - ' + livre_disponible.titre;
        li.innerHTML += " <button type='button' class='btn btn-danger bouton-supprimer' onclick='supprimerLivre(" + livre_disponible.numLivre + ")'><i class=\"far fa-trash-alt\"></i></button>"; // Un bouton pour supprimer le livre
        li.className = "champ";
        li.setAttribute("tabindex", -1);
        li.setAttribute("onclick", "charger_menu_livre_disponible(this, " + JSON.stringify(livre_disponible) + ")"); // Pour charger le menu demandant quel adhérent veut emprunter ce livre

        div_livres_disponibles.appendChild(li);
    }

    // Parcours des livres empruntés pour mettre leurs informations dans la liste des livres empruntés
    if (xhrJSON[2].length == 0) {
        div_livres_empruntes.insertAdjacentHTML('beforeend', '<li>Il n\'y aucun livre emprunté.</li>');
    }
    for (let livre_emprunte of xhrJSON[2]) {
        let li = document.createElement('li');
        li.innerHTML = livre_emprunte.numLivre + ' - ' + livre_emprunte.titre;
        li.innerHTML += " <button type='button' class='btn btn-danger bouton-supprimer' onclick='supprimerLivre(" + livre_emprunte.numLivre + ")'><i class=\"far fa-trash-alt\"></i></button>"; // Un bouton pour supprimer le livre
        li.className = "champ";
        li.setAttribute("tabindex", -1);
        li.setAttribute("onclick", "charger_menu_livre_emprunter(this, " + JSON.stringify(livre_emprunte) + ")"); // Pour charger le menu permettant de rendre un livre

        div_livres_empruntes.appendChild(li); // Ligne mis dans la div des livres empruntés
    }

    // Remplissage du select des genres dans l'insertion de livres et de l'accueil
    let selectGenre = document.getElementById('selectionGenre');
    selectGenre.innerText = null;
    let selectGenreAccueil = document.getElementById('selectionGenreAccueil');

    // On regarde si une option à déjà été sélectionné et on la sélectionnera quand le select sera initialisé
    let optionDejaSelectionner;
    if (selectGenreAccueil.value != null) {
        optionDejaSelectionner = selectGenreAccueil.value;
    }
    selectGenreAccueil.innerHTML = '<option value="Tous">Tous les Genres</option>'; // Ajout d'une option pour choisir les livres de tous les genres

    // Parcours des genres pour mettre dans le select
    for (let genre of xhrJSON[3]) {
        let option = document.createElement('option');
        let optionAccueil = document.createElement('option');

        option.value = genre['id_genre'];
        option.text = genre['nom_genre'];

        optionAccueil.value = genre['id_genre'];
        optionAccueil.text = genre['nom_genre'];
        ;

        selectGenre.add(option); // Ajout des options dans le select
        selectGenreAccueil.add(optionAccueil);
    }

    selectGenre.value = 1; // On met le select à une position par défaut
    if (optionDejaSelectionner) {
        selectGenreAccueil.value = optionDejaSelectionner; // Reselection de la valeur
    }
}

/***
 * Permettra d'afficher un menu pour chaque adhérent contenant les livres qu'il a empruntés
 * @param li Un adhérent dans le HTML
 * @param adherent L'adhérent sélectionné en objet
 */
function charger_menu_adherent(li, adherent) {
    setTimeout(function () {
        // Si on sélectionne un élément, un menu s'affiche avec les livres que l'adhérent a emprunté
        if (li == document.activeElement) {
            let texte = adherent.prenom + ' ' + adherent.nom + ' a ' + adherent.livreEmpruntes.nombreLivre + ' ';

            // Singulier ou pluriel
            if (adherent.livreEmpruntes.nombreLivre > 1) {
                texte += 'emprunts en ce moment : \n ';
            } else if (adherent.livreEmpruntes.nombreLivre == 1) {
                texte += 'emprunt en ce moment : \n ';
            } else {
                texte += 'emprunt en ce moment.';
            }

            // Récupération des livres de l'adhérent dans un tableau
            let tableauLivres = Object.keys(adherent.livreEmpruntes).map((i) => adherent.livreEmpruntes[i]);

            for (let livre of tableauLivres) {
                if (livre.titre) {
                    texte += '\n- ' + livre.titre;

                    if (livre.auteur) {
                        texte += ' de ' + livre.auteur;
                    }
                }
            }
            document.getElementById('modalInformationsLabel').innerText = 'Livres Empruntés de ' + adherent.prenom + ' ' + adherent.nom;
            document.getElementById('modalInformationsBody').innerText = texte;
            let modalAdherent = new bootstrap.Modal(document.getElementById('modalInformations'), {keyboard: false}); // Appel du modal pour afficher les livres empruntés de l'adhérent
            modalAdherent.show();
        }
    }, 1);
}

/***
 * Permet d'afficher un menu pour chaque livre pour demander quel adhérent veut emprunter le livre sélectionné
 * @param li Un livre dans le html
 * @param livre Un livre en objet
 */
function charger_menu_livre_disponible(li, livre) {
    setTimeout(function () {
        if (li == document.activeElement) { // Si le livre a été selectionné

            document.getElementById('modalLivreDisponibleLabel').innerText = 'Emprunt de "' + livre.titre + '"'; // Remplacement des textes du modal
            document.getElementById('modalPhraseEmpruntLivre').innerText = 'Veuillez entrer le numéro de l\'emprunteur :';
            document.getElementById('modalNumLivreAEmprunter').value = livre.numLivre;

            let modalLivreDisponible = new bootstrap.Modal(document.getElementById('modalLivreDisponible'), {keyboard: false}); // Appel du modal
            modalLivreDisponible.show();
        }
    }, 1);
}

/***
 * Permet d'afficher un menu permettant de rendre le livre sélectionné
 * @param li Un livre dans le html
 * @param livre Un livre en objet
 */
function charger_menu_livre_emprunter(li, livre) {
    setTimeout(function () {
        if (li == document.activeElement) { // Si le livre a été sélectionné
            let texte = 'Livre prêté à ' + livre.prenomAdherent + ' ' + livre.nomAdherent + '\nRetour de ce livre ?';

            document.getElementById('modalLivreEmprunterLabel').innerText = 'Retour de "' + livre.titre + '"'; // Remplacement des textes du modal
            document.getElementById('modalPhraseRendreLivre').innerText = 'Livre prêté à ' + livre.prenomAdherent + ' ' + livre.nomAdherent + '\nRetour de ce livre ?';
            document.getElementById('modalNumLivreARendre').value = livre.numLivre;
            document.getElementById('modalAdherentIdRendre').value = livre.numEmprunteur;

            let modalLivreEmprunter = new bootstrap.Modal(document.getElementById('modalLivreEmprunter'), {keyboard: false}); // Appel du modal
            modalLivreEmprunter.show();
        }
    }, 1);
}

/***
 * Permet de charger tous les contenus affichés dans la médiathèque
 */
function charger_contenu() {
    let url = 'php/recherche/recherche.php';
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback(); // Appel du callback
        }
    }
    xhr.send(null);
}

/***
 * Pour insérer un adhérent dans la base de données
 */
function inserer_adherent() {
    // Récupération des champs
    let champPrenomAdherent = document.getElementById('prenomAdherent');
    let champNomAdherent = document.getElementById('nomAdherent');

    if (champPrenomAdherent.value.length > 0 && champNomAdherent.value.length > 0) {
        let url = 'php/enregistrer/enregistrerAdherent.php?prenom=' + champPrenomAdherent.value + '&nom=' + champNomAdherent.value; // Appel de la page php permettant d'insérer un adhérent
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                charger_contenu(); // Rechargement des listes
                champPrenomAdherent.value = ''; // Vidage des inputs
                champNomAdherent.value = '';

                apparaitreOnglet('gestion', 'ajouterAdherent', 'ajouterLivre', 'options'); // Pour diriger automatiquement vers l'accueil
                document.getElementById('gestion').classList.add("show"); // // Charger quel bouton d'onglet est actif
                document.getElementById('gestion-tab').classList.add("active");
                document.getElementById('ajouterAdherent-tab').classList.remove("active");
            }
        }
        xhr.send(null);
    }
}

/***
 * Pour insérer un livre dans la base de données
 */
function inserer_livre() {
    // Récupération des champs
    let champTitreLivre = document.getElementById('titreLivre');
    let champAuteurLivre = document.getElementById('auteurLivre');
    let champIdLivre = document.getElementById('selectionGenre');

    if (champTitreLivre.value.length > 0 && champAuteurLivre.value.length > 0) {
        let url = 'php/enregistrer/enregistrerLivre.php?titreLivre=' + champTitreLivre.value + '&auteurLivre=' + champAuteurLivre.value + '&idGenreLivre=' + champIdLivre.value; // Appel de la page php permettant d'insérer un livre
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                charger_contenu(); // Rechargement des listes
                champTitreLivre.value = ''; // Vidage des inputs
                champAuteurLivre.value = '';

                apparaitreOnglet('gestion', 'ajouterAdherent', 'ajouterLivre', 'options'); // Pour diriger automatiquement vers l'accueil
                document.getElementById('gestion').classList.add("show"); // Charger quel bouton d'onglet est actif
                document.getElementById('gestion-tab').classList.add("active");
                document.getElementById('ajouterLivre-bouton').classList.remove("active");
            }
        }
        xhr.send(null);
    }
}

/***
 * Permet de supprimer un adhérent de la base de données
 * @param numAdherent Numéro d'un adhérent
 */
function supprimerAdherent(numAdherent) {
    if (numAdherent) {
        let url = 'php/supprimer/supprimerAdherent.php?numAdherent=' + numAdherent; // Appel de la page php permettant de supprimer un adhérent
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('selectionGenreAccueil').selectedIndex = 0; // Sélection de tous les genres de livres
                charger_contenu(); // Rechargement des listes
            }
        }
        xhr.send(null);
    }
}

/***
 * Permet de supprimer un livre de la base de données
 * @param numLivre Numéro d'un livre
 */
function supprimerLivre(numLivre) {
    if (numLivre) {
        let url = 'php/supprimer/supprimerLivre.php?numLivre=' + numLivre; // Appel de la page php permettant de supprimer un livre
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('selectionGenreAccueil').selectedIndex = 0; // Sélection de tous les genres de livres
                charger_contenu(); // Rechargement des listes
            }
        }
        xhr.send(null);
    }
}

/***
 *
 * @param numAdherent Numéro de l'adhérent
 * @param idInput L'identifiant de l'input sur lequel on teste les valeurs
 * @param idMessageErreur L'identifiant du message qui va aider à savoir quel erreur l'utilisateur a
 * @return boolean Un booléen pour savoir si le numéro de l'adhérent est aau moins 1
 */
function verifierNumAdherent(numAdherent, idInput, idMessageErreur) {
    if (numAdherent < 1 || !numAdherent) { // Si condition non respectée
        document.getElementById(idInput).setAttribute('class', 'form-control is-invalid'); // Couleur sur l'input
        document.getElementById(idMessageErreur).innerText = "Le numéro de l'emprunteur est trop petit."; // Message d'erreur
        return false;
    } else { // Pas de message d'erreur
        document.getElementById(idInput).setAttribute('class', 'form-control');
        document.getElementById(idMessageErreur).innerText = "";
        return true;
    }
}

/***
 * Met à jour le statut d'un livre de emprunter vers disponible ou de disponible vers emprunter, si il y a un id dans numEmprunteur dans la bdd, c'est emprunter
 * @param action Action prévue : Vers disponible ou vers emprunter
 * @param numLivre Numéro d'un livre
 * @param numAdherent Numéro d'un adhérent
 */
function majLivre(action, numLivre, numAdherent) {
    if (numLivre && numAdherent) {
        let numLivreValeur = document.getElementById(numLivre).value; // Récupération des valeur
        let numAdherentValeur = document.getElementById(numAdherent).value;

        if (action == 'emprunter') { // Vérification
            if (verifierNumAdherent(numAdherentValeur, 'modalAdherentId', 'errorModalAdherentBody')) {
                let url = 'php/maj/majLivre.php?action=emprunter&numLivre=' + numLivreValeur + '&numAdherent=' + numAdherentValeur; // Appel de la page php permettant de mettre à jour vers emprunter
                xhr.open("GET", url, true);
                xhr.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            if (xhr.responseText == '') { // Si il n'y a pas d'erreur
                                charger_contenu(); // Rechargement des listes
                                document.getElementById('selectionGenreAccueil').selectedIndex = 0; // Le select des genres de livre se remet sur tous les genres dans le cas où un genre était sélectionné
                                document.getElementById('modalLivreDisponibleFermer').click(); // Fermeture du modal après emprunt
                            } else { // Sinon, affichage de l'erreur dans le modal
                                document.getElementById('modalAdherentId').setAttribute('class', 'form-control is-invalid'); // Couleur sur l'input
                                document.getElementById('errorModalAdherentBody').innerText = 'Aucun adhérent n\'a ce numéro.'; // Message d'erreur
                            }
                        }
                    }
                }
                xhr.send(null);
            }
        } else if (action == 'disponible') {
            let url = 'php/maj/majLivre.php?action=disponible&numLivre=' + numLivreValeur; // Appel de la page php permettant de mettre à jour vers disponible
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    charger_contenu(); // Rechargement des listes
                    document.getElementById('selectionGenreAccueil').selectedIndex = 0; // Le select se remet sur tous les genres
                    document.getElementById('modalLivreEmprunterFermer').click(); // Fermeture du modal après que le livre soit rendu
                }
            }
            xhr.send(null);
        }
    }
}

/***
 * Permet de trouver les livres d'un certain genre dans la page d'accueil
 */
function rechercherLivreParGenre() {
    let selectionGenreAccueil = document.getElementById('selectionGenreAccueil');
    let selectionGenreAccueilValeur = selectionGenreAccueil.value;

    if (selectionGenreAccueilValeur) {
        let url = 'php/recherche/recherche.php?idGenre=' + selectionGenreAccueilValeur; // Appel de la page php permettant de mettre à jour vers emprunter
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                callback();
            }
        }
        xhr.send(null);
    }
}

/***
 * Permet de changer le background
 * @param nomTheme Thème à mettre en fond d'écran
 */
function changerTheme(nomTheme) {
    switch (nomTheme) {
        case 'bibliotheque':
            document.body.style.backgroundImage = "url('images/book.jpg')"; // Changement de l'image
            break;
        case 'espace':
            document.body.style.backgroundImage = "url('images/espace.jpg')"; // Changement de l'image
            break;
        case 'montagne':
            document.body.style.backgroundImage = "url('images/montagne.jpg')"; // Changement de l'image
            break;
        case 'aurore_boreale':
            document.body.style.backgroundImage = "url('images/aurora-borealis.jpg')"; // Changement de l'image
            break;
        case 'seigneur_des_anneaux':
            document.body.style.backgroundImage = "url('images/seigneur_des_anneaux.jpg')"; // Changement de l'image
            break;
        default:
            document.body.style.backgroundImage = "url('images/book.jpg')"; // Changement de l'image
    }
}

/***
 * Pour changer la taille de la fenêtre
 * @param tailleFenetre La taille de la fenetre demandé
 */
function changerTailleFenetre(tailleFenetre) {
    let fenetre = document.getElementById('fenetre'); // Récupération de l'élement

    switch (tailleFenetre) {
        case 'petite':
            fenetre.style.width = '50%'; // Changement de la taille
            fenetre.style.height = '50%';
            fenetre.style.margin = 'auto';
            fenetre.style.marginTop = '10%';
            fenetre.style.marginBottom = '10%';
            break;
        case 'moyenne':
            fenetre.style.width = '60%';
            fenetre.style.height = '60%';
            fenetre.style.margin = 'auto';
            fenetre.style.marginTop = '10%';
            fenetre.style.marginBottom = '10%';
            break;
        case 'grande':
            fenetre.style.width = '75%';
            fenetre.style.height = '75%';
            fenetre.style.margin = 'auto';
            fenetre.style.marginTop = '10%';
            fenetre.style.marginBottom = '10%';
            break;
        case "tres_grande":
            fenetre.style.width = '85%';
            fenetre.style.height = '85%';
            fenetre.style.margin = 'auto';
            fenetre.style.marginTop = '10%';
            fenetre.style.marginBottom = '10%';
            break;
        case "enorme":
            fenetre.style.width = '100%';
            fenetre.style.height = '100%';
            fenetre.style.margin = 'auto';
            break;
        default:
            fenetre.style.width = '85%';
            fenetre.style.height = '85%';
            fenetre.style.margin = 'auto';
            fenetre.style.marginTop = '10%';
            fenetre.style.marginBottom = '10%';
    }
}

/***
 * Permet de faire apparaitre le contenu d'un onglet et d'en faire disparaitre d'autres, utile pour l'utilisation des onglets
 * @param idOngletApparaitre L'id de l'onglet à faire apparaître
 * @param idOngletDisparaitre1 L'id de l'onglet à faire disparaitre
 * @param idOngletDisparaitre2 L'id du deuxième onglet à faire disparaitre
 * @param idOngletDisparaitre2 L'id du troisième onglet à faire disparaitre
 */
function apparaitreOnglet(idOngletApparaitre, idOngletDisparaitre1, idOngletDisparaitre2, idOngletDisparaitre3) {
    // Récupération des onglets
    let onglet = document.getElementById(idOngletApparaitre);
    let ongletDisparaitre1 = document.getElementById(idOngletDisparaitre1);
    let ongletDisparaitre2 = document.getElementById(idOngletDisparaitre2);
    let ongletDisparaitre3 = document.getElementById(idOngletDisparaitre3);

    // Changement des display pour faire apparaître ou disparaitre les onglets
    onglet.style.display = 'block';
    ongletDisparaitre1.style.display = 'none';
    ongletDisparaitre2.style.display = 'none';
    ongletDisparaitre3.style.display = 'none';
}