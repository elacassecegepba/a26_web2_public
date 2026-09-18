<?php $titreOnglet = 'Inscription'; ?>
<?php ob_start(); ?>

<h1 class="text-center">Inscription</h1>

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

    <form method="post" action="index.php?action=inscrire" class="needs-validation" novalidate>
        <div class="mb-3 mt-3">
            <label for="nomUtilisateur" class="form-label">Nom d'utilisateur&nbsp;:</label>
            <input type="text" class="form-control" id="nomUtilisateur" placeholder="Entrez votre nom d'utilisateur" name="nomUtilisateur" required minlength="3" maxlength="45">
            <div class="invalid-feedback">
                Le nom d'utilisateur est requis et doit contenir entre 3 et 45 caractères.
            </div>
        </div>

        <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe&nbsp;:</label>
            <input type="password" class="form-control" id="motDePasse" placeholder="Entrez votre mot de passe" name="motDePasse" required minlength="6" maxlength="45">
            <div class="invalid-feedback">
                Le mot de passe est requis et doit contenir entre 6 et 45 caractères.
            </div>
        </div>

        <div class="mb-3">
            <label for="confirmationMotDePasse" class="form-label">Confirmez le mot de passe&nbsp;:</label>
            <input type="password" class="form-control" id="confirmationMotDePasse" placeholder="Confirmez votre mot de passe" required>
            <div class="invalid-feedback">
                La confirmation du mot de passe doit correspondre au mot de passe.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<script src="js/inscription.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>