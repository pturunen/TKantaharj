-- Kayttaja-taulun luonti
CREATE TABLE rekisteri (
  id serial PRIMARY KEY,
  nimi varchar UNIQUE,
  salasana varchar
);



