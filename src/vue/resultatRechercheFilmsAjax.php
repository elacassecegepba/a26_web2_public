<?php
/** @var \PDOStatement|false $requeteFilms */
assert(isset($requeteFilms), 'La variable $requeteFilms doit être définie.');
assert($requeteFilms instanceof \PDOStatement || $requeteFilms === false, 'La variable $requeteFilms doit être une instance de PDOStatement ou false.');
?>
<?php
$nombreFilms = $requeteFilms->rowCount();
?>
    <div class="alert alert-info text-center" role="alert">
        <strong><?php echo $nombreFilms; ?></strong> film(s) trouvé(s) pour le titre recherché.
    </div>
<?php
while ($film = $requeteFilms->fetch()) {
?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($film['titre']); ?></h5>
            <p class="card-text">
                Année de sortie : <?php echo htmlspecialchars($film['annee_sortie']); ?><br>
                Durée : <?php echo htmlspecialchars($film['duree_minutes']); ?> minutes<br>
                Catégorie : <?php echo htmlspecialchars($film['categorie']); ?>
            </p>
        </div>
    </div>
<?php
}
?>
