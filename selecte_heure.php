<!DOCTYPE html>
<html lang="fr">

<head>
    <title>EPHealth</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style/style.css" rel="stylesheet">
    <link rel="stylesheet" href="style/home_log.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" style="max-width: 50px; max-height: 50px;">
            <img src="image/logov2.ico" alt="image" style="width: 100%; height: auto;">
        </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

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
    <?php
    session_start();
    $id_medecin =$_POST['id_medecin'];
    
    echo "<h1>Vous avez choisi le médecin : " . getNomMedecin($id_medecin) . "</h1>";
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Prendre un rendez-vous</h4>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
                            $date = $_POST['date'];
                            if(empty($date)){
                                echo "<h3>Vous n'avez pas choisi de date</h3>";
                                echo '<form method="post">';
                                echo '<div class="form-group">';
                                echo '<label for="date">Date de RDV</label>';
                                echo '<select class="form-control" id="date" name="date">';
                                afficheDateDispo($id_medecin);
                                echo '</select>';
                                echo '</div>';
                                echo '<input type="hidden" name="id_medecin" value="' . $id_medecin . '">';
                                echo '<button type="submit" class="btn btn-primary btn-block">Valider</button>';
                                echo '</form>';
                                
                            }
                            else{
                            echo "<h3>Votre date choisie est : " . dateformat($date) . "</h3>";
                            echo '<form method="post">';
                            echo '<input type="hidden" name="date" value="' . htmlspecialchars($date) . '">';
                            echo '<div class="form-group">';
                            echo '<label for="heure">Heure de RDV</label>';
                            echo '<h3>' . $nom . '</h3>';
                            echo '<select class="form-control" id="heure" name="heure">';
                            afficheHeureDispo($id_medecin, $date);
                            echo '</select>';
                            echo '</div>';
                            echo '<input type="hidden" name="id_medecin" value="' . $id_medecin . '">';
                            echo '<button type="submit" class="btn btn-primary btn-block">Valider</button>';
                            echo '</form>';
                        }

                        } else {
                            
                            echo '<form method="post">';
                            echo '<div class="form-group">';
                            echo '<label for="date">Date de RDV</label>';
                            echo '<select class="form-control" id="date" name="date">';
                            afficheDateDispo($id_medecin);
                            echo '</select>';
                            echo '</div>';
                            echo '<input type="hidden" name="id_medecin" value="' . $id_medecin . '">';
                            echo '<button type="submit" class="btn btn-primary btn-block">Valider</button>';
                            echo '</form>';
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['heure'])) {
                            $heure = $_POST['heure'];
                            if(empty($heure)){
                                echo "<h3>Vous n'avez pas choisi d'heure</h3>";
                            }
                            else{
                            $id_client = getClientId($_SESSION['email_client']);
                            $date = $_POST['date'];
                            
                            echo "<h3>Votre rendez-vous est prévu à " . $heure . "</h3>";
                            prendreRendezVous($id_client, $id_medecin, $date, $heure);
                            header("refresh:1;url=home_log_client.php");
                            
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>