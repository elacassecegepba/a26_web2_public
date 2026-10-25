<?php $titreOnglet = 'Formulaire Ajax'; ?>
<?php ob_start(); ?>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <form id="formulaireAjax" class="needs-validation" novalidate>
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

    <div id="formulaireAjaxPlaceholder" class="d-none">
        <div class="placeholder-glow mb-2">
            <label class="placeholder bg-transparent">Données à envoyer :</label>
            <textarea class="form-control placeholder" style="height: 7rem;" disabled></textarea>
        </div>

        <div class="placeholder-glow mb-2">
            <label class="placeholder bg-transparent">Attente :</label>
            <div class="input-group">
                <input class="form-control placeholder" disabled>
                <span class="input-group-text placeholder">ms</span>
            </div>
        </div>

        <div class="placeholder-glow mb-2">
            <input class="placeholder rounded-1" style="height: 1rem; width: 1rem;" disabled>
            <label class="placeholder bg-transparent">
                Erreur
            </label>
        </div>

        <div class="placeholder-glow">
            <button class="btn btn-primary placeholder" disabled>Soumettre</button>
        </div>
    </div>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>