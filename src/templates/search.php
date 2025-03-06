<?php
// Fichier : pages/home.php
include 'navbar.php';
include_once '../static/script/getKey.php';
require_once '../classes/Composant/Restaurant.php';
require_once '../static/script/modele.php';

$API = get_CSV_Key("MAPS");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resto']) && isset($_POST['position'])) {
    $resto = $_POST['resto'];
    $position = $_POST['position'];

    if (isset($_POST['date']) && isset($_POST['time']))
        {$date = $_POST['date']; $time = $_POST['time'];}
    else
        {$date = date('Y-m-d'); $time = "18:00";}
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nourriture = $_GET['nourriture'] ?? "";
    $rating = $_GET['rating'] ?? "0";
    $tendance = $_GET['tendance'] ?? "false";
    $Ouvert = $_GET['Ouvert'] ?? "false";
    $PMR = $_GET['PMR'] ?? "false";


    if (isset($_POST['nourriture'])) {

        if (strpos($nourriture, $_POST['nourriture']) !== false) {
            echo "Mot trouvé !";
            if(strpos($nourriture, ",".$_POST['nourriture']) !== false){
                $nourriture =  trim($nourriture, ",".$_POST['nourriture']);
            }else{
                $nourriture =  trim($nourriture, $_POST['nourriture']);
            }
        } else if ($nourriture ==""){
            $nourriture = $_POST['nourriture'];
        } else {
            $nourriture += ",".$_POST['nourriture'];
        }
        
    }
    
    if (isset($_POST['rating'])) {
        $rating = $_POST['rating'];
    }

    getPOSTNomCuisine();

    if (isset($_POST['tendance'])) {
        $traitement = strtolower($_POST['tendance']);
        if($tendance == "false"){
            $tendance == "true";
        } else if($tendance == $traitement){
            $tendance = "false";
        }

    }


    if (isset($_POST['Ouvert'])) {
        $traitement = strtolower($_POST['Ouvert']);
        if($Ouvert == "false"){
            $Ouvert == "true";
        } else if($Ouvert == $traitement){
            $Ouvert = "false";
        }

        echo("hahaha open");
    }


    if (isset($_POST['PMR'])) {
        $traitement = strtolower($_POST['Ouvert']);
        if($PMR == "false"){
            $PMR == "true";
        } else if($PMR == $traitement){
            $PMR = "false";
        }
        echo("hahaha cest mal");
    }


}

$restocarte = new Restaurant(1,"test","","Centre-Val-De-Loire","Loiret","Orléans","1.9052942","47.902964","https://test.com","@test","06 06 06 06 06", 3.4, 42, true, false,true, true,false, "12:00-14:00,19:00-22:00", ["Français","Italien"]);
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
    <link rel="stylesheet" href="../static/styles/grande_fiche.css">
</head>
<body>
    <header></header>
        <section class="Search home">
            <div class="Search-section">
                <div class="islam">
                    <h1>Les meilleurs restaurants
                        <span><?php 
                        if (isset($resto)) {echo "pour “".$resto."”";}?>
                        </span> à
                        <?php 
                        if (isset($position)) {echo $position;}
                        else echo "Orléans"?>
                    </h1>
                    <div><img src="../static/images/logo-pony.png" alt="search" class="search-pos-image"></div>
                </div>
                        
                <form method="POST" action="search.php">
                    <div class="search-bar left">
                        <div class="resto">
                            <!-- <img src="../static/images/search.png" alt="search" class="search-pos-image"> -->
                            <button type="submit">Recherche</button>
                            <div class="petite-barre"></div>
                            <input type="text" id="resto" name="resto" placeholder="Cherchez un nom de restaurant ou de cuisine" <?php if (isset($resto)) {echo 'value="'.$resto.'"';}?> required>
                        </div>
                        <div class="Position">
                            <img src="../static/images/maps.png" alt="search" class="maps">
                            <input type="text" id="resto-pos" name="position" <?php if (isset($position)) {echo 'value="'.$position.'"';}?> required>
                        </div>
                    </div>
                    <div class="search-bar right">
                        <div class="date">
                            <label for="date" class="date-label">
                                <?php 
                                    setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); // Pour afficher la date en français
                                    echo utf8_encode(strftime('%A %d %B %Y', strtotime($date))); 
                                ?>
                            </label>
                            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
                        </div>

                        <div class="time">
                            <label for="time" class="time-label"><?php echo $time?> h</label>
                            <input type="time" id="time" name="time" value=<?php echo $time?>>
                        </div>
                    </div>
                    <input type="submit">
                </form>


            </div>
        </section>

        <!-- Popup date/heure -->
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
    <main class="contenu-principal">
        
        <!--  -->
        <form method="POST" action="search.php">
            <section class= contenu-vertical>
                <section class ="trier">
                    <section class = "v1">
                        <input class="styled"  type="submit"  name="tendance" value="tendance" />
                        <input class="styled"  type="submit"  name="Ouvert" value="Ouvert aujourd'hui" />

                        <select id="rating" name="rating" >

                            <option value="0">Notation ⭐ </option>
                            <option value="1">⭐✦✦✦✦</option>
                            <option value="2">⭐⭐✦✦✦</option>
                            <option value="3">⭐⭐⭐✦✦</option>
                            <option value="4">⭐⭐⭐⭐✦</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                        <input class="styled"  type="submit" name="PMR" value="Accés PMR" />
                    </section>

                    <section class = "scrollmenu">
                        <?php getimputeNomCuisine() ?>
                    </section>
                </section>

                
        </form>

            <div class="Separation-affichage-vertical">
                <section class="Affichage-restaurants-vertical">
                    <h2>D'après votre recherche :</h2>
                    <div class="Affichage-fiches-horizontal">
                        <?php 
                        for ($i = 1; $i <= 10; $i++) {
                            $restocarte->renderFull();
                            // echo 
                            // '<a href="" class="fiche-resto">
                            //     <article >
                            //         <img src="../static/images/noequestrians.png" alt="Balade en forêt" class="fiche-resto-image">
                            //         <div>
                            //             <span>
                            //                 <h3>Beast Burger</h3>
                            //                 <h3>4.5☆</h3>
                            //             </span>
                            //             <p>Mr. Beaaaaaaaast!</p>
                            //         </div>
                            //     </article>
                            // </a>';
                        }
                        ?>
                    </div>
                </section>

                <iframe
                width="400"
                height="768"
                style="border: 1px;"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade" 
                src="https://www.google.com/maps/embed/v1/place?key=<?php echo $API; ?>
                &q=<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['position'])) {echo $_POST['position'];}
                            else echo "Orléans" ?>">
                </iframe>
                <!-- Penser à remettre et retirer la clé d'API (dispo sur discord)  -->
            </div>
        </section>
        
    </main>

    <?php
        include('footer.php');
    ?>

    <script src="../static/script/popup-search.js"></script>
</body>
</html>
