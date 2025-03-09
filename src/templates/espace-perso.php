<?php
// Fichier : pages/home.php
session_start();

include_once "../static/script/modele.php";
include_once "../classes/Composant/Note.php";

include 'navbar.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les cuisines sélectionnées
    $selectedCuisines = explode(',', $_POST['selectedCuisines']);
    
    // Appeler la fonction pour ajouter les cuisines préférées de l'utilisateur
    foreach ($selectedCuisines as $cuisine) {
        ajoutePrefCuisine($_SESSION['mail'], $cuisine);
    }
}


function extractNomCuisine(array $data): array {
    $result = [];
    
    foreach ($data as $item) {
        if (isset($item['nomcuisine'])) {
            $result[] = $item['nomcuisine'];
        }
    }
    
    return $result;
}

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
    <link rel="stylesheet" href="../static/styles/petite_fiche.css">
</head>
<body>
    <header></header>

    <main class="contenu-principal">
        <h1>Vos informations de compte</h1>
        <section class="info-perso">
            <?php 
                echo '<h2>' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</h2>';
                echo '<p>Utilisateur enregistré</p>';
                
                // Récupérer les cuisines préférées de l'utilisateur via la fonction getPrefCuisine
                $userCuisines = getPrefCuisine($_SESSION['mail']);
                $userCuisines = extractNomCuisine($userCuisines);
                // var_dump($userCuisines);
            ?>
            <form class="cuisines-pref" method="POST">
                <h2>Vos préférences culinaires !</h2>
                <div class="cuisine-container">
                    <!-- Les blocs de cuisine -->
                    <?php 
                        $cuisines = fetchCuisine();

                        foreach ($cuisines as $cuisine) {
                            $cuisine = $cuisine["nomcuisine"];
                            // Vérifier si cette cuisine est sélectionnée par l'utilisateur
                            $isSelected = in_array($cuisine, $userCuisines) ? 'selected' : '';
                            echo '<div class="cuisine-block ' . $isSelected . '" data-value="' . $cuisine . '">' . $cuisine . '</div>';
                        }
                    ?>
                </div>
                <div class="form-actions">
                    <input type="hidden" name="selectedCuisines" id="selectedCuisines">
                    <button type="submit">Enregistrer vos préférences</button>
                </div>

                <script src="../static/script/cuisine-pref.js"></script>
            </form>
        </section>





        <section class="Affichage-restaurants resto-favoris">
            <h2>Restaurants favoris</h2>
            <div class="Affichage-fiches">
                <?php 
                $restoFAV = getFavoris($_SESSION['mail']);
                foreach ($restoFAV as $resto) {
                    $resto->renderSmall();
                    sleep(0.1);
                }
                ?>
            </div>
        </section>
        
        <section class="Affichage-commentaires all-comments">
            <h2>Avis enregistrés</h2>
            <div class="Affichage-fiches-commentaires">
                <?php 
                afficheAllComment($_SESSION['mail']);
                ?>
            </div>
        </section>

    </main>

    <?php
        include('footer.php');
    ?>

</body>
</html>
