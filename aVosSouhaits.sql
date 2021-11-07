--
-- 
--

CREATE DATABASE aVosSouhaits;

USE aVosSouhaits;

--
-- Structure of `users`
--

CREATE TABLE users (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
lastname VARCHAR(30) NOT NULL,
firstname VARCHAR(30) NOT NULL,
address VARCHAR(80) NOT NULL,
email VARCHAR(90) NOT NULL,
admin BOOL NOT NULL);

--
-- Structure of `specialty`
--
CREATE TABLE specialties (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(30) NOT NULL,
    img VARCHAR(150) NOT NULL
);


--
-- Structure of `genies`
--

CREATE TABLE genies (
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(30) NOT NULL,
material VARCHAR(20) NOT NULL,
nb_wishes INT NOT NULL,
specialty_id VARCHAR(20) NOT NULL,
costPerDay INT NOT NULL,
genie_img VARCHAR(150) NOT NULL,
lamp_img VARCHAR(150) NOT NULL)
FOREIGN KEY (specialty_id) REFERENCES specialties(id);

--
-- Structure of `booking`
--

CREATE TABLE bookings (
user_id INT NOT NULL,
genie_id INT NOT NULL,
check_in DATE NOT NULL,
checkout DATE NOT NULL,
opinion TEXT,
mark INT,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (genie_id) REFERENCES genies(id));