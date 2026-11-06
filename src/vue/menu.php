<nav class="navbar navbar-expand-sm bg-body-tertiary" aria-label="Navigation principale">
    <div class="container">
        <!-- Bouton hamburger pour les petits écrans -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Sélecteur de thème : toujours visible -->
        <div class="dropdown order-sm-last ms-auto ms-sm-3">

            <button
                class="btn btn-outline-secondary dropdown-toggle"
                id="bd-theme"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                aria-label="Sélectionner le thème">

                <i class="bi bi-circle-half"></i>
                <span class="d-none d-sm-inline">Thème</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end"
                aria-labelledby="bd-theme">

                <li>
                    <button class="dropdown-item"
                        type="button"
                        data-bs-theme-value="light">
                        <i class="bi bi-sun-fill me-2"></i>
                        Clair
                    </button>
                </li>

                <li>
                    <button class="dropdown-item"
                        type="button"
                        data-bs-theme-value="dark">
                        <i class="bi bi-moon-stars-fill me-2"></i>
                        Sombre
                    </button>
                </li>

                <li>
                    <button class="dropdown-item"
                        type="button"
                        data-bs-theme-value="auto">
                        <i class="bi bi-circle-half me-2"></i>
                        Automatique
                    </button>
                </li>

            </ul>
        </div>

        <!-- Menu de navigation -->
        <!-- Sur les petits écrans, les éléments du menu sont cachés par défaut et -->
        <!-- doivent être affichés lorsque le bouton hamburger est cliqué -->
        <div class="collapse navbar-collapse" id="navbar">
            <!-- Boutons de navigation à gauche -->
            <ul class="navbar-nav me-auto">
                <!-- Bouton vers la page d'accueil -->
                <li class="nav-item">
                    <a
                        class="nav-link <?php NavClass("afficherPageAccueil");
                                        NavClassDefault(); ?>"
                        href="index.php?action=afficherPageAccueil">
                        Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link <?php NavClass("afficherPageRegex"); ?>"
                        href="index.php?action=afficherPageRegex">
                        Regex
                    </a>
                </li>
            </ul>
            <!-- Boutons de navigation à droite -->
            <ul class="navbar-nav">
            </ul>
        </div>
    </div>
</nav>

<?php
// Ajoute la classe active si le lien de menu est actif selon l'action demandée dans l'URL
function NavClass(string $menu)
{
    if (isset($_GET['action']) && $_GET['action'] === $menu) {
        echo ' active ';
    }
}

// Ajoute la classe active si aucune action n'est spécifiée dans l'URL.
// Un seul élément du menu (généralement l'accueil) devrait appeler cette fonction.
function NavClassDefault()
{
    if (!isset($_GET['action'])) {
        echo ' active ';
    }
}

// Vérifie si l'utilisateur est connecté en vérifiant la présence de la variable de session
function estConnecte()
{
    return isset($_SESSION['utilisateur']);
}
?>