<?php $titreOnglet = 'Profil'; ?>

<?php ob_start(); ?>

<h1 class="text-center">Profil</h1>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>