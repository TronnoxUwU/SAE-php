// Fonction pour afficher un popup
export function showPopup(message, success) {
    const popup = document.createElement("div");
    console.log("status de l'envoi : "+success);
    popup.className = success ? "popup-val" : "popup-val-err";
    popup.textContent = message;
    // let main_e = document.getElementsByTagName("main")[0];
    // main_e.prepend(popup);
    document.body.appendChild(popup)
    setTimeout(() => {
        popup.remove();
    }, 3000);
}