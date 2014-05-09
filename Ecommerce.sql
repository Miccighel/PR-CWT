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
  prezzo         INT(3)       NOT NULL,
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
  ('PRDT1212', 'Borderlands 2', 'Frenetico sparatutto ambientato nel mondo di Pandora', 45, 100,
   'borderlands2coverXbox360.jpg', 'borderlands2', 'FPS'),
  ('PRDT1313', 'Borderlands 2', 'Frenetico sparatutto ambientato nel mondo di Pandora', 45, 100,
   'borderlands2coverPS3.jpg', 'borderlands2', 'FPS'),
  ('PRDT1515', 'Total War Rome 2', 'Guida le armate di Roma alla conquista del mondo!', 60, 250,
   'totalwarrome2cover.jpg', 'totalwarrome2', 'RTS');

DROP TABLE IF EXISTS tblutenti;
CREATE TABLE IF NOT EXISTS tblutenti (
  codicefiscale         CHAR(16)    NOT NULL,
  nome                  VARCHAR(20) NOT NULL,
  cognome               VARCHAR(20) NOT NULL,
  datanascita           CHAR(10)    NOT NULL,
  indirizzo             VARCHAR(50) NOT NULL,
  email                 VARCHAR(30) NOT NULL,
  telefono              VARCHAR(15) NOT NULL,
  user                  VARCHAR(30) NOT NULL UNIQUE,
  psw                   VARCHAR(40) NOT NULL,
  dirittoAmministratore CHAR(2)     NOT NULL,
  PRIMARY KEY (codicefiscale)
)
  ENGINE =InnoDB;

INSERT INTO tblutenti (codicefiscale, nome, cognome, datanascita, indirizzo, email, telefono, user, psw, dirittoAmministratore)
VALUES
  ('SPRMHL92T17D962J', 'Mario', 'Rossi', '17/12/92', 'Via Roma 12', 'admin@gamescommerce.it', '3336665454', 'admin',
   sha1('password'), 'si'),
  ('THGMGF87D22Y789B', 'Gianni', 'Balengo', '05/03/78', 'Piazza Svizzera 48', 'giannibalengo@gmail.com', '333456871',
   'giannibal78', sha1('password2'), 'no'),
  ('WERTIF22V48Z777N', 'Giuliano', 'Palma', '12/12/88', 'Corso Verdi 3', 'giulianopalma@hotmail.it', '3495412347',
   'giulpal12', sha1('password3'), 'no');

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
  ('PRDT1515', 'SPRMHL92T17D962J', 5);

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
  ('PRDT1212', 'XBOX 360'),
  ('PRDT1313', 'Playstation 3'),
  ('PRDT1515', 'PC');



