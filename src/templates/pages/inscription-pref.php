<main class="login-container">
    <title>Préférences Culinaires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        .cuisine-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .cuisine-block {
            width: 150px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cuisine-block:hover {
            background-color: #f0f0f0;
        }

        .cuisine-block.selected {
            background-color: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .form-actions {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
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
            <button type="submit">S'inscrire</button>
            <button type="button" onclick="location.replace('home.php')">Ignorer ceci -></button>
        </div>
    </form>

    <script>
        const cuisineBlocks = document.querySelectorAll('.cuisine-block');
        const selectedCuisinesInput = document.getElementById('selectedCuisines');

        // Liste des cuisines sélectionnées
        let selectedCuisines = [];

        cuisineBlocks.forEach(block => {
            block.addEventListener('click', () => {
                const cuisine = block.dataset.value;

                if (block.classList.contains('selected')) {
                    // Désélectionner
                    block.classList.remove('selected');
                    selectedCuisines = selectedCuisines.filter(item => item !== cuisine);
                } else {
                    // Sélectionner
                    block.classList.add('selected');
                    selectedCuisines.push(cuisine);
                }

                // Mettre à jour l'input caché
                selectedCuisinesInput.value = selectedCuisines.join(',');
            });
        });
    </script>
</main>