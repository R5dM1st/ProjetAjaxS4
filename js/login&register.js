
$(document).ready(function() {
    // Generic modal form loader
    function loadModalForm(formHtml) {
        $("#myModal").modal("show");
        $("#log").html(formHtml);
    }

    $("#log_medecin").click(function() {
        loadModalForm(medecinLoginForm());
    });

    $("#log_client").click(function() {
        loadModalForm(clientLoginForm());
    });

    $(document).on("click", "#register_medecin_link", function() {
        loadModalForm(medecinRegisterForm());
    });

    $(document).on("click", "#register_client_link", function() {
        loadModalForm(clientRegisterForm());
    });

    $(document).on("click", "#login_client_link", function() {
        loadModalForm(clientLoginForm());
    });

    $(document).on("click", "#login_medecin_link", function() {
        loadModalForm(medecinLoginForm());
    });

    // Form submission handlers
    $(document).on("submit", "#medecin_login_form, #client_login_form", function(event) {
        event.preventDefault();
        var formId = $(this).attr('id');
        var email = $('#' + formId + ' #email').val();
        var mdp = $('#' + formId + ' #mdp').val();

        var url = formId === 'medecin_login_form' ? './request.php/log_medecin' : './request.php/log_client';

        ajaxRequest('POST', url, {mail: email, mdp: mdp}, function(response) {
            sessionDisplayLogin(response);
        });
    });

    $(document).on("submit", "#medecin_register_form, #client_register_form", function(event) {
        event.preventDefault();
        var formId = $(this).attr('id');
        var data = $(this).serialize();

        var url = formId === 'medecin_register_form' ? './request.php/register_medecin' : './request.php/register_client';

        ajaxRequest('POST', url, data, function(response) {
            sessionDisplayRegister(response);
        });
    });

    // Generic AJAX request function
    function ajaxRequest(method, url, data, callback) {
        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function(response) {
                callback(JSON.parse(response));
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // Display login response
    function sessionDisplayLogin(response) {
        var message = $("#message");
        if (response.email !== undefined) {
            sessionStorage.setItem('prenom', response.prenom);
            sessionStorage.setItem('nom', response.nom);
            sessionStorage.setItem('email', response.email);
            sessionStorage.setItem('profile', response.profile);
            sessionStorage.setItem('id', response.id);

            message.html('<div class="alert alert-success" role="alert">Connexion réussie !</div>');
            setTimeout(function() {
                window.location.href = "index.html";
            }, 2000);
        } else {
            message.html('<div class="alert alert-danger" role="alert">Problème d\'authentification...</div>');
        }
    }

    // Display register response
    function sessionDisplayRegister(response) {
        var message = $("#message");
        switch (response) {
            case "1":
                message.html('<div class="alert alert-danger" role="alert">Les adresses email ne correspondent pas</div>');
                break;
            case "2":
                message.html('<div class="alert alert-danger" role="alert">Les mots de passe ne correspondent pas</div>');
                break;
            case "3":
                message.html('<div class="alert alert-danger" role="alert">L\'adresse email est déjà utilisée</div>');
                break;
            default:
                message.html('<div class="alert alert-success" role="alert">Inscription réussie !!</div>');
                break;
        }
    }

    // Form HTML templates
    function medecinLoginForm() {
        return `
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
        `;
    }

    function clientLoginForm() {
        return `
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
        `;
    }

    function medecinRegisterForm() {
        return `
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="client_register_form">
                <h2>Inscrivez-vous <i class="fas fa-user"></i></h2>
                <label for="form-lastname">Nom</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="form-lastname" id="form-lastname" placeholder="Nom" value="1" required>
                </div>
                <label for="form-firstname">Prénom</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="form-firstname" id="form-firstname" placeholder="Prénom" value="1" required>
                </div>
                <label for="from-tel">Téléphone</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="from-tel" id="medecin_tel" placeholder="Téléphone" value="1" required>
                </div>
                <label for="from-email">Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="from-email" id="from-email" placeholder="Email" value="1@gmail.com" required>
                </div>
                <label for="email-confirm">Confirmation Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="email-confirm" id="email-confirm" placeholder="Confirmation Email" value="1@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="from-mdp">Mot de passe</label>
                    <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe" value="1" required>
                </div>
                <label for="mdp-confirm">Confirmation Mot de passe</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe" value="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="login_client_link">Vous avez déja un compte ?</a>
            </form>
            <div id="message"></div>
        `;
    }

    function clientRegisterForm() {
        return `
            <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" style="width: 400px; margin: 0 auto; text-align: center;" id="client_register_form">
                <h2>Inscrivez-vous <i class="fas fa-user"></i></h2>
                <label for="form-lastname">Nom</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="form-lastname" id="form-lastname" placeholder="Nom" value="1" required>
                </div>
                <label for="form-firstname">Prénom</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="form-firstname" id="form-firstname" placeholder="Prénom" value="1" required>
                </div>
                <label for="from-tel">Téléphone</label>
                <div class="form-group">   
                    <input type="text" class="form-control" name="from-tel" id="medecin_tel" placeholder="Téléphone" value="1" required>
                </div>
                <label for="from-email">Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="from-email" id="from-email" placeholder="Email" value="1@gmail.com" required>
                </div>
                <label for="email-confirm">Confirmation Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control" name="email-confirm" id="email-confirm" placeholder="Confirmation Email" value="1@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="from-mdp">Mot de passe</label>
                    <input type="password" class="form-control" name="from-mdp" id="from-mdp" placeholder="Mot de passe" value="1" required>
                </div>
                <label for="mdp-confirm">Confirmation Mot de passe</label>
                <div class="form-group">
                    <input type="password" class="form-control" name="mdp-confirm" id="mdp-confirm" placeholder="Confirmation Mot de passe" value="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
                <a class="nav-link" id="login_client_link">Vous avez déja un compte ?</a>
            </form>
            <div id="message"></div>
        `;
    }
});
