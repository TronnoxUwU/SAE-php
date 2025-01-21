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
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail AND mdp = :mdp");
    $stmt->execute(array('mail' => $mail, 'mdp' => $mdp));
    $result = $stmt->fetchAll();
    if ($result != null){
        return true;
    }
    return false;
}

function getUtilisateur($mail, $mdp) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail AND mdp = :mdp");
    $stmt->execute(array('mail' => $mail, 'mdp' => $mdp));
    $result = $stmt->fetchAll();
    if ($result){
        return $result;
    }
    return null;
}
 
function insertClient($nom, $prenom, $tel, $email, $cp, $ville, $mdp) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, prenom, telephone, email, codepostal, ville, mdp) Values (?,?,?,?,?,?,?)");
    $stmt->execute([$nom, $prenom, $tel, $email,$cp, $ville, $mdp]);
}