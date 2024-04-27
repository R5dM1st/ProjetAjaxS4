<?php

require('database.php');

$request_method = $_SERVER["REQUEST_METHOD"];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);

$requestRessource = array_shift($request);
$request_uri = $_SERVER['REQUEST_URI'];

$params = parse_url($request_uri, PHP_URL_QUERY);
parse_str($params, $query_params);
$nom = $query_params['nom'] ?? '';
$prenom = $query_params['prenom'] ?? '';
$tel = $query_params['tel'] ?? '';
$email = $query_params['mail'] ?? '';
$email_confirm = $query_params['mail_confirm'] ?? '';
$mdp = $query_params['mdp'] ?? '';
$mdp_confirm = $query_params['mdp_confirm'] ?? '';
$ville = $query_params['ville'] ?? '';
$specialite = $query_params['specialite'] ?? '';
$type = $query_params['type'] ?? '';
$id_ref = $query_params['id_ref'] ?? '';
$date = $query_params['date'] ?? '';
$id_medecin = $query_params['id_medecin'] ?? '';
$id_client = $query_params['id_client'] ?? '';
$heure = $query_params['heure'] ?? '';
$id_rdv = $query_params['id_rdv'] ??'';
$heure_debut = $query_params['heure_debut'] ??'';
$heure_fin = $query_params['heure_fin'] ??'';
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

    case 'log_client':
        switch ($request_method) {
            case 'GET':
                if ($email != '' && $mdp != '') { 
                    $hashedPasswordFromDatabase = getPasswordByEmail_Hash_Client($email);
                    if ($hashedPasswordFromDatabase !== null && password_verify($mdp, $hashedPasswordFromDatabase)) {
                        $data = array('prenom' => getPrenomByEmailClient($email), 'nom' => getNomByEmailClient($email), 'email' => $email, 'profile' => 1, 'id' => getClientId($email));
                    } else {
                        $data = false;
                    }
                }
                break;
        }
        break;

    case 'register_client':
        switch ($request_method) {
            case 'POST':
                if($email != '' && $mdp != '' && $nom != '' && $prenom != '' && $tel != '' && $email_confirm != '' && $mdp_confirm != ''){
                    $email_existe = emailExisteClient($email);
                    if ($email !== $email_confirm) {
                        $data = json_encode("Les adresses email ne correspondent pas");
                    } elseif ($mdp !== $mdp_confirm) {
                        $data = json_encode("Les mots de passe ne correspondent pas");
                    } elseif ($email_existe === true) {
                        $data = json_encode("L'adresse email existe déjà");
                    } else {
                        insertClient($nom, $prenom, $tel, $email, $mdp);
                        $data = "Client ajouté avec succès";
                    }
                } else {
                    $data = json_encode("Tous les champs doivent être remplis");
                }
                break;
        }
        break;

    case 'log_medecin':
        switch ($request_method) {
            case 'GET':
                if ($email != '' && $mdp != '') { 
                    $hashedPasswordFromDatabase = getPasswordByEmail_Hash_Medecin($email);
                    if ($hashedPasswordFromDatabase !== null && password_verify($mdp, $hashedPasswordFromDatabase)) {
                        $data = array('prenom' => getPrenomByEmailMedecin($email), 'nom' => getNomByEmailMedecin($email), 'email' => $email, 'profile' => 2, 'id' => getMedecinId($email));
                    } else {
                        $data = false;
                    }
                }
                break;
        }
        break;
                   
        case 'register_medecin':
            switch ($request_method) {
                case 'POST':
                    if($email != '' && $mdp != '' && $nom != '' && $prenom != '' && $tel != '' && $email_confirm != '' && $mdp_confirm != '' && $codePostal != '' && $specialite !='' && $adresse != '' && $ville != '' &&  $type !=''){
                        $email_existe = emailExisteMedecin($email);
                        if ($email !== $email_confirm) {
                            $data = json_encode("Les adresses email ne correspondent pas");
                        } elseif ($mdp !== $mdp_confirm) {
                            $data = json_encode("Les mots de passe ne correspondent pas");
                        } elseif ($email_existe === true) {
                            $data = json_encode("L'adresse email existe déjà");
                        } else {
                            insertMedecin($nom, $prenom, $telephone, $mail, $mot_de_passe, $adresse, $ville, $code_postal, $specialite, $type);
                            $data = "Medecin ajouté avec succès";
                        }
                    } else {
                        $data = json_encode("Tous les champs doivent être remplis");
                    }
                    exit;
            default:
                header("HTTP/1.0 405 Method Not Allowed");
                break;
            }
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
                    switch($request_method){
                        case 'GET':
                            if($id_rdv !=NULL){
                                suppRDV($id_rdv);
                            }
                            else{
                                $data = "ça marche pas";
                            }
                            break;
                        }
                    break;
                    default;
                    case 'date':
                        switch ($request_method) {
                            case 'GET':
                                if ($id_medecin != "") {
                                    $data = getDateDisponible($id_medecin);
                                }
                                break;
                            case 'POST':
                               
                                header("HTTP/1.0 405 Method Not Allowed");
                                break;
                            default:
                                header("HTTP/1.0 405 Method Not Allowed");
                                break;
                        }
                        break;
                    
                case 'heure':
                    switch ($request_method) {
                        case 'GET':
                            if($id_medecin!=""&&$date!=""){
                                $data = getHeuresDisponible($id_medecin, $date);

                            }

                            break;

                        default:
                        case 'POST':
                            if($id_ref!=""){
                                insertDateJournéeClassique($id_ref, $date);
                            }
                                header("HTTP/1.0 405 Method Not Allowed");
                                break;
                        }
              
                 
                    
                        break;
                    case 'heure_special':
                        switch ($request_method) {
                            case 'POST':
                                if($id_ref!=""&&$date!=""&&$heure_debut!=""&&$heure_fin!=""){
                                        insertDateJournéeSpecial($id_ref, $date, $heure_debut, $heure_fin);

                                }
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