document.addEventListener("DOMContentLoaded", initialiser);

function initialiser() {
    const inputTitre = document.querySelector("#titre");
    inputTitre.addEventListener("input", gererInputTitre);
}

let timeout;
function gererInputTitre(event) {
    const titre = event.currentTarget.value;

    // Faire requete recherche lorsque l'utilisateur cesse de taper pendant 300ms
    if (timeout) {
        clearTimeout(timeout);
    }
    timeout = setTimeout(async () => {
        // Faire la requête de recherche ici
        if (titre.length < 1 || titre.length > 255) {
            viderZoneReponse();
            return;
        }

        const formData = new FormData();
        formData.append("titre", titre);

        try {
            const reponse = await fetch(
                "index.php?action=rechercherFilmsAjax",
                {
                    method: "POST",
                    body: formData,
                },
            );

            const donnees = await reponse.text();

            if (reponse.ok) {
                gererSuccessServeur(donnees);
            } else {
                gererErreurServeur(donnees);
            }
        } catch (erreur) {
            gererErreurClient(erreur);
        }
    }, 300);
}

function viderZoneReponse() {
    document.querySelector("#reponse").innerHTML = "";
}

function gererSuccessServeur(htmlSuccess) {
    document.querySelector("#reponse").innerHTML = htmlSuccess;
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
    document.querySelector("#reponse").innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Une erreur est survenue. Veuillez réessayer plus tard.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `;
}
