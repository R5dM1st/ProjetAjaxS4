document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("log_medecin").addEventListener("click", function() {
      showModal(`<style>
      form {
        width: 400px;
        margin: 0 auto;
        text-align: center;
      }
        </style>
      <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" id="loginForm">
          <h2>Connecte-vous</h2>
          <div class="form-group">
              <label for="email">Entre ton mail</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
          </div>
          <div class="form-group">
              <label for="mdp">Entre Mot de passe</label>
              <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
          </div>
          <button type="submit" id="btn_client" class="btn btn-primary">Valider</button>
          <a class="dropdown-item" id="register_link_medecin">Vous n'avez pas de compte ?</a>
      </form>
      <div id="message"></div>`);
    });
    document.getElementById("register_link_medecin").addEventListener("click", function() {
        console.log("Vous n'avez pas de compte ? (médecin) a été cliqué !");
    });
  
    document.getElementById("log_client").addEventListener("click", function() {
      showModal(`
      <style>
      form {
        width: 400px;
        margin: 0 auto;
        text-align: center;
      }
        </style>
      <form class="px-4 py-3 shadow p-3 mb-5 bg-white rounded" id="loginForm">
          <h2>Connectez-vous</h2>
          <div class="form-group">
              <label for="email">Entre ton mail</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
          </div>
          <div class="form-group">
              <label for="mdp">Entre Mot de passe</label>
              <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" required>
          </div>
          <button type="submit" id="btn_client" class="btn btn-primary">Valider</button>
          <a class="dropdown-item" id="register_link_client">Vous n'avez pas de compte ?</a>
      </form>
<div id="message"></div>`);
    });
    
    function showModal(content) {
      var modalBody = document.querySelector(".modal-body");
      modalBody.innerHTML = content;
      $('#myModal').modal('show');
    }
  
     
  });
  
  
  $(document).ready(function() {
      $('#log_client').click(function() {
          $('#loginForm').submit(function(event) {
              event.preventDefault();
              
              var email = $('#email').val();
              var mdp = $('#mdp').val();
              console.log(email);
              console.log(mdp);
  
              ajaxRequest('GET', './request.php/log_client?mail=' + encodeURIComponent(email) + '&mdp=' + encodeURIComponent(mdp), function(response) {
                  sessiondisplay(response);
              });
                                       
          });
      });
      $('#log_medecin').click(function() {
          $('#loginForm').submit(function(event) {
              event.preventDefault();
              
              var email = $('#email').val();
              var mdp = $('#mdp').val();
              console.log(email);
              console.log(mdp);
  
              ajaxRequest('GET', './request.php/log_medecin?mail=' + encodeURIComponent(email) + '&mdp=' + encodeURIComponent(mdp), function(response) {
                  sessiondisplay(response);
              });
                                       
          });
          
      });
        $('#register_client').click(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();
                
                var nom = $('#form-lastname').val();
                var prenom = $('#form-firstname').val();
                var tel = $('#from-tel').val();
                var email = $('#from-email').val();
                var email_confirm = $('#email-confirm').val();
                var mdp = $('#from-mdp').val();
                var mdp_confirm = $('#mdp-confirm').val();
                console.log(nom);
                console.log(prenom);
                console.log(tel);
                console.log(email);
                console.log(email_confirm);
                console.log(mdp);
                console.log(mdp_confirm);
    
                ajaxRequest('POST', './request.php/log_client?nom=' + encodeURIComponent(nom) + '&prenom=' + encodeURIComponent(prenom) + '&tel=' + encodeURIComponent(tel) + '&mail=' + encodeURIComponent(email) + '&mail_confirm=' + encodeURIComponent(email_confirm) + '&mdp=' + encodeURIComponent(mdp) +'&mdp_confirm='+encodeURIComponent(mdp_confirm));

                                         
            });
        });
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
            Erreur de connexion !
        </div>`;
      }
  }