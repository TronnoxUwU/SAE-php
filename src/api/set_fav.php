<?php
require_once '../static/script/modele.php';
header('Content-Type: application/json');

error_log(implode(" ", $_GET));

if (isset($_GET['mail']) && isset($_GET['idResto'])) {
    error_log("FAVORIS");
    $mail = trim($_GET['mail']);
    $resto = trim($_GET['idResto']);
    ajouter_supprimerFavoris($mail, $resto);
    echo json_encode(array('valid' => 'true'));

} else {
    error_log("PAS FAVORIS");
    echo json_encode(array('valid' => 'false', 'error' => 'pas de compte ou restaurant associé'));
}
?>
