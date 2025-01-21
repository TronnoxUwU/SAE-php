// Fonction pour afficher un popup
function showPopup(message, success) {
    const popup = document.createElement("div");
    console.log("status de l'envoi : "+success);
    popup.className = success ? "popup-val" : "popup-val-err";
    popup.textContent = message;
    document.body.appendChild(popup);
    setTimeout(() => {
        popup.remove();
    }, 3000);
}