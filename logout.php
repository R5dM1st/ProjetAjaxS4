<?php
session_start();
if (isset($_SESSION['email_medecin'])) {
    session_destroy();
}
if (isset($_SESSION['email_client'])) {
    session_destroy();
}
header("Location: accueil.php");
exit();
?>