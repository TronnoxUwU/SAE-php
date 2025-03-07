import { showPopup } from './popup_valid.js';

const favbutton = document.getElementById('fav-button');

console.log("feur");

console.log(usermail);
console.log(idResto);

favbutton.addEventListener(('click'), async function () {
    const response = await fetch(`../api/set_fav.php?mail=${usermail}idResto=${idResto}`);
    const data = await response.json();
    console.log(data);
    if (data.length > 0) {
        if (data.valid) {
            showPopup("Restaurant bien ajouté aux favoris !", true);
        } else { showPopup("Erreur lors de l'ajout, veuillez rééssayer plus tard.", false); }
    } else { showPopup("Erreur lors de l'ajout, veuillez rééssayer plus tard.", false); }
});