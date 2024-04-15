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
$id_ref = $query_params['id_ref'] ?? '';
$date = $query_params['date'] ?? '';
$id_medecin = $query_params['id_medecin'] ?? '';
$id_client = $query_params['id_client'] ?? '';
$heure = $query_params['heure'] ?? '';
$id_rdv = $query_params['id_rdv'] ??'';
$id_heure = $query_params['id_heure'] ??'';
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
            case 'rdv':
                switch ($request_method) {
                    case 'POST':
                        
                            prendreRendezVous($id_client,$id_medecin,$date,$heure);
                            $data = "Rendez-vous pris avec succès";
                        
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
                    case 'delete_rdv_medecin':
                        switch($request_methode){
                            case 'DELETE':
                                if(isset($id_rdv) && !is_null($id_rdv)){
                                    $data = suppRDV($id_rdv);
                                }
                                else{
                                    $data = "Id NULL";
                                }
                                break;
                        }
                        break;
                case 'heure':
                    switch ($request_method) {
                        case 'GET':
                            if($id_medecin!=""){

                                $data = getDateDisponible($id_medecin);
                            }
                            if($id_medecin!=""&&$date!=""){
                                $data = getHeuresDisponible($id_medecin, $date);
                            }
                            break;

                        default:
                        case 'POST':
                                insertDateJournéeClassique($id_ref, $date);
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