<html>
    <head>
        <title>EPHealth</title>
        <meta charset="utf-8">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <style>
            h1{
                text-align: center;
                margin-top: 50px;
                color: black;
            }
        </style>
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
        </div>
        <?php 
            session_start();
            $id_client=getClientId($_SESSION['email_client']);
            list_rdv_client($id_client);

        ?>

        
    </body>
</html>
