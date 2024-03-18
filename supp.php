<?php
include "database.php";
$id_rdv = $_POST['id_rdv'];
suppRDV($id_rdv);
header("Location: list_rdv_medecin.php");
?>