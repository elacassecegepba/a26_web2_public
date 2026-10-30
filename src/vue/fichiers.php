<?php

/** @var \PDOStatement|false $requeteFichiers */
assert(isset($requeteFichiers), 'La variable $requeteFichiers doit être définie.');
assert($requeteFichiers instanceof \PDOStatement || $requeteFichiers === false, 'La variable $requeteFichiers doit être une instance de PDOStatement ou false.');
?>
<?php $titreOnglet = 'Fichiers'; ?>
<?php ob_start(); ?>

<h1 class="text-center"><?php echo $titreOnglet; ?></h1>

<!-- Boucle pour afficher chaque fichier dans une table-->
<table class="table align-middle">
    <thead>
        <tr>
            <th>Nom du fichier</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fichier = $requeteFichiers->fetch()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($fichier['nom_original']); ?></td>
                <td>
                    <img
                        src="index.php?action=telechargerFichier&id=<?php echo $fichier['id']; ?>"
                        alt="<?php echo htmlspecialchars($fichier['nom_original']); ?>"
                        class="img-thumbnail" style="max-width: 100px;">
                </td>
                <td>
                    <a
                        href="index.php?action=telechargerFichier&id=<?php echo $fichier['id']; ?>"
                        class="btn btn-primary">
                        Télécharger
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $contenu = ob_get_clean(); ?>
<?php require 'vue/gabarit.php'; ?>