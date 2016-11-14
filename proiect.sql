-- ex 1) folderul unde vor fi incarcate fisierele CSV
DROP DIRECTORY CSV 
/
CREATE DIRECTORY CSV AS 'C:\xampp\htdocs\implementare\upload'; 
GRANT READ ON DIRECTORY CSV TO PUBLIC; 
GRANT WRITE ON DIRECTORY CSV TO PUBLIC;
/




-- ex 7) doua obiect + doua colectii
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana
DROP TYPE TabelaParole force;
DROP TYPE infoModificari force;
DROP TYPE TabelaIstoricLogin force;
DROP TYPE istoricLogin force;
/
CREATE OR REPLACE TYPE infoModificari AS OBJECT
(
   pid         int,
   parola     varchar(64)
);
/
CREATE OR REPLACE TYPE istoricLogin AS OBJECT
(
   iid         int,
   browser     varchar(500),
   ip		   varchar(50),
   dataLogare  varchar(50)
);
/
CREATE OR REPLACE TYPE TabelaIstoricLogin AS TABLE OF istoricLogin;
/
CREATE OR REPLACE TYPE TabelaParole AS TABLE OF infoModificari;
/





-- codul de creare al tabelelor
DROP TABLE continent;
drop table grupareparole;
drop table userpasswords;
drop table utilizatori;
/
create table continent
(
	codContinent Number(2),
	numeContinent varchar2(50),
	primary key (codContinent)
);
/
create table grupareparole
(
	codGrupare number(2),
	tarieParola varchar2(50) not null,
	frecventaUtilizare varchar2(50) not null,
	domeniuSite varchar2(50) not null
);
/
create table userpasswords
(
	pid number(6),
	userID number(10) not null,
	titluParola varchar(50) not null,
	cont varchar(50) not null,
	parola varchar(50) not null,
	AdresaWeb  varchar2(150) not null,
	dataAdaugare date not null,
	timpMaximDeValabilitate number(10) not null,
	statusParola number(10),
	Comentarii varchar2(500) not null,
	codGrupare number(2),
	primary key (pid)
);
/
create table utilizatori
(
	userid number(6),
	username varchar(25) NOT NULL,
	parola TabelaParole,
	nume varchar2(30)  not null,
	prenume varchar2(30) not null,
	email varchar2(150) not null,
	codPostal number(4) not null,
	dataCreareCont date not null,
	avatar varchar2(200),
	codContinent NUMBER(1) not null,
	istoricLogariU TabelaIstoricLogin,
	CONSTRAINT PK_utilizatori primary key(userid),
	CONSTRAINT UQ_utilizatori unique(username),
	CONSTRAINT uq_email unique(email)
)NESTED TABLE parola STORE AS customer_passwords,
 NESTED TABLE istoricLogariU STORE AS customer_istoric;
 /
 
 
 
 
-- ex 5) trigare pentru auto-increment inregistrare utilizator nou + autoincrement adaugare parola
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana
DROP SEQUENCE utilizatori_seq;
/
CREATE SEQUENCE utilizatori_seq;
/
CREATE OR REPLACE TRIGGER trig_utilizaReg 
BEFORE INSERT ON utilizatori 
FOR EACH ROW
BEGIN
  SELECT utilizatori_seq.NEXTVAL
  INTO   :new.userid
  FROM   dual;
END;
/
DROP SEQUENCE parola_seq;
/
CREATE SEQUENCE parola_seq;
/
CREATE OR REPLACE TRIGGER trig_utilizaPw 
BEFORE INSERT ON userpasswords 
FOR EACH ROW
BEGIN
  SELECT parola_seq.NEXTVAL
  INTO   :new.pid
  FROM   dual;
END;
/



-- codul pentru completarea tabelelor
INSERT INTO grupareparole  VALUES (0, 'slaba', 'zilnic', 'social')
/
INSERT INTO grupareparole VALUES (1, 'slaba', 'zilnic', 'fun')
/
INSERT INTO grupareparole values  (2, 'slaba', 'zilnic', 'shopping')
/
INSERT INTO grupareparole values  (3, 'slaba', 'zilnic', 'educativ')
/
INSERT INTO grupareparole values  (4, 'slaba', 'saptamanal', 'social')
/
INSERT INTO grupareparole values (5, 'slaba', 'saptamanal', 'fun')
/
INSERT INTO grupareparole values (6, 'slaba', 'saptamanal', 'shopping')
/
INSERT INTO grupareparole values (7, 'slaba', 'saptamanal', 'educativ')
/
INSERT INTO grupareparole values (8, 'slaba', 'lunar', 'social')
/
INSERT INTO grupareparole values (9, 'slaba', 'lunar', 'fun')
/
INSERT INTO grupareparole values (10, 'slaba', 'lunar', 'shopping')
/
INSERT INTO grupareparole values (11, 'slaba', 'lunar', 'educativ')
/
INSERT INTO grupareparole values (12, 'medie', 'zilnic', 'social')
/
INSERT INTO grupareparole values (13, 'medie', 'zilnic', 'fun')
/
INSERT INTO grupareparole values (14, 'medie', 'zilnic', 'shopping')
/
INSERT INTO grupareparole values (15, 'medie', 'zilnic', 'educativ')
/
INSERT INTO grupareparole values (16, 'medie', 'saptamanal', 'social')
/
INSERT INTO grupareparole values  (17, 'medie', 'saptamanal', 'fun')
/
INSERT INTO grupareparole values (18, 'medie', 'saptamanal', 'shopping')
/
INSERT INTO grupareparole values (19, 'medie', 'saptamanal', 'educativ')
/
INSERT INTO grupareparole values (20, 'medie', 'lunar', 'social')
/
INSERT INTO grupareparole values (21, 'medie', 'lunar', 'fun')
/
INSERT INTO grupareparole values (22, 'medie', 'lunar', 'shopping')
/
INSERT INTO grupareparole values (23, 'medie', 'lunar', 'educativ')
/
INSERT INTO grupareparole values (24, 'puternica', 'zilnic', 'social')
/
INSERT INTO grupareparole values (25, 'puternica', 'zilnic', 'fun')
/
INSERT INTO grupareparole values (26, 'puternica', 'zilnic', 'shopping')
/
INSERT INTO grupareparole values (27, 'puternica', 'zilnic', 'educativ')
/
INSERT INTO grupareparole values (28, 'puternica', 'saptamanal', 'social')
/
INSERT INTO grupareparole values (29, 'puternica', 'saptamanal', 'fun')
/
INSERT INTO grupareparole values (30, 'puternica', 'saptamanal', 'shopping')
/
INSERT INTO grupareparole values (31, 'puternica', 'saptamanal', 'educativ')
/
INSERT INTO grupareparole values (32, 'puternica', 'lunar', 'social')
/
INSERT INTO grupareparole values (33, 'puternica', 'lunar', 'fun')
/
INSERT INTO grupareparole values (34, 'puternica', 'lunar', 'shopping')
/
INSERT INTO grupareparole values  (35, 'puternica', 'lunar', 'educativ');
/
--bloc de inserare pe tabela Continent
BEGIN
  INSERT INTO Continent (codContinent, numeContinent) VALUES (0,'Africa');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (1,'America de Nord');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (2,'America de Sud');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (3,'Antarctica');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (4,'Asia');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (5,'Australia');
  INSERT INTO Continent (codContinent, numeContinent) VALUES (6,'Europa');
END;
/
--bloc de inserare pe tabela Utilizatori
DECLARE
  v_userid NUMBER(5) :=0 ;
  v_username VARCHAR2(25);
  v_parola VARCHAR2(64);
  v_nume VARCHAR2(30);
  v_prenume VARCHAR2(30);
  v_email VARCHAR2(50);
  v_codContinent NUMBER(5);
BEGIN
  FOR v_userid in 1..998
	LOOP
	  v_username := DBMS_RANDOM.STRING('A',25);
	  v_parola := DBMS_RANDOM.STRING('A',64);
	  v_nume := DBMS_RANDOM.STRING('U',30);
	  v_prenume := DBMS_RANDOM.STRING('U',30);
	  v_email := DBMS_RANDOM.STRING('A',50);
	  v_codContinent := TRUNC(SYS.DBMS_RANDOM.VALUE(0,6),0);
	  INSERT INTO utilizatori 
		VALUES (null, v_username,TabelaParole(infoModificari(1,v_parola)), v_nume, v_prenume, v_email, 1234, SYSDATE-DBMS_RANDOM.VALUE(0,500), null,v_codContinent,TabelaIstoricLogin(istoricLogin(1,'am creat contul','ip',(sysdate||''))));
	END LOOP;
END;
/
--cu aceasta inregistrare vom testa
insert INTO utilizatori 
VALUES (null, 'stefanuca', TabelaParole(infoModificari(1,'a80b568a237f50391d2f1f97beaf99564e33d2e1c8a2e5cac21ceda701570312')), 'stefanuca', 'ionel', 'ionel.stefanuca@info.uaic.ro', '1234', sysdate,'https://everythingtwitter.files.wordpress.com/2012/04/img-avatar.png', '6',TabelaIstoricLogin(istoricLogin(1,'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36','192.168.1.1','May 25, 2015 6:41 pm')))
/
commit;
/


--bloc de inserare pe tabela UserPasswords
BEGIN
  FOR i in 1..500
	LOOP
	  INSERT INTO UserPasswords 
		VALUES (null,TRUNC(DBMS_RANDOM.VALUE(1,1000),0), DBMS_RANDOM.STRING('A',20), DBMS_RANDOM.STRING('A',10), DBMS_RANDOM.STRING('X',15), DBMS_RANDOM.STRING('L',10), SYSDATE-DBMS_RANDOM.VALUE(0,1000), TRUNC(DBMS_RANDOM.VALUE(1,365),0),1,DBMS_RANDOM.STRING('A',50), TRUNC(DBMS_RANDOM.VALUE(0,35)));
	END LOOP;
END;
/
commit;
/









--------------------------------------------------- 
--din motive de securitate vom retine toate parolele pe care un utilizator le-a avut la contul sau, deci daca:
-- prima parola a fost '123456'
-- a doua parola a fost '1234567'
-- si vrea ca a treia parola sa fie '123456' sau '1234567' nu o va putea schimba cu una dintre acestea doua

--parolele sunt intexate crescator in ordine cronologica in care au fost adaugate, deci ultima parola este cea cu care va puteti conecta la cont
				--> functia returneazaParola returneaza acea parola
				
				
-- ex 1) procedura updateCSV incarca date in BD dintr-un fisier CSV
-- ex 2) exceptiile vor fi prinse si afisate in php
-- ex 6) pachetul contine o functie si 3 proceduri
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana
create or replace PACKAGE  pachet as
  FUNCTION returneazaParola (v_userID in utilizatori.userid%TYPE) RETURN STRING deterministic;
  PROCEDURE updateParola (v_userID IN utilizatori.userid%TYPE, v_parola in String,v_mesaj OUT STRING);
  PROCEDURE updateCSV (v_userID IN utilizatori.userid%TYPE, v_numeFisier in String);
  PROCEDURE updateIstoricLogin (v_userID IN utilizatori.userid%TYPE,v_browser in String,v_ip in String,v_data in String);
END pachet;
/
create or replace PACKAGE BODY pachet IS
  PROCEDURE updateIstoricLogin (v_userID IN utilizatori.userid%TYPE,v_browser in String,v_ip in String,v_data in String)
  is
	  v_nestedIstoric utilizatori.istoricLogariU%TYPE;
	  v_nestedIstoricClone TabelaIstoricLogin := TabelaIstoricLogin();
  BEGIN
			select istoricLogariU into v_nestedIstoric
			from utilizatori 
			where userid = v_userID;
			
			v_nestedIstoricClone.extend(v_nestedIstoric.count+1);
			
			 FOR i IN 1 .. v_nestedIstoric.COUNT()
				LOOP
						  v_nestedIstoricClone(i) :=v_nestedIstoric(i) ;
			 END LOOP;
			 
			 v_nestedIstoricClone(v_nestedIstoric.count+1) :=istoricLogin(v_nestedIstoric.count()+1,v_browser,v_ip,v_data);
			 
			 update utilizatori 
			 set istoricLogariU=v_nestedIstoricClone
			 where userid = v_userID;
					  
  END updateIstoricLogin;
  
  
  FUNCTION returneazaParola(v_userID in utilizatori.userid%TYPE) RETURN STRING 
	IS
	   v_parolaUserCamp utilizatori.parola%TYPE;
	   v_parola varchar(64); 
	BEGIN
	  select parola into v_parolaUserCamp  
	  from utilizatori
	  where userid = v_userID;     
				  FOR n IN 1 .. v_parolaUserCamp.count()
				   LOOP
					  v_parola:=v_parolaUserCamp(n).parola;
				   END LOOP;
	  RETURN v_parola;
	END returneazaParola;
------------------------------------------------------------------------------------------------------------------------    
	PROCEDURE updateParola (
	v_userID IN utilizatori.userid%TYPE, 
	v_parola in String,
	v_mesaj OUT STRING
	) 
	is
	  v_nested utilizatori.parola%TYPE := TabelaParole();
	  v_nestedClona TabelaParole :=TabelaParole();
	  
	  v_sePoateUpdata boolean := true;
	  v_return varchar(2) := 'da';
	  
	BEGIN
			select parola into v_nested
			from utilizatori 
			where userid = v_userID;
			
			v_nestedClona.extend(v_nested.count()+1);
			
			 FOR i IN 1 .. v_nested.COUNT()
				LOOP
					IF v_nested(i).parola != v_parola THEN
						  v_nestedClona(i) :=v_nested(i) ;
						 -- DBMS_OUTPUT.PUT_LINE(v_nestedClona(i).pid||' ' ||v_nestedClona(i).parola);
					ELSE
						v_sePoateUpdata := false;
					END IF;
			 END LOOP;
			 
			 IF v_sePoateUpdata THEN
				  v_nestedClona(v_nested.count()+1) :=infoModificari(v_nested.count()+1,v_parola);
				  
				  update utilizatori
				  set parola = v_nestedClona
				  where userid = v_userID;

			 ELSE
				  v_return := 'nu';
			 END IF;
  
		v_mesaj:= v_return;
	END updateParola;
	
	PROCEDURE updateCSV (v_userID IN utilizatori.userid%TYPE, v_numeFisier in String)
	is
	  F UTL_FILE.FILE_TYPE;
	  V_LINE VARCHAR2 (1000);
	  v_titluParola userpasswords.titluParola%TYPE;
	  v_cont userpasswords.cont%TYPE;
	  v_parola userpasswords.parola%TYPE;
	  v_AdresaWeb userpasswords.AdresaWeb%TYPE;
	  v_dataAdaugare userpasswords.dataAdaugare%TYPE;
	  v_timpMaximDeValabilitate userpasswords.timpMaximDeValabilitate%TYPE;
	  v_comentariu userpasswords.Comentarii%TYPE;
	  v_tarieP grupareparole.tarieParola%TYPE;
	  v_frecventa grupareparole.frecventaUtilizare%TYPE;
	  v_domeniuSite grupareparole.domeniuSite%TYPE;
	  
	  no_timpValabilitate EXCEPTION;
	  no_FaraNULL EXCEPTION;
	  
	  v_contor int :=1;
	BEGIN
	  F := UTL_FILE.FOPEN ('CSV', v_numeFisier, 'R');
		  IF UTL_FILE.IS_OPEN(F) THEN
			  LOOP
					   BEGIN
								UTL_FILE.GET_LINE(F, V_LINE, 1000);
								IF  v_contor > 1 THEN
										IF V_LINE IS NULL THEN
										  EXIT;
										END IF;
											v_titluParola := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 1);
											v_cont := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 2);
											v_parola := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 3);
											v_AdresaWeb := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 4);
											v_dataAdaugare := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 5);
											v_timpMaximDeValabilitate := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 6);
											v_comentariu := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 7);
											v_tarieP := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 8);
											v_frecventa := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 9);
											v_domeniuSite := REGEXP_SUBSTR(V_LINE, '[^,]+', 1, 10);
										   
										   IF v_timpMaximDeValabilitate < 0 THEN
												raise no_timpValabilitate;
										   END IF;
										   
										   IF v_titluParola is null or v_cont is null or v_parola is null or v_AdresaWeb is null or  v_dataAdaugare is null or v_timpMaximDeValabilitate is null or v_comentariu is null or v_tarieP is null or v_frecventa is null or v_domeniuSite is null THEN
											  raise  no_FaraNULL;
										   END IF;
										   
										   
										   -- va urma insertul in baza de date daca nu sunt erori
										   insert into userpasswords values (null,v_userID,v_titluParola,v_cont,v_parola,v_AdresaWeb,sysdate,v_timpMaximDeValabilitate,1,v_comentariu, (SELECT codGrupare FROM grupareparole WHERE domeniuSite=v_domeniuSite and frecventaUtilizare=v_frecventa and tarieParola=v_tarieP ));
										   
										   
										   DBMS_OUTPUT.PUT_LINE(v_titluParola ||' '||v_cont||' '||v_parola||' '||v_AdresaWeb||' '||v_dataAdaugare||' '||v_timpMaximDeValabilitate||' '||v_comentariu||' '||v_tarieP||' '||v_frecventa||' '||v_domeniuSite);
								 END IF; 
									 EXCEPTION
									  WHEN NO_DATA_FOUND THEN
											 EXIT;    
									  WHEN no_timpValabilitate THEN
											 raise_application_error (-20001,'Timpul maxim de valailitate trebuie sa fie pozitiv.Eroare la linia '||v_contor);
											 EXIT; 
									  WHEN no_FaraNULL THEN
											 raise_application_error (-20010,'Toate coloanele trebuie completare. Nu poti avea valori de NULL. Linia: '||v_contor);
											 EXIT; 
									  WHEN OTHERS THEN   
											  raise_application_error (-20077,'Alt tip de eroare. Linia: '||v_contor);     
						END;  
					   v_contor :=v_contor+1;
			  END LOOP;
		END IF;
		UTL_FILE.FCLOSE(F);
		commit;
   END updateCSV;
	
END pachet;
/






-- ex 7) trei view-uri
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana
drop view viewParoleNegrupate;
/
CREATE VIEW viewParoleNegrupate AS  -- avand data adaugarii parolei si numarul maxim de zile, cu ajutorul acestui view o sa afisma data cand va expira parola
		select pid,userid,titluParola, codgrupare,cont, Parola, AdresaWeb, dataAdaugare, timpMaximDeValabilitate, statusParola, Comentarii, (dataAdaugare+ timpMaximDeValabilitate) as dataExpirare 
		from userpasswords ;
		
drop view viewLogin;
/
CREATE VIEW viewLogin AS -- va aplica functia pachet.returneazaParola(userid) peste user id... va intoarce datele de logare (ultima actualizare a parolei -> in caz ca a fost modificata)
		select userid,username, pachet.returneazaParola(userid) as parola,nume,prenume,avatar 
		FROM utilizatori ;		
/
drop view viewExport;  
/
CREATE VIEW viewExport AS -- ne va ajuta cand exportam fisierele xml, json
		SELECT titluParola, cont, Parola, AdresaWeb, dataAdaugare, timpMaximDeValabilitate, Comentarii,tarieParola, frecventaUtilizare, domeniuSite,userid
				FROM userpasswords, grupareparole 
				WHERE userpasswords.codGrupare = grupareparole.codGrupare;
/






--indecsii
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana
--drop index grupareParoleIndex;
create unique index grupareParoleIndex on grupareparole(domeniuSite,frecventaUtilizare,tarieParola);
------------------
---- index userIdCodGrupare_index;
create index userIdCodGrupare_index on userpasswords(userID,codGrupare);

--drop index parole_index; -- atunci cand vrem sa stergem o parola  din contul anumitui utilizator
create index parole_index on userpasswords (pid,userid);

--drop index utilizatoriIndex;  -- acest index ne ajuta la logare, este index unic pe username care este bazat pe o functie  >> daca cream acest index nu vom mai putea adauga noi inregistrari, este un conflict cu trigarul
--create UNIQUE INDEX utilizatoriIndex ON utilizatori (username,pachet.returneazaParola(userid));






--cateva interogari-->> acestea au fost propuse in saptamana a 7-a
-- rezolvat de: Stefanuca R. Ionel & Ungureanu Cristina Diana

--[Utilizatorii trebuie sa poata face “curatenie” in cont, adica sa iti stearga toate parolele]--
DELETE FROM  userpasswords 
where userID=?;
/

--[Fiecare utilizator trebuie sa poata sa isi actualizeze imaginea reprezentand avatarul]--
select avatar
from utilizatori
where userid=?;
/
update utilizatori
set avatar =? 
where userid = ? ;
/

--[Sa se afiseze istoricul logarilor unui utilizator pe site >> ultimele 5 logari ale unui utilizator]
select *
from(select browser,dataLogare,ip
from utilizatori u1,TABLE(u1.istoricLogariU) u2
where username = ?
order by iid desc)
where rownum<6;
/

--[Sa se grupeze parolele unui utilizator dupa domeniu site, frecventa utilizare si tarie parola]--
select *
from viewParoleNegrupate 
where userID = ?
and codGrupare =
(
    SELECT codGrupare
    FROM grupareparole 
    WHERE  domeniuSite=? and frecventaUtilizare=? and tarieParola=?
) ORDER BY pid OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
/	

--[se face paginarea, cate n parole pe fiecare pagina>> acestea nu sunt grupate]--
select *
from viewParoleNegrupate 
where userID = ?
ORDER BY pid OFFSET ? ROWS FETCH NEXT ? ROWS ONLY;
/

--[Un utilizator trebuie sa se poata loga pe site (se verifica in php daca numarul de randuri este egal cu unu)]--
SELECT * 
FROM viewLogin 
WHERE username = ? and pachet.returneazaParola(userid) =?;
/

--[Fiecare parola poate fi stearsa]--
DELETE FROM userpasswords 
WHERE pid = ? and userid=?;
/

--[Email-urile utilizatorilor trebuie sa fie unice >> interogarea este folosita la crearea unui nou cont]--
SELECT email 
FROM utilizatori 
WHERE email = ?;
/

--[afiseaza istoricul logarilor pentru un utilizator >> s-a facut joint cu un nested-table]
select username,iid,browser,dataLogare,ip
from utilizatori u1,TABLE(u1.istoricLogariU) u2
where username = ?
order by iid desc
/


--[Cautarea parolelor dupa titplu >> cautarea este paginata] --
SELECT *
FROM viewParoleNegrupate 
WHERE userID = ? AND titluparola LIKE ? 
ORDER BY pid OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
