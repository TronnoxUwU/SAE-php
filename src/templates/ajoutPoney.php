<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion de poney</title>
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
            <div class="titreAdmin">Veuillez entrez les informations du poney</div>
            <section class="section">
                <div class="table-container">
                    <form action="ajoutPoney.php" method="post">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" required><br><br>
                        <label for="taille">Taille:</label>
                        <input type="text" id="taille" name="taille" required><br><br>
                        <label for="poids">Poids:</label>
                        <input type="text" id="poids" name="poids" required><br><br>
                        <label for="race">Race:</label>
                        <select name="race">
                            <option value="Poney">Poney</option>
                            <option value="Licorne">Licorne</option>
                            <option value="Alicorne">Alicorne</option>
                            <option value="Pegase">Pégase</option>
                            <option value="Girafe">Girafe</option>
                            <option value="Hippopotame">Hippopotame</option>
                        </select>
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
        $taille = $_POST['taille'] ?? '';
        $poids = $_POST['poids'] ?? '';
        $race = $_POST['race'] ?? '';
        // Insert data into database
        insertPoney($nom, $race, $poids, $taille);
        header("Location: admin.php");
        exit();
    }
?>