document.addEventListener("DOMContentLoaded", init);

function init() {
    const selectMarque = document.querySelector("#marque");
    selectMarque.addEventListener("change", gererSelectionMarque);
}

async function gererSelectionMarque(event) {
    const marqueSelectionnee = event.target.value;

    try {
        const reponse = await fetch(
            `index.php?action=obtenirModelesParMarque&marque=${marqueSelectionnee}`,
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
}

function gererSuccessServeur(htmlSuccess) {
    const selectModele = document.querySelector("#modele");
    selectModele.innerHTML = htmlSuccess;
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
