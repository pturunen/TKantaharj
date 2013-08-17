-- Kayttaja-taulun luonti
CREATE TABLE rekisteri (
  tunnus varchar(10) PRIMARY KEY,
  salasana varchar(18),
  luontipvm date,
  sukupuoli vachar(1),
  pituus int,
  paino int,
  ika int
);





