<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: home.php");
    exit();
}

echo "<h1>Bienvenue, vous êtes connecté !</h1>";
echo "<a href='../static/script/logout.php'>Se déconnecter</a>";
?>
