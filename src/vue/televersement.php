<?php $titreOnglet = 'Téléversement'; ?>
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

    <form enctype="multipart/form-data" method="post" action="index.php?action=televerserFichier" class="needs-validation" novalidate>
        <div class="mb-3 mt-3">
            <label for="fichier" class="form-label">Fichier&nbsp;:</label>
            <input type="file" class="form-control" id="fichier" name="fichier" required accept=".png, .jpg, .gif, .webp">
            <div class="invalid-feedback">
                Veuillez sélectionner un fichier à téléverser (types autorisés : .png, .jpg, .gif, .webp).
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Téléverser</button>
    </form>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>