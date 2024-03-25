// Fonction pour effectuer une requête AJAX
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
console.log(typeProfile);

if (typeProfile === '1') {
  function displayClient(response) {
    var clients = JSON.parse(response);
    var clientInfo = document.getElementById('client-info');
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

  $('#all-button').on('click', () => {
    currentTitle = 'Liste des Clients inscrits';
    ajaxRequest('GET', './get_client.php', displayClient);
    console.log('Client');
  });
} else if (typeProfile === '2') {
  function displayMedecin(response) {
    var medecins = JSON.parse(response);
    var medecinInfo = document.getElementById('medecin-info');
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

  $('#all-button').on('click', () => {
    currentTitle = 'Liste des Médecins inscrits';
    ajaxRequest('GET', './get_medecin.php', displayMedecin);
    console.log('Medecin');
  });
}
