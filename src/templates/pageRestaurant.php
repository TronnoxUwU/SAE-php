<?php
// Fichier : pages/home.php

include 'navbar.php';
require_once '../classes/Composant/Restaurant.php';
require_once '../classes/Composant/Note.php';

try {
    // Vérifier si l'utilisateur est connecté
    
    if (!isset($_GET['id'])) {
        throw new Exception("Utilisateur non connecté.");
    }
    
    $id = $_GET['id'];
    // Récupérer les informations de l'utilisateur via la fonction du modèle
    $restaurant = new Restaurant(1,"test","","Centre-Val-De-Loire","Loiret","Orléans","1.9052942","47.902964","https://test.com","@test","06 06 06 06 06", 3.4, 42, true, false,true, true,false, "12:00-14:00,19:00-22:00", ["Français","Italien"],[new Note("test",3,"test","2020-12-12"),new Note("test",3,"test","2020-12-12")]);
    if (!$restaurant) {
        throw new Exception("Aucun resto trouvé.");
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
        <section class="Search home">
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
                            <input type="text" id="resto-pos" name="position" <?php if (isset($position)) {echo 'value="'.$position.'"';}?> required>
                        </div>
                    </div>
                    <div class="search-bar right">
                        <div class="date">
                            <label for="date" class="date-label">
                                <?php 
                                    setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); // Pour afficher la date en français
                                    //echo utf8_encode(strftime('%A %d %B %Y', strtotime($date))); 
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
                $restaurant->renderMax();
                ?>
            </div>
        </section>
    </main>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de la présence des données
    if (isset($_POST["rating"]) && isset($_POST["commentaire"])) {
        $rating = intval($_POST["rating"]);
        $commentaire = trim($_POST["commentaire"]);
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        echo $id.PHP_EOL;
        echo $rating.PHP_EOL;
        echo $commentaire.PHP_EOL;
        echo $_SESSION['mail'];
        try {
            //$resto = getRestoById($id);
            echo "test".PHP_EOL;
            //$comment = $resto->getCommentaireParAuteur($_SESSION['mail']);
            if ($comment) {
                // $comment->setCommentaire($commentaire);
                // $comment->setNote($rating);
                // $comment->setDate(date('Y-m-d'));
            } else {
                // $comment = new Note($_SESSION['mail'], $rating, $commentaire, date('Y-m-d'), $id);
                // $resto->addCommentaire($comment);
            }
            echo "test2".PHP_EOL;
            // Redirection après enregistrement
            header('Location: http://localhost:3000/src/templates/pageRestaurant.php?id=' . $this->getOsmId());
            echo "test3".PHP_EOL;
            exit();

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {    
        echo '<p>'.$_POST['rating'].'</p>';
        echo '<p>'.$_POST['commentaire'].'</p>';
        echo "<p>Erreur : données manquantes.</p>";
    }
}
?>