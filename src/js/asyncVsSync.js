document.addEventListener("DOMContentLoaded", initialiser);

function initialiser() {
    document
        .querySelector("#btn-sync")
        .addEventListener("click", gererClickSync);
    document
        .querySelector("#btn-async")
        .addEventListener("click", gererClickAsync);
}

function gererClickSync() {
    const divAffichage = document.querySelector("#affichage-sync");
    const nbSecondes = obtenirNombreSecondes();
    const horodatageDepart = Date.now();

    // On vide la div d'affichage
    divAffichage.innerHTML = "";

    for (let i = 0; i < nbSecondes; i++) {
        while (Date.now() < horodatageDepart + i * 1000) {
            // Attente active d'une seconde
            // On attend activement
        }
        divAffichage.innerHTML += `${nbSecondes - i}<br>`;
    }
}

/**
 * Identifiant de l'intervalle pour pouvoir l'arrêter si nécessaire
 * @type {number}
 */
let intervalId;

function gererClickAsync() {
    const divAffichage = document.querySelector("#affichage-async");
    const nbSecondes = obtenirNombreSecondes();
    let secondesRestantes = nbSecondes;

    // On vide la div d'affichage
    divAffichage.innerHTML = "";
    clearInterval(intervalId); // Au cas où un intervalle est déjà en cours

    intervalId = setInterval(() => {
        divAffichage.innerHTML += `${secondesRestantes}<br>`;
        secondesRestantes--;
        if (secondesRestantes === 0) {
            clearInterval(intervalId);
        }
    }, 1000);
}

function obtenirNombreSecondes() {
    const inputNbSecondes = document.querySelector("#nombreSecondes");
    return inputNbSecondes.value;
}
