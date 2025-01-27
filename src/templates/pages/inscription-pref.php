

<main class="login-container wide">
    <title>Préférences Culinaires</title>
    <link rel="stylesheet" href="../static/styles/preferences-culinaires.css">
    <form id="registerForm" method="POST" class="form-container">
        <h1>Indiquez vos préférences culinaires !</h1>
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

        <!-- Actions -->
        <div class="form-actions">
            <input type="hidden" name="selectedCuisines" id="selectedCuisines">
            <button type="submit">Valider vos préférence</button>
            <button class="skip-pref" name="partie-pref" type="button" onclick="location.replace('home.php')">Ignorer pour l'instant</button>
        </div>
        <script src="../static/script/cuisine-pref.js"></script>
    </form>
</main>