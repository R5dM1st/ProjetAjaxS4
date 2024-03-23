<?php
include "./database.php";

$requestType = $_SERVER['REQUEST_METHOD'];

$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);

$return = get_allmedecin();

header('Content-Type: application/json');

echo json_encode($return);
?>
