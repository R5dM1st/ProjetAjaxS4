
function ajaxRequest(method, url, callback,data=null) {
  var xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          callback(xhr.responseText);
      }
  };
  xhr.send(data);
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
  var print = document.getElementById('print');
  print.innerHTML = '';
  
  clients.forEach(function (client) {
    if (client.mail_client === email) {
      var cardDiv = document.createElement('div');
      cardDiv.className = 'card';
      cardDiv.style.width = '18rem';
      
      var cardBodyDiv = document.createElement('div');
      cardBodyDiv.className = 'card-body';
      
      cardBodyDiv.innerHTML = ` 
      <h5 class="card-title">${client.prenom_client} ${client.nom_client}</h5>
      <p class="card-text">Téléphone: 0${client.telephone_client}</p>
      <p class="card-text">Mail: ${client.mail_client}</p>
      <button class="btn btn-warning" id="editButton">Modifier votre profile</button>`;
      cardDiv.appendChild(cardBodyDiv);
      clientInfo.appendChild(cardDiv);

      var editButton = document.getElementById('editButton');
      editButton.addEventListener('click', function() {
        displayEditForm(client);
      });
    }
  });
}


 

function displayEditForm(client) {
  var cardBodyDiv = document.querySelector('.card-body');
  cardBodyDiv.innerHTML = `
    <form id="editForm">
      <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="${client.nom_client}">
      </div>
      <div class="form-group">
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="${client.prenom_client}">
      </div>
      <div class="form-group">
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" value="${client.telephone_client}">
      </div>
      <div class="form-group">
        <label for="mail">Mail:</label>
        <input type="text" id="mail" name="mail" value="${client.mail_client}">
      </div>
      <button class="btn btn-warning" id="editButton">Modifier votre profile</button>
    </form>
  `;

  var editForm = document.getElementById('editForm');
  editForm.addEventListener('submit', function(event) {
    event.preventDefault();
    updateClient(client.client_id);
    
  });
}

function updateClient(clientId) {
  var nom = document.getElementById('nom').value;
  var prenom = document.getElementById('prenom').value;
  var telephone = document.getElementById('telephone').value;
  var mail = document.getElementById('mail').value;

}


function displayRdvShowClient(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);
  if (rdvs.length === 0) {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
      <style>
        .alert {
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
    rdvDiv.innerHTML = `
      <div id="rdvDiv">
        <form id="rdvForm">
          <div class="form-group">
            <input type="text" class="form-control" id="rechercheRDV" placeholder="Recherche sur les noms et prénoms...">
          </div>
        </form>
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
          <tbody id="rdvTableBody"></tbody>
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
        <td><button class="btn btn-warning list" data-id="${rdv.id_medecin}">Reprendre</button></td>`;
      rdvTableBody.appendChild(rdvRow);
    });

    var reprendreButtons = document.querySelectorAll('.list');
    reprendreButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var id_medecin = this.getAttribute('data-id');
        console.log(id_medecin);
        displayerCommande(id_medecin);
      });
    });

    var rechercheRDV = document.getElementById('rechercheRDV');
    rechercheRDV.addEventListener('input', function() {
      var filterValue = this.value.toUpperCase();
      var rows = rdvTableBody.getElementsByTagName('tr');
      for (var i = 0; i < rows.length; i++) {
        var cols = rows[i].getElementsByTagName('td');
        var display = false;
        for (var j = 0; j < cols.length; j++) {
          var textValue = cols[j].textContent || cols[j].innerText;
          if (textValue.toUpperCase().indexOf(filterValue) > -1) {
            display = true;
            break;
          }
        }
        rows[i].style.display = display ? '' : 'none';
      }
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
                </select>
            </div>
            <div class="form-group">
                <label for="typeRDV">Type de rendez-vous</label>
                <select class="form-control" id="typeRDV" name="type">
                    <option value="0">Choisir un type de rendez-vous</option>
                </select>
                
            </div>
            <div class="form-group">
            <label for="nom">Nom du Docteur:</label>
            <input type="text" class="form-control" id="nom" name="nom">
        </div>

            <div class="form_submit">
                <button type="submit" id="find_search" class="btn btn-primary">Rechercher</button>
            </div>

        </form>
    </div>`;

  findRdv.appendChild(rdvDiv);

  
  document.getElementById('find_search').addEventListener('click', function(event) {
    event.preventDefault();
    var ville = $('#ville').val();
    var specialite = $('#specialite').val();
    var typeRDV = $('#typeRDV').val();
    var nom = $('#nom').val();

    console.log(ville, specialite, typeRDV, nom);
      var url = './request.php/medecin?';
      if (ville != 0) url += 'ville=' + encodeURIComponent(ville);
      if (specialite != 0) url += '&specialite=' + encodeURIComponent(specialite);
      if (typeRDV != 0) url += '&type=' + encodeURIComponent(typeRDV);
      if (nom.trim() !== '') url += '&nom=' + encodeURIComponent(nom);
      ajaxRequest('GET', url, displayAfficheMedecin);
});
}


function displayAfficheMedecin(response) {
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
      window.scrollTo(0,document.body.scrollHeight);
      
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
    } else {
      displayHeure(id_medecin, date);

    }
  });
}
function displayHeure($id_medecin, $date) {
  ajaxRequest('GET', './request.php/heure?id_medecin=' + $id_medecin + '&date=' + $date, function(response) {
    var rdvInfo = document.getElementById('info');
    rdvInfo.innerHTML = '';

    var rdvs = JSON.parse(response);
    rdvs = rdvs.filter(function(rdv) {
      return rdv.date_dispo !== null && rdv.date_dispo !== undefined && rdv.date_dispo !== '';
    });

    if (rdvs.length === 0) {
      var errorMessage = document.createElement('p');
      errorMessage.innerHTML = `<style>
        .alert{
            width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        </style>
        <div class="alert alert-danger" role="alert">
        Aucune heure disponible pour cette date
        </div>`;
      rdvInfo.appendChild(errorMessage);
    } else {
      var heureSelect = document.getElementById('heure');
      heureSelect.innerHTML = afficheHeure(rdvs);

      var rdvDiv = document.createElement('div');
      rdvDiv.innerHTML = `
        <style>
          .container {
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
          }

          form {
            text-align: center;
          }
        </style>
        <div class="container">
          <form id="heureForm">
            <h4>Vous avez choisi la date du</h4><br><h3>${dateComplete($date)}</h3>
            <div class="form-group">
              <label for="heure">Maintenant choisissez une heure :</label>
              <select class="form-control" id="heure" name="heure">
                <option value="0">Choisir une heure de rendez-vous</option>
              </select>
            </div>
            <button type="button" class="btn btn-info" id="btn_heure">Rechercher</button>
          </form>
        </div>`;
      rdvInfo.appendChild(rdvDiv);

      $('#btn_heure').on('click', function() {
        var error_date = document.getElementById('print');
        error_date.innerHTML = '';
        console.log($date);
        var heure = document.getElementById('heure').value;
        console.log(heure);
        if (heure == '0') {
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
        } else {
          
          ajaxRequest('POST', './request.php/rdv?id_client=' + encodeURIComponent(id) + '&id_medecin=' + encodeURIComponent($id_medecin) + '&date=' + encodeURIComponent($date) + '&heure=' + encodeURIComponent(heure));
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
          setTimeout(function() {
            document.location.href = 'index.html';
          }, 2000);
        }
      });
    }
  });
}




//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------PARTIE MEDECIN-----------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function displayMedecin(response) {
  var medecin = JSON.parse(response);
  var medecinInfo = document.getElementById('info');
  medecinInfo.innerHTML = '';
  var print = document.getElementById('print');
  print.innerHTML = '';
  if (typeof medecin === 'object' && medecin !== null) {
    var medecinDiv = document.createElement('div');
    medecinDiv.innerHTML = `<div class="card">
      <div class="card-body">
        <h5 class="card-title">${medecin.nom_medecin} ${medecin.prenom_medecin}</h5>
        <p class="card-text">${medecin.specialite_medecin}</p>
        <p class="card-text">${medecin.ville_cabinet}</p>
        <p class="card-text">${medecin.adresse_cabinet}</p>
        <p class="card-text">${medecin.code_postal_cabinet}</p>
        <p class="card-text">Téléphone: 0${medecin.telephone_cabinet}</p>
        <p class="card-text">${medecin.mail_medecin}</p>
        <button class="btn btn-warning" id="editButton">Modifier votre profile</button>
      </div>
    </div>`;
    medecinInfo.appendChild(medecinDiv);
    $('#editButton').on('click', function() {
      displayEditForm(medecin);
    });
  } else {
    console.error("La réponse du serveur n'est pas au format attendu.");
  }
}
function displayEditForm(client) {
  var cardBodyDiv = document.querySelector('.card-body');
  cardBodyDiv.innerHTML = `
    <form id="editForm">
    <div class="form-group">
        <label for="nom">Id:</label>
        <input type="text" id="id" name="id" value="${client.client_id}">
      </div>
      <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="${client.nom_client}">
      </div>
      <div class="form-group">
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="${client.prenom_client}">
      </div>
      <div class="form-group">
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" value="${client.telephone_client}">
      </div>
      <div class="form-group">
        <label for="mail">Mail:</label>
        <input type="text" id="mail" name="mail" value="${client.mail_client}">
      </div>
      <button class="btn btn-warning" id="editButton">Modifier votre profile</button>
    </form>
  `;
  $('#editButton').on('click', function(event) {
    event.preventDefault();
    //ajaxRequest('PUT', './request.php/update_client?client_id='+encodeURIComponent(client.client_id)+'&nom_client='+encodeURIComponent(client.nom_client)+'&prenom_client='+encodeURIComponent(client.prenom_client)+'&telephone_client='+encodeURIComponent(client.telephone_client)
    
    ajaxRequest('PUT', './request.php/update_client', function(response) {
      var successMessage = document.createElement('p');
      successMessage.innerHTML = `<style>
        .alert {
          width: 400px;
          margin: 0 auto;
          margin-top: 20px;
          text-align: center;
        }
      </style>
      <div class="alert alert-success" role="alert">
        Profile modifié
      </div>`;
      cardBodyDiv.appendChild(successMessage);
  },'prenom='+client.prenom_client +'&nom='+client.nom_client+'&tel='+ client.telephone_client);
});
}
function displayRdvShowMedecin(response) {
  var rdvInfo = document.getElementById('info');
  rdvInfo.innerHTML = '';

  var rdvs = JSON.parse(response);
  if (rdvs.length === 0) {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
      <div class="alert alert-danger" role="alert">
        Aucun rendez-vous trouvé
      </div>`;
    rdvInfo.appendChild(rdvDiv);
  } else {
    var rdvDiv = document.createElement('div');
    rdvDiv.innerHTML = `
    <div id="rdvDiv">
    <form id="rdvForm">
      <div class="form-group">
        <input type="text" class="form-control" id="rechercheRDV" placeholder="Recherche sur les noms et prénoms...">
      </div>
    </form>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Heure</th>
          <th scope="col">Client</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody id="rdvTableBody"></tbody>
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
        <td><button class="btn btn-danger btn_delete" data-id="${rdv.id_rdv}" >Supprimer</button></td>`;
      rdvTableBody.appendChild(rdvRow);
    });

    var rechercheRDV = document.getElementById('rechercheRDV'); // Placer la déclaration de rechercheRDV ici
    rechercheRDV.addEventListener('input', function() {
      var filterValue = this.value.toUpperCase();
      var rows = rdvTableBody.getElementsByTagName('tr');
      for (var i = 0; i < rows.length; i++) {
        var cols = rows[i].getElementsByTagName('td');
        var display = false;
        for (var j = 0; j < cols.length; j++) {
          var textValue = cols[j].textContent || cols[j].innerText;
          if (textValue.toUpperCase().indexOf(filterValue) > -1) {
            display = true;
            break;
          }
        }
        rows[i].style.display = display ? '' : 'none';
      }
    });

    rdvTableBody.addEventListener('click', function(event) {
      if (event.target.classList.contains('btn_delete')) {
        var id_rdv = event.target.getAttribute('data-id');
        deleteRDV(id_rdv);
        event.target.closest('tr').remove();
      }
    });

    var printDiv = document.getElementById('print');
    printDiv.innerHTML = '';
  }
}



function deleteRDV(id_rdv) {
  ajaxRequest('GET','./request.php/delete_rdv_medecin/?id_rdv='+encodeURIComponent(id_rdv),function(){
    var divSup = document.createElement('div')
    divSup.innerHTML = `Rdv supprimé`
  })
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
  var btnDate = document.getElementById('btn_date');
  btnDate.addEventListener('click', rdvClickListener);

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
          label {
            font-weight: bold;
          }
          .form-group {
            margin-bottom: 20px;
            text-align: center;
          }
          .from_submit {
            text-align: center;
          }
        </style>
        <div class="container">
        
          <form id="heureForm">
          <div class="form-group">
          <label for="heure">RDV pour le ${dateComplete(date)}</label>
          <input type="hidden" id="date" value="${date}">
        </div>
            <div class="form-group">
              <label for="heure">Heure debut:</label>
              <input type="time" class="form-control" id="heure_debut" min="8:00" max="12:00" value="08:00"  required >
              <label for="heure">Heure fin:</label>
              <input type="time" class="form-control" id="heure_fin" min="08:00" max="19:00" value="19:00" required >
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-info" id="btn_heure">Rechercher</button>
            </div>
            <label for="heure">Préférez-vous choisir une journée standard ?</label>
            <div class="form-group">
              
              <button type="button" class="btn btn-info" id="btn_standard">Journée Standard</button>
            </div>
          </form>
        </div>`;
      findRdv.appendChild(rdvDiv);
      $('#btn_heure').on('click', function(event) {
        event.preventDefault();
        var date = document.getElementById('date').value;
        var id = sessionStorage.getItem('id');
        var heure_debut = document.getElementById('heure_debut').value;
        var heure_fin = document.getElementById('heure_fin').value;
        console.log(date, heure_debut, heure_fin);
        ajaxRequest('POST','./request.php/heure_special?id_ref=' + encodeURIComponent(id) + '&date=' + encodeURIComponent(date) +'&heure_debut='+encodeURIComponent(heure_debut)+'&heure_fin='+encodeURIComponent(heure_fin));
        var successMessage = document.createElement('p');
        successMessage.innerHTML = `<style>
            .alert {
                width: 400px;
                margin: 0 auto;
                margin-top: 20px;
                text-align: center;
            }
            </style>
            <div class="alert alert-success" role="alert">
            Journée spécial prise 
            </div>`;
        findRdv.appendChild(successMessage);
        setTimeout(function(){
            document.location.href = 'index.html';
        }, 2000);
      });
    
    $('#btn_standard').on('click', function() {
        var date = document.getElementById('date').value;
        var id = sessionStorage.getItem('id');
        ajaxRequest('POST', './request.php/heure?id_ref=' + encodeURIComponent(id) + '&date=' + encodeURIComponent(date));
        var successMessage = document.createElement('p');
        successMessage.innerHTML = `<style>
            .alert {
                width: 400px;
                margin: 0 auto;
                margin-top: 20px;
                text-align: center;
            }
            </style>
            <div class="alert alert-success" role="alert">
            Journée standard prise 
            </div>`;
        findRdv.appendChild(successMessage);
        setTimeout(function(){
            document.location.href = 'index.html';
        }, 2000);
    });
  }
  }
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
    ajaxRequest('GET', './request.php/client/' + id, displayClient);
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
    ajaxRequest('GET', './request.php/medecin/' + id, displayMedecin);

  });

}
