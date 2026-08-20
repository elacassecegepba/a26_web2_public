<?php
function genererPresentation(string $prenom, int $age, string $ville, string $passion): string {
    return "Salut! Je suis {$prenom}, {$age} ans, de {$ville}. Ma passion : {$passion}!";
}

function evaluerNiveau(int $niveau): string
{
    if ($niveau >= 1 && $niveau <= 3) {
        return "Débutant";
    } elseif ($niveau >= 4 && $niveau <= 6) {
        return "Intermédiaire";
    } elseif ($niveau >= 7 && $niveau <= 10) {
        return "Avancé";
    } else {
        return "Niveau invalide";
    }
}

function validerCompetence(array $competence): bool
{
    // Bonus, vérifier que $competence est un tableau
    if (!is_array($competence)) {
        return false;
    }

    if (!isset($competence["niveau"]) || empty($competence["niveau"])) {
        return false;
    }

    // Bonus, vérifier que le niveau est un nombre entre 1 et 10
    if (!is_int($competence["niveau"]) || $competence["niveau"] < 1 || $competence["niveau"] > 10) {
        return false;
    }

    if (!isset($competence["experience"]) || empty($competence["experience"])) {
        return false;
    }

    // Bonus, vérifier que l'expérience est une string
    if (!is_string($competence["experience"])) {
        return false;
    }

    return true;
}
