<?php


// $dsn = "mysql:dbname="."sae_mlp".";host="."127.0.0.1";
// try{
//     $connexion = new PDO($dsn, "root", "clermont");
// }
// catch(PDOException $e){
//     printf("Error connecting to database: %s", $e->getMessage());
//     exit();
// }

// Chemin vers la base de données SQLite
$db_path = "../data/data.sqlite";

$pdo = new PDO('sqlite:'.$db_path);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function utilisateurExistant($mail, $mdp) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    if ($result != null){
        return true;
    }
    return false;
}

function getUtilisateur($mail) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    if ($result){
        return $result;
    }
    return null;
}
 
function insertClient($nom, $prenom, $tel, $email, $cp, $ville, $mdp, $handicap) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, prenom, telephone, email, codepostal, ville, mdp) Values (?,?,?,?,?,?,?)");
    $stmt->execute([$nom, $prenom, $tel, $email,$cp, $ville, $mdp]);
}

function ajoutePrefCuisine($email, $cuisine){
    
}

function getPrefCuisine($email){
    return array("Chinoise","Americaine");
}

function getRegion($ville) {
    // Exemple de simulation de données
    $data = [
        "Moret" => [[null, "Pensylvanie"], ["Loir-et-Cher", "Centre-Val de Loire"]],
        "Orleans" => [["Loiret", "Centre-Val de Loire"]],
        "Nates" => [["Loire-Atlantique", "Pays de la Loire"]],
        "Lille" => [["Nord", "Hauts-de-France"]]
    ];

    return $data[$ville] ?? [];
}

function getBestResto(){
    $resto = new Restaurant(
        1, "test BEST RESTO", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
        "1.9052942", "47.902964", "https://test.com", "@testbest",
        "06 06 06 06 69", 3.4, 42, true, false, true, true, false,
        "12:00-14:00,19:00-22:00", ["Française", "Italienne"]
    );

    return array_fill(0, 10, $resto);
}
function getPopResto(){
    $resto = new Restaurant(
        1, "test POPULAR", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
        "1.9052942", "47.902964", "https://test.com", "@testPOP",
        "06 06 06 69 06", 3.4, 42, true, false, true, true, false,
        "12:00-14:00,19:00-22:00", ["Chinoise"]
    );

    return array_fill(0, 10, $resto);
}



function estFavoris($mail, $resto){

}
function ajouter_supprimerFavoris($mail, $resto){

}