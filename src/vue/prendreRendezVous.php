<?php

/** @var \PDOStatement|false $requeteMarques */
assert(isset($requeteMarques), 'La variable $requeteMarques doit être définie.');
assert($requeteMarques instanceof \PDOStatement || $requeteMarques === false, 'La variable $requeteMarques doit être une instance de PDOStatement ou false.');

/** @var \PDOStatement|false $requeteModeles */
assert(isset($requeteModeles), 'La variable $requeteModeles doit être définie.');
assert($requeteModeles instanceof \PDOStatement || $requeteModeles === false, 'La variable $requeteModeles doit être une instance de PDOStatement ou false.');
?>
<?php $titreOnglet = 'Prendre un rendez-vous'; ?>
<?php ob_start(); ?>

<h1 class="text-center"><?php echo $titreOnglet; ?></h1>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <?php
    if (isset($_SESSION['erreurs'])) {
        $erreurs = implode("<br>", $_SESSION['erreurs']);
        echo '<div class="alert alert-danger" role="alert">' . $erreurs . '</div>';
        unset($_SESSION['erreurs']);
    }
    ?>

    <form method="post" action="index.php?action=prendreRendezVous" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="marque" class="form-label">Marque</label>
                <select name="marque" id="marque" class="form-select" required>
                    <option value="" disabled selected>Choisissez une marque</option>
                    <?php while ($marque = $requeteMarques->fetch()) { ?>
                        <option value="<?php echo $marque['id']; ?>"><?php echo htmlspecialchars($marque['nom']); ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    Veuillez choisir la marque de votre voiture.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="modele" class="form-label">Modèle</label>
                <select name="modele" id="modele" class="form-select" required>
                    <option value="" disabled selected>Choisissez un modèle</option>
                    <?php while ($modele = $requeteModeles->fetch()) { ?>
                        <option value="<?php echo $modele['id']; ?>"><?php echo htmlspecialchars($modele['nom']); ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    Veuillez entrer le modèle de votre voiture.
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" style="height: 9rem;" placeholder="Description" id="description" name="description" required maxlength="65535"></textarea>
            <div class="invalid-feedback">
                Veuillez entrer une description pour le rendez-vous.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Prendre rendez-vous</button>
    </form>
</div>

<script src="public/js/prendreRendezVous.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>