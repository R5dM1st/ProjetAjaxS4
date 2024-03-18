<?php
 require_once './main.php';

$requestType = $_SERVER['REQUEST_METHOD'];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);

if ($requestType == 'GET'){

    $return = get_allclients();
} else {
    $return = false;
}
echo json_encode($return);
?>
