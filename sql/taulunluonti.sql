-- Kayttaja-taulun luonti
CREATE TABLE rekisteri (
  tunnus varchar(10) PRIMARY KEY,
  salasana varchar(18),
  luontipvm date,
  sukupuoli varchar(1),
  pituus int,
  paino int,
  ika int
);

-- paivakirjan taulun luonti
CREATE TABLE tapahtumapaiva (
  paiva date PRIMARY KEY,
  tunnus varchar(10) REFERENCES rekisteri(tunnus) ON DELETE CASCADE,
  paino int,
  selite varchar(50)
);

-- raakaaine taulun luonti
CREATE TABLE raakaaine (
  nimi varchar(40) NOT NULL,
  valmistaja varchar,
  luokka varchar,
  selite varchar(50),
  PRIMARY KEY(nimi,valmistaja)
);

-- paivakirjan rivin luonti
CREATE TABLE energiansaanti (
  id serial  PRIMARY KEY,
  paiva date REFERENCES tapahtumapaiva(paiva) ON DELETE CASCADE,
  ruoka varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  valmistaja varchar REFERENCES raakaaine(valmistaja) ON DELETE CASCADE,
  maara integer
);

-- perusravintoaine taulun luonti
CREATE TABLE perusravintoaineet (
  id serial  PRIMARY KEY,
  nimi varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  mittayksikko varchar(4),
  maara integer
);

-- kivennaisjahivenaineet taulun luonti
CREATE TABLE kivhivenaineet (
  id serial  PRIMARY KEY,
  nimi varchar(40) REFERENCES raakaaine(nimi) ON DELETE CASCADE,
  mittayksikko varchar(4),
  maara integer
);
