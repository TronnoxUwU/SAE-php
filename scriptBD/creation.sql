create type ROLES as ENUM('Administrateur', 'Client');

create table PERSONNE {
    EMailPersonne VARCHAR(128) PRIMARY KEY,
    NomPersone VARCHAR(64),
    PrenomPersone VARCHAR(64),
    TelPersone VARCHAR(17),
    MotDePasse VARCHAR(256),
    Role ROLES
};

create table REGION {
    CodeRegion INT PRIMARY KEY,
    NomRegion VARCHAR(128)
};

create table DEPARTEMENT {
    CodeDepartement INT,
    CodeRegion INT,
    NomDepartement VARCHAR(128),
    PRIMARY KEY (CodeDepartement, CodeRegion)
};

create table COMMUNE {
    CodeCommune INT,
    CodeDepartement INT,
    CodeRegion INT,
    NomCommune VARCHAR(128),
    PRIMARY KEY (CodeCommune, CodeDepartement, CodeRegion)
};

create table RESTAURANT {
    OsmID INT PRIMARY KEY,
    Longitude FLOAT,
    Latitude FLOAT,
    CodeCommune INT,
    CodeDepartement INT,
    CodeRegion INT,
    NomRestaurant VARCHAR(128),
    SiteWeb VARCHAR(128),
    Facebook VARCHAR(128),
    TelRestaurant VARCHAR(17),
    NbEtoileMichelin INT,
    Capacite INT,
    Fumeur BOOLEAN,
    Drive BOOLEAN,
    AEmporter BOOLEAN,
    Livraison BOOLEAN,
    Vegetarien BOOLEAN,
    HorrairesOuverture VARCHAR(128)
};

ALTER TABLE RESTAURANT ADD FOREIGN KEY (CodeCommune) REFERENCES COMMUNE(CodeCommune);
ALTER TABLE RESTAURANT ADD FOREIGN KEY (CodeDepartement) REFERENCES COMMUNE(CodeDepartement);
ALTER TABLE RESTAURANT ADD FOREIGN KEY (CodeRegion) REFERENCES COMMUNE(CodeRegion);

create table FAVORI {
    EMailPersonne VARCHAR(128),
    OsmID INT,
    PRIMARY KEY (EMailPersonne, OsmID)
};

ALTER TABLE FAVORI ADD FOREIGN KEY (EMailPersonne) REFERENCES PERSONNE(EMailPersonne);
ALTER TABLE FAVORI ADD FOREIGN KEY (OsmID) REFERENCES RESTAURANT(OsmID);

create table CUISINE {
    NomCuisine VARCHAR(64) PRIMARY KEY
};

create table PREFERER {
    EMailPersonne VARCHAR(128),
    NomCuisine VARCHAR(64),
    PRIMARY KEY (EMailPersonne, NomCuisine)
};

ALTER TABLE PREFERER ADD FOREIGN KEY (EMailPersonne) REFERENCES PERSONNE(EMailPersonne);
ALTER TABLE PREFERER ADD FOREIGN KEY (NomCuisine) REFERENCES CUISINE(NomCuisine);

create table PREPARER {
    OsmID INT,
    NomCuisine VARCHAR(64),
    PRIMARY KEY (OsmID, NomCuisine)
};

ALTER TABLE PREPARER ADD FOREIGN KEY (OsmID) REFERENCES RESTAURANT(OsmID);
ALTER TABLE PREPARER ADD FOREIGN KEY (NomCuisine) REFERENCES CUISINE(NomCuisine);

create table NOTER {
    EMailPersonne VARCHAR(128),
    OsmID INT,
    Note INT,
    Commentaire VARCHAR(512),
    Date DATE,
    PRIMARY KEY (EMailPersonne, OsmID)
};

ALTER TABLE FAVORI ADD FOREIGN KEY (EMailPersonne) REFERENCES PERSONNE(EMailPersonne);
ALTER TABLE FAVORI ADD FOREIGN KEY (OsmID) REFERENCES RESTAURANT(OsmID);
