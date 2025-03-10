<?php



session_start();

include 'navbar.php';
require_once '../classes/Composant/Restaurant.php';
require_once '../static/script/getImage.php';
require_once "../static/script/modele.php";
require_once '../classes/Composant/Note.php';

$ville = "Orleans";
try {
    // Vérifier si l'utilisateur est connecté
    //$_SESSION['mail'] = "TEST";
    if (!isset($_GET['id'])) {
        throw new Exception("Aucun resto trouvé.");
    }
    
    $id = $_GET['id'];
    // Récupérer les informations de l'utilisateur via la fonction du modèle
    // $restaurant = new Restaurant(314079813,"Campanille","","Centre-Val-De-Loire","Loiret","Orléans","1.9405488", "47.815701299981235","https://test.com","@test","06 06 06 06 06", 3.4, 42, true, false,true, true,false, "12:00-14:00,19:00-22:00", ["Français","Italien"]);
    $restaurant = getRestoById($id);
    $ville = $restaurant->getVille();

    if (!$restaurant) {
        throw new Exception("Aucun resto trouvé.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérification de la présence des données
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
            header("Location: login.php");
            exit();
        }
        if (isset($_POST["rating"]) && isset($_POST["commentaire"])) {
            $rating = intval($_POST["rating"]);
            $commentaire = trim($_POST["commentaire"]);
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            try {
                $comment = $restaurant->getCommentaireParAuteur($_SESSION['mail']);
                if ($comment) {
                    modifNote($_SESSION['mail'], $restaurant->getOsmId(), $rating, $commentaire);
                } else {
                    $comment = new Note($_SESSION['mail'], $rating, $commentaire, date('Y-m-d'), $_SESSION['nom'], $_SESSION['prenom']);
                    $restaurant->addCommentaire($comment);
                }
                header("Location: pageRestaurant.php?id=$id");
                exit();
                
    
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}



$date=date('Y-m-d');
$time="18:00";



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
    <link rel="stylesheet" href="../static/styles/pageRestaurant.css">
</head>
<body>
    <main>
    <section class="Search home" style="min-height:1em">
            <div class="Search-section">     
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
                            <input type="text" id="resto-pos" name="position" <?php if (isset($ville)) {echo 'value="'.$ville.'"';}?> required>
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
        <!--  -->
        <section class="contenu-principal">
            <div class="resto">
                <?php
                $restaurant->renderMax($_SESSION['loggedin']);

                ?>
            </div>
        </section>
    </main>
    
    <script type="text/javascript">
        var usermail='<?php echo $_SESSION['mail'];?>';
        var idResto='<?php if (isset($_GET['id'])) {echo trim($_GET['id']);} ?>';
    </script>
    <script type="module" src="../static/script/resto.js"></script>
</body>

