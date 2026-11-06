document.addEventListener("DOMContentLoaded", init);

function init() {
    const formulaireRegex = document.querySelector("#formulaireRegex");
    formulaireRegex.addEventListener("submit", gererSoumissionFormulaireRegex);
}

function validerExempleRegexEnJS(valeur) {
    const regexExRegex = /^abc123$/;

    if (!regexExRegex.test(valeur)) {
        return ["Le champ 'ExRegex' ne correspond pas au format requis. OK"];
    }

    return [];
}

async function gererSoumissionFormulaireRegex(event) {
    event.preventDefault();
    event.stopPropagation();

    const formulaire = event.target;
    const conteneurReponse = document.querySelector("#reponseFormulaireRegex");
    const skipValidationHTML = formulaire.skipValidationHTML.checked;
    const skipValidationJS = formulaire.skipValidationJS.checked;

    // Validation HTML
    if (!formulaire.checkValidity() && !skipValidationHTML) {
        return;
    }

    // Validation JavaScript
    if (!skipValidationJS) {
        const erreurs = [
            ...validerExempleRegexEnJS(formulaire.exRegex.value)
        ];

        if (erreurs.length > 0) {
            const textErreurs = erreurs.join("<br>");
            afficherMessageErreur(conteneurReponse, textErreurs, "Validation JavaScript");
            return;
        }
    }
    
    // Soumission du formulaire pour validation côté serveur
    try {
        const formData = new FormData(formulaire);
        const reponse = await fetch(
            "index.php?action=soumettreFormulaireRegex",
            {
                method: "POST",
                body: formData,
            },
        );

        const donnees = await reponse.text();
        if (reponse.ok) {
            gererSuccessServeur(conteneurReponse, donnees);
        } else {
            afficherMessageErreur(conteneurReponse, donnees, "Validation serveur");
        }
    } catch (erreur) {
        gererErreurClient(conteneurReponse, erreur);
    }
}

function gererSuccessServeur(conteneur, htmlSuccess) {
    conteneur.innerHTML = htmlSuccess;
}

function afficherMessageErreur(conteneur, erreur, source) {
    console.error("Erreur :", erreur);
    conteneur.innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>${source}</strong> 
        <hr>
        ${erreur}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `;
}

function gererErreurClient(conteneur, erreur) {
    afficherMessageErreur(conteneur, "Une erreur est survenue. Veuillez réessayer plus tard.", "Erreur client");
}
