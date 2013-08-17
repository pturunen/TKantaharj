-- Kayttaja-taulun luonti
CREATE TABLE rekisteri (
  tunnus varchar(10) PRIMARY KEY,
  salasana varchar(18),
  luontipvm date,
  sukupuoli vachar(1) DEFAULT f,
  pituus int(3),
  paino int(3),
  ika int(3)
);



