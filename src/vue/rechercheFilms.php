<?php $titreOnglet = 'Recherche films'; ?>
<?php ob_start(); ?>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <?php
    if (isset($_SESSION['erreurs'])) {
        // Récupère les erreurs et les formate pour l'affichage
        $erreurs = implode("<br>", $_SESSION['erreurs']);
        // htmlspecialchars n'est pas nécessaire ici car les erreurs sont générées en interne
        // Affiche les erreurs dans une alerte Bootstrap
        echo '<div class="alert alert-danger" role="alert">' . $erreurs . '</div>';
        // Supprime les erreurs de la session après les avoir affichées
        unset($_SESSION['erreurs']);
    }
    ?>

    <form class="needs-validation" novalidate method="post" action="index.php?action=rechercherFilms">
        <div class="mb-2">
            <label for="donnees">Titre du film :</label>
            <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre du film" required maxlength="255">
            <div class="invalid-feedback">
                Veuillez entrer un titre de film.
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Rechercher</button>
    </form>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>