<?php $titreOnglet = 'Formulaire'; ?>
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

    <form class="needs-validation" novalidate method="post" action="index.php?action=gererSoumissionFormulaire">
        <div class="mb-2">
            <label for="donnees">Données à envoyer :</label>
            <textarea class="form-control" name="donnees" id="donnees" style="height: 7rem;" placeholder="Données quelconques" required></textarea>
            <div class="invalid-feedback">
                Veuillez entrer quelque chose.
            </div>
        </div>

        <div class="mb-2">
            <label for="delai">Délai de traitement :</label>
            <div class="input-group has-validation">
                <input type="number" class="form-control" name="delai" id="delai" placeholder="1000" required min="1">
                <span class="input-group-text">ms</span>
                <div class="invalid-feedback">
                    Veuillez entrer le temps d'attente en millisecondes.
                </div>
            </div>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" value="" id="erreur" name="erreur">
            <label class="form-check-label" for="erreur">
                Erreur
            </label>
        </div>

        <button class="btn btn-primary" type="submit">Soumettre</button>
    </form>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>