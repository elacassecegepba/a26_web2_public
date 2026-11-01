document.addEventListener("DOMContentLoaded", init);

function init() {
    const form = document.querySelector("#formConnexion");
    form.addEventListener("submit", gererSoumission);
}

let timeoutId;

async function gererSoumission(event) {
    event.preventDefault();
    event.stopPropagation();

    const formulaire = event.target;

    if (!formulaire.checkValidity()) {
        return;
    }

    const btnSubmit = formulaire.querySelector("button[type='submit']");
    btnSubmit.disabled = true;
    timeoutId = setTimeout(() => {
        btnSubmit.innerHTML = `
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `;
    }, 500); // Ajout d'un délai de 1 seconde avant d'afficher le spinner

    const formData = new FormData(formulaire);

    try {
        const reponse = await fetch("index.php?action=connecter", {
            method: "POST",
            body: formData,
        });

        const donnees = await reponse.text();
        if (reponse.ok) {
            gererSuccessServeur();
        } else {
            gererErreurServeur(donnees);
        }
    } catch (erreur) {
        gererErreurClient(erreur);
    }

    btnSubmit.disabled = false;
    btnSubmit.innerHTML = "Se connecter";
    clearTimeout(timeoutId);
}

function gererSuccessServeur() {
    document.location = "index.php?action=afficherPageProfil";
}

function gererErreurServeur(htmlErreur) {
    document.querySelector("#reponse").innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ${htmlErreur}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `;
}

function gererErreurClient(erreur) {
    console.error("Erreur :", erreur);
    document.querySelector("#reponse").innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Une erreur est survenue. Veuillez réessayer plus tard.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `;
}
