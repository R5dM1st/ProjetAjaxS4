--le mot de passe pour tout le monde est "123" pour que ce soit plus simple


-- Insertion de clients
INSERT INTO client (nom_client, prenom_client, telephone_client, mail_client, mot_de_passe_client)
VALUES
    ('Doe', 'John', 123456789, 'john.doe@email.com', '$2y$12$GNMISDtdQrsPAEIz7wm2YO9p8jrf3ySU0dzpzIMRKIphAhpz4GVzK'),
    ('Smith', 'Jane', 987654321, 'jane.smith@email.com', '$2y$12$GNMISDtdQrsPAEIz7wm2YO9p8jrf3ySU0dzpzIMRKIphAhpz4GVzK'),
    ('Brown', 'Robert', 555555555, 'robert.brown@email.com', '$2y$12$GNMISDtdQrsPAEIz7wm2YO9p8jrf3ySU0dzpzIMRKIphAhpz4GVzK');


-- Insertion de médecins
INSERT INTO medecin (
    specialite_medecin, nom_medecin, prenom_medecin, mail_medecin, mdp_medecin,
    adresse_cabinet, ville_cabinet, code_postal_cabinet, telephone_cabinet, id_type_demande)
VALUES
    ('Cardiologue', 'Dupont', 'Pierre', 'pierre.dupont@email.com', '$2y$12$GNMISDtdQrsPAEIz7wm2YO9p8jrf3ySU0dzpzIMRKIphAhpz4GVzK','123 Rue du Cabinet', 'Paris', 75000, 123456789, 1),
    ('Dermatologue', 'Martin', 'Sophie', 'sophie.martin@email.com', '$2y$12$GNMISDtdQrsPAEIz7wm2YO9p8jrf3ySU0dzpzIMRKIphAhpz4GVzK','456 Avenue du Cabinet', 'Lyon', 69000, 987654321, 2);

-- Insertion d'heures disponibles
INSERT INTO heuredisponible (id_medecin, date_dispo, heure_dispo, dispo)
VALUES
    (1, '2024-01-15', '09:00:00', true),
    (1, '2024-01-15', '10:30:00', true),
    (2, '2024-01-16', '14:00:00', true);

-- Insertion de rendez-vous
INSERT INTO rdv (id_medecin, id_client, id_heure)
VALUES
    (1, 1, 1),
    (2, 2, 3);
