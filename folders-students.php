<?php

// fonction var_dump personnalisée
function d($variable) {
    echo '***** VAR DUMP / Start *****';
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    echo '***** End / VAR DUMP *****';
    die();
}

/*
*******************************************
EXPORT CSV
*******************************************
TODO : exporter le contenu des champs csv dans un tableau associatif PHP Prenom => Nom
*/

// on déclare le nom du fichier csv contenant les datas des étudiants
$fileName = 'listing-students.csv';

// on ouvre en lecture le fichier csv avec contrôle d'erreur à l'ouverture
// la fonction fopen() ouvre le fichier $fileName en lecture seule (argument 'r') et place le curseur au début de la première ligne
// retourne une ressource représentant le pointeur de fichier ou FALSE si erreur

if ($handle = fopen($fileName, 'r')) {

// la fonction fgetcsv() retourne les champs du csv dans un array indexé $line
// index 0 => nom ; index 1 => prénom

    while ($line = fgetcsv($handle)) {
        // on stocke les infos de l'étudiant dans l'array associatif $students
        // clé : prénom => valeurs : nom;
       
        $students[$line[1]] = $line[0];
    }

} else {
    echo 'Erreur à l\'ouverture du fichier ' . $fileName;
}

/*
*******************************************
TRAITEMENT DES DATAS
*******************************************
TODO : passer les datas des étudiants en minuscule et remplacer les éventuels espaces par des underscores
*/

// strtolower() renvoie une chaîne en minuscules
// str_replace() remplace un caractère par un autre

foreach ($students as $firstname => $lastname) {
    //$studentsLowercase[strtolower($firstname)] = strtolower($lastname);
    $studentsFormated[str_replace(' ', '_', strtolower($firstname))] = str_replace(' ', '_', strtolower($lastname));
}

//d($studentsFormated);

/*
*******************************************
CREATION DES DOSSIERS
*******************************************
TODO : générer les noms de dossier en kebab case sous la forme prenom-nom
*/

// on déclare le nom du dossier de stockage des dossiers étudiants
$folderParent = 'students';

// s'il n'est pas déjà présent, on crée ce dossier de stockage
// is_dir() teste l'existence d'un dossier
// mkdir() crée un dossier
if(!is_dir($folderParent)){
    mkdir($folderParent);
}

// on crée dans le dossier de stockage les dossiers des étudiants au format prenom-nom
foreach ($studentsFormated as $firstname => $lastname) {

$folderName = $firstname . '-' . $lastname; 

    if(!is_dir($folderParent . '/' . $folderName)){
        mkdir($folderParent . '/' . $folderName);
     }
    
}
