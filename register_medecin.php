<!DOCTYPE html>
<html lang="en">
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
            margin: 0 auto;
            background-color: 	#1E90FF;
            border-radius: 2px;
        }
        #texteretour{
            color: white;
        }

    </style>
</head>

<body>
    <div class="retour">
        <a class="dropdown-item" id="texteretour" href="index.html">Retour</a>
    </div>

    <div class="dropdown">
        <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" method="post">
            <h2>Inscrivez-vous</h2>
            <label for="form-lastname">Nom</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="form-lastname" id="form-lastname" placeholder="Nom" value="" required>
            </div>
            <label for="form-firstname">Prénom</label>
            <div class="form-group">
                <input type="text" class="form-control" name="form-firstname" id="form-firstname" placeholder="Prénom" value="" required>
            </div>
            <label for="from-adresse">Adresse Cabinet</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="from-adresse" id="from-adresse" placeholder="Adresse" value="Rue de " required>
            </div>
            <label for="from-ville">Ville</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="from-ville" id="from-ville" placeholder="Ville" value="" required>
            </div>

            <label for="from-postal">Code postal</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="from-postal" id="from-postal" placeholder="Code postal" value="" required>
            </div>
            <label for="from-tel">Téléphone</label>
            <div class="form-group">   
                <input type="text" class="form-control" name="from-tel" id="from-tel" placeholder="Téléphone" value="" required>
            </div>
            <label for="from-email">Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                <input type="email" class="form-control" name="from-email" id="from-email" placeholder="Email" value="@gmail.com" required>
            </div>
            <label for="email-confirm">Confirmation Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                <input type="email" class="form-control" name="email-confirm" placeholder="Confirmation Email" value="@gmail.com" required>
            </div>
        

            <label for="specialite-select">Specialité</label>
            <div class="form-group">
                <input type="text" class="form-control" name="specialite-select" id="specialite-select" placeholder="Specialite" value="Généraliste" required>
            </div>
            <label for="from-type">Type de consultation</label>
            <div class="form-group">
                <select type="text" class="form-control" name="from-type" id="from-type" placeholder="Type de consultation" required>
                    <?php
                        include "database.php";
                        afficheType();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="from-mdp">Mot de passe</label>
                <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe" value="" required>
            </div>
            <label for="mdp-confirm">Confirmation Mot de passe</label>
            <div class="form-group">
                <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe" value="" required>
            </div>
            <button type="submit" class="btn btn-primary" href="login_medecin.php">Valider</button>
            <a class="dropdown-item" href="login_medecin.php">Vous avez déjà un compte ?</a>
            <?php

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nom = $_POST['form-lastname'];
                    $prenom = $_POST['form-firstname'];
                    $codePostal = $_POST['from-postal'];
                    $specialite = $_POST['specialite-select'];
                    $type = $_POST['from-type'];
                    $telephone = $_POST['from-tel'];
                    $mail = $_POST['from-email'];
                    $mot_de_passe = $_POST['from-mdp'];
                    $confirmation_email = $_POST['email-confirm'];
                    $confirmation_mot_de_passe = $_POST['mdp-confirm'];
                    $adresse = $_POST['from-adresse'];
                    $ville = $_POST['from-ville'];
                    $email_existe = emailExisteMedecin($mail);

                    if (empty($nom) || empty($prenom) || empty($telephone) || empty($mail) || empty($mot_de_passe) || empty($confirmation_email) || empty($confirmation_mot_de_passe || empty($codePostal) || empty($specialite)||empty($ville)||empty($adresse))) {
                        echo "Veuillez remplir tous les champs";
                    } elseif ($mail !== $confirmation_email) {
                        echo "Les adresses email ne correspondent pas";
                    } elseif ($mot_de_passe !== $confirmation_mot_de_passe) {
                        echo "Les mots de passe ne correspondent pas";
                    } else {
                       if($email_existe === true){
                            echo "L'adresse email existe déjà";
                        }
                        else{
                            insertMedecin($nom, $prenom, $telephone, $mail, $mot_de_passe, $adresse, $ville, $codePostal, $specialite, $type);
                            echo "<p style='color:green;'>Votre compte a bien été créé !</p>";

                            echo "<script>window.location.href = 'login_medecin.php';</script>";
                            exit();
                        }
                        
                    }
                }
        ?>
        </form>

       
    </div>

</body>

</html>