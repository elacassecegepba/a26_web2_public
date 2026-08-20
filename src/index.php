<?php 
    include_once 'donnees.php';
    include_once 'fonctions.php';
    $donnees = getDonnees();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio de Alice - Techniques Informatique</title>
</head>

<body>
    <h1>Portfolio de <?php echo "{$donnees["prenom"]} {$donnees["nom"]}"; ?></h1>

    <p><i><?php echo genererPresentation($donnees["prenom"], $donnees["age"], $donnees["ville"], "la programmation"); ?></i></p>

    <?php echo "Mon pseudo c'est \"{$donnees["pseudo"]}\"<br>"; ?>

    <h2>Mes Compétences</h2>
    <ul>
        <?php
        foreach ($donnees["competences"] as $nomCompetence => $details) {
            if (!validerCompetence($details)) {
                continue;
            }
            echo "<li><h3>$nomCompetence<h3></li>";
            echo "<ul>";
            echo   "<li><strong>Niveau:</strong> " . $details["niveau"] . "/10 (" . evaluerNiveau($details["niveau"]) . ")</li>";
            echo   "<li><strong>Expérience:</strong> " . $details["experience"] . "</li>";
            echo "</ul>";
        }
        ?>
    </ul>

    <?php var_dump($donnees["competences"]); ?>
</body>

</html>