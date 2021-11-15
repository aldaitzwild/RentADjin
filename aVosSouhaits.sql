--
-- 
--

DROP DATABASE aVosSouhaits;

CREATE DATABASE aVosSouhaits;

USE aVosSouhaits;

--
-- Structure of users
--

CREATE TABLE users (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
lastname VARCHAR(30) NOT NULL,
firstname VARCHAR(30) NOT NULL,
address VARCHAR(80) NOT NULL,
email VARCHAR(90) NOT NULL,
admin BOOL NOT NULL);

--
-- Structure of specialty
--
CREATE TABLE specialties (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(30) NOT NULL,
img VARCHAR(150)
);


--
-- Structure of genies
--

CREATE TABLE genies (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(30) NOT NULL,
material VARCHAR(20) NOT NULL,
nb_wishes INT NOT NULL,
specialty_id INT NOT NULL,
costPerDay INT NOT NULL,
genie_img VARCHAR(150) NOT NULL,
lamp_img VARCHAR(150) NOT NULL,
description VARCHAR (250),
FOREIGN KEY (specialty_id) REFERENCES specialties(id)
);


--
-- Structure of booking
--

CREATE TABLE bookings (
user_id INT NOT NULL,
genie_id INT NOT NULL,
check_in DATE NOT NULL,
checkout DATE NOT NULL,
opinion TEXT,
mark INT,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (genie_id) REFERENCES genies(id)
);


--
-- Sample data
--

INSERT INTO specialties (name,img)
VALUES ('activités physiques','/assets/images/activities.png'),
('activités manuelles','/assets/images/crafts.png'),
('arts','/assets/images/arts.png'),
('météo','/assets/images/meteo.png'),
('amour','/assets/images/love.png'),
('travail','/assets/images/business.png');

INSERT INTO genies (name,material,nb_wishes,costPerDay,genie_img,lamp_img,specialty_id,description)
VALUES ('Billie Djinn','laiton',5,30,'/assets/images/billie.jpg','/assets/images/laitonlamp.jpg',1,'Vous voulez danser comme un dieu? Enflammer le dancefloor avec le déhanché d’un roi de la pop ? Ne cherchez plus, Billie sera votre meilleur allié!'),
('Chuppee Don','laiton',1,100,'/assets/images/chuppee.jpg','/assets/images/redlamp.jpg',5,'Ne vous fiez pas à son apparente jeunesse, Chuppee Don en connait un rayon et saura vous accompagner sur le chemin de l\'amour'),
('Miss Daisy','argile',3,10,'/assets/images/daisy.jpg','/assets/images/claylamp2.jpg',2,'Curabitur sapien dolor, congue sed mi ac, rhoncus maximus est. Sed ac tincidunt sapien. Mauris sed magna velit. Nulla condimentum nisi eu vestibulum elementum.'),
('Franz Kyss','laiton',5,50,'/assets/images/franz.jpg','/assets/images/goldenlamp1.jpg',5,'Nulla id eros ac massa finibus rhoncus non quis ligula. Maecenas in magna eget neque semper facilisis at eget velit. In molestie ante posuere justo luctus, in malesuada arcu gravida.'),
('Ginny Weather','argent',3,25,'/assets/images/ginny.jpg','/assets/images/bluegoldenlamp1.jpg',4,'Faire la pluie et le beau temps, vous allez adorer!'),
('Guy Thubiro','argent',5,50,'/assets/images/guy.jpg','/assets/images/silverlamp2.jpg',6,'Avec ce dieu du code, rentrez dans la matrice et venez à bout des projets les plus ambitieux...'),
('Joe Cooker','argile',5,15,'/assets/images/joe.jpg','/assets/images/claylamp1.jpg',2,'Notre spécialiste des fourneaux vous mettra dans la peau d\'un chef étoilé. Fusce et pharetra nunc, fringilla consectetur nulla. Nunc eu lectus vitae quam fringilla sollicitudin.'),
('Led Zibeline','argent',3,20,'/assets/images/olly.jpg','/assets/images/silverlamp1.jpg',3,'Led saura révéler la rockstar qui sommeille en vous et vous métamorphosera en un véritable guitar hero.'),
('Olly Wayzontime','bronze',5,5,'/assets/images/led.jpg','/assets/images/bronzelamp.jpg',6,'Dans la catégorie business, vous demandez notre spécialiste de la ponctualité: pannes de réveil, retards à répétition, terminé tout ça, soyez ponctuel comme un coucou suisse!'),
('Yvan Naigé','argent',5,20,'/assets/images/yvan.jpg','/assets/images/bluesilverlamp.jpg',4,'En expert de la météo hivernale, Yvan peut vous garantir une chose : il va neiger! De la poudreuse, de la fraiche partout où vos skis passeront!'),
('Surfer Rosa','laiton',5,20,'/assets/images/rosa.jpg','/assets/images/bluegoldenlamp2.jpg',1,'Grâce à Rosa, à Houlgate comme à Honolulu vous allez adorer être dans le creux de la vague'),
('Jasmine','argile',3,150,'/assets/images/jasmine.jpg','/assets/images/claylamp3.jpg',3,'Be inspired! notre spécialiste des arts graphiques va sublimer vos talents de peintre!');
