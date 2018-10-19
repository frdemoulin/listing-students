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

// on déclare le tableau des étudiants
$students = [];

if ($handle = fopen($fileName, 'r')) {

// la fonction fgetcsv() retourne les champs du csv dans un array indexé $line
// index 0 => nom ; index 1 => prénom

    while ($line = fgetcsv($handle)) {
        // on stocke les datas des étudiants dans un tableau de tableaux indexés
        // index 0 : premier étudiant
            // index 0 => nom ; index 1 => prénom
        
        array_push($students, $line);
    }

} else {
    echo 'Erreur à l\'ouverture du fichier ' . $fileName;
}

//d($students);

/*
*******************************************
TRAITEMENT DES DATAS
*******************************************
TODO : passer les datas des étudiants en minuscule, supprimer les accents et remplacer les espaces par des underscores
*/

// strtolower() renvoie une chaîne en minuscules
// str_replace() remplace un caractère par un autre

// on stocke les datas formatées des étudiants dans $studentsFormated qui est un tableau indexé de tableaux indexés
// index 0 : premier étudiant
    // index 0 : prenom ; index 1 : nom

foreach ($students as $key => $value) {
    // on stocke le prénom en index 0
    $studentsFormated[$key][0] = str_replace('é', 'e', str_replace(' ', '_', strtolower($value[1])));
    // on stocke le nom en index 1
    $studentsFormated[$key][1] = str_replace('é', 'e', str_replace(' ', '_', strtolower($value[0])));
}

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
    echo 'création du dossier parent OK <br />';
}

// on déclare un compteur de dossier créé
$cpt = 1;

// on crée dans le dossier de stockage les dossiers des étudiants au format prenom-nom
// $value[0] contient le prénom, $value[1] le nom
foreach ($studentsFormated as $value) {

$folderName = $value[0] . '-' . $value[1]; 

    if(!is_dir($folderParent . '/' . $folderName)){
        mkdir($folderParent . '/' . $folderName);
        echo '#' . $cpt . ' - dossier ' . $folderName . ' créé avec succès <br />';
    $cpt++; 
    }
}
