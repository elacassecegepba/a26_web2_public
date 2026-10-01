<?php
/** @var array $article Array contenant les données de l'article */
assert(isset($article) && is_array($article), 'La variable $article doit être un tableau.');
assert(isset($article['images']) && is_array($article['images']), 'La variable $article[\'images\'] doit être un tableau.');
?>
<?php $titreOnglet = htmlspecialchars($article['titre']); ?>
<?php ob_start(); ?>

<link rel="stylesheet" href="style/articleDetail.css">

<div class="container py-4">
    <div class="mb-4">
        <a href="index.php?action=afficherPageArticles" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour aux articles
        </a>
    </div>

    <article class="bg-white p-4 p-md-5 rounded shadow-sm">
        <h1 class="fw-bold mb-3"><?php echo htmlspecialchars($article['titre']); ?></h1>

        <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom gap-3">
            <div>
                <i class="bi bi-person-circle"></i> 
                <strong><?php echo htmlspecialchars($article['auteur_nom']); ?></strong>
            </div>
            <div>•</div>
            <div>
                <i class="bi bi-calendar3"></i> Publié le 
                <?php $dateUtcIso = date('Y-m-d\TH:i:s\Z', strtotime($article['date_publication'])); ?>
                <time class="date-locale fw-medium" datetime="<?php echo $dateUtcIso; ?>">
                    <?php echo htmlspecialchars($article['date_publication']); ?>
                </time>
            </div>
        </div>

        <?php if (!empty($article['images'])) { ?>
            <div id="carouselArticle" class="carousel slide mb-4 rounded overflow-hidden shadow-sm" data-bs-ride="carousel">
                <?php if (count($article['images']) > 1) { ?>
                    <div class="carousel-indicators">
                        <?php foreach ($article['images'] as $index => $imgUrl) { ?>
                            <button type="button" data-bs-target="#carouselArticle" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-label="Image <?php echo $index + 1; ?>"></button>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="carousel-inner">
                    <?php foreach ($article['images'] as $index => $imgUrl) { ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" class="d-block w-100 object-fit-cover" style="max-height: 500px;" alt="Image article">
                        </div>
                    <?php } ?>
                </div>

                <?php if (count($article['images']) > 1) { ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselArticle" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselArticle" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>

        <p class="lead text-secondary fw-semibold border-start border-4 border-primary ps-3 my-4">
            <?php echo nl2br(htmlspecialchars($article['resume'])); ?>
        </p>

        <div class="article-content fs-5 lh-lg">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>
    </article>
</div>

<script src="js/utcVersLocal.js"></script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>