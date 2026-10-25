document.addEventListener("DOMContentLoaded", initialiser);

function initialiser() {
    const formulaireAjax = document.querySelector("#formulaireAjax");
    formulaireAjax.addEventListener("submit", gererSoumissionFormulaireAjax);
}

async function gererSoumissionFormulaireAjax(event) {
    event.preventDefault();
    event.stopPropagation();

    const formulaire = event.currentTarget;

    // Vérifie la validité du formulaire avant de continuer
    if (!formulaire.checkValidity()) {
        return;
    }

    // Afficher le placeholder de chargement et cacher le formulaire
    togglePlaceholderEtFormulaire();

    // Vider la zone de réponse avant d'envoyer la requête
    document.querySelector("#reponse").innerHTML = "";

    // Préparer les données du formulaire pour l'envoi AJAX
    const formData = new FormData(formulaire);

    // Envoyer les données via fetch
    try {
        const reponse = await fetch(
            "index.php?action=gererSoumissionFormulaireAjax",
            {
                method: "POST",
                body: formData,
            },
        );

        // Récupération de la réponse du serveur sous forme de texte
        const donnees = await reponse.text();

        // Vérifie si le serveur indique que la requête a été effectuée avec succès
        if (reponse.ok) {
            gererSuccessServeur(donnees);
        } else {
            gererErreurServeur(donnees);
        }
    } catch (erreur) {
        // Si on arrive ici, c'est qu'il y a eu une erreur dans le fetch
        // Peut-être une erreur réseau ou une exception levée
        gererErreurClient(erreur);
    } finally {
        // Réafficher le formulaire et cacher le placeholder de chargement
        togglePlaceholderEtFormulaire();
    }
}

function gererSuccessServeur(htmlSuccess) {
    // Afficher le HTML de succès retourné par le serveur
    document.querySelector("#reponse").innerHTML = htmlSuccess;
    // Réinitialiser le formulaire après une soumission réussie
    const formulaire = document.querySelector("#formulaireAjax");
    formulaire.reset(); // Vider les champs du formulaire
    formulaire.classList.remove("was-validated"); // Cacher la validation Bootstrap
}

function gererErreurServeur(htmlErreur) {
    // Afficher le HTML d'erreur retourné par le serveur
    document.querySelector("#reponse").innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ${htmlErreur}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `;
}

function gererErreurClient(erreur) {
    // Afficher l'erreur dans la console pour le débogage
    console.error("Erreur :", erreur);
    // Afficher un message d'erreur dans la page
    document.querySelector("#reponse").innerHTML =
        `<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer.</div>`;
}

function togglePlaceholderEtFormulaire() {
    const formulaire = document.querySelector("#formulaireAjax");
    const placeholder = document.querySelector("#formulaireAjaxPlaceholder");
    formulaire.classList.toggle("d-none");
    placeholder.classList.toggle("d-none");
}
