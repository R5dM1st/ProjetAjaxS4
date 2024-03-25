<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['mdp'];
    include 'database.php';
    $hashedPasswordFromDatabase = getPasswordByEmail_Hash_Client($email);
    if ($hashedPasswordFromDatabase !== null && password_verify($password, $hashedPasswordFromDatabase)) {
        $infoconnexion = getInfoConnexion($email,$password);
        $nom = getNomByEmailClient($email);
        $prenom = getPrenomByEmailClient($email);
        $_SESSION['prenom'] = $prenom;
        $_SESSION['nom'] = $nom;
        $_SESSION['email'] = $email;
        $_SESSION['profile'] = 1;
    } else {
        $messageErreur = "Identifiants incorrects. Veuillez réessayer.";
    }
}
if (isset($_SESSION['prenom']) && isset($_SESSION['nom'])) {
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPHealth</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style/style.css" rel="stylesheet">
    <style>
        form {
            margin: 0 auto;
            width: 400px;
            background-color: white;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header></header>
    <div class="dropdown">
        <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" method="post">
            <h2>Connectez-vous</h2>
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
            <?php if (isset($messageErreur)) {
                echo "<p style='color:red;'>$messageErreur</p>";
            } ?>
        </form>
    </div>


    <script>
        <?php if(isset($_SESSION['prenom']) && isset($_SESSION['nom'])&& isset($_SESSION['email'])) { ?>
            sessionStorage.setItem('prenom', <?php echo json_encode($_SESSION['prenom']); ?>);
            sessionStorage.setItem('nom', <?php echo json_encode($_SESSION['nom']); ?>);
            sessionStorage.setItem('email', <?php echo json_encode($_SESSION['email']); ?>);
            sessionStorage.setItem('profile', <?php echo json_encode($_SESSION['profile']); ?>);
            window.location.replace("index.html");
            session_destroy();
            
        <?php } ?>
    </script>
</body>
</html>
