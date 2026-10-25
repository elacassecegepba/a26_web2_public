<div class="card">
    <div class="card-header">
        Données reçues
    </div>
    <div class="card-body">
        <?php highlight_array($_GET, '$_GET'); ?>
        <?php highlight_array($_POST, '$_POST'); ?>
        <?php highlight_array($_SESSION, '$_SESSION'); ?>
    </div>
</div>