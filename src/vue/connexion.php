<?php $titreOnglet = 'Connexion'; ?>

<?php ob_start(); ?>

<h1 class="text-center">Connexion</h1>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <form method="post" action="index.php?action=connecter" class="needs-validation" novalidate>
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

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>