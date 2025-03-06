<?php
session_start();

require_once "../static/script/modele.php";

// Enregistrement selection cuisine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedCuisines'])) {
    // TODO mettre les cuisines prefs dans la bd


    $cuisines = $_POST['selectedCuisines'] ?? null;

    if ($cuisines){
        foreach ($cuisines as $miam){
            ajoutePrefCuisine($_SESSION['mail'], $miam);
        }
    }

    header("Location: home.php");
}

?>

<main class="login-container wide">
    <title>Préférences Culinaires</title>
    <link rel="stylesheet" href="../static/styles/preferences-culinaires.css">
    <form id="registerForm" method="POST" class="form-container">
        <h1>Indiquez vos préférences culinaires !</h1>
        <div class="cuisine-container">
            <!-- Les blocs de cuisine -->
            <?php 
                $cuisines = fetchCuisines();

                foreach ($cuisines as $index => $cuisine) {
                    echo '<div class="cuisine-block" data-value="'.$cuisine.'">'.$cuisine.'</div>';
                }
            ?>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <input type="hidden" name="selectedCuisines" id="selectedCuisines">
            <button type="submit" >Valider vos préférence</button>
            <button class="skip-pref" name="partie-pref" type="button" onclick="location.href='home.php';">Ignorer pour l'instant</button>
        </div>


        <script src="../static/script/cuisine-pref.js"></script>

    </form>
</main>