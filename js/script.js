function profileUtilisateur() {
    const profile = document.getElementById('profile');
    const circleContainer = document.getElementById('circleContainer');

    const circleStyles = document.createElement('style');
    circleStyles.innerHTML = `
        #vert, #rouge {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
        }
        #vert {
            background-color: green;
        }
        #rouge {
            background-color: red;
        }
    `;
    document.head.appendChild(circleStyles);

    const prenom = sessionStorage.getItem('prenom');
    const nom = sessionStorage.getItem('nom');
    if (prenom && nom) {
        const userInfo = document.createElement('div');
        userInfo.innerHTML = `<h5>${prenom} ${nom}</h5>`;
        profile.appendChild(userInfo);

        const greenCircle = document.createElement('div');
        greenCircle.id = 'vert';
        circleContainer.appendChild(greenCircle);

        greenCircle.addEventListener('click', () => {
            sessionStorage.clear();
            location.reload(); 
        });
    } else {
        const redCircle = document.createElement('div');
        redCircle.id = 'rouge';
        circleContainer.appendChild(redCircle);
        redCircle.addEventListener('click', () => {
            const prenom = prompt('Entrez votre prénom:');
            const nom = prompt('Entrez votre nom:');
            if (prenom && nom) {
                sessionStorage.setItem('prenom', prenom);
                sessionStorage.setItem('nom', nom);
                location.reload(); 
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', profileUtilisateur);
