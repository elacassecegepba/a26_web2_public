document.addEventListener("DOMContentLoaded", initialiserMemoire);

function initialiserMemoire() {
    ajouterEvenementClicCartes();
}

function ajouterEvenementClicCartes() {
    document.querySelectorAll(".carte").forEach((carte) => {
        carte.addEventListener("click", gererClickCarte);
    });
}

/**
 * Variable pour stocker la première carte cliquée
 * @type {HTMLElement|undefined}
 */
let premiereCarte;

/**
 * Variable pour indiquer si on est en attente de la fin du délai
 * @type {boolean}
 */
let enAttente = false;

/**
 * Nombre de paires à trouver pour gagner
 * @type {number}
 */
const MAX_SCORE = 6;

/**
 * Variable pour stocker le score
 * @type {number}
 */
let score = 0;

/**
 * Gère le clic sur une carte
 * @param {Event} event
 */
function gererClickCarte(event) {
    if (enAttente) {
        return; // On ne fait rien si on est en attente de la fin du délai
    }

    const carte = event.currentTarget; // Récupère la carte cliquée
    const couleur = carte.dataset.couleur; // Récupère la couleur de la carte
    carte.classList.add(couleur); // Ajoute la classe de couleur à la carte

    // Si premièreCarte est undefined, on la définit à la carte cliquée
    if (premiereCarte == undefined) {
        premiereCarte = carte;
        return; // On sort de la fonction pour attendre le prochain clic
    }

    // Si la carte cliquée est la même que la première, on ne fait rien
    if (premiereCarte === carte) {
        return;
    }

    // Si les couleurs sont les mêmes, on affiche l'icône de l'oeil sur les deux cartes et on réinitialise premièreCarte
    if (premiereCarte.dataset.couleur === couleur) {
        premiereCarte.innerHTML = '<i class="fa-solid fa-eye"></i>';
        carte.innerHTML = '<i class="fa-solid fa-eye"></i>';
        premiereCarte = undefined;

        score++; // On incrémente le score
        // Si l'utilisateur a trouvé toutes les paires, on affiche un message de félicitations
        if (score === MAX_SCORE) {
            const plateauJeuMemoire = document.querySelector("#plateauJeuMemoire");
            plateauJeuMemoire.innerHTML = `
                <div class="alert alert-success" role="alert">
                    Félicitations! Vous avez trouvé toutes les paires!
                </div>
                ${plateauJeuMemoire.innerHTML}
            `;
        }
        return;
    }

    // Si les couleurs sont différentes, on cache les cartes après un délai de 1 seconde
    const anciennePremiereCarte = premiereCarte; // On stocke l'ancienne première carte pour pouvoir la réinitialiser après le délai
    enAttente = true; // On indique qu'on est en attente de la fin du délai
    premiereCarte = undefined; // On réinitialise premièreCarte
    setTimeout(() => {
        anciennePremiereCarte.classList.remove(
            anciennePremiereCarte.dataset.couleur,
        );
        carte.classList.remove(couleur);
        enAttente = false; // On indique qu'on n'est plus en attente
    }, 100);
}
