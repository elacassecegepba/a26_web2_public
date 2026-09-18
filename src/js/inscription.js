document.getElementById('confirmationMotDePasse').addEventListener('input', validerConfirmationMotDePasse);
document.getElementById('motDePasse').addEventListener('input', validerConfirmationMotDePasse);

function validerConfirmationMotDePasse() {
    const inputConfirmation = document.getElementById('confirmationMotDePasse');
    const motDePasse = document.getElementById('motDePasse').value;
    const confirmationMotDePasse = inputConfirmation.value;

    let erreur = '';
    if (motDePasse !== confirmationMotDePasse) {
        erreur = 'Les mots de passe ne correspondent pas.';
    }
    inputConfirmation.setCustomValidity(erreur);
}