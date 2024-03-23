
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


function displayClient(response) {
  var clients = JSON.parse(response);
  var clientInfo = document.getElementById('client-info');
  clientInfo.innerHTML = '';
  clients.forEach(function (client) {
      var clientDiv = document.createElement('div');
      clientDiv.innerHTML = `
          <p>Nom: ${client.nom_client}</p>
          <p>Prénom: ${client.prenom_client}</p>
          <p>Téléphone: ${client.telephone_client}</p>

      `;
      clientInfo.appendChild(clientDiv);
  });
}

$('#all-button').on('click', () => {
  currentTitle = 'Liste des client inscript';

  ajaxRequest('GET', './get_client.php', displayClient);
});
