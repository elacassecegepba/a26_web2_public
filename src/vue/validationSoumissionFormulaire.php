<?php $titreOnglet = 'Validation soumission'; ?>
<?php ob_start(); ?>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            Données reçues
        </div>
        <div class="card-body">
            <?php highlight_array($_GET, '$_GET'); ?>
            <?php highlight_array($_POST, '$_POST'); ?>
            <?php highlight_array($_SESSION, '$_SESSION'); ?>
        </div>
    </div>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>