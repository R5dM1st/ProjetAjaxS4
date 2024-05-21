Bienvenue sur notre site de EPHealth.
Vous avez besoin de soin ? venez prendre RDV sur notre site web. 
Vous avez besoin de visibilité entant que medecin ? venez poster des RDV sur notre site web.

pour utiliser notre site web vous aurez besoin de PostgreSQL 15.6 et de Apache/2.4.57

Voici l'arborescence de notre projet:
/EPHealth_website
│
├── /css
│   ├── accueil.css
│
├── /js
│   ├── main.js
│   ├── ajax.js
|   ├── script.js
|   ├── main.js
|   ├── login&register.js
|   ├── session.js
│
├── /images
│   ├── icon_medecin.png
│   ├── iconV2.png
│
├── /BDD
│   ├── constants.php
|   ├── BDD.sql
|   ├── insertBDD.sql
│
├── /fonctionphp
│   ├── connectBDD.php
│   ├── functionMedecin.php
│   ├── functionClient.php
│   ├── functionRDV.php
│   ├── functionMedecin.php
│   ├── functionHeure.php
│   ├── functionMedecin.php
│   ├── main.php
│
├── index.html
├── request.php
├── database.php
│
└── README.md

n'oubliez pas de inseret la BDD.sql : 
psql -U postgres -d votre_base -f BDD.sql
puis: insert_BDD.sql



fait par Emile Duplais et Pierre Zboril
