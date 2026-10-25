<?php $titreOnglet = 'Connexion - AJAX'; ?>

<?php ob_start(); ?>

<h1 class="text-center"><?php echo $titreOnglet; ?></h1>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <div id="reponse"></div>

    <form id="formConnexion" action="index.php?action=connecter" class="needs-validation" novalidate>
        <div class="mb-3 mt-3">
            <label for="nom" class="form-label">Nom d'utilisateur&nbsp;:</label>
            <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom d'utilisateur" name="nom" required minlength="3" maxlength="45">
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

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<script src="js/connexion.js"></script>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>