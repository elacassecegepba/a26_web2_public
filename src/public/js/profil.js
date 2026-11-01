const URL_IMAGE_DEFAUT = "https://www.gravatar.com/avatar/?d=mp";
const imageProfil = document.getElementById("image-profil");
let urlImageProfilFallback = URL_IMAGE_DEFAUT;

document.addEventListener("DOMContentLoaded", function () {
    verifierUrlImage(imageProfil.src)
        .then(() => (urlImageProfilFallback = imageProfil.src))
        .catch(() => (imageProfil.src = urlImageProfilFallback));
});

function verifierUrlImage(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve();
        img.onerror = () => reject();
        img.src = url;
    });
}

imageProfil.addEventListener("error", function () {
    imageProfil.src = urlImageProfilFallback;
});

document.getElementById("btn-modifier-profil").onclick = function () {
    document.getElementById("profil-infos").style.display = "none";
    document.getElementById("form-modifier-profil").style.display = "block";
    previsualiserImage(document.getElementById("image").value);
};

document.getElementById("btn-annuler").onclick = function () {
    document.getElementById("form-modifier-profil").style.display = "none";
    document.getElementById("profil-infos").style.display = "block";
    imageProfil.src = urlImageProfilFallback;
};

// Prévisualisation dynamique de l'image de profil
document.getElementById("image").addEventListener("input", function (event) {
    previsualiserImage(event.target.value);
});

function previsualiserImage(url) {
    const imageProfil = document.getElementById("image-profil");
    if (url.trim() === "") {
        imageProfil.src = URL_IMAGE_DEFAUT;
        return;
    }

    // Teste si l'URL est valide en essayant de charger l'image
    verifierUrlImage(url)
        .then(() => (imageProfil.src = url))
        .catch(() => (imageProfil.src = urlImageProfilFallback));
}
