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
        .retour{
            width: 100px;
            margin 0 auto;
            background-color: 	#1E90FF;
            border-radius: 2px;
        }
        #texteretour{
            color: white;
        }
    </style>
</head>

<body>
<header>

    </header>
    <div class="retour">
     <a class="dropdown-item" id="texteretour" href="index.html">Retour</a>
    </div>
    <div class="dropdown">
        <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" method="post">
            <h2>Inscrivez-vous</h2>
            <label for="form-lastname">Nom</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="form-lastname" id="form-lastname" placeholder="Nom"  required>
            </div>
            <label for="form-firstname">Prénom</label>
            <div class="form-group">
                <input type="text" class="form-control" name="form-firstname" id="form-firstname" placeholder="Prénom"  required>
            </div>
            <label for="from-tel">Téléphone</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="from-tel" id="from-tel" placeholder="Téléphone"  required>
            </div>
            <label for="from-email">Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                <input type="email" class="form-control" name="from-email" placeholder="Email"  required>
            </div>
            <label for="email-confirm">Confirmation Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                <input type="email" class="form-control" name="email-confirm" placeholder="Confirmation Email"  required>
            </div>
            <div class="form-group">
                <label for="from-mdp">Mot de passe</label>
                <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe"  required>
            </div>
            <label for="mdp-confirm">Confirmation Mot de passe</label>
            <div class="form-group">
                <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe"  required>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
            <a class="dropdown-item" href="login_client.php">Vous avez déjà un compte ?</a>
            <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include 'database.php';
            $nom = $_POST['form-lastname'];
            $prenom = $_POST['form-firstname'];
            $telephone = $_POST['from-tel'];
            $mail = $_POST['from-email'];
            $mot_de_passe = $_POST['from-mdp'];
            $confirmation_email = $_POST['email-confirm'];
            $confirmation_mot_de_passe = $_POST['mdp-confirm'];
            $email_existe = emailExisteClient($mail);

            if (empty($nom) || empty($prenom) || empty($telephone) || empty($mail) || empty($mot_de_passe) || empty($confirmation_email) || empty($confirmation_mot_de_passe)) {
                echo "Veuillez remplir tous les champs";
            } elseif ($mail !== $confirmation_email) {
                echo "Les adresses email ne correspondent pas";

            } elseif ($mot_de_passe !== $confirmation_mot_de_passe) {
                echo "Les mots de passe ne correspondent pas";
            } elseif ($email_existe === true) {
                echo "L'adresse email existe déjà";
            
            } else {
                insertClient($nom, $prenom, $telephone, $mail, $mot_de_passe);
                echo "<p style='color:green;'>Votre compte a bien été créé !</p>";
                echo "<script>window.location.href = 'login_client.php';</script>";
                exit();
                
            }
        }
        
        ?>
        </form>

       
    </div>

</body>

</html>
