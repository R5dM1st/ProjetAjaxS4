<!DOCTYPE html>
<html lang="fr">

<head>
<title>EPHealth</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style/style.css" rel="stylesheet">
    <style>
        form{
            margin: 0 auto;
            width: 400px;
            background-color: white;
            margin-top: 50px;
            text-align: center;
        }
        </style>
</head>

<body>


    <div class="dropdown">
        <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" method="post">
            <h2>Connectez-vous</h2>
            <?php
            session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $hashedPasswordFromDatabase = getPasswordByEmail_Hash_Client($email);

                if ($hashedPasswordFromDatabase !== null && password_verify($password, $hashedPasswordFromDatabase)) {
                    $_SESSION['email_client'] = $email;
                    $infoconnect = getInfoConnexion($email,$password);
                    $nom=getNomByEmailClient($email);
                    $prenom=getPrenomByEmailClient($email);
                    echo "<script type='text/javascript'>
                    sessionStorage.setItem('prenom', <?php echo json_encode($prenom); ?>);
                    sessionStorage.setItem('nom', <?php echo json_encode($nom); ?>);
                </script>";
                    
                    
                    exit();
                } else {
                    $messageErreur = "Identifiants incorrects. Veuillez réessayer.";
                }
            }
            ?>
            <div class="form-group">
                <label for="email">Entre ton mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
            </div>
            <div class="form-group">
                <label for="mdp">Entre Mot de passe</label>
                <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
            <a class="dropdown-item" href="register_client.php">Vous n'avez pas de compte ?</a>
            <?php
            if (isset($messageErreur)) {
                echo "<p style='color:red;'>$messageErreur</p>";
            }
            ?>
        </form>
    </div>
    <script type="text/javascript">
    var firstname = <?php $prenom ?>;
    var lastname = <?php $nom ?>;
    sessionStorage.setItem('prenom',);
    sessionStorage.setItem('nom', <?php echo json_encode($nom); ?>);
</script>

</body>

</html>
