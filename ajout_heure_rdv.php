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
    <div class="retour">
    <a href="home_log_client.php"><img src="image/fleche.ico" alt="image" style="max-width: 50px; max-height: 50px; width: 100%; height: auto;"></a>
        </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Selectionner les heure pour</h4>
                        <form method="post">
                            <div class="form-group">
                                <input type="month" class="form-control" id="mois" name="mois" min="2024-01" value="2024-01" />
                            </div>
                            <?php
                                if (isset($_POST['mois']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                                    $mois = $_POST['mois'];
                                    $moiscomplet = formatmois($mois);
                                    echo "<h3>Vous avez sélectionné $moiscomplet</h3>";
                                    echo "<input type='hidden' name='mois' value='$mois'>";
                                    echo "<input type='date' class='form-control' id='date' name='date' min='$mois-01' max='$mois-31' value='' />";
                                }
                                if (isset($_POST['date']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                                    $date = $_POST['date'];
                                    echo "<p>Heure d'une journée classique ?</p>";
                                    echo '<input type="hidden" name="date" value="' . htmlspecialchars($date) . '">';
                                    echo "<input type='checkbox' id='heure-journée' name='heure-journée' value='on' />";
                                    echo "<p>Heure d'une journée spéciale ?</p>";
                                    echo "<input type='checkbox' id='heure-select' name='heure-select' value='on' />";
                                    
                                    
                                    if (isset($_POST['heure-journée']) && $_POST['heure-journée'] == 'on') {
                                        $date = $_POST['date'];
                                        $email_medecin = $_SESSION['email_medecin'];
                                        $id_medecin = getMedecinId($email_medecin);
                                        echo "<p>Heure d'une journée classique</p>";
                                        echo $date;
                                        insertDateJournéeClassique($id_medecin, $date);
                
                                    }
                                    if (isset($_POST['heure-select']) && $_POST['heure-select'] == 'on') {
                                        $date = $_POST['date'];
                                        $email_medecin = $_SESSION['email_medecin'];
                                        $id_medecin = getMedecinId($email_medecin);
                                        echo "<p>Heure d'une journée spéciale</p>";
                                        echo "Veuillez choisir une heure de rendez-vous entre". "<input type='time' id='heure_min' name='heure_min' min='08:00' max='12:30' value='08:00' /> " . " jusqu'à "." <input type='time' id='heure_max' name='heure_max' min='12:30' max='18:00' value='18:00' required/>";

                                    }
                                    if(isset($_POST['heure_min']) && isset($_POST['heure_max'])){
                                        echo "<br>";
                                        $date = $_POST['date'];
                                        $heure_min = $_POST['heure_min'];
                                        $heure_max = $_POST['heure_max'];
                                        $email_medecin = $_SESSION['email_medecin'];
                                        $id_medecin = getMedecinId($email_medecin);
                                        insertDateJournéeSpecial($id_medecin, $date, $heure_min, $heure_max);
                                    }
                                }                   
                            ?>
                            <button type="submit" class="btn btn-primary btn-block">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</body>

</html>
