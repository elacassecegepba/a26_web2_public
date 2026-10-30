<?php
// Le gabarit est le modèle de page HTML utilisé pour toutes les pages de l'application.
// Il définit la structure de base de la page, y compris l'en-tête, le pied de page et la zone de contenu principal.
?>

<?php
// Validation de la présence et typage des variables attendues dans la vue.
/** @var string $titreOnglet */
assert(isset($titreOnglet), 'La variable $titreOnglet doit être définie.');
assert(is_string($titreOnglet), 'La variable $titreOnglet doit être une chaîne de caractères.');

/** @var string $contenu */
assert(isset($contenu), 'La variable $contenu doit être définie.');
assert(is_string($contenu), 'La variable $contenu doit être une chaîne de caractères.');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/bootstrap.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Maison (on en fait seulement si Bootstrap ne le permet pas) -->
    <link href="public/style/index.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="public/image/logo-64x64.png" type="image/jpg">
    <title>
        <?php
        // Utilisation de la variable $titreOnglet définie dans chaque vue spécifique pour le titre de l'onglet.
        echo $titreOnglet;
        ?>
    </title>
</head>

<body class="container-fluid vh-100 p-0 m-0 d-flex flex-column">
    <header class="bg-dark sticky-top">
        <?php
        // Chargement du menu de navigation.
        // Le menu est responsable de l'affichage des liens de navigation.
        // Toutes les pages de l'application utilisent ce menu.
        require_once 'vue/menu.php';
        ?>
    </header>
    <main class="p-2 flex-fill">
        <?php
        // Zone de contenu principal.
        // Affichage du contenu spécifique à chaque page.
        // Le contenu est récupéré depuis la variable $contenu définie dans chaque vue spécifique.
        // Cette variable contient le code HTML généré par la vue entre ob_start() et ob_get_clean().
        echo $contenu;
        ?>
    </main>
    <footer>
        <p class="container text-center py-2 mt-2 border-top">&copy; <?php echo date('Y') ?> Mon Site</p>
    </footer>
</body>

</html>