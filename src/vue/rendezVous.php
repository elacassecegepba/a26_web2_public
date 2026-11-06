<?php
/** @var array $rendezVous */
assert(isset($rendezVous), 'La variable $rendezVous doit être définie.');
assert(is_array($rendezVous), 'La variable $rendezVous doit être un tableau.');
?>
<?php $titreOnglet = 'Rendez-vous'; ?>
<?php ob_start(); ?>

<?php
// Le code des images est à remplacer pour afficher les images du rendez-vous
$images = [
    'https://placehold.co/600x400?text=Placeholder',
    'https://placehold.co/600x400/000000/FFF',
    'https://placehold.co/600x400/orange/white'
];
?>

<div class="col-sm-10 col-md-8 col-lg-6 m-auto">
    <div class="card">
        <div id="carouselImageRendezVous" class="carousel slide">
            <div class="carousel-inner">
                <?php foreach ($images as $id => $image) { ?>
                    <div class="carousel-item <?php if ($id == 0) {echo 'active';} ?>">
                        <img src="<?php echo htmlspecialchars($image); ?>" class="d-block card-img-top" alt="Image-<?php echo $id; ?>">
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImageRendezVous" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImageRendezVous" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Prochain</span>
            </button>
        </div>
        <div class="card-body">
            <h5 class="card-title text-center">
                <?php echo htmlspecialchars($rendezVous["marques_nom"] . ' ' . $rendezVous["modeles_nom"]); ?>
            </h5>
            <p>
                <?php echo htmlspecialchars($rendezVous["description"]); ?>
            </p>
        </div>
    </div>
</div>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>