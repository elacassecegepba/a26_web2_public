<?php require_once("horloge.php") ?>

<section>
    <h1>Exercice formatif</h1>
    <article>
        <p>Bienvenue!</p>
    </article>
    <article>
        <p>
            <?php
            $horloge = new Horloge("Canada/Eastern");
            echo "Il est : " . $horloge->obtenirHeureMinute() . "<br>";
            echo $horloge->obtenirMessage();
            ?>
        </p>
    </article>
</section>