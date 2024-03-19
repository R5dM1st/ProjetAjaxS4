window.onload = () => {
    var prenom, nom;

    if (localStorage.prenom != null) {
        prenom = localStorage.prenom;
    } else {
        prenom = prompt("Entrez votre prénom");
        localStorage.prenom = prenom;
    }
    
    if (localStorage.nom != null) {
        nom = localStorage.nom;
    } else {
        nom = prompt("Entrez votre nom");
        localStorage.nom = nom;
    }

    var bonjourDiv = document.querySelector('#profile');
    bonjourDiv.textContent = 'Bonjour ' + prenom + ' ' + nom;
    var profileLink = document.querySelector('#profile-link');
    var vertDiv = document.createElement('div');
    var rougeDiv = document.createElement('div');

    vertDiv.id = 'vert';
    vertDiv.style.width = '15px';
    vertDiv.style.height = '15px';
    vertDiv.style.backgroundColor = 'green';
    vertDiv.style.borderRadius = '50%';
    vertDiv.style.display = 'inline-block';

    rougeDiv.id = 'rouge';
    rougeDiv.style.width = '15px';
    rougeDiv.style.height = '15px';
    rougeDiv.style.backgroundColor = 'red';
    rougeDiv.style.borderRadius = '50%';
    rougeDiv.style.display = 'inline-block';

    if (localStorage.prenom != null && localStorage.nom != null) {
        profileLink.innerHTML = '<a href="home.php"><h5>' + localStorage.prenom + ' ' + localStorage.nom + '</h5></a>';
        profileLink.appendChild(vertDiv);
    } else {
        profileLink.appendChild(rougeDiv);
    }
}

function supprimerStockageLocal() {
    localStorage.removeItem('prenom');
    localStorage.removeItem('nom');
    window.location.reload();
}
