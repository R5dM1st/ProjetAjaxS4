<?php
//------------------------Fonction pour les RDV------------------------//
function get_allrdv() {
    $conn = dbConnect();

    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM rdv");
            $stmt->execute();

            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rdvs;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'ERREUR';
    }
}
function get_rdvByIdClient($id) {
    $conn = dbConnect();

    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * 
            FROM rdv 
            INNER JOIN client ON rdv.id_client = client.client_id 
            INNER JOIN medecin ON rdv.id_medecin = medecin.id_medecin 
            INNER JOIN heuredisponible ON rdv.id_heure = heuredisponible.id_heure
            WHERE rdv.id_client = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rdvs;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'ERREUR';
    }
}
function get_rdvByIdMedecin($id) {
    $conn = dbConnect();

    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * 
            FROM rdv 
            INNER JOIN client ON rdv.id_client = client.client_id 
            INNER JOIN medecin ON rdv.id_medecin = medecin.id_medecin 
            INNER JOIN heuredisponible ON rdv.id_heure = heuredisponible.id_heure
            WHERE rdv.id_medecin = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rdvs;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'ERREUR';
    }
}

function dateformat($date){
    $date = explode("-", $date);
    $date = $date[2] . "/" . $date[1] . "/" . $date[0];
    return $date;
}
function heureformat($heure){
    $heure = explode(":", $heure);
    $heure = $heure[0] . "h" . $heure[1];
    return $heure;
}

function prendreRendezVous($id_client, $id_medecin, $date, $heure) {
    $id_heure_dispo = recupereIDHeure($id_medecin, $date, $heure);
    $conn = dbConnect();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT id_rdv FROM RDV WHERE id_client = :id_client AND id_medecin = :id_medecin AND id_heure = :id_heure");
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
            $stmt->bindParam(':id_heure', $id_heure_dispo, PDO::PARAM_INT);
            $stmt->execute();

            $existingRdv = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingRdv) {
                echo "<h3>Vous avez déjà un rendez-vous à cette date et heure. Veuillez réessayer.</h3>";
            }
            
            else {
                $stmt = $conn->prepare("INSERT INTO rdv (id_client, id_medecin, id_heure) VALUES (:id_client, :id_medecin, :id_heure_dispo)");
                $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
                $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
                $stmt->bindParam(':id_heure_dispo', $id_heure_dispo, PDO::PARAM_INT);
                $stmt->execute();
                $dispo = false;
                $stmt = $conn->prepare("UPDATE heuredisponible SET dispo = :dispo WHERE id_heure = :id_heure_dispo");
                $stmt->bindParam(':dispo', $dispo, PDO::PARAM_BOOL);
                $stmt->bindParam(':id_heure_dispo', $id_heure_dispo, PDO::PARAM_INT);
                $stmt->execute();

            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo "<h3>Erreur de connexion à la base de données. Veuillez réessayer.</h3>";
    }
}


function list_rdv_client($id_client) {
    $conn = dbConnect();

    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT rdv.*, medecin.nom_medecin, medecin.specialite_medecin, heuredisponible.date_dispo, heuredisponible.heure_dispo FROM rdv INNER JOIN medecin ON rdv.id_medecin = medecin.id_medecin INNER JOIN heuredisponible ON rdv.id_heure = heuredisponible.id_heure WHERE rdv.id_client = :id_client ORDER BY heuredisponible.date_dispo, heuredisponible.heure_dispo");
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->execute();

            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<style>
                h1 {
                    text-align: center;
                    padding: 50px;
                    color: white;
                }
                .container {
                    margin-top: 50px;
                }
                table {
                    margin: 0 auto;
                    width: 800px;
                    background-color: white;
                    margin-top: 50px;
                    margin-bottom: 50px;
                    text-align: center;
                }
                </style>";

            echo '<div class="container mt-5">';

            if ($rdvs) {
                echo '<h1>Vos Rendez-vous</h1>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Date</th>';
                echo '<th scope="col">Heure</th>';
                echo '<th scope="col">Spécialité</th>';
                echo '<th scope="col">Médecin</th>';
                echo '<th scope="col">Reprendre un rdv</th>';
                echo '</tr>';
                echo '</thead>';

                foreach ($rdvs as $rdv) {
                    $id_medecin = $rdv['id_medecin'];
                    $nom_medecin = getNomMedecin($id_medecin);
                    echo '<tr>';
                    echo '<td>' . dateformat($rdv['date_dispo']) . '</td>';
                    echo '<td>' . heureformat($rdv['heure_dispo']) . '</td>';
                    echo '<td>' . $rdv['specialite_medecin'] . '</td>';
                    echo '<td>' . $nom_medecin  . '</td>';
                    echo '<td>';
                    echo '<form method="post" action="selecte_heure.php">';
                    echo '<input type="hidden" name="id_medecin" value="' . $id_medecin . '">';
                    echo '<button type="submit" class="btn btn-outline-success" name="reprendre_rdv">Reprendre un rdv</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<h1>Aucun rendez-vous trouvé !</h1>';
            }

            echo '</div>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'ERREUR';
    }
}





function list_rdv_medecin($id_medecin) {
    $conn = dbConnect();

    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT rdv.*, client.nom_client, client.prenom_client, heuredisponible.date_dispo, heuredisponible.heure_dispo FROM rdv INNER JOIN client ON rdv.id_client = client.client_id INNER JOIN heuredisponible ON rdv.id_heure = heuredisponible.id_heure WHERE rdv.id_medecin = :id_medecin ORDER BY heuredisponible.date_dispo, heuredisponible.heure_dispo");
            $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
            $stmt->execute();

            $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<style>
                h1 {
                    text-align: center;
                    padding: 50px;
                    color: white;
                }
                .container {
                    margin-top: 50px;
                }
                table {
                    margin: 0 auto;
                    width: 800px;
                    background-color: white;
                    margin-top: 50px;
                    margin-bottom: 50px;
                    text-align: center;
                }
                </style>";

            echo '<div class="container mt-5">';

            if ($rdvs) {
                echo '<h1>Vos Rendez-vous</h1>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Date</th>';
                echo '<th scope="col">Heure</th>';
                echo '<th scope="col">Client</th>';
                echo '<th scope="col">Le rdv est déjà passé ?</th>';
                echo '</tr>';
                echo '</thead>';

                foreach ($rdvs as $rdv) {
                    echo '<form method="post" action="supp.php">';
                    echo '<tr>';
                    echo '<td>' . dateformat($rdv['date_dispo']) . '</td>';
                    echo '<td>' . heureformat($rdv['heure_dispo']) . '</td>';
                    echo '<td>' . $rdv['prenom_client'].' '. $rdv['nom_client'] .  '</td>';
                    echo '<td><input type="hidden" name="id_rdv" value="' . $rdv['id_rdv'] . '"> <button type="submit" class="btn btn-outline-danger">Rendez-vous déjà passé</button></td>';
                    echo '</tr>';
                    echo '</form>';
                }
                echo '</table>';
                
            } else {
                echo '<h1>Aucun rendez-vous trouvé !</h1>';
            }

            echo '</div>';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'ERREUR';
    }
}
function suppRDV($id_rdv){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("DELETE FROM rdv WHERE id_rdv = :id_rdv");
            $stmt->bindParam(':id_rdv', $id_rdv, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>