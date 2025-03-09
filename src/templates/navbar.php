<!-- Fichier : navbar.php -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/nav.css">
</head>

<div class="navbar">
    <div class="maison">
        <p>My Little Food</p>
        <a href="home.php" class="home" >
            <img src="../static/images/maison.png" alt="maison">
        </a>
    </div>
    <ul class="nav-links">
        <?php 
        // session_start();
        // var_dump($_SESSION['nom']);
        
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']==false) {
            echo '<li><a href="login.php">Se connecter</a></li>';
            }
        else {
            echo '<li><a href="espace-perso.php">'.$_SESSION['nom'].' '.$_SESSION['prenom'].'</a></li>';
            echo   '<div class="dropdown">
                        <button class="dropbtn"><img class="dropimg" src="../static/images/3barres.png" alt="barres"></button>
                        <div class="dropdown-content">
                            <a href="settings.php" id="param">Modifier mes informations</a>
                            <a href="espace-perso.php#favoritas" id="critik">Mes critiques</a>
                            <a href="espace-perso.php#comentairas" id="favorites">Mes favoris</a>
                            <a href="../static/script/logout.php" id="disconnect">Se déconnecter</a>
                        </div>
                    </div>';
        }
        ?>
    </ul>
</div>

