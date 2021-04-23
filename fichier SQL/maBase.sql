
SELECT table_name FROM user_tables

CREATE TABLE LesSpectacles  
   (
      noSpec int , nomS varchar(30) 
      , CONSTRAINT PK_Spectacles PRIMARY KEY  (noSpec)
      , CONSTRAINT ck1_LesSpectacles CHECK (noSpec>0)
   )  
;

CREATE TABLE LesRepresentations  
   (
      dateRep date, noSpec int 
      , CONSTRAINT PK0_Representations PRIMARY KEY  (dateRep)
      , CONSTRAINT FK0_Representations FOREIGN KEY (noSpec)
        REFERENCES LesSpectacles (noSpec)
        ON DELETE CASCADE
     ,  CONSTRAINT ck1_LesRepresentations CHECK (noSpec>0)
   )
;

CREATE TABLE LesCategories  
   (
      nomC varchar(20), prix real 
      , CONSTRAINT PK_Categories PRIMARY KEY  (nomC)
      , CONSTRAINT ck1_LesCategories CHECK (prix>0) 
      , CONSTRAINT ck2_LesCategories CHECK (nomC in ('orchestre', '1er balcon','2nd balcon', 'poulailler'))
   )  
;


CREATE TABLE LesZones 
   (
      noZone int , nomC varchar(20)
      , CONSTRAINT PK_Zones PRIMARY KEY  (noZone)
      , CONSTRAINT FK_Zones FOREIGN KEY (nomC)
        REFERENCES LesCategories (nomC) 
        ON DELETE CASCADE
      , CONSTRAINT ck1_LesZones CHECK (noZone>0)
   )
;


CREATE TABLE LesPlaces 
   (
      noPlace int , noRang int  ,noZone int 
      , CONSTRAINT PK_Places PRIMARY KEY  (noPlace,noRang)
      , CONSTRAINT FK_Places FOREIGN KEY (noZone)
        REFERENCES LesZones (noZone)
        ON DELETE CASCADE
      , CONSTRAINT ck1_LesPlaces CHECK (noPlace>0)
      , CONSTRAINT ck2_LesPlaces CHECK (noRang>0)
      , CONSTRAINT ck3_LesPlaces CHECK (noZone>0)
   )
;

CREATE TABLE LesDossiers  
   (
      noDossier int , montant int 
      , CONSTRAINT PK_Dossier PRIMARY KEY  (noDossier)  
      , CONSTRAINT ck1_LesDossiers CHECK(noDossier>0)    
   )
;


CREATE TABLE LesTickets  
   (
      noSerie int , noSpec int ,dateRep date,noPlace int ,noRang int ,dateEmiss date,noDossier int 
      , CONSTRAINT PK_Tickets PRIMARY KEY  (noSerie)
      , CONSTRAINT UK_Tickets UNIQUE (noSpec,dateRep,noPlace,noRang)   
      , CONSTRAINT FK1_Tickets FOREIGN KEY (noPlace,noRang)
        REFERENCES LesPlaces (noPlace,noRang)
        ON DELETE CASCADE
      , CONSTRAINT FK2_Tickets FOREIGN KEY (noDossier)
        REFERENCES LesDossiers (noDossier)
        ON DELETE CASCADE
      , CONSTRAINT ck1_LesTickets CHECK (dateEmiss < dateRep)
	  , CONSTRAINT ck2_LesTickets CHECK (noSerie > 0)
	  , CONSTRAINT ck3_LesTickets CHECK (noSpec > 0)
	  , CONSTRAINT ck4_LesTickets CHECK (noPlace > 0)
	  ,	CONSTRAINT ck5_LesTickets CHECK (noRang > 0)
	  ,	CONSTRAINT ck6_LesTickets CHECK (noDossier > 0)
   )
;




