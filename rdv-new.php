<!DOCTYPE html>
<html lang="fr">
<head>
    <title>EPHealth</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <style>
        h1{
            text-align: center;
            margin-top: 50px;
            color: black;
        }
    </style>
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" style="max-width: 50px; max-height: 50px;">
            <img src="image/logov2.ico" alt="image" style="width: 100%; height: auto;">
        </a>

                
                <div class="collapse navbar-collapse" id="profile">
                <div class="navbar-nav mx-auto">
                <?php
                        include "database.php";
                        session_start();
                        $email_medecin = $_SESSION['email_medecin'];
                        $email_client = $_SESSION['email_client'];
profileUtilisateur2($email_client,$email_medecin);
                        ?>
                </div>
            </div>

        </nav>
    </header>
    <div class=retour>
    <a href="home_log_client.php"><img src="image/fleche.ico" alt="image" style="max-width: 50px; max-height: 50px; width: 100%; height: auto;"></a>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Prendre un rendez-vous</h4>
                        <form method="post">
                            <div class="form-group">
                                <label for="ville">Ville du RDV</label>
                                <select class="form-control" id="ville" name="ville">
                                    <option value="0">Choisir une ville</option>
                                    <?php
                                    afficheVille();
                                    ?>
                                </select>
                                    
                            </div>
                            <div class="form-group">
                                <label for="specialite">Spécialité</label>
                                <select class="form-control" id="specialite" name="specialite">
                                    <option value="0">Choisir une spécialité</option>
                                    <?php
                                    afficheSpecialité();
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="typeRDV">Type de rendez-vous</label>
                                <select class="form-control" id="typeRDV" name="type">
                                    <option value="0">Choisir un type de rendez-vous</option>
                                    <?php
                                    afficheType();
                                    ?>    
                            </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ville = $_POST['ville'];
    $specialite = $_POST['specialite'];
    $type = $_POST['type'];
    afficherMedecinsDispo($ville, $specialite, $type);
    
    if (isset($_POST['medecin_id'])) {
        $id_client = getClientId($_SESSION['email']);
        $id_medecin = $_POST['medecin_id'];
        $_SESSION['id_medecin'] = $id_medecin;
        header('Location: home_log_client.php');
        exit();
        
    }
}

    ?>
</body>
</html>
