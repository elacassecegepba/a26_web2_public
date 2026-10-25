<?php $titreOnglet = 'Recherche films'; ?>
<?php ob_start(); ?>

<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
    <div class="mb-3">
        <label for="donnees">Titre du film :</label>
        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre du film">
    </div>
    <div id="reponse"></div>
</div>

<script src="js/rechercheFilmsAjax.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>