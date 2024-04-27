<?php

// ------------------------Fonction pour les heures------------------------//
function get_allheure(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM heuredisponible");
            $stmt->execute();
            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rdvs;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
    return array();
}
function recupereIDHeure($id_medecin, $date, $heure){
    $conn = dbConnect();
    $id_heure_dispo = null;

    if ($conn) {
        try {
            if (!empty($date)) {
                $stmt = $conn->prepare("SELECT id_heure FROM heuredisponible WHERE id_medecin = :id_medecin AND date_dispo = :date_dispo AND heure_dispo = :heure_dispo");
                $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
                $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
                $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $id_heure_dispo = $result['id_heure'];
                } else {
                    echo "<h3>Heure indisponible. Veuillez choisir une autre heure.</h3>";
                }
            } else {
                echo "<h3>La date est vide. Veuillez sélectionner une date valide.</h3>";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo "<h3>Erreur de connexion à la base de données. Veuillez réessayer.</h3>";
    }

    return $id_heure_dispo;
}

function getHeuresDisponible($id_medecin, $date_dispo){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT heure_dispo FROM heuredisponible WHERE id_medecin = :id_medecin AND date_dispo = :date_dispo AND dispo=true");
            $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
            $stmt->bindParam(':date_dispo', $date_dispo, PDO::PARAM_STR);
            $stmt->execute();

            $heures = $stmt->fetchAll(PDO::FETCH_COLUMN);

            return $heures;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }

    return array();
}

function getDateDisponible($id_medecin){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT DISTINCT date_dispo FROM heuredisponible WHERE id_medecin = :id_medecin ORDER BY date_dispo ASC");
            $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
            $stmt->execute();

            $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dates;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}

function afficheHeureDispo($id_medecin, $date_dispo){
    $heures_dispo = getHeuresDisponible($id_medecin, $date_dispo);
    if($heures_dispo == null){
        echo '<option value="">Aucune heure disponible</option>';
    }
    else{
        echo '<option value="">Choisir une heure</option>';
    }
    foreach ($heures_dispo as $heure) {
        echo '<option value="' . $heure . '">' . heureformat($heure) . '</option>';
    }
}
function afficheDateDispo($id_medecin){
    $dates_dispo = getDateDisponible($id_medecin);
    if($dates_dispo == null){
        echo '<option value="">Aucune date disponible</option>';
    }
    else{
        echo '<option value="">Choisir une date</option>';
    }
    foreach ($dates_dispo as $date) {
        echo '<option value="' . $date . '">' . dateformat($date) . '</option>';
    }
}
function formatmois($mois){
    $date = DateTime::createFromFormat('Y-m', $mois);
    $mois = $date->format('m');
    $année = $date->format('Y');
    if($mois == 1){
        $mois = "Janvier";
    }
    if($mois == 2){
        $mois = "Février";
    }
    if($mois == 3){
        $mois = "Mars";
    }
    if($mois == 4){
        $mois = "Avril";
    }
    if($mois == 5){
        $mois = "Mai";
    }
    if($mois == 6){
        $mois = "Juin";
    }
    if($mois == 7){
        $mois = "Juillet";
    }

    return $mois . " " . $année;
}
function extraireHeure($heureComplete) {
    $heureArray = explode(":", $heureComplete);
    $heureSeulement = $heureArray[0];
    return $heureSeulement;
}
function insertDateJournéeClassique($medecin, $date){
    $conn = dbConnect();
    
    if ($conn) {
        try {

            $formatted_date = date('Y-m-d', strtotime($date));

            for ($i = 8; $i < 18; $i++) {
                $heure = sprintf("%02d:00", $i);
                
                $stmt = $conn->prepare("SELECT COUNT(*) FROM heuredisponible WHERE id_medecin = :medecin AND date_dispo = :date_dispo AND heure_dispo = :heure_dispo");
                $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                $stmt->bindParam(':date_dispo', $formatted_date, PDO::PARAM_STR); 
                $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                $count = $stmt->fetchColumn();
                if ($count == 0) {
                    if($i != 12){
                    $stmt = $conn->prepare("INSERT INTO heuredisponible (id_medecin, date_dispo, heure_dispo, dispo) VALUES (:medecin, :date_dispo, :heure_dispo, true)");
                    $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                    $stmt->bindParam(':date_dispo', $formatted_date, PDO::PARAM_STR);
                    $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                    $stmt->execute();
                    $heure = sprintf("%02d:30", $i);
                    $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                    $stmt->bindParam(':date_dispo', $formatted_date, PDO::PARAM_STR);
                    $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                    $stmt->execute();
                    }
                }
            }
            $heure = "18:00";
            $stmt = $conn->prepare("INSERT INTO heuredisponible (id_medecin, date_dispo, heure_dispo, dispo) VALUES (:medecin, :date_dispo, :heure_dispo, true)");
            $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
            $stmt->bindParam(':date_dispo', $formatted_date, PDO::PARAM_STR);
            $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode( "<h3>Les heures de la journée classique ont bien été ajoutées.</h3>");
            } else {
                echo json_encode("<h3>Erreur lors de l'ajout des heures de la journée classique.</h3>");
            }
        } catch (PDOException $e) {
            echo json_encode( 'Error : ' . $e->getMessage());
        }
    }
}

function insertDateJournéeSpecial($medecin, $date, $heure_min, $heure_max){
    $conn = dbConnect();

    if ($conn) {
        try {
            $heure_min = extraireHeure($heure_min);
            $heure_max = extraireHeure($heure_max);
            for ($i = $heure_min; $i < $heure_max; $i++) {
                $heure = sprintf("%02d:00", $i);
                $stmt = $conn->prepare("SELECT COUNT(*) FROM heuredisponible WHERE id_medecin = :medecin AND date_dispo = :date_dispo AND heure_dispo = :heure_dispo");
                $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
                $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                if ($count == 0) {
                    $stmt = $conn->prepare("INSERT INTO heuredisponible (id_medecin, date_dispo, heure_dispo, dispo) VALUES (:medecin, :date_dispo, :heure_dispo, true)");
                    $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                    $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                    $stmt->execute();
                    $heure = sprintf("%02d:30", $i);
                    $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                    $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':heure_dispo', $heure, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
            $heure_max = extraireHeure($heure_max);
            $heure_max = sprintf("%02d:00", $heure_max);
            $stmt = $conn->prepare("SELECT COUNT(*) FROM heuredisponible WHERE id_medecin = :medecin AND date_dispo = :date_dispo AND heure_dispo = :heure_dispo");
            $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
            $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
            $stmt->bindParam(':heure_dispo', $heure_max, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                $stmt = $conn->prepare("INSERT INTO heuredisponible (id_medecin, date_dispo, heure_dispo, dispo) VALUES (:medecin, :date_dispo, :heure_dispo, true)");
                $stmt->bindParam(':medecin', $medecin, PDO::PARAM_INT);
                $stmt->bindParam(':date_dispo', $date, PDO::PARAM_STR);
                $stmt->bindParam(':heure_dispo', $heure_max, PDO::PARAM_STR);
                $stmt->execute();
            }// insert l'heure max
            
            echo json_encode("<h3>Les heures de la journée ont bien été ajoutées.</h3>");
        } catch (PDOException $e) {
            echo json_encode('Error : ' . $e->getMessage());
        }
    }
}









?>

