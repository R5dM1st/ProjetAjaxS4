<?php

require('database.php');

// Inclure d'autres classes si nécessaire

session_start();

// Connexion à la base de données.



$request_method = $_SERVER["REQUEST_METHOD"];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);

$data = false;
$id = array_shift($request);
if ($id == '') {
    $id = NULL;
}

switch ($requestRessource) {
    case 'client':
        // Endpoint pour les clients
        switch ($request_method) {
            case 'GET':
                if ($id!=NULL) {
                    $data = get_clientsById($id);
                } else {
                    $data = get_allclients();
                }
                break;
            case 'POST':
                // Logique pour créer un client
                break;
            case 'PUT':
                // Logique pour mettre à jour un client
                break;
            case 'DELETE':
                // Logique pour supprimer un client
                break;
            default:
                // Requête invalide
                header("HTTP/1.0 405 Method Not Allowed");
                break;
        }
        break;
        case 'medecin':
            // Endpoint pour les clients
            switch ($request_method) {
                case 'GET':
                    if ($id!=NULL) {
                        $data = get_medecinById($id);
                    } else {
                        $data = get_allmedecin();
                    }
                    break;
                case 'POST':
                    // Logique pour créer un client
                    break;
                case 'PUT':
                    // Logique pour mettre à jour un client
                    break;
                case 'DELETE':
                    // Logique pour supprimer un client
                    break;
                default:
                    // Requête invalide
                    header("HTTP/1.0 405 Method Not Allowed");
                    break;
            }
            break;
            case 'rdv':
                // Endpoint pour les clients
                switch ($request_method) {
                    case 'GET':
                        if ($id!=NULL) {
                            $data = get_rdvByIdClient($id);
                        } else {
                            $data = get_allmedecin();
                        }
                        break;
                    case 'POST':
                        // Logique pour créer un client
                        break;
                    case 'PUT':
                        // Logique pour mettre à jour un client
                        break;
                    case 'DELETE':
                        // Logique pour supprimer un client
                        break;
                    default:
                        // Requête invalide
                        header("HTTP/1.0 405 Method Not Allowed");
                        break;
                }
                break;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
exit;

?>
