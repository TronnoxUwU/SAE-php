<?php
// Start session
session_start();
require "../static/script/modele.php"; // Inclure le modèle contenant la fonction `verifierUtilisateur`

// Check if user is already logged in
// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
//     header("Location: admin.php");
//     exit();
// }

// Handle login errors
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get submitted data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    try {
        // Vérification des identifiants via la fonction du modèle
        $user = isUtilisateurExistant($username, $password);

        if ($user) {
            // Set session and redirect
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $username;
            $_SESSION['pswrd'] = $password;

            if (isAdmin($username, $password)) {
                echo "admin";
                header("Location: admin.php");
            } else if (isMoniteur($username, $password)) {
                echo "moniteur";
                header("Location: admin.php");
            } else {
                echo "client";
                header("Location: infoClient.php");
            }
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/login.css">
    <title>Connexion</title>
</head>
<body>
    <a href="home.php" style="position: absolute; top: 10px; left: 10px;">
        <img src="../static/images/maison noire.png" alt="Retour à l'accueil" style="width: 40px; height: 40px; cursor: pointer;">
    </a>

    <main class="login-container">
        <form id="loginForm" method="POST">
            <h1>Connexion</h1>

            <!-- Display error message if any -->
            <?php if ($error): ?>
                <p id="error-message" class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group" id="btnform">
                <button type="submit">Se connecter</button>
            </div>

        </form>
        <div class="barreB"></div>

        <a href="./inscription.php"> <p>Pas de compte ? S'inscrire -></p> </a>
    </main>
</body>
</html>
