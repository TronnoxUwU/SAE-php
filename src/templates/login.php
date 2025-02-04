<script src="../static/script/popup_valid.js"></script>

<?php
session_start();
require "../static/script/modele.php";

// Utilisateur déjà connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: espace-perso.php");
    exit();
}

// Handle login errors
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get submitted data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    try {
        // Vérification des identifiants via la fonction du modèle
        $user = utilisateurExistant($username, $password);

        if ($user) {
            // Set session and redirect
            $_SESSION['loggedin'] = true;
            $_SESSION['mail'] = $username;
            $_SESSION['nom'] = "REQUESTE A FAIRE DANS LA BD";
            $_SESSION['prenom'] = "REQUESTE A FAIRE DANS LA BD";

            header("Location: home.php");
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
            echo '<script language="javascript">';
            echo 'alert("Identifiant ou Mot de passe incorrect")';
            echo '</script>';
        }
    } catch (Exception $e) {
            // Erreur connexion
        echo '<script language="javascript">';
        echo 'alert("Erreur de connexion, veuillez rééssayer plus tard")';
        echo '</script>';
        die("Erreur : " . $e->getMessage());
    }
}
?>

        <!-- Display error message if any -->
        <?php if ($error): ?>
            <p id="error-message" class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; 
        
        include "./pages/login.html";

        ?>
