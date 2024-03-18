<?php
function getNomPrenomMedecin($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT nom_medecin, prenom_medecin FROM medecin WHERE mail_medecin = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['prenom_medecin'] . " " . $result[0]['nom_medecin'];
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
function findAllville(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT DISTINCT ville_cabinet FROM medecin");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function findAllType(){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT * FROM TypeDemande");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
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
function insertMedecin($nom, $prenom, $telephone, $mail, $mot_de_passe, $adresse, $ville, $code_postal, $specialite, $type){
    if ($type == "Consultation") {
        $type = 1;
    }
    if ($type == "Urgence") {
        $type = 2;
    }
    if ($type == "Visite à domicile") {
        $type = 3;
    }
    $hashed_pwd = hashPassword($mot_de_passe);
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO medecin (specialite_medecin, nom_medecin, prenom_medecin, mail_medecin, mdp_medecin, adresse_cabinet, ville_cabinet, code_postal_cabinet, telephone_cabinet, id_type_demande) VALUES (:specialite, :nom, :prenom, :mail, :mot_de_passe, :adresse, :ville, :code_postal, :telephone, :type_demande_id)");
            $stmt->bindParam(':specialite', $specialite, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $hashed_pwd, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
            $stmt->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_INT);
            $stmt->bindParam(':type_demande_id', $type, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
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
function medecinselect($ville, $specialité,$type){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT * FROM medecin WHERE ville_cabinet = '$ville' AND specialite_medecin = '$specialité' AND id_type_demande = (SELECT id_type_demande FROM TypeDemande WHERE nom_type_demande = '$type')");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function afficherMedecinsDispo($ville,$specialité,$type) {
    $medecinsDispo = medecinselect($ville, $specialité,$type);

    
    echo "<style>
        .card{
            margin: 0 auto;
            width: 400px;
            background-color: white;
            margin-top: 50px;
            margin-bottom: 50px;
            text-align: center;
        }
        .card-title {
            margin-top: 20px;
        }
        .card-text {
            margin-top: 20px;
        }
        .btn {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        h1{
            text-align: center;
            padding: 50px;
            color: white;
        }
        img{
            width: 100px;
            height: 100px;
        }

    </style>";
    if($medecinsDispo == null){
        echo "<h1>Il n'y a pas de médecins ".$specialité." disponibles à ".$ville." pour une ".$type."</h1>";
    }
    else{
        echo "<h1>Voici les médecins ".$specialité." disponibles à ".$ville." pour une ".$type."</h1>";
    }

    foreach ($medecinsDispo as $medecin) {
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img src="image/docteurPessi.png" alt="image" class="card-image">';
        echo '<h5 class="card-title">'.$medecin['prenom_medecin'] . ' ' . $medecin['nom_medecin'] . '</h5>';
        echo '<p class="card-text">' . $medecin['specialite_medecin'] . '</p>';
        echo '<p class="card-text">' . $medecin['telephone_cabinet'] . '</p>';
        echo '<p class="card-text">' . $medecin['mail_medecin'] . '</p>';
        echo '<p class="card-text">' . $medecin['adresse_cabinet'] . '</p>';
        echo '<p class="card-text">' . $medecin['ville_cabinet'] . '</p>';
        echo '<p class="card-text">' . $medecin['code_postal_cabinet'] . '</p>';
        echo '<form method="post" action="selecte_heure.php">';
        echo '<input type="hidden" name="id_medecin" value="' . $medecin['id_medecin'] . '">';
        echo '<button type="submit" class="btn btn-primary">Prendre rendez-vous</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
}
?>