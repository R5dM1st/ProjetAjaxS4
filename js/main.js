if (sessionStorage.getItem('profile') == '1' || sessionStorage.getItem('profile') == '2') {
    document.getElementById('main').remove();
}

if (sessionStorage.getItem('profile') == '1' || sessionStorage.getItem('profile') == '2') {
    var all_info = document.getElementById('all_info');
    all_info.innerHTML = `
        <style>
        #container {
            display: flex;
            flex-direction: column;
            align-items: center;

        }
        #info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }


           
        </style>
        <button id="all_button" class="btn btn-primary">Mes Informations</button>`;
        
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-primary">Mes Rendez-vous</button>
        <button id="find_rdv_button" class="btn btn-primary">Trouver <br>un<br> Rendez-vous</button>`;
}

if (sessionStorage.getItem('profile') == '2') {
    var all_info = document.getElementById('all_info');
    all_info.innerHTML = `
        <style>
            #container {
                display: flex;
                flex-direction: column;
                align-items: center;

            }
            button {
                margin: 20px;
            }
            #info {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 30px;
            }


           
        </style>
        <button id="all_button" class="btn btn-danger">Mes Informations</button>`;
        
    
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-danger">Mes Rendez-vous</button>
        <button id="add_rdv_button" class="btn btn-danger">Ajouter des heures <br>de Rendez-vous</button>`;
}

