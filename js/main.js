if (sessionStorage.getItem('profile') == '1' || sessionStorage.getItem('profile') == '2') {
    document.getElementById('main').remove();

}

if (sessionStorage.getItem('profile') == '1') {
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
            background-color: #b34151;
        }
        #info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }


           
        </style>
        <button id="all_button" class="btn btn-light">Mes Informations</button>`;
        
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-light">Mes Rendez-vous</button>
        <button id="find_rdv_button" class="btn btn-light">Trouver <br>un<br> Rendez-vous</button>
        <div id="last_date"></div>`;
        
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
        <button id="all_button" class="btn btn-light">Mes Informations</button>
        <div id="last_date"></div>`;

        
    
    var rdv = document.getElementById('rdv');
    rdv.innerHTML = `
        <button id="show_rdv_button" class="btn btn-light">Mes Rendez-vous</button>
        <button id="add_rdv_button" class="btn btn-light">Ajouter <br>des heures<br>de Rendez-vous</button>`;
}

