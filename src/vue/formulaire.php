<?php
// Définition du titre de l'onglet.
// En PHP, lorsqu'on déclare une variable, celle-ci est accessible dans tout le script.
// Cela signifie qu'on peut utiliser $titreOnglet dans la vue gabarit.php qui est incluse plus bas.
$titreOnglet = 'Formulaire';
?>

<?php
// Démarrage de la mise en tampon de sortie.
// Cela permet de capturer le contenu HTML généré (echo, <h1>, <p>, etc.).
// On récupère ensuite ce contenu dans la variable $contenu avec ob_get_clean().
ob_start();
?>

<h1 class="text-center">Formulaire</h1>

<form method="post" action="index.php?action=inscrireAUnCours">
    <div class="mb-3 mt-3">
        <label for="nom" class="form-label">Nom:</label>
        <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
    </div>
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Entrez votre email" name="email">
    </div>
    <div class="mb-3 mt-3">
        <label for="cours" class="form-label">Choix du cours:</label>
        <select class="form-select" id="cours" name="cours">
            <option selected value="" disabled>Sélectionnez un cours</option>
            <option value="algo">Algorithmique</option>
            <option value="web">Développement Web</option>
            <option value="reseau">Réseaux</option>
            <option value="bdd">Bases de données</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>


<?php
// Récupération de tout le contenu généré depuis le début de la mise en tampon.
// Le contenu est ensuite stocké dans la variable $contenu.
// La variable $contenu est ensuite utilisée dans la vue gabarit.php.
$contenu = ob_get_clean();
?>

<?php
// Chargement de la vue gabarit.php
// Le gabarit est responsable de l'affichage de la structure HTML de base de l'application
// et utilise la variable $contenu pour afficher le contenu spécifique à chaque page.
require 'vue/gabarit.php';
?>