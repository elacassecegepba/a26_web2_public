<?php
/** @var \PDOStatement|false $requeteModeles */
assert(isset($requeteModeles), 'La variable $requeteModeles doit être définie.');
assert($requeteModeles instanceof \PDOStatement || $requeteModeles === false, 'La variable $requeteModeles doit être une instance de PDOStatement ou false.');
?>

<option value="" disabled selected>Choisissez un modèle</option>
<?php while ($modele = $requeteModeles->fetch()) { ?>
    <option value="<?php echo $modele['id']; ?>"><?php echo htmlspecialchars($modele['nom']); ?></option>
<?php } ?>
