<?php $titreOnglet = 'Formulaire'; ?>
<?php ob_start(); ?>

<div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
    <div id="alerteInfo" class="alert alert-info d-none" role="alert">
        Le contenu de l'alerte sera inséré ici par JavaScript.
    </div>
    <form id="formulaireInscription" method="post" action="index.php?action=inscrire" class="needs-validation row flex-column g-3" novalidate>
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
            <div class="invalid-feedback">
                Veuillez entrer une adresse courriel valide.
            </div>
        </div>

        <!--
        (?=.*[A-Z]) : Au moins une lettre majuscule.
        (?=.*[a-z]) : Au moins une lettre minuscule.
        (?=.*\d) : Au moins un chiffre.
        (?=.*\W) : Au moins un caractère spécial.
        .{8,} : Au moins 8 caractères.
        -->
        <div>
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Mot de passe" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}" required>
            <div class="invalid-feedback">
                <strong>Veuillez entrer un mot de passe respectant les critères de sécurité suivants&nbsp;:<br></strong>
                <ul class="m-0">
                    <li id="auMoins8Caractere" class="text-danger">Au moins 8 caractères.</li>
                    <li id="auMoinsUneLettreMajuscule" class="text-danger">Au moins une lettre majuscule.</li>
                    <li id="auMoinsUneLettreMinuscule" class="text-danger">Au moins une lettre minuscule.</li>
                    <li id="auMoinsUnChiffre" class="text-danger">Au moins un chiffre.</li>
                    <li id="auMoinsUnCaractereSpecial" class="text-danger">Au moins un caractère spécial.</li>
                </ul>
            </div>
        </div>

        <div>
            <label for="validationMotDePasse" class="form-label">Validation du mot de passe</label>
            <input type="password" class="form-control" id="validationMotDePasse" name="validationMotDePasse" placeholder="Validation mot de passe" required>
            <div class="invalid-feedback">
                Doit être identique au mot de passe
            </div>
        </div>

        <div>
            <button class="btn btn-primary" type="submit">Soumettre</button>
        </div>
    </form>
</div>

<script src="js/formulaire.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>