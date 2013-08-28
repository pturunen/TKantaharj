INSERT INTO rekisteri (tunnus,salasana,luontipvm,sukupuoli,pituus,paino,ika)
values ('pallero','opensource',DATE(NOW()),'f',180,30,80);

INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite)
values (DATE(NOW()),'pallero',45,'uusi elämä');

INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite)
values ('2013-08-10','pallero',100,'joopa joo');

INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite)
values ('2013-08-11','pallero',99,'loistava päivä');

INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite)
values ('2013-08-28','pallero',30,'rahat loppu');


INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('silakka','teollisuus','kalat','kerran viikossa');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','silakka','kj/100 g','491');

INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('kampela','teollisuus','kalat','paljon proteiinia');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','kampela','kj/100 g','403');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('natrium','kampela','mg/100 g','54.0');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('kalium','kampela','mg/100 g','270.0');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('fosfori','kampela','mg/100 g','180.0');

INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('grillikylki','teollisuus','lihavalmisteet','luomu');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','grillikylki','kj/100 g','3000');

INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('rasvaton maito','teollisuus','maidot','rasvaa alle 2%');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','rasvaton maito','kj/100 g','175');
INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('vuohen maito','teollisuus','maidot','rasvaa yli 2%');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','vuohen maito','kj/100 g','275');

INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('terni maito','tuore','maidot','käsittelemätön');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','terni maito','kj/100 g','375');
INSERT INTO raakaaine (nimi,valmistaja,luokka,selite)
values ('täysmaito laktoositon','teollisuus','maidot','rasvaa yli 3%');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('energia','täysmaito laktoositon','kj/100 g','218');

INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('hiilihydraatti','täysmaito laktoositon','g/100 g','3.1');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('rasva','täysmaito laktoositon','g/100 g','3.0');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('proteiini','täysmaito laktoositon','g/100 g','3.2');
INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara)
values ('laktoosi','täysmaito laktoositon','g/100 g','0.0');

INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('natrium','täysmaito laktoositon','mg/100 g','100.0');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('suola','täysmaito laktoositon','mg/100 g','112.1');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('kalsium','täysmaito laktoositon','mg/100 g','120.0');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('fosfori','täysmaito laktoositon','mg/100 g','90.0');
INSERT INTO kivhivenaineet (ravintotekija,nimi,mittayksikko,maara)
values ('seleeni','täysmaito laktoositon','ug/100 g','2.9');



