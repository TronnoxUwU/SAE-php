<?php
require_once '../classes/Composant/Restaurant.php';
require_once '../classes/Composant/Note.php';
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
            $comment = $resto->getCommentaireParAuteur($_SESSION['mail']);
            if ($comment) {
                $comment->setCommentaire($commentaire);
                $comment->setNote($rating);
                $comment->setDate(date('Y-m-d'));
            } else {
                $comment = new Note($_SESSION['mail'], $rating, $commentaire, date('Y-m-d'), $id);
                $resto->addCommentaire($comment);
            }

            

            // Redirection après enregistrement
            header('Location: pageRestaurant.php?id="'.$this->getOsmId().'"');
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {    
        echo '<p>'.$_POST['rating'].'</p>';
        echo '<p>'.$_POST['commentaire'].'</p>';
        echo "<p>Erreur : données manquantes.</p>";
    }
} else {
    echo "Accès non autorisé.";
}
?>
