document.addEventListener("DOMContentLoaded", initialiserBootstrap);

function initialiserBootstrap() {
    initialiserFormulaireNeedsValidation();
    initialiserPopover();
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
            false
        );
    }
}

// https://getbootstrap.com/docs/5.3/components/popovers/#enable-popovers
function initialiserPopover() {
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );
}