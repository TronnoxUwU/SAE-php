<script src="../static/script/popup_valid.js"></script>

<?php
// Fichier : register.php
session_start();

require_once "../static/script/modele.php";


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partie-insc'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['name'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $mdp = $_POST['password'] ?? null;
    (int)$cp = $_POST['cp'] ?? 45000;
    $ville = $_POST['ville'] ?? "orleans";
    $tel = $_POST['telephone'] ?? "+33";
    $handicap = $_POST['handicap'] ?? false;

    // Validation de base
    if ($nom && $prenom && $email && $mdp) {
        try {

            if (utilisateurExistant($email, $mdp)) {
                echo '<p></p>';
                echo '<script>showPopup("Cet email est déjà utilisé.", false);</script>';
            } else {
                // Insérer les données dans la table "users"
                // function insertAdherent($nom, $prenom, $tel, $mail, $taille, $poids, $dateInscription, $mdp){

                insertClient($nom, $prenom, $tel, $email, $cp, $ville, $mdp, $handicap);
                
                $id = utilisateurExistant($email, hash('sha256', $mdp));
                $inscription++;

                //sleep(3);
                //header("Location: inscription.php");
                echo '<p></p>';
                echo '<script>showPopup("Inscription réussie !", true);</script>';
                //header("Location: login.php");
                //exit();
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();

            //header("Location: inscription.php");
            echo '<p></p>';
            echo '<script>showPopup("Cela na pas fonctionné, cest de la faut de tristan", false);</script>';
            //header("Location: login.php"); 
            exit();
        }
    } else {

        //header("Location: inscription.php");
        echo '<p></p>';
        echo '<script>showPopup("Veuillez remplir tous les champs obligatoires.", false);</script>';
    }
}


// A CONFIGURER POUR LA PARTIE DES PREFERENCES CULINAIRES

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partie-pref'])) {
    $selectedCuisines = explode(',', $_POST['selectedCuisines']);
    if (!empty($selectedCuisines)) {
        echo "Cuisines sélectionnées : " . implode(', ', $selectedCuisines);
        // Insérez en base de données ici
    } else {
        echo "Aucune cuisine sélectionnée.";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/login.css">
    <link rel="stylesheet" href="../static/styles/popup_valid.css">
    <title>Inscription</title>
</head>
<body>

    <a href="login.php" style="position: absolute; top: 10px; left: 10px;">
        <img src="../static/images/maison noire.png" alt="Retour à l'accueil" style="width: 40px; height: 40px; cursor: pointer;">
    </a>

    <?php
    switch ($_SESSION['inscription']) {
        case 1:
            include "pages/inscription-pref.php";
            break;
        default:
            include "pages/inscription.html";
            break;
    }
    ?>

</body>
</html>
