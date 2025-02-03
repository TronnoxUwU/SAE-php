<?php
// Start session and destroy it
session_start();
session_destroy();
header("Location: ../../templates/home.php");
exit();
?>
