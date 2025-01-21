<script src="../static/script/popup_valid.js"></script>

<?php
// Fichier : register.php
session_start();

require_once "../static/script/modele.php";


// Chemin vers la base de données SQLite
$db_path = "../data/data.sqlite";

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['name'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $mdp = $_POST['password'] ?? null;
    (int)$taille = $_POST['taille'] ?? 0;
    (int)$poids = $_POST['poids'] ?? 0;
    $tel = $_POST['telephone'] ?? "+33";
    (int)$lvl = $_POST['lvl'] ?? "+33";

    // Validation de base
    if ($nom && $prenom && $email && $mdp) {
        try {

            if (isUtilisateurExistant($email, $mdp)) {
                echo '<p></p>';
                echo '<script>showPopup("Cet email est déjà utilisé.", false);</script>';
            } else {
                // Insérer les données dans la table "users"
                // function insertAdherent($nom, $prenom, $tel, $mail, $taille, $poids, $dateInscription, $mdp){

                insertAdherent($nom, $prenom, $tel, $email, $taille, $poids, date('Y-m-d H:i:s'), $mdp);
                
            
                $id = utilisateurExistant($email, hash('sha256', $mdp));

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/settings.css">
    <link rel="stylesheet" href="../static/styles/popup_valid.css">
    <title>Inscription</title>
</head>
<body>

    <a href="login.php" style="position: absolute; top: 10px; left: 10px;">
        <img src="../static/images/maison noire.png" alt="Retour à l'accueil" style="width: 40px; height: 40px; cursor: pointer;">
    </a>

    <main class="login-container">
        <form id="registerForm" method="POST">
            <h1>Inscription</h1>

            <div class="form-group">
                <label for="name">Nom *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="email">eMail *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone">
            </div>

            <div class="form-group">
                <label for="taille">Taille (cm)</label>
                <input type="number" id="taille" name="taille" value=0>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg)</label>
                <input type="number" id="poids" name="poids" value=0>
            </div>

            <div class="form-group">
                <label for="lvl">Niveau</label>
                <select id="lvl" name="lvl">
                    <option value="1">debutant</option>
                    <option value="2">intermediaire</option>
                    <option value="3">experimenté</option>
                </select>
            </div>

            <div class="form-group" id="btnform">
                <button type="submit">S'inscrire</button>
            </div>
        </form>
    </main>
</body>
</html>
