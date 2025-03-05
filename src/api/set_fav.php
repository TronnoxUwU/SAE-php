<?php
require_once '../static/script/modele.php';
header('Content-Type: application/json');

if (isset($_GET['mail']) && isset($_GET['idResto'])) {
    $mail = trim($_GET['mail']);
    $resto = trim($_GET['idresto']);
    ajouter_supprimerFavoris($mail, $resto);
    echo json_encode(array('valid' => 'true'));

} else {
    echo json_encode(array('valid' => 'false', 'error' => 'pas de compte ou restaurant associé'));
}
?>
