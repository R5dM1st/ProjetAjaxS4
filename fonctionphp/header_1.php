
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" style="max-width: 50px; max-height: 50px;">
            <img src="image/logov2.ico" alt="image" style="width: 100%; height: auto;">
        </a>

                
                <div class="collapse navbar-collapse" id="profile">
                <div class="navbar-nav mx-auto">
                <?php
                        include "main.php";
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
  