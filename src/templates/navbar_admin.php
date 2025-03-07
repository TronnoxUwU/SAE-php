<?php 
session_start();
require_once "../static/script/modele.php"; // Inclure le fichier contenant les fonctions liées à MySQL

try {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user']) || !isset($_SESSION['pswrd'])) {
        throw new Exception("Utilisateur non connecté.");
    }

    // Récupérer les informations de l'utilisateur via la fonction du modèle
    $userNAV = getUtilisateur($_SESSION['user'], $_SESSION['pswrd']);
    if (!$userNAV) {
        throw new Exception("Aucun utilisateur trouvé.");
    }
    //var_dump($userNAV);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<head>
    <link rel="stylesheet" href="../static/styles/nav_admin.css">
</head>

<div class="logo">
    <img src="../static/images/logo-pony.png" alt="Logo">
</div>

<div class="admin-info">
    <?php 
    if (isAdmin($userNAV["mail"], $_SESSION['pswrd'])) {
        echo "<h2>ADMIN</h2>";
    } elseif (isMoniteur($userNAV["mail"], $_SESSION['pswrd'])) {
        echo "<h2>ENCADRANT</h2>";
    } else {
        echo "<h2>CLIENT</h2>";
    }
    ?>
    <p><?php echo htmlspecialchars($userNAV['nomPers']) . " " . htmlspecialchars($userNAV['prenomPers']); ?></p>
</div>

<nav>
    <ul>
        <?php 
        if (isAdmin($userNAV["mail"], $_SESSION['pswrd'])) {
            echo "<a href='./admin.php'><li>Gestionnaire</li></a>";
            echo "<a href='./planning.php'><li>Plannings</li></a>";
        } elseif (isMoniteur($userNAV["mail"], $_SESSION['pswrd'])) {
            echo "<a href='./admin.php'><li>Informations</li></a>";
            echo "<a href='./planning.php'><li>Plannings</li></a>";
        } else {
            echo "<a href='./infoclient.php'><li>Informations du compte</li></a>";
            echo "<a href='./planning.php'><li>Planning</li></a>";
        }
        ?>
        <a href='./settings.php'><li>Paramètres</li></a>
        <a href='../static/script/logout.php'><li class="logout">Déconnexion</li></a>
    </ul>
</nav>
