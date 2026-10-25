<div class="alert alert-success" role="alert">
    Connexion réussie! <br>
    Vous allez être redirigé vers votre profil. <br>
    Notez que la redirection est gérée côté client dans <strong>connexion.js</strong>
    et non par le serveur.
</div>

<?php
    // Si on est ici à cause d'une inscription, on ajoute le code de redirection,
    // car contrairement à la page de connexion, l'inscription fonctionne avec une
    // soumission de formulaire classique et non avec AJAX.
?>
<?php if ($_GET['action'] === 'inscrire') { ?>
    <script>document.location = "index.php?action=afficherPageProfil";</script>
<?php } ?>