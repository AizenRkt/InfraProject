CREATE DATABASE infraproject
\c

CREATE EXTENSION postgis;
CREATE EXTENSION postgis_topology;

-- district
SELECT * FROM district_analamange WHERE num_fiv IN (101, 102, 103, 105);

CREATE VIEW vue_district_tana AS
SELECT * FROM district_analamange
WHERE num_fiv IN (101, 102, 103, 105);

-- communes
SELECT * FROM communes_antananarivo WHERE num_fiv IN (101, 102, 103, 105);

CREATE VIEW vue_communes_tana AS
SELECT * FROM communes_antananarivo
WHERE num_fiv IN (101, 102, 103, 105);

-- tables principales
CREATE TABLE categorie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE type (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NOT NULL,
    categorie_id INTEGER NOT NULL,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE CASCADE
);

CREATE TABLE infrastructure (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    descriptif TEXT,
    type_id INTEGER NOT NULL,
    geom geometry(POINT, 4326),
    FOREIGN KEY (type_id) REFERENCES type(id) ON DELETE CASCADE
);

INSERT INTO categorie (nom) VALUES 
('Sante'),
('Education'),
('Administration'),
('Transport');

INSERT INTO type (nom, icon, categorie_id) VALUES
('Hopital', 'hospital.png',1),
('Centre de sante', 'cs.png',1),
('Pharmacie', 'pharmacy.png',1),
('Ecole', 'school.png',2),
('Universite', 'university.png',2),
('Mairie', 'townhall.png',3),
('Commissariat', 'police.png',3),
('Gare routiere', 'station.png',4),
('Aeroport', 'airport.png',4);