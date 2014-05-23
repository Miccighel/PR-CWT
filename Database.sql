DROP DATABASE IF EXISTS ecommerce;
CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

DROP TABLE IF EXISTS tblcategorie;
CREATE TABLE IF NOT EXISTS tblcategorie (
  nome VARCHAR(20) NOT NULL,
  PRIMARY KEY (nome)
)
  ENGINE =InnoDB;

INSERT INTO tblcategorie (nome) VALUES
  ('RTS'),
  ('TBS'),
  ('FPS'),
  ('RPG'),
  ('MMORPG'),
  ('TPS'),
  ('Arcade'),
  ('Avventura'),
  ('Puzzle Game'),
  ('Avventura Grafica');

DROP TABLE IF EXISTS tblconsole;
CREATE TABLE IF NOT EXISTS tblconsole (
  nome       VARCHAR(20) NOT NULL,
  produttore VARCHAR(30),
  PRIMARY KEY (nome)
)
  ENGINE = InnoDB;

INSERT INTO tblconsole (nome, produttore) VALUES
  ('PC', NULL),
  ('XBOX 360', 'Microsoft'),
  ('XBOX One', 'Microsoft'),
  ('Playstation 3', 'Sony'),
  ('Playstation 4', 'Sony'),
  ('PSP', 'Sony'),
  ('PSVita', 'Sony'),
  ('DS', 'Nintendo'),
  ('3DS', 'Nintendo'),
  ('Wii', 'Nintendo'),
  ('Wii U', 'Nintendo');

DROP TABLE IF EXISTS tblprodotti;
CREATE TABLE IF NOT EXISTS `tblprodotti` (
  codiceprodotto CHAR(8)      NOT NULL,
  nomeprodotto   VARCHAR(30)  NOT NULL,
  descrizione    VARCHAR(250) NOT NULL,
  prezzo         FLOAT(4)     NOT NULL,
  numeropezzi    INT(5)       NOT NULL,
  immagine       VARCHAR(100) NOT NULL,
  galleria       VARCHAR(20)  NOT NULL,
  categoria      VARCHAR(20)  NOT NULL,
  PRIMARY KEY (codiceprodotto),
  FOREIGN KEY (categoria) REFERENCES tblcategorie (nome)
    ON UPDATE CASCADE
    ON DELETE NO ACTION
)
  ENGINE =InnoDB;

  INSERT INTO tblprodotti (codiceprodotto, nomeprodotto, descrizione, prezzo, numeropezzi, immagine, galleria, categoria)
VALUES
  ('PRDT1212', 'Borderlands 2', 'Frenetico sparatutto ambientato nel mondo di Pandora', 45.00, 100,'borderlands2coverXbox360.jpg', 'borderlands2', 'FPS'),
  ('PRDT1313', 'Borderlands 2', 'Frenetico sparatutto ambientato nel mondo di Pandora', 45.00, 100, 'borderlands2coverPS3.jpg', 'borderlands2', 'FPS'),
  ('PRDT1414', 'The Last of Us', 'Il nuovo titolo post apocalittico sviluppato da Naughty Dog!', 45, 200, 'thelastofuscoverPS3.JPG', 'thelustofus', 'Avventura'),
  ('PRDT1515', 'Total War Rome 2', 'Guida le armate di Roma alla conquista del mondo!', 60.00, 250, 'totalwarrome2cover.jpg', 'totalwarrome2', 'RTS'),
  ('PRDT1616', 'Killzone Shadow Fall', 'Un nuovo emozionante capitolo per la saga di Guerrilla Games', 70.00, 350, 'killzoneshadowfallcoverPS4.jpg', 'killzoneshadowfall', 'FPS'),
  ('PRDT1717', 'Pokemon X', 'Un nuovo bellissimo capitolo della lunghissima saga dei mostriciattoli di Nintendo!', 35.50, 150, 'pokemonxcover3DS.jpg', 'pokemonx', 'RPG'),
  ('PRDT1818', 'Call of Duty Black Ops 2', 'Il nuovo capitolo di Call of Duty, ambientato nel futuro.', 55, 340, 'codblackops2coverPS3.JPG', 'blackops2', 'FPS'),
  ('PRDT1919', 'Call of Duty Black Ops 2', 'Il nuovo capitolo di Call of Duty, ambientato nel futuro.', 55, 210, 'codblackops2coverXbox360.JPG', 'blackops2', 'FPS'),
  ('PRDT2020', 'Call of Duty Black Ops 2', 'Il nuovo capitolo di Call of Duty, ambientato nel futuro.', 55, 200, 'codblackops2coverPc.JPG', 'blackops2', 'FPS'),
  ('PRDT2121', 'Bioshock Infinite', 'Il terzo entusiasmante capitolo della saga di Bioshock', 35, 70, 'bioshockinfinitecoverXbox360.JPG', 'bioshockinfinite', 'FPS'),
  ('PRDT2222', 'Bioshock Infinite', 'Il terzo entusiasmante capitolo della saga di Bioshock', 35, 80, 'bioshockinfinitecoverPc.JPG', 'bioshockinfinite', 'FPS'),
  ('PRDT2323', 'Bioshock Infinite', 'Il terzo entusiasmante capitolo della saga di Bioshock', 35, 50, 'bioshockinfinitecoverPS3.JPG', 'bioshockinfinite', 'FPS');

DROP TABLE IF EXISTS tblutenti;
CREATE TABLE IF NOT EXISTS tblutenti (
  codicefiscale         CHAR(16)    NOT NULL,
  nome                  VARCHAR(20) NOT NULL,
  cognome               VARCHAR(20) NOT NULL,
  datanascita           CHAR(10)    NOT NULL,
  indirizzo             VARCHAR(50) NOT NULL,
  email                 VARCHAR(30) NOT NULL UNIQUE,
  telefono              VARCHAR(15) NOT NULL,
  user                  VARCHAR(30) NOT NULL UNIQUE,
  psw                   VARCHAR(40) NOT NULL,
  dirittoAmministratore CHAR(2)     NOT NULL,
  PRIMARY KEY (codicefiscale)
)
  ENGINE =InnoDB;

INSERT INTO tblutenti (codicefiscale, nome, cognome, datanascita, indirizzo, email, telefono, user, psw, dirittoAmministratore)
VALUES
  ('SPRMHL92T17D962J', 'Mario', 'Rossi', '17/12/92', 'Udine Via Roma 12', 'admin@gamescommerce.it', '3336665454', 'admin',
   sha1('password'), 'si'),
  ('THGMGF87D22Y789B', 'Gianni', 'Balengo', '05/03/78', 'Roma Piazza Svizzera 48', 'giannibalengo@gmail.com', '333456871',
   'gianni', sha1('password2'), 'no'),
  ('WERTIF22V48Z777N', 'Giuliano', 'Palma', '12/12/88', 'Milano Corso Verdi 3', 'giulianopalma@hotmail.it', '3495412347',
   'giul', sha1('password3'), 'no');

DROP TABLE IF EXISTS tblcarrelli;
CREATE TABLE IF NOT EXISTS tblcarrelli (
  codiceprodotto CHAR(8)  NOT NULL,
  codiceutente   CHAR(16) NOT NULL,
  quantita       INT(4)   NOT NULL,
  PRIMARY KEY (codiceprodotto, codiceutente),
  FOREIGN KEY (codiceprodotto) REFERENCES tblprodotti (codiceprodotto)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  FOREIGN KEY (codiceutente) REFERENCES tblutenti (codicefiscale)
    ON UPDATE CASCADE
    ON DELETE NO ACTION
)
  ENGINE =InnoDB;

INSERT INTO tblcarrelli (codiceprodotto, codiceutente, quantita) VALUES
  ('PRDT1212', 'SPRMHL92T17D962J', 10),
  ('PRDT1212', 'THGMGF87D22Y789B', 12),
  ('PRDT1313', 'THGMGF87D22Y789B', 18),
  ('PRDT1313', 'WERTIF22V48Z777N', 2),
  ('PRDT1515', 'SPRMHL92T17D962J', 5),
  ('PRDT1616', 'SPRMHL92T17D962J', 1),
  ('PRDT1717', 'SPRMHL92T17D962J', 100),
  ('PRDT2020', 'WERTIF22V48Z777N', 18),
  ('PRDT1717', 'WERTIF22V48Z777N', 28);


DROP TABLE IF EXISTS tblprodotticonsole;
CREATE TABLE IF NOT EXISTS tblprodotticonsole (
  codiceprodotto CHAR(8)     NOT NULL,
  console        VARCHAR(20) NOT NULL,
  PRIMARY KEY (codiceprodotto, console),
  FOREIGN KEY (codiceprodotto) REFERENCES tblprodotti (codiceprodotto)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  FOREIGN KEY (console) REFERENCES tblconsole (nome)
    ON UPDATE CASCADE
    ON DELETE NO ACTION
)
  ENGINE = InnoDB;

INSERT INTO tblprodotticonsole (codiceprodotto, console) VALUES
  ('PRDT1717', '3DS'),
  ('PRDT1515', 'PC'),
  ('PRDT2020', 'PC'),
  ('PRDT2222', 'PC'),
  ('PRDT1313', 'Playstation 3'),
  ('PRDT1414', 'Playstation 3'),
  ('PRDT1818', 'Playstation 3'),
  ('PRDT2323', 'Playstation 3'),
  ('PRDT1616', 'Playstation 4'),
  ('PRDT1212', 'XBOX 360'),
  ('PRDT1919', 'XBOX 360'),
  ('PRDT2121', 'XBOX 360');


