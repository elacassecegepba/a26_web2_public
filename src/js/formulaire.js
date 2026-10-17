document.addEventListener("DOMContentLoaded", initialiser);

function initialiser() {
    document
        .querySelector("#validationMotDePasse")
        .addEventListener("input", validerConfirmationMotDePasse);
    document
        .querySelector("#motDePasse")
        .addEventListener("input", validerConfirmationMotDePasse);
    document
        .querySelector("#formulaireInscription")
        .addEventListener("submit", gererSoumissionFormulaire);
}

function validerConfirmationMotDePasse() {
    const inputConfirmation = document.querySelector("#validationMotDePasse");
    const motDePasse = document.querySelector("#motDePasse").value;
    const confirmationMotDePasse = inputConfirmation.value;

    let erreur = "";
    if (motDePasse !== confirmationMotDePasse) {
        erreur = "Les mots de passe ne correspondent pas.";
    }
    inputConfirmation.setCustomValidity(erreur);
}

/**
 * Gérer la soumission du formulaire.
 * @param {Event} event 
 * @returns 
 */
function gererSoumissionFormulaire(event) {
    // Empêcher la soumission du formulaire par le navigateur.
    event.preventDefault();
    event.stopPropagation();

    const formulaire = event.currentTarget;

    // Récupérer les valeurs des champs.
    const email = formulaire.email.value;
    const motDePasse = formulaire.motDePasse.value;
    const validationMotDePasse = formulaire.validationMotDePasse.value;

    // Valider les champs.
    if (!formulaire.checkValidity()) {
        return;
    }

    // Vider le formulaire.
    formulaire.reset();

    // Cacher la validation de Bootstrap.
    formulaire.classList.remove("was-validated");

    // Afficher les valeurs dans une alerte Bootstrap.
    const alerteInfo = document.getElementById("alerteInfo");
    alerteInfo.innerHTML =
        `Email : <strong>${email}</strong><br>` +
        `Mot de passe : <strong>${motDePasse}</strong><br>` +
        `Validation du mot de passe : <strong>${validationMotDePasse}</strong>`;
    alerteInfo.classList.remove("d-none");
}
