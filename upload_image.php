<!-- Fenetre upload -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form class="form" id="formImage" name="formImage" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="dispositionImage">Disposition de l'image</label> <!-- On demande à l'utilisateur si l'image doit être placé à côté d'un texte -->
                        <div class="row text-center">
                            <div class="form-check col">
                                <input type="radio" id="choixAucun" name="dispositionImage" value="none" checked class="form-check-input">
                                <label class="form-check-label" for="choixAucun">Aucun</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" id="choixGauche" name="dispositionImage" value="left" class="form-check-input">
                                <label class="form-check-label" for="choixGauche">Gauche</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" id="choixDroite" name="dispositionImage" value="right" class="form-check-input">
                                <label class="form-check-label" for="choixDroite">Droite</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tailleImage">Taille de l'image</label> <!-- On demande à l'utilisateur quelle taille d'image il veut -->
                        <div class="row text-center">
                            <div class="form-check col">
                                <input type="radio" id="choixIcone" name="tailleImage" value="icone" checked class="form-check-input">
                                <label class="form-check-label" for="choixIcone">Icone</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" id="choixPetite" name="tailleImage" value="petit" class="form-check-input">
                                <label class="form-check-label" for="choixPetite">Petite</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" id="choixMoyenne" name="tailleImage" value="moyen" class="form-check-input">
                                <label class="form-check-label" for="choixMoyenne">Moyenne</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" id="choixGrande" name="tailleImage" value="grande" class="form-check-input">
                                <label class="form-check-label" for="choixGrande">Grande</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images">Image</label>
                        <div class="input-group">
                            <!-- Upload de miniature -->
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="images" id="images" accept=".jpg, .png, .bmp, .gif" required onchange="controleTexteInput(this, 'imageIndication', 'miniature')" aria-describedby="images"> <!-- Si un fichier a été choisi, l'événement onchange permettra de montrer le nom du fichier sur le label d'information -->
                                <label id="imageIndication" class="custom-file-label" for="images">Choisir fichier</label>
                            </div>
                            <div>
                                <input type="hidden" id="commentaire" name="commentaire">
                                <button type="submit" style="margin-left: 9px;" class="btn btn-success">Envoyer</button> <!-- On ajoute l'image -->
                            </div>
                        </div>
                    </div>
                    <div class="progress">
                        <!-- Barre de progression -->
                        <div class="bar progress-bar" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100"></div>
                        <div class="percent">0%</div>
                    </div>
                    <div id="status">Ajoutez une image</div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Fonction pour l'upload et la barre de progression
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('#formImage').ajaxForm({
            beforeSend: function() {
                // Avant l'envoi, on met la barre à zéro
                status.text("Ajoutez une image");
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                // Progression de la barre
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            complete: function(xhr) {
                // Fin de l'upload
                status.text("Fichier upload");

                date = new Date(); // On prend la date

                jour = String(date.getDate()).padStart(2, '0');
                mois = String(date.toLocaleString('fr-FR', {
                    month: 'long'
                }));
                mois_chiffre = String(date.getMonth());
                annee = String(date.getFullYear());
                heure = String(date.getHours()).padStart(2, '0');
                minute = String(date.getMinutes()).padStart(2, '0');
                seconde = String(date.getSeconds()).padStart(2, '0');

                date_actuel = String(annee + '-' + mois_chiffre + '-' + jour + " " + heure + ':' + minute + ":" + seconde);

                imageNom = $('#imageIndication').text();
                hash = Math.random().toString(36).substring(2); // Le hash servira à générer un nom de fichier qui ne soit pas le même
                extension_image = imageNom.substr(imageNom.lastIndexOf('.') + 1, imageNom.length);

                var nom_fichier = jour + "_" + mois + "_" + annee + "_" + heure + "h" + minute + "m" + seconde + "_" + hash + "." + extension_image; // Le nom du fichier

                var data = new FormData();
                data.append('images', $("#images")[0].files[0]);
                data.append('date_actuel', date_actuel);
                data.append('jour', jour);
                data.append('mois', mois);
                data.append('annee', annee);
                data.append('heure', heure);
                data.append('minute', minute);
                data.append('seconde', seconde);
                data.append('jour', jour);
                data.append('hash', hash);
                data.append('extension_image', extension_image);
                data.append('ancien_nom', imageNom);
                data.append('nom_fichier', nom_fichier);
                data.append('dispositionImage', $("[name='dispositionImage']:checked").val());
                data.append('tailleImage', $("[name='tailleImage']:checked").val());
                data.append('image', true);

                $.ajax({
                    data: data,
                    type: "post",
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: "/portfolio/upload_image_traitement_premier.php",
                    error: function() {
                        alert('Erreur');
                    },
                    success: function(data) {
                        image = '<div class="form-group" id="divPrevisualisationImage"><label for="imagePrevisualisation">Prévisualisation</label><img src="/portfolio/images/' + nom_fichier + '"onerror="this.oneerror=null; this.src="/portfolio/1.png";" name="imagePrevisualisation" id="imagePrevisualisation" class="img-fluid img-thumbnail form-control" style="height: 10vh; width: 10vh;"></div>';
                        $('#status').after(image); // On place l'iframe
                    }
                });

                ajoutClickBBcodeFormulaire('[image2=' + $('input[name="dispositionImage"]:checked').val() + ']' + nom_fichier + '[/image2]', '', nom_contenu); // Ajoute les balises et l'alignement

                $('#divPrevisualisationImage').remove(); // Si on recharge l'image, on supprime l'ancienne
            },
        });
    });
</script>