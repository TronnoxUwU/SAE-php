<?php
require_once "../static/script/modele.php";
session_start();
echo utilisateurExistant($_SESSION['user'],$_SESSION['pswrd']);
reserveCreneau(utilisateurExistant($_SESSION['user'],$_SESSION['pswrd']),$_GET['id']);
header("Location: infoClient.php");
?>
