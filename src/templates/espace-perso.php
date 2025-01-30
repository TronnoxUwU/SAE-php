<?php
// Fichier : pages/home.php
session_start();

include_once '';

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../static/styles/home.css">
    <link rel="stylesheet" href="../static/styles/acceuil.css">
    <link rel="stylesheet" href="../static/styles/preferences-culinaires.css">
    <link rel="stylesheet" href="../static/styles/espace-perso.css">
</head>
<body>
    <header></header>

    <main class="contenu-principal">
        <h1>Vos informations de compte</h1>
        <section class="info-perso">
            <?php echo '<h2>'.$_SESSION['nom'].' '.$_SESSION['prenom'].'</h2>'?>
            <p>Utilisateur enregistré</p> 
            <!-- A changer par le rôle de l'utilisateur -->


            <div class="cuisines-pref">
                <h2>Vos préférences culinaires !</h2>
                <div class="cuisine-container">
                    <!-- Les blocs de cuisine -->
                    <?php 
                        $cuisines = [
                            "Italienne", "Chinoise", "Mexicaine", 
                            "Japonaise", "Française", "Indienne",
                            "Thaïlandaise", "Marocaine", "Libanaise", 
                            "Américaine"
                        ];

                        foreach ($cuisines as $index => $cuisine) {
                            echo '<div class="cuisine-block" data-value="'.$cuisine.'">'.$cuisine.'</div>';
                        }
                    ?>
                </div>
            </div>
        </section>




        <section class="Affichage-restaurants resto-favoris">
            <h2>Restaurants favoris</h2>
            <div class="Affichage-fiches">
                <?php 
                for ($i = 1; $i <= 10; $i++) {
                    echo 
                    '<a href="" class="fiche-resto">
                        <article >
                            <img src="../static/images/noequestrians.png" alt="Balade en forêt" class="fiche-resto-image">
                            <div>
                                <span>
                                    <h3>Beast Burger</h3>
                                    <h3>4.5☆</h3>
                                </span>
                                <p>Mr. Beaaaaaaaast!</p>
                            </div>
                        </article>
                    </a>';
                }
                ?>
            </div>
        </section>
        
        <section class="Affichage-commentaires all-comments">
            <h2>Avis enregistrés</h2>
            <div class="Affichage-fiches-commentaires">
                <?php 
                for ($i = 1; $i <= 10; $i++) {
                    echo 
                    '<a href="" class="fiche-commentaire">
                        <article >
                            <div>
                                <h3>Scandale !!!</h3>
                                <h3>1☆</h3>
                            </div>
                            <div>
                                <h4>Food n\'go</h4>
                                <p>C\'est le piiiiire restaurant que j\'ai vu de ma vie, des cafards jusque dans ma soupe :(</p>
                            </div>
                        </article>
                    </a>';
                }
                ?>
            </div>
        </section>

    </main>

    <?php
        include('footer.php');
    ?>

</body>
</html>
