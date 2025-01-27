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
    <link rel="stylesheet" href="../static/styles/search.css">
    <link rel="stylesheet" href="../static/styles/popup-search.css">
</head>
<body>
    <header></header>

    <main class="contenu-principal">
    <section class="Search home">
        <div class="Search-section">
            <div class="islam">
                <h1>Les meilleurs restaurants pour <span>“j’ai faim et pas beaucoup d’argent”</span></h1>
                <div><img src="../static/images/logo-pony.png" alt="search" class="search-pos-image"></div>
            </div>
                    
            <form method="POST" action="search.php">
                <div class="search-bar left">
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
                <div class="search-bar right">
                    <div class="date">
                        <label for="date" class="date-label">Dimanche 26 janvier 2025</label>
                        <input type="date" id="date" name="date" value="2025-01-26">
                    </div>
                    <div class="time">
                        <label for="time" class="time-label">18:00 h</label>
                        <input type="time" id="time" name="time" value="18:00">
                    </div>
                </div>
            </form>
        </div>
    </section>

<!-- Popup Modal -->
<div id="dateTimeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <h3>Choisissez une date et une heure</h3>
            <input type="date" id="popup-date">
            <input type="time" id="popup-time">
            <button id="saveDateTime">Valider</button>
        </div>
    </div>
</div>

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

    <script src="../static/script/popup-search.js"></script>
</body>
</html>
