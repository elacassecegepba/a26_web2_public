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