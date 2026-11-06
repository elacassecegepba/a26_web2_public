<?php

/** @var \PDOStatement|false $requeteRendezVous */
assert(isset($requeteRendezVous), 'La variable $requeteRendezVous doit être définie.');
assert($requeteRendezVous instanceof \PDOStatement || $requeteRendezVous === false, 'La variable $requeteRendezVous doit être une instance de PDOStatement ou false.');
?>

<?php $titreOnglet = 'Mes rendez-vous'; ?>
<?php ob_start(); ?>

<h1 class="text-center"><?php echo $titreOnglet; ?></h1>

<?php
if (isset($_SESSION['erreurs'])) {
    $erreurs = implode("<br>", $_SESSION['erreurs']);
    echo '<div class="alert alert-danger" role="alert">' . $erreurs . '</div>';
    unset($_SESSION['erreurs']);
}
?>

<table class="table align-middle">
    <thead>
        <tr>
            <th>Rendez-vous</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Description</th>
            <th>Images</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($rendezVous = $requeteRendezVous->fetch()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($rendezVous['id']); ?></td>
                <td><?php echo htmlspecialchars($rendezVous['marques_nom']); ?></td>
                <td><?php echo htmlspecialchars($rendezVous['modeles_nom']); ?></td>
                <td><?php echo htmlspecialchars($rendezVous['description']); ?></td>
                <td>
                    <?php
                    $images = json_decode($rendezVous['images'], true);
                    if (empty($images)) {
                        echo '<div class="text-secondary fst-italic">Aucune image</div>';
                    } else {
                        $idCarousel = 'carouselImageRendezVous' . $rendezVous['id'];
                    ?>
                        <div id="<?php echo $idCarousel ?>" class="carousel slide" style="max-width: 100px;">
                            <div class="carousel-inner">
                                <?php foreach ($images as $id => $image) { ?>
                                    <div class="carousel-item <?php if ($id == 0) { echo 'active'; } ?>">
                                        <img
                                            alt="Image du problème <?php echo htmlspecialchars($image['id']); ?>"
                                            class="me-2 mb-2"
                                            style="max-width: 100px;">
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (count($images) > 1) { ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $idCarousel ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Précédent</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $idCarousel ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Prochain</span>
                                </button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>