function dateComplete(date){
    var date = new Date(date);
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
}
function transformdateCompete(dateString) {
    if (!dateString) {
        return ''; 
    }
    
    var date = new Date(dateString);
    if (isNaN(date.getTime())) {
        return '';
    }
    
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var formattedMonth = (month < 10) ? '0' + month : month;
    var formattedDay = (day < 10) ? '0' + day : day;
    
    return date.getFullYear() + '-' + formattedMonth + '-' + formattedDay;
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
  function affichedate(response) {
    var dates = JSON.parse(response);
    var optionsHtml = '';
    optionsHtml += '<option value="0">Choisir une date de rendez-vous</option>';
    for (var i = 0; i < dates.length; i++) {
      var date=dateComplete((dates[i].date_dispo));
      optionsHtml += '<option value="' + dates[i].date_dispo + '">' + date + '</option>';
    }
    return optionsHtml;
  }