<?php
// Fichier : pages/home.php
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
</head>
<body>
    <header></header>

    <main class="contenu-principal">
        <section class="Search home">
            <div class="Search-section">
                        <h1>Découvrez les meilleurs restaurants dans votre région</h1>
                <form>
                    <div class="search-bar">
                        <div class="resto">
                            <img src="../static/images/search.png" alt="search" class="search-pos-image">
                            <div class="petite-barre"></div>
                            <input type="text" id="resto" name="resto" placeholder="Cherchez un nom de restaurant ou de cuisine" required>
                        </div>
                        <div class="Position">
                            <img src="../static/images/maps.png" alt="search" class="maps">
                            <input type="text" id="resto-pos" name="resto" value="Orléans" required>
                        </div>
                    </div>
                </form>
            </div>
            <img src="../static/images/miam_cut.png" alt="corne d'abondance" class="search-image">
        </section>

        <section class="Affichage-restaurants A-la-une">
            <h2>Restaurants à la une</h2>
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

        <section class="Affichage-restaurants Les-favoris">
            <h2>Restaurants les plus prisés</h2>
            <div class="Affichage-fiches">
                <?php 
                for ($i = 1; $i <= 10; $i++) {
                    echo 
                    '<a href="" class="fiche-resto">
                        <article >
                            <img src="../static/images/noequestrians.png" alt="Balade en forêt" class="fiche-resto-image">
                            <div>
                                <span>
                                    <h3>Food n`go</h3>
                                    <h3>2.7☆</h3>
                                </span>
                                <p>La nourriture lente du vietnam</p>
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

    <script src="../static/scripts/language.js"></script>
    <script src="../static/scripts/accessibility.js"></script>
</body>
</html>
