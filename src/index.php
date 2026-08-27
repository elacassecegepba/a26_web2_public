<!doctype html>
<html lang="fr">

<head>
    <title>Exercice formatif</title>
    <meta charset="utf-8">
    <!-- Pour cellulaire -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php require_once("entete.php") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 py-2 pe-2">
                <?php require_once("contenu.php") ?>
            </div>
            <div class="col-sm-4 py-2">
                <?php require_once("menu.php") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php require_once("pied.php") ?>
            </div>
        </div>
    </div>
</body>

</html>