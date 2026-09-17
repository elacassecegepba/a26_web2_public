<?php $titreOnglet = '2e formulaire'; ?>
<?php ob_start(); ?>

<h1 class="text-center">2e formulaire</h1>

<form
    method="post"
    action="index.php?action=inscrireAUnCoursPartie2"
    class="needs-validation"
    novalidate>

    <!-- Données du premier formulaire -->
    <input name="nom" value="<?= htmlspecialchars($_POST['nom']) ?>" hidden>
    <input name="email" value="<?= htmlspecialchars($_POST['email']) ?>" hidden>
    <input name="cours" value="<?= htmlspecialchars($_POST['cours']) ?>" hidden>

    <div class="mb-3">
        <label for="nomTitulaire" class="form-label">Nom du titulaire:</label>
        <input
            type="text"
            class="form-control"
            id="nomTitulaire"
            placeholder="Entrez le nom sur la carte"
            name="nomTitulaire"
            autocomplete="cc-name"
            required
            minlength="3"
            maxlength="100">
        <div class="invalid-feedback">
            Le nom du titulaire est requis et doit contenir entre 3 et 100 caractères.
        </div>
    </div>

    <div class="mb-3">
        <label for="numeroCarte" class="form-label">Numéro de carte:</label>
        <input
            type="text"
            class="form-control"
            id="numeroCarte"
            placeholder="1234 5678 9012 3456"
            name="numeroCarte"
            inputmode="numeric"
            autocomplete="cc-number"
            required
            minlength="13"
            maxlength="19">
        <div class="invalid-feedback">
            Le numéro de carte est requis et doit être valide.
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 mb-3">
            <label for="moisExpiration" class="form-label">Mois:</label>
            <select
                class="form-select"
                id="moisExpiration"
                name="moisExpiration"
                autocomplete="cc-exp-month"
                required>
                <option value="" selected disabled>Mois</option>
                <option value="01">01 - Janvier</option>
                <option value="02">02 - Février</option>
                <option value="03">03 - Mars</option>
                <option value="04">04 - Avril</option>
                <option value="05">05 - Mai</option>
                <option value="06">06 - Juin</option>
                <option value="07">07 - Juillet</option>
                <option value="08">08 - Août</option>
                <option value="09">09 - Septembre</option>
                <option value="10">10 - Octobre</option>
                <option value="11">11 - Novembre</option>
                <option value="12">12 - Décembre</option>
            </select>
            <div class="invalid-feedback">
                Le mois d'expiration est requis.
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <label for="anneeExpiration" class="form-label">Année:</label>
            <select
                class="form-select"
                id="anneeExpiration"
                name="anneeExpiration"
                autocomplete="cc-exp-year"
                required>
                <option value="" selected disabled>Année</option>
                <?php
                $anneeCourante = date('Y');
                for ($i = 0; $i < 10; $i++) {
                    $annee = $anneeCourante + $i;
                    echo "<option value=\"{$annee}\">{$annee}</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">
                L'année d'expiration est requise.
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <label for="cvv" class="form-label">CVV:</label>
            <input
                type="password"
                class="form-control"
                id="cvv"
                placeholder="123"
                name="cvv"
                inputmode="numeric"
                autocomplete="cc-csc"
                required
                minlength="3"
                maxlength="4">
            <div class="invalid-feedback">
                Le CVV est requis et doit contenir 3 ou 4 chiffres.
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary d-block mx-auto">
        Terminer l'inscription
    </button>

</form>


<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>