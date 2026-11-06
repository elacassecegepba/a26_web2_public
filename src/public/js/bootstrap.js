document.addEventListener("DOMContentLoaded", initialiserBootstrap);

function initialiserBootstrap() {
    initialiserFormulaireNeedsValidation();
    initialiserPopover();
    initialiserThemeBootstrap();
}

// https://getbootstrap.com/docs/5.3/forms/validation/#how-it-works
function initialiserFormulaireNeedsValidation() {
    // Récupère tous les formulaires avec la classe needs-validation
    const forms = document.querySelectorAll(".needs-validation");

    // Pour chaque formulaire :
    // - Empêche la soumission si au moins un champ est invalide
    // - Affiche la validation Bootstrap (was-validated)
    for (const form of forms) {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false,
        );
    }
}

// https://getbootstrap.com/docs/5.3/components/popovers/#enable-popovers
function initialiserPopover() {
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]',
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl),
    );
}

// Gestion des thèmes Bootstrap
function initialiserThemeBootstrap() {
    const themeSwitcher = document.querySelector("#bd-theme");
    const themeOptions = document.querySelectorAll("[data-bs-theme-value]");

    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");

    const getStoredTheme = () => localStorage.getItem("theme");

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();

        if (["light", "dark", "auto"].includes(storedTheme)) {
            return storedTheme;
        }

        return "auto";
    };

    const setStoredTheme = (theme) => {
        localStorage.setItem("theme", theme);
    };

    const setTheme = (theme) => {
        const themeEffectif =
            theme === "auto" ? (mediaQuery.matches ? "dark" : "light") : theme;

        document.documentElement.setAttribute("data-bs-theme", themeEffectif);
    };

    const showActiveTheme = (theme) => {
        if (!themeSwitcher) {
            return;
        }

        themeOptions.forEach((option) => {
            const estActif = option.dataset.bsThemeValue === theme;

            option.classList.toggle("active", estActif);
            option.setAttribute("aria-pressed", estActif);
        });

        const icones = {
            light: "bi-sun-fill",
            dark: "bi-moon-stars-fill",
            auto: "bi-circle-half",
        };

        const icone = themeSwitcher.querySelector("i");

        if (icone) {
            icone.className = `bi ${icones[theme]}`;
        }

        themeSwitcher.setAttribute("aria-label", `Thème actuel : ${theme}`);
    };

    // Appliquer le thème sauvegardé ou automatique
    const themeInitial = getPreferredTheme();

    setTheme(themeInitial);
    showActiveTheme(themeInitial);

    // Changer de thème lors d'un clic
    themeOptions.forEach((option) => {
        option.addEventListener("click", () => {
            const theme = option.dataset.bsThemeValue;

            setStoredTheme(theme);
            setTheme(theme);
            showActiveTheme(theme);
        });
    });

    // Actualiser le thème si les préférences du système changent
    mediaQuery.addEventListener("change", () => {
        if (getStoredTheme() === "auto" || !getStoredTheme()) {
            setTheme("auto");
        }
    });
}

// Initialisation du thème Bootstrap avant le chargement du DOM pour éviter un flash de thème incorrect
(() => {
    const theme = localStorage.getItem("theme");

    const themeValide = ["light", "dark", "auto"].includes(theme)
        ? theme
        : "auto";

    const themeEffectif =
        themeValide === "auto"
            ? window.matchMedia("(prefers-color-scheme: dark)").matches
                ? "dark"
                : "light"
            : themeValide;

    document.documentElement.setAttribute("data-bs-theme", themeEffectif);
})();
