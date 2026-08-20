<?php
function getDonnees() {
    return [
        "prenom" => "Alice",
        "nom" => "Dubois",
        "age" => 19,
        "ville" => "St-Georges",
        "pseudo" => "CodeMaster",
        "competences" => [
            "HTML/CSS"         => ["niveau" => 8, "experience" => "2 ans"],
            "JavaScript"       => ["niveau" => 7, "experience" => "1.5 ans"],
            "C#"               => ["niveau" => 6, "experience" => "1 an"],
            "PHP"              => ["niveau" => 3, "experience" => "Débutant"],
            "MySQL"            => ["niveau" => 2, "experience" => "À venir"],
            "ManqueExperience" => ["niveau" => 2]
        ]
    ];
}
