<html>
    <head>
        <title>EPHealth</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/accueil.css">


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
                        profileUtilisateur1($email_client,$email_medecin);
                        ?>
                </div>
            </div>
            
            <ul class="nav navbar-nav navbar-expand-lg navbar-right">
                <a class="nav-item nav-link" href="login_medecin.php">Êtes-vous medecin ?</a>
                <a class="nav-item nav-link" href="login_client.php">Connexion</a>
            </ul>
        </nav>
    </header>
    <main class="container text-center-main my-4 text-center">
    <h2>Bienvenue sur notre site de prise de rdv EPHealth</h2>
        <h4>Ici, vous pouvez consulter les horaires des rendez-vous médicaux et réserver en ligne.</h4>
    </main>
    </body>
</html>
