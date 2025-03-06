document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star");
    const result = document.getElementById("result");
    let locked = false;

    stars.forEach(star => {
        star.addEventListener("click", function () {
            if (locked) return; // Empêche le changement après sélection
            
            const value = this.getAttribute("data-value");
            result.textContent = `Votre note : ${value}`;
            stars.forEach(s => s.classList.remove("selected"));
            this.classList.add("selected");
            let prev = this.previousElementSibling;
            while (prev) {
                prev.classList.add("selected");
                prev = prev.previousElementSibling;
            }
            
            locked = true; // Verrouille la sélection
            console.log("Note sélectionnée :", value);
            // Envoi de la note au serveur via requête AJAX
            fetch("save_rating.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `rating=${value}`
            })
            .then(response => response.text())
            .then(data => console.log("Réponse du serveur :", data))
            .catch(error => console.error("Erreur :", error));
        });
    });
});