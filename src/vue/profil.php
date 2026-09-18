<?php $titreOnglet = 'Profil'; ?>
<?php ob_start(); ?>

<?php
$nomUtilisateur = htmlspecialchars($_SESSION['utilisateur']['nom']);
$email = htmlspecialchars($_SESSION['utilisateur']['email'] ?? '');
$image = htmlspecialchars($_SESSION['utilisateur']['image'] ?? '');
?>

<h1 class="text-center">Profil</h1>

<div class="col-sm-10 col-md-8 col-lg-6 card mx-auto">
    <?php
    if (isset($_SESSION['erreurs'])) {
        // Récupère les erreurs et les formate pour l'affichage
        $erreurs = implode("<br>", $_SESSION['erreurs']);
        // htmlspecialchars n'est pas nécessaire ici car les erreurs sont générées en interne
        // Affiche les erreurs dans une alerte Bootstrap
        echo '<div class="alert alert-danger m-3" role="alert">' . $erreurs . '</div>';
        // Supprime les erreurs de la session après les avoir affichées
        unset($_SESSION['erreurs']);
    }
    ?>
    <div class="card-body text-center">
        <!-- Affichage des données du profil -->
        <img id="image-profil" src="<?php echo $image; ?>" alt="Image de profil" class="rounded-circle mb-3" width="100" height="100">
        <h5 class="card-title">Informations du profil</h5>
        <div id="profil-infos">
            <p class="card-text"><strong>Nom d'utilisateur :</strong> <?php echo $nomUtilisateur; ?></p>
            <p class="card-text"><strong>Email :</strong> <?php echo $email; ?></p>
            <button id="btn-modifier-profil" class="btn btn-primary mt-3" type="button">Modifier le profil</button>
        </div>
        <!-- Formulaire de modification du profil -->
        <form method="post" action="index.php?action=modifierProfil" id="form-modifier-profil" style="display:none;" class="needs-validation" novalidate>
            <div class="mb-3 text-start">
                <label for="nomUtilisateur" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" required minlength="3" maxlength="45" id="nomUtilisateur" name="nomUtilisateur" value="<?php echo $nomUtilisateur; ?>">
                <div class="invalid-feedback">Veuillez entrer un nom d'utilisateur.</div>
            </div>
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" maxlength="255" id="email" name="email" value="<?php echo $email; ?>">
                <div class="invalid-feedback">Veuillez entrer une adresse email valide (optionnel).</div>
            </div>
            <div class="mb-3 text-start">
                <label for="image" class="form-label">URL de l'image de profil</label>
                <input type="url" class="form-control" maxlength="2048" id="image" name="image" placeholder="https://..." value="<?php echo $image; ?>">
                <div class="invalid-feedback">Veuillez entrer une URL d'image valide (optionnel).</div>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <button type="button" class="btn btn-danger ms-2" id="btn-annuler">Annuler</button>
        </form>
    </div>
</div>

<script src="js/profil.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>