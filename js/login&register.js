
$(document).ready(function() {
    $("#log_medecin").click(function() {
        $("#myModal").modal("show");

        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="medecin_login_form" >
                <h2>Connectez-vous <i class="fas fa-user-md"></i></h2>
                <div class="form-group">
                    <label for="email">Entre ton mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Entre Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
                </div>
                <button type="submit" id="btn_medecin" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="register_medecin_link">Vous avez déja un compte ?</a>
            </form>
            <div id="message"></div>
        `);
    });
    $("#log_client").click(function() {
        $("#myModal").modal("show");
        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="client_login_form">
                <h2>Connectez-vous <i class="fas fa-user"></i></h2>
                <div class="form-group">
                    <label for="email">Entre ton mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Entre Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
                </div>
                <button type="submit" id="btn_client" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="register_client_link">Vous avez déja un compte ?</a>
            </form>
            <div id="message"></div>
        `);
    });

    $(document).on("click", "#register_medecin_link", function() {
        ajaxRequest('GET', './request.php/type', function(response) {
            var typeRDVSelect = document.getElementById('typeRDV');
            typeRDVSelect.innerHTML = afficheTypesDemande(response);
          });
        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="medecin_register_form">
                <h2>Inscrivez-vous <i class="fas fa-user-md"></i></h2>
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
                    <input type="text" class="form-control" name="from-tel" id="medecin_tel" placeholder="Téléphone" value="" required>
                </div>
                <label for="from-email">Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="from-email" id="from-email" placeholder="Email" value="@gmail.com" required>
                </div>
                <label for="email-confirm">Confirmation Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" id=email-confirm name="email-confirm" placeholder="Confirmation Email" value="@gmail.com" required>
                </div>
                <label for="specialite-select">Spécialité</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="specialite-select" id="specialite-select" placeholder="Spécialité" value="Généraliste" required>
                </div>
                <label for="from-type">Type de consultation</label>
                <div class="form-group">
                    <select class="form-control" id="typeRDV" name="type"></select>
                </div>
                <label for="from-mdp">Mot de passe</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe" value="" required>
                </div>
                <label for="mdp-confirm">Confirmation Mot de passe</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe" value="" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="login_medecin_link">Vous avez déja un compte ?</a>
            </form>
            <div id="message"></div>
        `);
    });
    $(document).on("click", "#register_client_link", function() {
        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="client_register_form">
                <h2>Inscrivez-vous <i class="fas fa-user"></i></h2>
                <label for="form-lastname">Nom</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="form-lastname" id="form-lastname" placeholder="Nom" required>
                </div>
                <label for="form-firstname">Prénom</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="form-firstname" id="form-firstname" placeholder="Prénom" required>
                </div>
                <label for="from-tel">Téléphone</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="from-tel" id="medecin_tel" placeholder="Téléphone" required>
                </div>
                <label for="from-email">Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="from-email" placeholder="Email" required>
                </div>
                <label for="email-confirm">Confirmation Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="email-confirm" placeholder="Confirmation Email" required>
                </div>
                <div class="form-group">
                    <label for="from-mdp">Mot de passe</label>
                    <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe" required>
                </div>
                <label for="mdp-confirm">Confirmation Mot de passe</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="login_client_link">Vous avez déja un compte ?</a>
            </form>
        `);
    });

    $(document).on("click", "#login_client_link", function() {
        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="client_login_form">
                <h2>Connectez-vous <i class="fas fa-user"></i></h2>
                <div class="form-group">
                    <label for="email">Entre ton mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Entre Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
                </div>
                <button type="submit" id="btn_client" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="register_client_link">Vous n'avez pas de un compte ?</a>
            </form>
            <div id="message"></div>
        `);
    });
    $(document).on("click", "#login_medecin_link", function() {
        $("#log").html(`
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="medecin_login_form">
                <h2>Connectez-vous <i class="fas fa-user-md"></i></h2>
                <div class="form-group">
                    <label for="email">Entre ton mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Entre Mot de passe</label>
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
                </div>
                <button type="submit" id="btn_medecin" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="register_medecin_link">Vous n'avez pas de un compte ?</a>
            </form>
            <div id="message"></div>
        `);
    });

    
    $(document).on("submit", "#medecin_login_form", function(event) {
        event.preventDefault();
        
        var email = $('#email').val();
        var mdp = $('#mdp').val();
        console.log(email);
        console.log(mdp);

        ajaxRequest('GET', './request.php/log_medecin?mail=' + encodeURIComponent(email) + '&mdp=' + encodeURIComponent(mdp), function(response) {
            sessiondisplay(response);
        });
        
    });

    
    $(document).on("submit", "#client_login_form", function(event) {
        event.preventDefault();
        
        var email = $('#email').val();
        var mdp = $('#mdp').val();
        console.log(email);
        console.log(mdp);

        ajaxRequest('GET', './request.php/log_client?mail=' + encodeURIComponent(email) + '&mdp=' + encodeURIComponent(mdp), function(response) {
            sessiondisplay(response);
        });
        

    });

    
    $(document).on("submit", "#medecin_register_form", function(event) {
        event.preventDefault();
        var nom = $('#form-lastname').val();
        var prenom = $('#form-firstname').val();
        var tel = $('#medecin_tel').val();
        var email = $('#from-email').val();
        var email_confirm = $('#email-confirm').val();
        var mdp = $('#from-mdp').val();
        var typediv = $('#typeRDV').val();
        var mdp_confirm = $('#mdp-confirm').val();

        console.log(nom);
        console.log(prenom);
        console.log(typediv);
        console.log(tel);
        console.log(email);
        console.log(email_confirm);
        console.log(mdp);
        console.log(mdp_confirm);
        ajaxRequest('POST', './request.php/register_client?nom=' + encodeURIComponent(nom) + '&prenom=' + encodeURIComponent(prenom) + '&tel=' + encodeURIComponent(tel) + '&mail=' + encodeURIComponent(email) + '&mail_confirm=' + encodeURIComponent(email_confirm) + '&mdp=' + encodeURIComponent(mdp) +'&mdp_confirm='+encodeURIComponent(mdp_confirm)+'&type='+encodeURIComponent(typediv),function(response) {
            console.log("good");
        });
        
    });

    
    $(document).on("submit", "#client_register_form", function(event) {
        event.preventDefault();
        
    });
    function sessiondisplay(response) {
        response = JSON.parse(response);
        var message = document.getElementById("message");
        if(response.email !== undefined) {
            sessionStorage.setItem('prenom', response.prenom);
            sessionStorage.setItem('nom', response.nom);
            sessionStorage.setItem('email', response.email);
            sessionStorage.setItem('profile', response.profile);
            sessionStorage.setItem('id', response.id);
              
            message.innerHTML = `<style>
            #myModal{
              background-color: success;
            }
            .alert {
                width: 400px;
                margin: 0 auto;
                text-align: center;
            }
        </style>
        <div class="alert alert-success" role="alert">
            Connexion réussie !
        </div>
        `;
            setTimeout(function() {
              window.location.href = "index.html";
          }, 2000);
            
        } else {
          message.innerHTML = `<style>
          .alert {
              width: 400px;
              margin: 0 auto;
              text-align: center;
          }
          </style>
          <div class="alert alert-danger" role="alert">
            <span class="strong-hover-shake">Hover on me!</span>
          </div>`;
        }
    }
});
