<?php $titreOnglet = 'Regex'; ?>
<?php ob_start(); ?>

<h1 class="text-center"><?php echo $titreOnglet; ?></h1>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <div id="reponseFormulaireRegex"></div>

    <form id="formulaireRegex" class="needs-validation" novalidate>

        <div class="mb-3">
            <label for="exRegex" class="form-label">Exemple de validation Regex</label>
            <input type="text" name="exRegex" id="exRegex" class="form-control" required minlength="6" maxlength="6" pattern="abc123" />
            <div class="invalid-feedback">
                Veuillez entrer le texte "abc123".
            </div>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" required pattern="\(\d{3}\)\s?\d{3}-\d{4}" />
            <div class="invalid-feedback">
                Veuillez entrer un numéro de téléphone au format : (111) 111-1111.
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" required pattern="[a-zA-Z0-9\-_\.]{2,}@[a-zA-Z0-9\-\.]{2,}\.[a-zA-Z]{2,6}" />
            <div class="invalid-feedback">
                Veuillez entrer un email valide.
            </div>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <input type="text" name="message" id="message" class="form-control" required pattern="(Bonjour|Madame|Monsieur),.*web.*(Meilleures salutations|Respectueusement|Bonne journée), Bob" />
            <div class="invalid-feedback">
                Veuillez entrer un message valide.
            </div>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse postale</label>
            <input type="text" name="adresse" id="adresse" class="form-control" required pattern="\d+ .+, .+, [A-Za-z]{2} [A-Za-z]\d[A-Za-z][ ]?\d[A-Za-z]\d" />
            <div class="invalid-feedback">
                Veuillez entrer une adresse valide. Ex. : 116 rue, Saint-Georges, QC G5Y 3G1
            </div>
        </div>

        <div class="mb-3">
            <label for="skipValidationHTML" class="form-label">Envoyer sans valider HTML</label>
            <input type="checkbox" id="skipValidationHTML" class="form-check-input" />
        </div>

        <div class="mb-3">
            <label for="skipValidationJS" class="form-label">Envoyer sans valider JS</label>
            <input type="checkbox" id="skipValidationJS" class="form-check-input" />
        </div>

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>

<script src="public/js/regex.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>