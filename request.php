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
$info = array_shift($request);
if ($id == '') {
    $id = NULL;
}

switch ($requestRessource) {
    case 'client':
        switch ($request_method) {
            case 'GET':
                if ($id!=NULL) {
                    $data = get_clientsById($id);
                } else {
                    $data = get_allclients();
                }
                break;

            default:
                // Requête invalide
                header("HTTP/1.0 405 Method Not Allowed");
                break;
        }
        break;
        case 'medecin':
            switch ($request_method) {
                case 'GET':
                    if ($id!=NULL) {
                        $data = get_medecinById($id);
                    } else {
                        $data = get_allmedecin();
                    }
                    break;
                default:
                    // Requête invalide
                    header("HTTP/1.0 405 Method Not Allowed");
                    break;
            }
            break;
            case 'rdv_client':
                switch ($request_method) {
                    case 'GET':
                        if ($id!=NULL) {
                            $data = get_rdvByIdClient($id);
                        } else {
                            $data = get_allmedecin();
                        }
                        break;
                    default:
                        // Requête invalide
                        header("HTTP/1.0 405 Method Not Allowed");
                        break;
                }
                break;
                case 'rdv_medecin':
                    switch ($request_method) {
                        case 'GET':
                            if ($id!=NULL) {
                                $data = get_rdvByIdMedecin($id);
                            } else {
                                $data = get_allmedecin();
                            }
                            break;
                        default:
                         
                            header("HTTP/1.0 405 Method Not Allowed");
                            break;
                    }
                    break;
                case 'heure':
                    switch ($request_method) {
                        case 'GET':
                            break;
                        default:
                            
                            header("HTTP/1.0 405 Method Not Allowed");
                            break;
                    }
                    break;
                    case 'ville':
                        switch ($request_method) {
                            case 'GET':
                                $data = findAllville();
                                break;
    
                            default:

                                header("HTTP/1.0 405 Method Not Allowed");
                                break;
                        }
                        break;
                case 'specialité':
                    switch ($request_method) {
                        case 'GET':
                            $data = findAllspecialite();
                            break;
    
                        default:
                            header("HTTP/1.0 405 Method Not Allowed");
                            break;
                    }
                    break;
                case 'type':
                    switch ($request_method) {
                        case 'GET':
                            $data = findAlltype();
                            break;
    
                        default:
                            header("HTTP/1.0 405 Method Not Allowed");
                            break;
                    }
                    break;
                    
    }
    header('Content-Type: application/json');
    echo json_encode($data);
exit;

?>
