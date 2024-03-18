<?php
// ------------------------Fonction pour les clients------------------------//
function getNomPrenomClient($email){
    $conn = dbConnect();
    if ($conn) {
        try {
            $result = $conn->query("SELECT nom_client, prenom_client FROM client WHERE mail_client = '$email'");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result[0]['prenom_client'] . " " . $result[0]['nom_client'];
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
function insertClient($nom, $prenom, $telephone, $mail, $mot_de_passe){
    $hashed_pwd = hashPassword($mot_de_passe);
    $conn = dbConnect();
    if ($conn) {
        try {
            $stmt=$conn->prepare("INSERT INTO client (nom_client, prenom_client, telephone_client, mail_client, mot_de_passe_client) VALUES (:nom, :prenom, :telephone, :mail, :mot_de_passe)");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_INT);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $hashed_pwd, PDO::PARAM_STR);
            $stmt->execute();
            
            echo "Ajouté";
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
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
function profileUtilisateur1($email_client,$email_medecin){
    if(isset($email_medecin)){
        $nometprenom = getNomPrenomMedecin($email_medecin);
    }
    else if(isset($email_client)){
        $nometprenom = getNomPrenomClient($email_client);
    }
    else{
        $nometprenom = "Invité";
    }
    echo "<style>
        #profile {
            margin-left: 200px;
        }
        #vert {
            width: 15px;
            height: 15px;
            background-color: green;
            border-radius: 50%;
            display: inline-block;
        }
        #rouge {
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
        }
        a{
            text-decoration: none;
        }
    </style>";

    
    if(isset($_SESSION['email_medecin'])){
        echo '<a href="home_log_medecin.php"><h5> ' . $nometprenom . '</a> <a href="logout.php"><div id="vert" ></div></a></h5>';
    }
    if(isset($_SESSION['email_client'])){
        echo '<a href="home_log_client.php"><h5> ' . $nometprenom . '</a> <a href="logout.php"><div id="vert" ></div></a></h5>';
    }
    if(!isset($_SESSION['email_medecin']) && !isset($_SESSION['email_client'])){
        echo  ' <a href="logout.php"><div id="rouge" ></div></a>';
    }
    
}
function profileUtilisateur2($email_client,$email_medecin){
    if(isset($email_medecin)){
        $nometprenom = getNomPrenomMedecin($email_medecin);
    }
    else if(isset($email_client)){
        $nometprenom = getNomPrenomClient($email_client);
    }
    else{
        $nometprenom = "Invité";
    }
    echo "<style>
        #profile {
            margin-right: 50px;
        }
        #vert {
            width: 15px;
            height: 15px;
            background-color: green;
            border-radius: 50%;
            display: inline-block;
        }
        #rouge {
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
        }
        a{
            text-decoration: none;
        }
    </style>";

    
    if(isset($_SESSION['email_medecin'])){
        echo '<a href="home_log_medecin.php"><h5> ' . $nometprenom . '</a> <a href="logout.php"><div id="vert" ></div></a></h5>';
    }
    if(isset($_SESSION['email_client'])){
        echo '<a href="home_log_client.php"><h5> ' . $nometprenom . '</a> <a href="logout.php"><div id="vert" ></div></a></h5>';
    }
    if(!isset($_SESSION['email_medecin']) && !isset($_SESSION['email_client'])){
        echo  ' <a href="logout.php"><div id="rouge" ></div></a>';
    }
    
}
?>