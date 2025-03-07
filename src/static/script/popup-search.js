const dateLabel = document.querySelector('.date-label');
const timeLabel = document.querySelector('.time-label');
const dateInput = document.querySelector('#date');
const timeInput = document.querySelector('#time');
const modal = document.querySelector('#dateTimeModal');
const closeModal = document.querySelector('.close');
const popupDate = document.querySelector('#popup-date');
const popupTime = document.querySelector('#popup-time');
const saveButton = document.querySelector('#saveDateTime');

// Ouvre modal
dateLabel.addEventListener('click', () => {
    popupDate.value = dateInput.value; // date actuelle
    popupTime.value = timeInput.value; // heure actuelle
    modal.style.display = 'block';
});

timeLabel.addEventListener('click', () => {
    popupDate.value = dateInput.value; // date actuelle
    popupTime.value = timeInput.value; // heure actuelle
    modal.style.display = 'block';
});

// ferme modal
closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// save
saveButton.addEventListener('click', () => {
    const newDate = popupDate.value; // Récupère la date du sélecteur
    const newTime = popupTime.value; // Récupère l'heure du sélecteur

    if (newDate) {
        const dateObj = new Date(newDate);
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }; // Format "Lundi 27 Janvier 2025"
        const formattedDate = dateObj.toLocaleDateString('fr-FR', options);

        // update label date
        dateInput.value = newDate; 
        dateLabel.textContent = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);
    }

    if (newTime) {
        // update label heure
        timeInput.value = newTime;
        timeLabel.textContent = `${newTime} h`;
    }

    modal.style.display = 'none'; // Ferme le modal
});


