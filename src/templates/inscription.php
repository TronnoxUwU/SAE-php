<script src="../static/script/popup_valid.js"></script>

<?php

session_start();

require_once "../static/script/modele.php";

if (!isset($_SESSION['inscription'])){$_SESSION['inscription'] = 0;};



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['partie-insc'])) {

    $nom = $_POST['name'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $mdp = $_POST['password'] ?? null;
    $ville = $_POST['ville'] ?? "Orléans";
    $departement = $_POST['departement'] ?? "Loiret";
    $region = $_POST['Region'] ?? "Centre-val-de-Loire";
    $tel = $_POST['telephone'] ?? "+33";
    $handicap = $_POST['handicap'] ?? false;


    if ($nom && $prenom && $email && $mdp) {
        try {

            if (utilisateurExistant($email, $mdp)) {
                echo '<p></p>';
                echo '<script>showPopup("Cet email est déjà utilisé.", false);</script>';
            } else {

                // function insertAdherent($nom, $prenom, $tel, $mail, $taille, $poids, $dateInscription, $mdp){
                if (!$handicap){$handicap=0;}
                insertClient_light($nom, $prenom, $tel, $email, $mdp, $handicap);
                
                $id = utilisateurExistant($email, hash('sha256', $mdp));
                $_SESSION['inscription']++;
                $_SESSION['inscription-mail']=$email;


                echo '<p></p>';
                echo '<script>showPopup("Inscription réussie !", true);</script>';
                // sleep(3);
                // header("Location: inscription.php");
                //header("Location: login.php");
                //exit();
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();

            //header("Location: inscription.php");
            echo '<p></p>';
            echo '<script>showPopup("Cela na pas fonctionné :(", false);</script>';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedCuisines'])) {
    $selectedCuisines = explode(',', $_POST['selectedCuisines']);
    $_SESSION['inscription'] = 2;

    if (!empty($selectedCuisines)) {
        // echo "Cuisines sélectionnées : " . implode(', ', $selectedCuisines);

        foreach($selectedCuisines as $cuis){
            ajoutePrefCuisine($_SESSION['inscription-mail'], $cuis);
        }

        echo '<p></p>';
        echo '<script>showPopup("Inscription cuisines réussies!", true);</script>';
    } else {
        // echo "Aucune cuisine sélectionnée.";
        echo '<p></p>';
        echo '<script>showPopup("Echec ajout cuisines !", false);</script>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $_SESSION['inscription'] = 0;
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
        case 2:
            header("Location: ./login.php");
            break;
        case 1:
            include "pages/inscription-pref.php";
            break;
        default:
            include "pages/inscription.php";
            break;
    }
    ?>

</body>
</html>
