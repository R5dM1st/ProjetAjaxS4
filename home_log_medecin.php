<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EPHealth</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/home_log.css">
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
    <?php
        $email = $_SESSION['email_medecin'];

        if (!isset($_SESSION['email_medecin'])) {

            header('Location: login_medecin.php');
            exit();
        }
        $nomUtilisateur = getNomPrenomMedecin($email);
        echo "<h1>Bienvenue " . $nomUtilisateur . "</h1>";

?>
        <div class="container">
            <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ajout d'heures de rdv</h5>
                        <p class="card-text"></p>
                        <a href="ajout_heure_rdv.php" class="btn btn-primary">Cliquez ici</a>
                    </div>
                </div>
                
        </div>
            
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">les RDV prit</h5>
                        <p class="card-text"></p>
                        <a href="list_rdv_medecin.php" class="btn btn-primary">Cliquez ici</a>
                    </div>
                </div>
        </div>
            </div>
    </div>
        
</body>

</html>
