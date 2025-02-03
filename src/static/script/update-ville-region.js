document.addEventListener("DOMContentLoaded", function () {
    const villeInput = document.getElementById("ville");
    const selectRegion = document.getElementById("region-select");
    const inputDepartement = document.getElementById("departement");
    const inputRegion = document.getElementById("region");

    villeInput.addEventListener("change", async function () {
        const ville = villeInput.value.trim();

        if (ville) {
            try {
                console.log("1");
                const response = await fetch(`../api/get_region.php?ville=${encodeURIComponent(ville)}`);
                const data = await response.json();
                console.log("2");
                console.log(data);

                // Réinitialisation du select
                selectRegion.innerHTML = '<option value="">Sélectionner un lieu</option>';

                if (data.length > 0) {
                    data.forEach(entry => {
                        let optionText = entry[0] ? `${entry[0]}, ${entry[1]}` : `${entry[1]}`;
                        console.log(optionText);
                        console.log(entry[0], entry[1]);
                        let optionValue = JSON.stringify(entry); // Stocker en JSON pour le récupérer après

                        let option = document.createElement("option");
                        option.value = optionValue;
                        option.textContent = optionText;
                        selectRegion.appendChild(option);
                    });
                } else {
                    selectRegion.innerHTML += `<option value="">Aucun lieu trouvé</option>`;
                }
            } catch (error) {
                console.error("Erreur lors de la récupération des régions :", error);
            }
        }
    });

    // Lorsqu'on sélectionne un lieu, on met à jour les champs cachés
    selectRegion.addEventListener("change", function () {
        const selectedValue = selectRegion.value;

        if (selectedValue) {
            const [departement, region] = JSON.parse(selectedValue);
            inputDepartement.value = departement || "";
            inputRegion.value = region;
        } else {
            inputDepartement.value = "";
            inputRegion.value = "";
        }
    });
});
