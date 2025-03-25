DROP DATABASE IF EXISTS my_meetic;
CREATE DATABASE my_meetic;

USE my_meetic;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS loisir;
-- DROP TABLE IF EXISTS security;
DROP TABLE IF EXISTS gender;
-- DROP TABLE IF EXISTS user_security;
DROP TABLE IF EXISTS log_status;
DROP TABLE IF EXISTS user_loisir;
DROP TABLE IF EXISTS user_gender;
DROP TABLE IF EXISTS user_log;


CREATE TABLE user (
    id              INT             NOT NULL AUTO_INCREMENT,
    email           VARCHAR(255)    NOT NULL UNIQUE,
    firstname       VARCHAR(255)    NOT NULL,
    lastname        VARCHAR(255)    NOT NULL,
    birthdate       DATE        NOT NULL,
    address         VARCHAR(255),
    zipcode         VARCHAR(10),
    city            VARCHAR(255),
    country         VARCHAR(255),
    password        VARCHAR(32),
    PRIMARY KEY (id)
);
CREATE TABLE loisir (
    id              INT             NOT NULL AUTO_INCREMENT,
    name           VARCHAR(255)    NOT NULL UNIQUE,   
    PRIMARY KEY (id)
);

-- CREATE TABLE security (
--     id              INT             NOT NULL AUTO_INCREMENT,
--     password CHAR(32),
--     PRIMARY KEY (id)
-- );

CREATE TABLE gender (
    id              INT             NOT NULL AUTO_INCREMENT,
    name           CHAR(25)    NOT NULL UNIQUE,   
    PRIMARY KEY (id)
);

CREATE TABLE log_status(
   id              INT             NOT NULL AUTO_INCREMENT,
   name           CHAR(25)    NOT NULL UNIQUE,
   PRIMARY KEY (id)  
);

CREATE TABLE user_loisir (
    id_user        INT             NOT NULL,
    id_loisir        INT             NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_loisir) REFERENCES loisir(id)
);

-- CREATE TABLE user_security (
--     id_user        INT             NOT NULL,
--     id_security        INT             NOT NULL,
--     FOREIGN KEY (id_user) REFERENCES user(id),
--     FOREIGN KEY (id_security) REFERENCES security(id)
-- );

CREATE TABLE user_gender (
    id_user        INT             NOT NULL,
    id_gender        INT             NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_gender) REFERENCES gender(id)
);

CREATE TABLE user_log (
    id_user        INT             NOT NULL,
    id_log        INT             NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_log) REFERENCES log_status(id)
);

INSERT INTO user
            (email, firstname, lastname, birthdate, address, zipcode, city, country, password )
    VALUES  ('randy.black@ore.com', 'Randy', 'Black', '1997-10-28', '107 Montmoyen', '10190', 'Chennegy', 'France', '21232f297a57a5a743894a0e4a801fc3'),
            ('holikov.sasha@ore.com', 'Sasha', 'Holikov', '1997-02-25', '5 av de la Liberation', '77000', 'Melun', 'France', '7634684525bcc7995e56b5db59a85275'),
            ('anna.debois@ore.com', 'Anna', 'Debois', '1999-12-13', '11 rue les Halles', '75000', 'Paris', 'France','3fe7aa3c8c9b28b8d170b22dd92fe3ae');

INSERT INTO loisir
            (name)
    VALUES  ('sport'),
            ('yoga'),
            ('coffee'),
            ('dance'),
            ('art'),
            ('fitness'),
            ('books'),
            ('video games'),
            ('cooking'),
            ('chess'),
            ('origami'),
            ('poetry'),
            ('pottery'),
            ('card games'),
            ('swimming'),
            ('golf'),
            ('surfing'),
            ('rugby'),
            ('musiqu');

INSERT INTO gender
            (name)
    VALUES  ('female'),
            ('male');

INSERT INTO log_status
            (name)    
    VALUES  ('LogIn'),
            ('LogOut');


INSERT INTO user_loisir
            (id_user, id_loisir)
    VALUES  (1,1),
            (1,2),
            (2,3),
            (2,4),
            (3,1),
            (3,4);

INSERT INTO user_gender
            (id_user, id_gender)
    VALUES  (1,2),
            (2,2),
            (3,1);  


INSERT INTO user_log
            (id_user, id_log)
    VALUES  (1,2),
            (2,2),
            (3,2);
