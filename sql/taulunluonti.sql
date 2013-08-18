-- Kayttaja-taulun luonti
CREATE TABLE rekisteri (
  id serial PRIMARY KEY,
  tunnus varchar(10) NOT NULL UNIQUE,
  salasana varchar(18) NOT NULL,
  luontipvm date,
  sukupuoli varchar(1),
  pituus int,
  paino int,
  ika int
);

-- paivakirjan taulun luonti
CREATE TABLE tapahtumapaiva (
  id serial PRIMARY KEY,
  paiva date NOT NULL,
  tunnus varchar(10) REFERENCES rekisteri(tunnus) ON DELETE CASCADE,
  paino int,
  selite varchar(50)
);

-- raakaaine taulun luonti
CREATE TABLE raakaaine (
  nimi varchar(40) PRIMARY KEY,
  valmistaja varchar,
  luokka varchar,
  selite varchar(50)
);

-- paivakirjan rivin luonti
CREATE TABLE energiansaanti (
  id serial  PRIMARY KEY,
  tapid integer REFERENCES tapahtumapaiva(id) ON DELETE CASCADE,
  ruoka varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  maara integer
);

-- perusravintoaine taulun luonti
CREATE TABLE perusravintoaineet (
  id serial ,
  ravintotekija varchar(30) NOT NULL,
  nimi varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  mittayksikko varchar(4),
  maara integer,
  PRIMARY KEY(id,ravintotekija)
);

-- kivennaisjahivenaineet taulun luonti
CREATE TABLE kivhivenaineet (
  id serial ,
  ravintotekija varchar(30) NOT NULL,
  nimi varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  mittayksikko varchar(4),
  maara integer,
  PRIMARY KEY(id,ravintotekija)
);
