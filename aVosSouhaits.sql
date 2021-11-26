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
-- Structure of reviews
--

CREATE TABLE reviews (
user_id INT NOT NULL,
genie_id INT NOT NULL,
rating INT NOT NULL,
review TEXT, 
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
('Chuppee Don','laiton',1,100,'/assets/images/chuppee.jpg','/assets/images/redlamp.jpg',5,'Ne vous fiez pas à son apparente jeunesse, Chuppee Don en connait un rayon et saura vous accompagner sur le chemin de l\'amour.'),
('Miss Daisy','argile',3,10,'/assets/images/daisy.jpg','/assets/images/claylamp2.jpg',2,'Vous adorez les plantes et elles ne vous le rendent pas du tout? Même vos cactus ont tous rendu l\'âme les uns après les autres? Faites appel à notre experte en jardinage!'),
('Franz Kyss','laiton',5,50,'/assets/images/franz.jpg','/assets/images/goldenlamp1.jpg',5,'Vous voulez connaître les vertiges de l\'amour? Sans parler d\'enchainer les conquêtes à la pelle, reprenez simplement le contrôle...Grâce à Franz, ne laissez plus faire le hasard!'),
('Ginny Weather','argent',3,25,'/assets/images/ginny.jpg','/assets/images/bluegoldenlamp1.jpg',4,'Faire la pluie et le beau temps, souffler le chaud et le froid, semer la tempête, offrir un arc en ciel, à vous de jouer!'),
('Guy Thubiro','argent',5,50,'/assets/images/guy.jpg','/assets/images/silverlamp2.jpg',6,'Avec ce dieu du code, rentrez dans la matrice et venez à bout des projets les plus ambitieux...'),
('Joe Cooker','argile',5,15,'/assets/images/joe.jpg','/assets/images/claylamp1.jpg',2,'Notre spécialiste des fourneaux vous mettra dans la peau d\'un chef étoilé.'),
('Led Zibeline','argent',3,20,'/assets/images/led.jpg','/assets/images/silverlamp1.jpg',3,'Vous en avez assez du air guitar? de l\'air dubitatif voire compatissant de vos amis quand vous tentez l\'intro de Smells Like Teen Spirit? Led saura révéler le guitar hero qui sommeille en vous!'),
('Olly Wayzontime','bronze',5,5,'/assets/images/olly.jpg','/assets/images/bronzelamp.jpg',6,'Dans la catégorie travail/business, demandez notre spécialiste de la ponctualité: pannes de réveil, retards à répétition, terminé tout ça, soyez ponctuel comme un coucou suisse!'),
('Yvan Naigé','argent',5,20,'/assets/images/yvan.jpg','/assets/images/bluesilverlamp.jpg',4,'En expert de la météo hivernale, Yvan peut vous garantir une chose : il va neiger! De la poudreuse, de la fraiche partout où vos skis passeront!'),
('Surfer Rosa','laiton',5,20,'/assets/images/rosa.jpg','/assets/images/bluegoldenlamp2.jpg',1,'Grâce à Rosa, à Houlgate comme à Honolulu vous allez adorer être dans le creux de la vague'),
('Jasmine','argile',3,150,'/assets/images/jasmine.jpg','/assets/images/claylamp3.jpg',3,'Be inspired! Notre spécialiste des arts graphiques va sublimer vos talents de peintre!');

INSERT INTO users (lastname,firstname,address,email,admin)
VALUES ('Veilleux','Guy','5 place de la gare ','guyveilleux@gmail.com','0'),
('Meunier','Agathe','95 cours de la liberté', 'agathemeunier@ymail.com','0'),
('Pelletier','Jonathan','5 place de la gare ','guyveilleux@gmail.com','0'),
('Briard','Sandrine','39 rue des belges','sandrinebriard@hotmail.com','0'),
('Quirion', 'Manue','24 rue des lacs','manuequirion@laposte.net','0'),
('Ro','Toto','17 rue Delandine','totoro@gmail.com','0'),
('Gaudry','Valentin','15 place de la Liberté', 'vgaudry@hotmail.com','0');

INSERT INTO reviews (user_id,genie_id,rating,review)
VALUES (5,1,4,'Top! Avec Billie, choré chaloupées, rocks endiablés du soir au matin.'),
(3,1,2,'Peut-être un peu trop excentrique, beaucoup d\’improvisations improbables, mes potes se sont bien marré, c\’est déjà ça...'),
(4,1,3,'Je viens de récupérer la lampe magique, Billie est un peu exhubérant et farfelu, mais il semble  bien à l’écoute, impatiente de jouer les dancing queens !'),
(1,9,5,'Formidable, pas un retard pendant ma semaine d\'examens!'),
(7,10,4,'Au top à Chamechaude ce weekend!'),
(6,8,3,'à refaire très vite!');


