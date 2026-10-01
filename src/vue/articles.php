<?php
/** @var \PDOStatement|false $requeteArticles */
assert(isset($requeteArticles), 'La variable $requeteArticles doit être définie.');
assert($requeteArticles instanceof \PDOStatement || $requeteArticles === false, 'La variable $requeteArticles doit être une instance de PDOStatement ou false.');
?>
<?php $titreOnglet = 'Articles'; ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/articles.css">

<h1 class="fw-bold text-center mb-4">Articles</h1>

<div class="row justify-content-center mb-5">
    <div class="col-12 col-md-8 col-lg-6">
        <form id="rechercheForm" action="index.php?action=afficherPageArticles" method="POST" class="card p-3 shadow-sm border-0 bg-light">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input 
                    type="search"
                    id="filtreInput"
                    name="filtreTitre"
                    class="form-control border-start-0"
                    placeholder="Filtrer par titre"
                    value="<?php echo $_SESSION['filtreTitre'] ?? ''; ?>"
                    aria-label="Filtrer les articles"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

    <?php while ($article = $requeteArticles->fetch()) { ?>
        <?php 
            // Décodage du tableau d'images JSON
            $article['images'] = json_decode($article['images'], true); 
            
            // Image principale ou image par défaut
            $imageSource = !empty($article['images'][0]) 
                ? $article['images'][0] 
                : 'https://placehold.net/default.svg';
            
            // Formatage de la date pour le composant d'affichage local
            $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($article['date_publication'])); 
        ?>

        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($imageSource); ?>" class="card-img-top card-img-fixed" alt="<?php echo htmlspecialchars($article['titre']); ?>">
                <div class="card-body d-flex flex-column">
                    <div class="text-muted small mb-2">
                        <i class="bi bi-calendar"></i> Publié le
                        <time class="date-locale" datetime="<?php echo $dateUtcIso; ?>">
                            <?php echo htmlspecialchars($article['date_publication']); ?>
                        </time>
                    </div>
                    <h5 class="card-title card-title-fixed"><?php echo htmlspecialchars($article['titre']); ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($article['resume']); ?></p>
                    <a href="index.php?action=afficherPageArticles&articleId=<?php echo $article['id']; ?>" class="btn btn-primary mt-auto">Lire l'article</a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<script src="js/utcVersLocal.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>