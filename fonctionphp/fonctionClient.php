<?php
// ------------------------Fonction pour les clients------------------------//
function get_clientsById($id){
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM client WHERE client_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $clients;
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
    return array();
}
function get_allclients()
{
    $db= dbConnect();
    try
    {
        $request = 'SELECT * FROM client';
        $statement = $db->prepare($request);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
        error_log('Erreur de requête : ' . $exception->getMessage());
        return false;
    }
    
    return $result;
}

function getNomByEmailClient($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT nom_client FROM client WHERE mail_client = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['nom_client'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function getPrenomByEmailClient($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT prenom_client FROM client WHERE mail_client = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['prenom_client'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}

function getClientId($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT client_id FROM client WHERE mail_client = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['client_id'];
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }
}
function emailExisteClient($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT mail_client FROM client WHERE mail_client = '$email'");
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
function insertClient($nom, $prenom, $telephone, $mail, $mot_de_passe) {
    $conn = dbConnect();
    if (!$conn) {
        return json_encode("Erreur de connexion à la base de données.");
    }

    $hashed_pwd = hashPassword($mot_de_passe);
    if (!$hashed_pwd) {
        return "Erreur lors du hashage du mot de passe.";
    }

    $sql = "INSERT INTO client (nom_client, prenom_client, telephone_client, mail_client, mot_de_passe_client) 
            VALUES (:nom, :prenom, :telephone, :mail, :mot_de_passe)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $hashed_pwd, PDO::PARAM_STR);
        $stmt->execute();
        return "Client ajouté avec succès.";
    } catch (PDOException $e) {
        return "Erreur lors de l'insertion du client : " . $e->getMessage();
    }
}

function getPasswordByEmail_Hash_Client($email) {
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT mot_de_passe_client FROM client WHERE mail_client = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['mot_de_passe_client'];
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

function update_client($id, $nom, $prenom, $tel,$email) {
    $conn = dbConnect();
    
    if (!$conn) {
        return json_encode("Erreur de connexion à la base de données.");
    }

    $sql = "UPDATE client SET nom_client = :nom, prenom_client = :prenom, telephone_client = :tel,mail_client =:email WHERE client_id = :id";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $tel, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return "Informations modifiées avec succès.";
    } catch (PDOException $e) {
        return "Erreur lors de la modification des informations : " . $e->getMessage();
    }
}