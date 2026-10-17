<?php
/** @var string[][] $cartes */
assert(isset($cartes), 'La variable $cartes doit être définie.');
assert(is_array($cartes), 'La variable $cartes doit être un tableau.');
?>
<?php $titreOnglet = "Mémoire"; ?>
<?php ob_start(); ?>

<div class="h-100 d-flex flex-column text-center" id="plateauJeuMemoire">

    <?php foreach ($cartes as $numeroLigne => $ligne) { ?>
        <div class="row flex-fill">
            <?php foreach ($ligne as  $numeroColonne => $carte) { ?>
                <div class="col align-content-center carte border h-100" data-couleur="<?php echo $carte; ?>">
                    Carte <?php echo $numeroLigne . '-' . $numeroColonne; ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

</div>

<script src="js/memoire.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>