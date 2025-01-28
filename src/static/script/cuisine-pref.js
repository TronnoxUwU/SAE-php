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
                    console.log("à retiré cuisine : "+cuisine);
                    selectedCuisines = selectedCuisines.filter(item => item !== cuisine);
                } else {
                    // Sélectionner
                    block.classList.add('selected');
                    console.log("à ajouté cuisine : "+cuisine);
                    selectedCuisines.push(cuisine);
                }

                // Mettre à jour les cuisines selectionnées
                selectedCuisinesInput.value = selectedCuisines.join(',');
            });
        });