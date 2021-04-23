INSERT INTO LesSpectacles (noSpec, nomS)
SELECT noSpec,nomS FROM theatre.LesSpectacles ;

INSERT INTO LesRepresentations (dateRep, noSpec)
SELECT dateRep,noSpec FROM theatre.LesRepresentations ;

INSERT INTO LesCategories (nomC, prix)
SELECT nomC,prix FROM theatre.LesCategories ;

INSERT INTO LesZones (noZone, nomC)
SELECT noZone,nomC FROM theatre.LesZones ;

INSERT INTO LesPlaces (noPlace, noRang, noZone)
SELECT distinct noPlace,noRang,noZone FROM theatre.LesPlaces ; 

INSERT INTO LesDossiers (noDossier, montant)
SELECT noDossier , sum(prix) as montant FROM theatre.LesZones natural join theatre.LesCategories natural join theatre.LesPlaces 
natural join theatre.LesTickets group by noDossier order by noDossier;

INSERT INTO LesTickets (noSerie, noSpec,dateRep,noPlace,noRang,dateEmiss,noDossier)
SELECT * FROM theatre.LesTickets ; 






