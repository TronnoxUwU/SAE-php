
// Sélecteurs
const dateLabel = document.querySelector('.date-label');
const timeLabel = document.querySelector('.time-label');
const dateInput = document.querySelector('#date');
const timeInput = document.querySelector('#time');
const modal = document.querySelector('#dateTimeModal');
const closeModal = document.querySelector('.close');
const popupDate = document.querySelector('#popup-date');
const popupTime = document.querySelector('#popup-time');
const saveButton = document.querySelector('#saveDateTime');

// Ouvrir le modal
dateLabel.addEventListener('click', () => {
    popupDate.value = dateInput.value; // Pré-remplir avec la date actuelle
    popupTime.value = timeInput.value; // Pré-remplir avec l'heure actuelle
    modal.style.display = 'block';
});

timeLabel.addEventListener('click', () => {
    popupDate.value = dateInput.value; // Pré-remplir avec la date actuelle
    popupTime.value = timeInput.value; // Pré-remplir avec l'heure actuelle
    modal.style.display = 'block';
});

// Fermer le modal
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Sauvegarder les nouvelles valeurs
saveButton.addEventListener('click', () => {
    const newDate = popupDate.value; // Récupère la date du sélecteur
    const newTime = popupTime.value; // Récupère l'heure du sélecteur

    if (newDate) {
        // Formate la date au format désiré
        const dateObj = new Date(newDate);
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const formattedDate = dateObj.toLocaleDateString('fr-FR', options);

        // Met à jour le champ caché et le label visible
        dateInput.value = newDate; 
        dateLabel.textContent = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1); // Majuscule sur le premier caractère
    }

    if (newTime) {
        // Met à jour le champ caché et le label visible pour l'heure
        timeInput.value = newTime;
        timeLabel.textContent = `${newTime} h`;
    }

    modal.style.display = 'none'; // Ferme le modal
});


