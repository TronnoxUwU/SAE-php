<?php
require_once '../static/script/modele.php';
header('Content-Type: application/json');

if (isset($_GET['ville'])) {
    $ville = trim($_GET['ville']);
    $result = getRegion($ville);
    echo json_encode($result);
} else {
    echo json_encode([]);
}
?>
