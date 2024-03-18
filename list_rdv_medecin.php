<html>
    <head>
        <title>EPHealth</title>
        <meta charset="utf-8">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
<header>
<?php
        include "fonctionphp/header_1.php";
        ?>
    </header>
        <div class="retour">
        <a href="home_log_client.php"><img src="image/fleche.ico" alt="image" style="max-width: 50px; max-height: 50px; width: 100%; height: auto;"></a>
        </div>
        <?php 
            session_start();
            $id_medecin = getMedecinId($_SESSION['email_medecin']);
            list_rdv_medecin($id_medecin);
        ?>

        
    </body>
</html>
