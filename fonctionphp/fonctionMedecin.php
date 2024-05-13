<?php
function get_medecinById($id){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM medecin WHERE id_medecin = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            return null;
        }
    }
    return null;
}
function getIdByEmailMedecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT id_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['id_medecin'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getNomByEmailMedecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT nom_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['nom_medecin'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getPrenomByEmailMedecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT prenom_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['prenom_medecin'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getMailById($id){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT mail_medecin FROM medecin WHERE id_medecin = '$id'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['mail_medecin'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getMedecinId($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT id_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['id_medecin'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getNomMedecin($id){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT nom_medecin, prenom_medecin FROM medecin WHERE id_medecin = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['prenom_medecin'] . " " . $result['nom_medecin'];
            } else {
                return "Médecin introuvable";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
function get_allmedecin(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT * FROM medecin");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function emailExisteMedecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT mail_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            if($result == null){
                return false;
            }
            else{
                return true;
            }
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function findAllSpecialite(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT DISTINCT specialite_medecin FROM medecin");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function afficheSpecialité(){
    $specialites = findAllSpecialite();
    foreach ($specialites as $specialite) {
        echo '<option value="' . $specialite['specialite_medecin'] . '">' . $specialite['specialite_medecin'] . '</option>';
    }
}
function findAllville() {
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT DISTINCT ville_cabinet FROM medecin");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $villes = $result->fetchAll();
            return $villes;
        } catch (PDOException $e) {
            return false;
        }
    } else {

        return false;
    }
}


function findAllType(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT * FROM typedemande");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $types = $result->fetchAll();
            return $types;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}

function afficheType(){
    $types = findAllType();
    foreach ($types as $type) {
        echo '<option value="' . $type['nom_type_demande'] . '">' . $type['nom_type_demande'] . '</option>';
    }
}
function afficheVille(){
    $villes = findAllville();
    foreach ($villes as $ville) {
        echo '<option value="' . $ville['ville_cabinet'] . '">' . $ville['ville_cabinet'] . '</option>';
    }
}
function insertMedecin($nom, $prenom, $tel, $email, $mdp, $adresse, $ville, $code_postal, $specialite, $type) {
    $conn = dbConnect();
    if (!$conn) {
        return json_encode("Erreur de connexion à la base de données.");
    }
    $hashed_pwd = hashPassword($mdp);
    if (!$hashed_pwd) {
        return "Erreur lors du hashage du mot de passe.";
    }

    if (empty($code_postal) || !is_numeric($code_postal)) {
        return "Le code postal doit être un nombre entier.";
    }
    if (empty($adresse)) {
        return "L'adresse est obligatoire.";
    }
    

    $sql = "INSERT INTO medecin (nom_medecin, prenom_medecin, telephone_cabinet, mail_medecin, mdp_medecin, adresse_cabinet, ville_cabinet, code_postal_cabinet, specialite_medecin, id_type_demande) 
            VALUES (:nom, :prenom, :telephone, :mail, :mdp, :adresse, :ville, :code_postal, :specialite, :type)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $tel, PDO::PARAM_INT);
        $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mdp', $hashed_pwd, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
        $stmt->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->bindParam(':specialite', $specialite, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->execute();
        return "Médecin ajouté avec succès.";
    } catch (PDOException $e) {
        return "Erreur lors de l'insertion du médecin : " . $e->getMessage();
    }
}

function getPasswordByEmail_Hash_Medecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT mdp_medecin FROM medecin WHERE mail_medecin = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['mdp_medecin'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            return null;
        }
    }
    return null;
}
function medecinselect($ville, $specialite, $type, $nom) {
    $conn = dbConnect();
    if ($conn) {
        try {
            $sql = "SELECT * FROM medecin WHERE 1=1";
            $params = [];

            if (!empty($ville)) {
                $sql .= " AND ville_cabinet = :ville";
                $params[':ville'] = $ville;
            }

            if (!empty($specialite)) {
                $sql .= " AND specialite_medecin = :specialite";
                $params[':specialite'] = $specialite;
            }

            if (!empty($type)) {
                $sql .= " AND id_type_demande = :type_demande";
                $params[':type_demande'] = $type;
            }
            if(!empty($nom)) {
                $sql .= " AND nom_medecin = :nom";
                $params[':nom'] = $nom;
            }

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            return false;
        }
    }
}
function medecinselectByNom($nom){
    $conn = dbConnect();
    if ($conn) {
        try {
            $sql = "SELECT * FROM medecin WHERE 1=1";

                $sql .= " AND id_type_demande = :nom";
                $params[':type_demande'] = $nom;
            

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            return false;
        }
    }
}

function update_medecin($id, $nom, $prenom, $tel, $email, $adresse, $ville, $code_postal, $specialite, $type) {
    $conn = dbConnect();
    if (!$conn) {
        return json_encode("Erreur de connexion à la base de données.");
    }

    if (empty($code_postal) || !is_numeric($code_postal)) {
        return "Le code postal doit être un nombre entier.";
    }
    if (empty($adresse)) {
        return "L'adresse est obligatoire.";
    }

    $sql = "UPDATE medecin SET nom_medecin = :nom, prenom_medecin = :prenom, telephone_cabinet = :tel, mail_medecin = :email, adresse_cabinet = :adresse, ville_cabinet = :ville, code_postal_cabinet = :code_postal, specialite_medecin = :specialite, id_type_demande = :type WHERE id_medecin = :id";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $tel, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
        $stmt->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->bindParam(':specialite', $specialite, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->execute();
        return "Médecin modifié avec succès.";
    } catch (PDOException $e) {
        return "Erreur lors de la modification du médecin : " . $e->getMessage();
    }
}

?>