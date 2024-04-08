
function ajaxRequest(method, url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          callback(xhr.responseText);
      }
  };
  xhr.send();
}
const typeProfile = sessionStorage.getItem('profile');
const email = sessionStorage.getItem('email');
const id = sessionStorage.getItem('id');
console.log(typeProfile);


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------PARTIE CLIENT-----------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function displayClient(response) {
  var clients = JSON.parse(response);
  var clientInfo = document.getElementById('info');
  clientInfo.innerHTML = '';
  clients.forEach(function (client) {
    if (client.mail_client === email) {
      var clientDiv = document.createElement('div');
      clientDiv.innerHTML = `
      <div style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; margin-bottom: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
        <p>
          Nom: ${client.nom_client}<br>
          Prénom: ${client.prenom_client}<br>
          Téléphone: 0${client.telephone_client}<br>
          Mail: ${client.mail_client}<br>
        </p>
      </div>`;
      clientInfo.appendChild(clientDiv);
    }
  });
}

function displayRdvShowClient(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);
  if (rdvs.length === 0) {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
    .alert{
      width: 400px;
      margin: 0 auto;
      text-align: center;
  }
  </style>
  <div class="alert alert-danger" role="alert">
  Aucun rendez-vous trouvé
  </div>`;
    rdvInfo.appendChild(rdvDiv);
  } else {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `<style>
 
    </style>
    <div id="rdvDiv">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Client</th>
            <th scope="col">Spécialité</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="rdvTableBody">
        </tbody>
      </table>
    </div>`;
    rdvInfo.appendChild(rdvDiv);

    var rdvTableBody = document.getElementById('rdvTableBody');
    rdvs.forEach(function(rdv) {
      var rdvRow = document.createElement('tr');
      rdvRow.innerHTML = `
        <td><p>${dateComplete(rdv.date_dispo)}</p></td>
        <td><p>${rdv.heure_dispo}</p></td>
        <td><p>Docteur ${rdv.nom_medecin}</p></td>
        <td><p>${rdv.specialite_medecin}</p></td>
        <td><button id="list" class="btn btn-warning">Reprendre</button></td>`;
      rdvTableBody.appendChild(rdvRow);
      document.getElementById('list').addEventListener('click', function() {
        var id_medecin = rdv.id_medecin;
        displayerCommande(id_medecin);
      }
      );
    });
  }

  var printDiv = document.getElementById('print');
  printDiv.innerHTML = '';
}




function displayFindRdv() {
  ajaxRequest('GET', './request.php/ville', function(response) {
    var villeSelect = document.getElementById('ville');
    villeSelect.innerHTML = afficheVille(response);
  });
  ajaxRequest('GET', './request.php/specialité', function(response) {
    var specialiteSelect = document.getElementById('specialite');
    specialiteSelect.innerHTML = afficheSpecialite(response);
  });
  ajaxRequest('GET', './request.php/type', function(response) {
    var typeRDVSelect = document.getElementById('typeRDV');
    typeRDVSelect.innerHTML = afficheTypesDemande(response);
  });

  var findRdv = document.getElementById('info');
  findRdv.innerHTML = '';

  var rdvDiv = document.createElement('div');
  rdvDiv.innerHTML = `
    <style>
      .container {
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }
      .form-group {
        text-align: center;
      }
      .form_submit {
        text-align: center;
      }
    </style>
    <div class="container">
        <h4 class="card-title text-center">Prendre un rendez-vous</h4>
        <form id="find_rdv_form">
            <div class="form-group">
                <label for="ville">Ville du RDV</label>
                <select class="form-control" id="ville" name="ville">
                    
                </select>
            </div>
            <div class="form-group">
                <label for="specialite">Spécialité</label>
                <select class="form-control" id="specialite" name="specialite">
                    <option value="0">Choisir une spécialité</option>
                    <!-- Options de spécialité -->
                </select>
            </div>
            <div class="form-group">
                <label for="typeRDV">Type de rendez-vous</label>
                <select class="form-control" id="typeRDV" name="type">
                    <option value="0">Choisir un type de rendez-vous</option>
                </select>
                
            </div>
            <div class="form_submit">
                <button type="submit" id="find_search" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </div>`;

  findRdv.appendChild(rdvDiv);

  
  document.getElementById('find_search').addEventListener('click', function(event) {
    event.preventDefault();
    currentTitle = 'Mes Informations';
    var ville = $('#ville').val();
    var specialite = $('#specialite').val();
    var typeRDV = $('#typeRDV').val();

    console.log(ville, specialite, typeRDV);

    ajaxRequest('GET', './request.php/medecin?' + 'ville=' + encodeURIComponent(ville) + '&specialite=' + encodeURIComponent(specialite) + '&type=' + encodeURIComponent(typeRDV), displayAfficheMedecin);

  });
}


function displayAfficheMedecin(response) {
  try {
    var medecins = JSON.parse(response);
    var medecinInfo = document.getElementById('print');
    medecinInfo.innerHTML = '';
    if (medecins.length === 0) {
      var errorMessage = document.createElement('p');
      errorMessage.innerHTML = `<style>
      .alert{
          width: 400px;
          margin: 0 auto;
          text-align: center;
      }
      </style>
      <div class="alert alert-danger" role="alert">
      Aucun médecin trouvé pour cette recherche
      </div>`;
      medecinInfo.appendChild(errorMessage);
    } else {
      medecins.forEach(function (medecin) {
        var clientDiv = document.createElement('div');
        clientDiv.classList.add('card');
        clientDiv.innerHTML = `<style>
        #print{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card{
            margin: 0 auto;
            width: 400px;
            margin-top: 50px;
            margin-bottom: 50px;
            text-align: center;
        }
        .card-title {
            margin-top: 20px;
        }
        .card-text {
            margin-top: 20px;
        }
        .btn {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        h1{
            text-align: center;
            padding: 50px;
            color: white;
        }
        .card-image{
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        </style>
        <div class="card-body">
          <img src="image/docteurPessi.png" alt="image" class="card-image">
          <h5 class="card-title">${medecin.prenom_medecin} ${medecin.nom_medecin}</h5>
          <p class="card-text">${medecin.specialite_medecin}</p>
          <p class="card-text">Téléphone: 0${medecin.telephone_cabinet}</p>
          <p class="card-text">${medecin.mail_medecin}</p>
          <p class="card-text">${medecin.adresse_cabinet}</p>
          <p class="card-text">${medecin.ville_cabinet}</p>
          <p class="card-text">${medecin.code_postal_cabinet}</p>
          <form id="medecin_form">
            <input id="id_medecin" type="hidden" name="id_medecin" value="${medecin.id_medecin}">
            <button type="button" id="medecin_submit" class="btn btn-primary">Prendre rendez-vous</button>
          </form>
        </div>`;
        medecinInfo.appendChild(clientDiv);
        document.querySelectorAll('#medecin_submit').forEach(button => {
          window.scrollTo(0,document.body.scrollHeight);
          button.addEventListener('click', function (event) {
            event.preventDefault();
            id_medecin = this.parentNode.querySelector('#id_medecin').value;
            displayerCommande(id_medecin);
          });
      });
      
      });
    }
  } catch (error) {
    console.error("Erreur lors de l'analyse de la réponse JSON : ", error);
    var errorMessage = document.createElement('p');
    errorMessage.textContent = "Erreur lors de la récupération des données. Veuillez réessayer plus tard.";
    document.getElementById('info').appendChild(errorMessage);
  }
}

function displayerCommande(id_medecin) {
  var findRdv = document.getElementById('info');
  var print = document.getElementById('print');
  print.innerHTML = '';
  findRdv.innerHTML = '';

  ajaxRequest('GET', './request.php/heure?id_medecin='+id_medecin, function(response) {
    var dateSelect = document.getElementById('dateRDV');
    dateSelect.innerHTML = affichedate(response);
  });

  var rdvDiv = document.createElement('div');
  rdvDiv.innerHTML = `
    <style>
      .container {
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
      }
    </style>
    <div class="container">
      <form id="rdvForm">
        <div class="form-group">
          <label for="date">Date:</label>
          <select class="form-control" id="dateRDV" name="date">
            <option value="0">Choisir une date de rendez-vous</option>
          </select>
        </div>
        <button type="button" class="btn btn-info" id="btn_date">Rechercher</button>
      </form>
    </div>`;
  findRdv.appendChild(rdvDiv);
  $('#btn_date').on('click', () => {
    var error_date = document.getElementById('print');
    error_date.innerHTML = '';
    var date = document.getElementById('dateRDV').value;
    console.log(date);
    if(date == '0'){
      var errorMessage = document.createElement('p');
      errorMessage.innerHTML = `<style>
      .alert{
          width: 400px;
          margin: 0 auto;
          text-align: center;
      }
      </style>
      <div class="alert alert-danger" role="alert">
      Aucune date sélectionnée
      </div>`;
      error_date.appendChild(errorMessage);
      
}
if(date != '0'){
    displayHeure(id_medecin, date);
}
  });
}



function displayHeure($id_medecin, $date) {
   ajaxRequest('GET', './request.php/heure?id_medecin='+$id_medecin+'&date='+$date, function(response) {
     var heureSelect = document.getElementById('heure');
     heureSelect.innerHTML = afficheHeure(response);
  
   });
   var errorMessage = document.getElementById('print');
    errorMessage.innerHTML = '';
   var findRdv = document.getElementById('info');
   findRdv.innerHTML = '';
   var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
      <style>
        .container {
          padding: 30px;
          border-radius: 5px;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
          background-color: #f9f9f9;
        }
      </style>
      <div class="container">
        <form id="heureForm">
          <div class="form-group">
            <label for="heure">Heure:</label>
            <select class="form-control" id="heure" name="heure">
              <option value="0">Choisir une heure de rendez-vous</option>
            </select>
          </div>
          <button type="button" class="btn btn-info" id="btn_heure">Rechercher</button>
        </form>
      </div>`;
    findRdv.appendChild(rdvDiv);
    $('#btn_heure').on('click', function() {
      var error_date = document.getElementById('print');
    error_date.innerHTML = '';
      console.log($date);
      var heure = document.getElementById('heure').value;
      console.log(heure);
      if(heure == '0'){
        var errorMessage = document.createElement('p');
        errorMessage.innerHTML = `<style>
        .alert{
            width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        </style>
        <div class="alert alert-danger" role="alert">
        Aucune heure sélectionnée
        </div>`;
        error_date.appendChild(errorMessage);
      }
      if(heure!='0'){
        ajaxRequest('POST', './request.php/rdv?id_client=' + encodeURIComponent(id) + '&id_medecin=' + encodeURIComponent($id_medecin)+ '&date=' + encodeURIComponent($date) + '&heure=' + encodeURIComponent(heure));
        var successMessage = document.createElement('p');
        successMessage.innerHTML = `<style>
        .alert{
            width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        </style>
        <div class="alert alert-success" role="alert">
        Rendez-vous pris avec succès
        </div>`;
        error_date.appendChild(successMessage);
        setTimeout(function(){
          document.location.href = 'index.html';
        }, 2000);
        
    }
});
   }


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------PARTIE MEDECIN-----------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function displayMedecin(response) {
  var medecins = JSON.parse(response);
  var medecinInfo = document.getElementById('info');
  medecinInfo.innerHTML = '';
  medecins.forEach(function (medecin) {
    if (medecin.mail_medecin === email) {
      var clientDiv = document.createElement('div');
      clientDiv.innerHTML = `
        <p style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; margin-bottom: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
          Nom: ${medecin.nom_medecin}<br>
          Prénom: ${medecin.prenom_medecin}<br>
          Téléphone: 0${medecin.telephone_cabinet}<br>
          Spécialité: ${medecin.specialite_medecin}<br>
          Mail: ${medecin.mail_medecin}<br>
          Adresse: ${medecin.adresse_cabinet}<br>
          Ville: ${medecin.ville_cabinet}<br>
          Code Postal: ${medecin.code_postal_cabinet}<br>
        </p>`;
        medecinInfo.appendChild(clientDiv);
        
    }
  });
}

function displayRdvShowMedecin(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);
  if (rdvs.length === 0) {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
    <style>
      p {
        padding: 30px;
        background-color: #f9f9f9; 
        border-radius: 5px; 
        padding: 10px; 
        margin-bottom: 10px; 
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      }
    </style>
    <p>Vous n'avez pas de rendez-vous</p>`;
    rdvInfo.appendChild(rdvDiv);
  } else {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `<style>
    </style>
    <div id="rdvDiv">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Client</th>
            <th scope="col">Spécialité</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="rdvTableBody">
        </tbody>
      </table>
    </div>`;
    rdvInfo.appendChild(rdvDiv);

    var rdvTableBody = document.getElementById('rdvTableBody');
    rdvs.forEach(function(rdv) {
      var rdvRow = document.createElement('tr');
      rdvRow.innerHTML = `
        <td><p>${dateComplete(rdv.date_dispo)}</p></td>
        <td><p>${rdv.heure_dispo}</p></td>
        <td><p>${rdv.nom_client}</p></td>
        <td><button class="btn btn-danger">Supprimer</button></td>`;
      rdvTableBody.appendChild(rdvRow);
    });
  }

  var printDiv = document.getElementById('print');
  printDiv.innerHTML = '';
}


function displayNewRdv() {
  var findRdv = document.getElementById('info');
  findRdv.innerHTML = '';
  
  var rdvDiv = document.createElement('div');
  rdvDiv.innerHTML = `
    <style>
      .container {
        display: flex;
        justify-content: center; /* Pour centrer horizontalement */
        align-items: center;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
      }
      #btn_date{

        transform: translate(10%, 0);
        
      }
    </style>
    <div class="container">
      <form id="rdvForm">
        <div class="form-group">
          <label for="date">Date:</label>
          <input type="date" class="form-control" id="date">
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-info" id="btn_date">Rechercher</button>
        </div>
      </form>
    </div>`;

  findRdv.appendChild(rdvDiv);


  findRdv.removeEventListener('click', rdvClickListener);


  function rdvClickListener(event) {
    if (event.target && event.target.id === 'btn_date') {
      var date = document.getElementById('date').value;
      console.log(date);

      rdvDiv.innerHTML = `
        <style>
          .container {
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
          }
          .form-group {
            margin-bottom: 20px;
            text-align: center;
          }
          .from_submit {
            text-align: center;
          }
          label {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
          }
        </style>
        <div class="container">
          <form id="heureForm">
            <div class="form-group">
              <label for="heure">Heure:</label>
              <input type="time" class="form-control" id="heure">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-info" id="btn_heure">Rechercher</button>
            </div>
            <label for="heure">Préférez-vous choisir une journée standard ?</label>
            <div class="form-group">
              <input type="hidden" id="date" value="${date}">
              <button type="button" class="btn btn-info" id="btn_standard">Journée Standard</button>
            </div>
          </form>
        </div>`;
    } else if (event.target && event.target.id === 'btn_standard') {
      var date = document.getElementById('date').value;
      console.log(date);
      console.log(id);
      ajaxRequest('POST', './request.php/heure?id_ref=' + encodeURIComponent(id) + '&date=' + encodeURIComponent(date));
    }
  }

  findRdv.addEventListener('click', function(event) {
    event.preventDefault();
  });
  
  var printDiv = document.getElementById('print');
  printDiv.innerHTML = '';
}





//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------PARTIE COMMUNE-----------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if (typeProfile === '1') {
  $('#find_rdv_button').on('click', () => {
    currentTitle = 'Trouver un Rendez-vous';
    displayFindRdv();
    console.log('rdv_find');
  });
  $('#show_rdv_button').on('click', () => {
    currentTitle = 'Mes Rendez-vous';
    ajaxRequest('GET', './request.php/rdv_client/' + id, displayRdvShowClient);
    console.log('rdv');
  });

  $('#all_button').on('click', () => {
    currentTitle = 'Mes Informations';
    ajaxRequest('GET', './request.php/client/' + id, displayClient);
    console.log('Mes informations');
  });
  $('#find_date_search').on('click', () => {
    currentTitle = 'Mes Informations';
    displayHeure();
    console.log('Mes informations');
  });

} else if (typeProfile === '2') {
  $('#add_rdv_button').on('click', () => {
    currentTitle = 'Trouver un Rendez-vous';
    displayNewRdv();
    console.log('rdv_new');
  });
  $('#show_rdv_button').on('click', () => {
    currentTitle = 'Mes Rendez-vous';
    ajaxRequest('GET', './request.php/rdv_medecin/' + id, displayRdvShowMedecin);
    console.log('rdv');
  });

  $('#all_button').on('click', () => {
    currentTitle = 'Liste des Médecins inscrits';
    ajaxRequest('GET', './request.php/medecin', displayMedecin);
    console.log('Medecin');
  });

}
