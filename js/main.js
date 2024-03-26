if (sessionStorage.getItem('profile') == '1' || sessionStorage.getItem('profile') == '2') {
    document.getElementById('main').remove();
}

if (sessionStorage.getItem('profile') === '1') {
    var all_info = document.getElementById('all_info');
    all_info.innerHTML = `
        <style>
            #container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            button {
                margin: 10px;
            }
            #info {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 100px;
            }


           
        </style>
        <button id="all_button" class="btn btn-primary">Mes Informations</button>`;
        
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-primary">Mes Rendez-vous</button>
        <button id="find_rdv_button" class="btn btn-primary">Ajouter un Rendez-vous</button>`;
}

if (sessionStorage.getItem('profile') === '2') {
    var all_info = document.getElementById('all_info');
    all_info.innerHTML = `<button id="all_button" class="btn btn-primary">Mes Informations</button>`;
    
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-primary">Mes Rendez-vous</button>
        <button id="add_rdv_button" class="btn btn-primary">Ajouter des heures de Rendez-vous</button>`;
}
