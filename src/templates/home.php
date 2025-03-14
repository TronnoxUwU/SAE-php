<?php
// Fichier : pages/home.php
session_start();

include 'navbar.php';
require_once '../classes/Composant/Restaurant.php';
require_once '../classes/Composant/Note.php';
require_once "../static/script/modele.php";
require_once "../static/script/fonction_trier.php";

init_trier();
$restoBEST = getBestResto();
$restoPOP = getPopResto();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../static/styles/home.css">
    <link rel="stylesheet" href="../static/styles/acceuil.css">
    <link rel="stylesheet" href="../static/styles/petite_fiche.css">
    <link rel="stylesheet" href="../static/styles/grande_fiche.css">
</head>
<body>
    <header></header>
        <section class="Search home">
            <div class="Search-section">
                        <h1>Découvrez les meilleurs restaurants dans votre région</h1>
                <form method="POST" action="search.php">
                    <div class="search-bar">
                        <div class="resto">
                            <!-- <img src="../static/images/search.png" alt="search" class="search-pos-image"> -->
                            <button type="submit">Recherche</button>
                            <div class="petite-barre"></div>
                            <input type="text" id="resto" name="resto" placeholder="Cherchez un nom de restaurant ou de cuisine" required>
                        </div>
                        <div class="Position">
                            <img src="../static/images/maps.png" alt="search" class="maps">
                            <input type="text" id="resto-pos" name="position" value="Orléans" required>
                        </div>
                    </div>
                </form>
            </div>
            <img src="../static/images/miam_cut.png" alt="corne d'abondance" class="search-image">
        </section>
    <main class="contenu-principal">
        

        <section class="Affichage-restaurants A-la-une">
            <h2>Restaurants à la une sur Orléans</h2>
            <div class="Affichage-fiches">
                <?php 
                foreach ($restoBEST as $resto) {
                    $resto->renderSmall();
                    sleep(0.1);
                }
                
                ?>
            </div>
        </section>

        <section class="Affichage-restaurants Les-favoris">
            <h2>Restaurants les plus prisés sur Orléans</h2>
            <div class="Affichage-fiches">
                <?php 
                foreach ($restoPOP as $resto) {
                    $resto->renderSmall();
                    sleep(0.1);
                    // echo 
                    // '<a href="" class="fiche-resto">
                    //     <article >
                    //         <img src="../static/images/noequestrians.png" alt="Balade en forêt" class="fiche-resto-image">
                    //         <div>
                    //             <span>
                    //                 <h3>Food n`go</h3>
                    //                 <h3>2.7☆</h3>
                    //             </span>
                    //             <p>La nourriture lente du vietnam</p>
                    //         </div>
                    //     </article>
                    // </a>';
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
