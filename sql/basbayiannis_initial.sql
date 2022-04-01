CREATE DATABASE IF NOT EXISTS `basbayiannis` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE basbayiannis;

CREATE TABLE IF NOT EXISTS user (
  user_id int NOT NULL AUTO_INCREMENT,
  role ENUM('ΠΟΛΙΤΗΣ','ΓΙΑΤΡΟΣ') NOT NULL,
  name varchar(50) NOT NULL,
  surname varchar(50) NOT NULL,
  amka varchar(11) NOT NULL,
  afm varchar(9) NOT NULL UNIQUE,
  adt varchar(20) NOT NULL,
  age int NOT NULL,
  sex ENUM('ΑΡΡΕΝ','ΘΗΛΥ') DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  mobile varchar(20) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS center (
  center_id int NOT NULL AUTO_INCREMENT,
  name varchar(100) DEFAULT NULL,
  address varchar(100) NOT NULL,
  tk int NOT NULL,
  phone varchar(20) NOT NULL,
  PRIMARY KEY (center_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO center (name, address, tk, phone) VALUES
('Εμβολιαστικό κέντρο Αθήνας', 'Λεωφόρος Κηφισίας 39, Μαρούσι', 15122, '213 2161000'),
('Εμβολιαστικό κέντρο Θεσσαλονίκης', 'Περίπτερο 13 ΔΕΘ-Θεσσαλονίκης, Θεσσαλονίκη', 54621, '2310 291512');

CREATE TABLE IF NOT EXISTS center_doctor (
  center_doctor_id int NOT NULL AUTO_INCREMENT,
  doctor_id int,
  center_id int,
  PRIMARY KEY (center_doctor_id),
  FOREIGN KEY (doctor_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (center_id) REFERENCES center(center_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS rendezvous (
  rendezvous_id int NOT NULL AUTO_INCREMENT,
  center_id int DEFAULT NULL,
  user_id int DEFAULT NULL,
  rendezvous_date DATE NOT NULL,
  rendezvous_time TIME NOT NULL,
  status ENUM('ελεύθερο','προγραμματισμένο','ολοκληρωμένο') NOT NULL,
  PRIMARY KEY (rendezvous_id),
  FOREIGN KEY (center_id) REFERENCES center(center_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO rendezvous (center_id, rendezvous_date, rendezvous_time, status) VALUES
(1,'2022-04-01','08:00','ελεύθερο'),
(1,'2022-04-01','09:00','ελεύθερο'),
(1,'2022-04-01','10:00','ελεύθερο'),
(1,'2022-04-02','08:00','ελεύθερο'),
(1,'2022-04-02','09:00','ελεύθερο'),
(1,'2022-04-02','10:00','ελεύθερο'),
(2,'2022-04-01','08:00','ελεύθερο'),
(2,'2022-04-01','09:00','ελεύθερο'),
(2,'2022-04-01','10:00','ελεύθερο'),
(2,'2022-04-02','08:00','ελεύθερο'),
(2,'2022-04-02','09:00','ελεύθερο'),
(2,'2022-04-02','10:00','ελεύθερο');




