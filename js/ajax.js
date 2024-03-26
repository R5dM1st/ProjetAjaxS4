
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
  var all_info = document.getElementById('all_info');
  all_info.innerHTML = `<button id="all_button" class="btn btn-primary">Mes Informations</button>`;
  var medecins = JSON.parse(response);
  var medecinInfo = document.getElementById('info');
  medecinInfo.innerHTML = '';
  medecins.forEach(function (medecin) {
    if (medecin.mail_medecin === email) {
      var medecinDiv = document.createElement('div');
      medecinDiv.innerHTML = `
        <p style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; margin-bottom: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
          Nom: ${medecin.nom_medecin}<br>
          Prénom: ${medecin.prenom_medecin}<br>
          Téléphone: ${medecin.telephone_cabinet}<br>
          Adresse: ${medecin.adresse_cabinet}<br>
          Ville: ${medecin.ville_cabinet}<br>
          Code Postal: ${medecin.code_postal_cabinet}<br>
          Spécialité: ${medecin.specialite_medecin}
        </p>`;
      medecinInfo.appendChild(medecinDiv);
    }
  });
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
          Téléphone: ${client.telephone_client}
        </p>`;
      clientInfo.appendChild(clientDiv);
    }
  });
}

function displayRdvShow(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);

  rdvs.forEach(function(rdv) {
      var rdvDiv = document.createElement('div');
      rdvDiv.innerHTML = `
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Heure</th>
                      <th scope="col">Médecin</th>
                      <th scope="col">Spécialité</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>${rdv.date_dispo}</td>
                      <td>${rdv.heure_dispo}</td>
                      <td>Docteur ${rdv.nom_medecin}</td>
                      <td>${rdv.specialite_medecin}</td>
                  </tr>
              </tbody>
          </table>`;
      rdvInfo.appendChild(rdvDiv);
  });
}




if (typeProfile === '1') {
  $('#show_rdv_button').on('click', () => {
    currentTitle = 'Mes Rendez-vous';
    ajaxRequest('GET', './request.php/rdv/' + id, displayRdvShow);
    console.log('rdv');
  });

  $('#all_button').on('click', () => {
    currentTitle = 'Mes Informations';
    ajaxRequest('GET', './request.php/client/' + id, displayClient);
    console.log('caca');
  });

} else if (typeProfile === '2') {
  

  $('#all_button').on('click', () => {
    currentTitle = 'Liste des Médecins inscrits';
    ajaxRequest('GET', './request.php/', displayMedecin);
    console.log('Medecin');
  });

}
