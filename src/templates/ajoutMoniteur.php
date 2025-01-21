<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion de moniteur</title>
    <link rel="stylesheet" href="../static/styles/admin.css">
    <link rel="stylesheet" href="../static/styles/insert.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="../static/images/logo-pony.png" alt="Logo">
            </div>
            <div class="admin-info">
                <h2>ADMIN</h2>
                <p>Jeanne Huller</p>
            </div>
            <nav>
                <ul>
                    <a href='admin.php'><li>Gestionnaire</li></a>
                    <a href='../static/script/logout.php'><li>Plannings</li></a>
                    <a href='../static/script/logout.php'><li>Paramètres</li></a>
                    <a href='../static/script/logout.php'><li class="logout">Déconnexion</li></a>
                </ul>
            </nav>
        </aside>
        <main>
            <div class="titreAdmin">Veuillez entrez les informations du moniteur</div>
            <section class="section">
                <div class="table-container">
                    <form action="ajoutMoniteur.php" method="post">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" required><br><br>
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" required><br><br>
                        <label for="tel">Téléphone:</label>
                        <input type="text" id="tel" name="tel" required><br><br>
                        <label for="mail">Mail:</label>
                        <input type="text" id="mail" name="mail" required><br><br>
                        <label for="poids">Poids:</label>
                        <input type="text" id="poids" name="poids" required><br><br>
                        <label for="taille">Taille:</label>
                        <input type="text" id="taille" name="taille" required><br><br>
                        <label for="heureMax"> Nombre d'heures maximum:</label>
                        <input type="text" id="heureMax" name="heureMax" required><br><br>
                        <label for="mdp">Mot de passe:</label>
                        <input type="password" id="mdp" name="mdp" required><br><br>
                        <input type="submit" value="Ajouter">
                    </form>
                </div>
            </section>
        </main>
    </div>
</html>
<?php
    require_once '../static/script/modele.php';
    $error='';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get submitted data
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $mail = $_POST['mail'] ?? '';
        $poids = $_POST['poids'] ?? '';
        $taille = $_POST['taille'] ?? '';
        $heureMax = $_POST['heureMax'] ?? '';
        $mdp = $_POST['mdp'] ?? '';
        insertMoniteur($nom, $prenom, $tel, $mail, $taille, $poids, $heureMax, $mdp);
        header("Location: admin.php");
        exit();
    }