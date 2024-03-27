
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
          Spécialité: ${medecin.specialite_medecin}
        </p>`;
        medecinInfo.appendChild(clientDiv);
        
    }
  });
}

function transformDate(date) {
  const dateArray = date.split('-');
  return `${dateArray[2]}-${dateArray[1]}-${dateArray[0]}`;
}
function displayClient(response) {

  var clients = JSON.parse(response);
  var clientInfo = document.getElementById('info');
  clientInfo.innerHTML = '';
  clients.forEach(function (client) {
    if (client.mail_client === email) {
      var clientDiv = document.createElement('div');
      clientDiv.innerHTML = `
        <p style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; margin-bottom: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
          Nom: ${client.nom_client}<br>
          Prénom: ${client.prenom_client}<br>
          Téléphone: 0${client.telephone_client}
        </p>`;
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
  rdvDiv.innerHTML = `<p>Vous n'avez pas de rendez-vous</p>`;
  rdvInfo.appendChild(rdvDiv);
}
else{
  rdvs.forEach(function(rdv) {
      var rdvDiv = document.createElement('div');
      rdvDiv.innerHTML = `<style>
          p {
              padding: 30px;
          };
          </style>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Heure</th>
                      <th scope="col">Medecin</th>
                      <th scope="col">Spécialité</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td><p>${transformDate(rdv.date_dispo)}</p></td>
                      <td><p>${rdv.heure_dispo}</p></td>
                      <td><p>Docteur ${rdv.nom_medecin}</p></td>
                      <td><p>${rdv.specialite_medecin}</p></td>
                      <td><button class="btn btn-danger">Reprendre</button></td>
                  </tr>
              </tbody>
          </table>`;
      rdvInfo.appendChild(rdvDiv);
  });}

}
function displayRdvShowMedecin(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);
  if (rdvs.length === 0) {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `<p>Vous n'avez pas de rendez-vous</p>`;
    rdvInfo.appendChild(rdvDiv);
  }
  else{
    rdvs.forEach(function(rdv) {
        var rdvDiv = document.createElement('div');
        rdvDiv.innerHTML = `<style>
            p {
                padding: 30px;
            };
            </style>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Heure</th>
                        <th scope="col">Client</th>
                        <th scope="col">Spécialité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><p>${transformDate(rdv.date_dispo)}</p></td>
                        <td><p>${rdv.heure_dispo}</p></td>
                        <td><p>${rdv.nom_client}</p></td>
                        <td><button class="btn btn-danger">Supprimer</button></td>
                    </tr>
                </tbody>
            </table>`;
        rdvInfo.appendChild(rdvDiv);
    });}
}

function displayNewRdv() {
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
  </style>
    <div class="container">
      <form>
        <div class="form-group">
          <label for="date">Date:</label>
          <input type="date" class="form-control" id="date">
        </div>
        <div class="form-group">
          <label for="heure">Heure:</label>
          <input type="time" class="form-control" id="heure">
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
      </form>
    </div>`;

  findRdv.appendChild(rdvDiv);
}

function afficheVille(response) {
  var villes = JSON.parse(response);
  var optionsHtml = '';
  optionsHtml += '<option value="0">Choisir une ville</option>';
  for (var i = 0; i < villes.length; i++) {
    if (villes[i].ville_cabinet !== undefined) {
      optionsHtml += '<option value="' + villes[i].ville_cabinet + '">' + villes[i].ville_cabinet + '</option>';
    }
  }
  return optionsHtml;
}
function afficheSpecialite(response) {
  var specialites = JSON.parse(response);
  var optionsHtml = '';
  optionsHtml += '<option value="0">Choisir une spécialité</option>';
  for (var i = 0; i < specialites.length; i++) {
    if (specialites[i].specialite_medecin !== undefined) {
      optionsHtml += '<option value="' + specialites[i].specialite_medecin + '">' + specialites[i].specialite_medecin + '</option>';
    }
  }
  return optionsHtml;
}
function afficheTypesDemande(response) {
  var typesDemande = JSON.parse(response);
  var optionsHtml = '';
  optionsHtml += '<option value="0">Choisir un type de rendez-vous</option>';
  for (var i = 0; i < typesDemande.length; i++) {
    optionsHtml += '<option value="' + typesDemande[i].id_type_demande + '">' + typesDemande[i].nom_type_demande + '</option>';
  }
  return optionsHtml;
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
                    <!-- Options de type de rendez-vous -->
                </select>
                <button id="find_search" type="button" class="btn btn-primary">Rechercher</button>
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
    var medecinInfo = document.getElementById('info');
    medecinInfo.innerHTML = '';

    medecins.forEach(function (medecin) {
      var clientDiv = document.createElement('div');
      clientDiv.classList.add('card');
      clientDiv.innerHTML = `<style>
      .card{
          margin: 0 auto;
          width: 400px;
          background-color: white;
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
      img{
          width: 100px;
          height: 100px;
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
          <form method="post" action="selecte_heure.php">
            <input type="hidden" name="id_medecin" value="${medecin.id_medecin}">
            <button type="submit" class="btn btn-primary">Prendre rendez-vous</button>
          </form>
        </div>
      `;
      medecinInfo.appendChild(clientDiv);
    });
  } catch (error) {
    console.error("Erreur lors de l'analyse de la réponse JSON : ", error);
    var errorMessage = document.createElement('p');
    errorMessage.textContent = "Erreur lors de la récupération des données. Veuillez réessayer plus tard.";
    document.getElementById('info').appendChild(errorMessage);
  }
}





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
    console.log('caca');
  });
  $('#find_rdv_form').on('submit', function(e) {
    e.preventDefault();

    
   
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
