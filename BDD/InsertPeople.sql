-- Table client
CREATE TABLE client (
    client_id SERIAL PRIMARY KEY NOT NULL,
    nom_client character varying(100) NOT NULL,
    prenom_client character varying(100) NOT NULL,
    telephone_client integer NOT NULL,
    mail_client character varying(100) NOT NULL,
    mot_de_passe_client character varying(100) NOT NULL
);

-- Table typedemande
CREATE TABLE typedemande (
    id_type_demande SERIAL PRIMARY KEY NOT NULL,
    nom_type_demande character varying(100) NOT NULL
);

-- Insertion de données dans la table typedemande
INSERT INTO typedemande (nom_type_demande) VALUES
    ('Consultation'),
    ('Urgence'),
    ('Visite à domicile');

-- Table medecin
CREATE TABLE medecin (
    id_medecin SERIAL PRIMARY KEY NOT NULL,
    specialite_medecin character varying(100) NOT NULL,
    nom_medecin character varying(100) NOT NULL,
    prenom_medecin character varying(100) NOT NULL,
    mail_medecin character varying(100) NOT NULL,
    mdp_medecin character varying(100) NOT NULL,
    adresse_cabinet character varying(100) NOT NULL,
    ville_cabinet character varying(100) NOT NULL,
    code_postal_cabinet integer NOT NULL,
    telephone_cabinet integer NOT NULL,
    id_type_demande INT REFERENCES typedemande(id_type_demande)
);

-- Table heuredisponible
CREATE TABLE heuredisponible (
    id_heure SERIAL PRIMARY KEY NOT NULL,
    id_medecin integer REFERENCES medecin(id_medecin),
    date_dispo date NOT NULL,
    heure_dispo time without time zone NOT NULL,
    dispo boolean
);

-- Table rdv
CREATE TABLE rdv (
    id_rdv SERIAL PRIMARY KEY NOT NULL,
    id_medecin integer REFERENCES medecin(id_medecin),
    id_client integer REFERENCES client(client_id),
    id_heure integer REFERENCES heuredisponible(id_heure)
);
