<?php

require('database.php');


$request_method = $_SERVER["REQUEST_METHOD"];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);

$requestRessource = array_shift($request);
$request_uri = $_SERVER['REQUEST_URI'];

$params = parse_url($request_uri, PHP_URL_QUERY);
parse_str($params, $query_params);

$ville = $query_params['ville'] ?? '';
$specialite = $query_params['specialite'] ?? '';
$type = $query_params['type'] ?? '';
$medecin = $query_params['medecin'] ?? '';
$date = $query_params['date'] ?? '';

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
                header("HTTP/1.0 405 Method Not Allowed");
                break;
        }
        break;
        case 'medecin':
            switch ($request_method) {
                case 'GET':
                    if($ville != '' && $specialite != '' && $type != '') {
                        $data = medecinselect($ville, $specialite, $type);
                    }
                    else if ($id!=NULL) {
                        $data = get_medecinById($id);
                    } else {
                        $data = get_allmedecin();
                    }
                    break;
                default:
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

                        default:
                        case 'POST':
                            if($medecin =!'' && $date=!''){
                                insertDateJournéeClassique($medecin, $date);
                            }
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