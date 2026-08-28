<?php
// Validation de la présence et typage des variables attendues dans la vue.
/** @var array $cours */
assert(isset($cours), 'La variable $cours doit être définie.');
assert(is_array($cours), 'La variable $cours doit être un tableau.');
?>

<?php
// Définition du titre de l'onglet.
// En PHP, lorsqu'on déclare une variable, celle-ci est accessible dans tout le script.
// Cela signifie qu'on peut utiliser $titreOnglet dans la vue gabarit.php qui est incluse plus bas.
$titreOnglet = 'Confirmation';
?>

<?php
// Démarrage de la mise en tampon de sortie.
// Cela permet de capturer le contenu HTML généré (echo, <h1>, <p>, etc.).
// On récupère ensuite ce contenu dans la variable $contenu avec ob_get_clean().
ob_start();
?>

<h1 class="text-center">Confirmation</h1>

<p class="text-center">Merci, <strong><?php echo htmlspecialchars($_POST['nom']); ?></strong>, vous êtes inscrit au cours <strong><?php echo $cours['nom']; ?></strong>.</p>
<p class="text-center">Un email de confirmation a été envoyé à l'adresse <strong><?php echo htmlspecialchars($_POST['email']); ?></strong>.</p>

<?php
// Récupération de tout le contenu généré depuis le début de la mise en tampon.
// Le contenu est ensuite stocké dans la variable $contenu.
// La variable $contenu est ensuite utilisée dans la vue gabarit.php.
$contenu = ob_get_clean();
?>

<?php
// Chargement de la vue gabarit.php
// Le gabarit est responsable de l'affichage de la structure HTML de base de l'application
// et utilise la variable $contenu pour afficher le contenu spécifique à chaque page.
require 'vue/gabarit.php';
?>