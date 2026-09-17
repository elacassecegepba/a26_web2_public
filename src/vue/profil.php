<?php $titreOnglet = 'Profil'; ?>

<?php ob_start(); ?>

<h1 class="text-center">Profil</h1>
<p class="text-center">Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['utilisateur']['nomUtilisateur']); ?>!</strong></p>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>