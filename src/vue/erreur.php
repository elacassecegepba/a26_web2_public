<?php
/** @var string $msgErreur */
assert(isset($msgErreur), 'La variable $msgErreur doit être définie.');
assert(is_string($msgErreur), 'La variable $msgErreur doit être une chaîne de caractères.');
?>

<?php $titreOnglet = 'Erreur'; ?>

<?php ob_start(); ?>

<div class="text-center">
    <h1>Une erreur est survenue&nbsp;:</h1>
    <p><?php echo htmlspecialchars($msgErreur); ?></p>
</div>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>