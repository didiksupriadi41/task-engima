-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2019 at 08:08 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.2.18
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  AUTOCOMMIT = 0;

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubes2-wbd`
--
-- --------------------------------------------------------
--
-- Table structure for table `Book`
--
CREATE TABLE `Book` (
  `idBook` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idSchedule` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `isRate` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

-- --------------------------------------------------------
--
-- Table structure for table `Category`
--
CREATE TABLE `Category` (
  `idCategory` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Dumping data for table `Category`
--
INSERT INTO
  `Category` (`idCategory`, `category`)
VALUES
  (1, 'Action'),
  (2, 'Drama'),
  (3, 'Thriller'),
  (4, 'Mystery'),
  (5, 'Crime'),
  (6, 'Horror'),
  (7, 'Fantasy'),
  (8, 'Romance'),
  (9, 'Adventure'),
  (10, 'Comedy');

-- --------------------------------------------------------
--
-- Table structure for table `Cookie`
--
CREATE TABLE `Cookie` (
  `idCookie` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  `expiredDate` datetime NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

-- --------------------------------------------------------
--
-- Table structure for table `Movie`
--
CREATE TABLE `Movie` (
  `idMovie` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `duration` int(10) NOT NULL,
  `release` date NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `poster` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Dumping data for table `Movie`
--
INSERT INTO
  `Movie` (
    `idMovie`,
    `title`,
    `description`,
    `duration`,
    `release`,
    `rating`,
    `poster`
  )
VALUES
  (
    1,
    'Joker',
    'Failed comedian Arthur Fleck encounters violent thugs while wandering the streets of Gotham City dressed as a clown. Disregarded by society, Fleck begins a slow dissent into madness as he transforms into the criminal mastermind known as the Joker.',
    122,
    '2019-10-02',
    0,
    'img/joker.jpg'
  ),
  (
    2,
    'Danur 3: Sunyaruri',
    'After years of being friendly with her little ghosts, Risa begins to feel that she must have a normal life like other women. Especially now Risa has a boyfriend named Dimas, a radio announcer. Risa does not tell Dimas about her ability to see ghosts, and that she has five little friends who were not human. Risa\'s friendship with Peter cs shaken, after she feels Peter cs begin teasing Dimas. Risa finally chose to close her inner eyes so she could live a normal life. But a strange thing happens. He could no longer see Peter cs, but again smells danur (liquid that comes out of decayed corpses). It is an evil ghost who enters the house through heavy rain: the ghost of an evil woman who not only threatens her life, but also Peter cs.',
    90,
    '2019-09-26',
    0,
    'img/danur3.jpeg'
  ),
  (
    3,
    'IT Chapter Two',
    'Defeated by members of the Losers\' Club, the evil clown Pennywise returns 27 years later to terrorize the town of Derry, Maine, once again. Now adults, the childhood friends have long since gone their separate ways. But when people start disappearing, Mike Hanlon calls the others home for one final stand. Damaged by scars from the past, the united Losers must conquer their deepest fears to destroy the shape-shifting Pennywise -- now more powerful than ever.',
    170,
    '2019-09-04',
    0,
    'img/itc2.jpg'
  ),
  (
    4,
    'Weathering With You',
    'A boy runs away to Tokyo and befriends a girl who appears to be able to manipulate the weather.',
    112,
    '2019-08-21',
    0,
    'img/weatheringwithyou.jpg'
  ),
  (
    5,
    'Warkop DKI Reborn',
    'Warkop DKI (Dono, Kasino, Indro) is assigned as a secret police agent. They are under the command of Commander Cok, who lost his aide, Karman, when he smells money laundering in the Indonesian film industry. Precisely at a production house owned by Amir Muka. Warkop DKI finally get into the film world and is involved in making a comedy film in pairs with a soap opera artist who moves to the film world, Inka. Warkop DKI instead make Inka trapped with them in a room. Warkop DKI and Inka fainted. When awoken, Warkop DKI are shocked because they are in the desert. But Inka disappears. Warkop DKI\'s search for traces of Inka dragging them on exciting adventures in the desert.',
    103,
    '2019-09-12',
    0,
    'img/wdkireborn.jpg'
  ),
  (
    6,
    'Midsommar',
    'With their relationship in trouble, a young American couple travel to a fabled Swedish midsummer festival where a seemingly pastoral paradise transforms into a sinister, dread-soaked nightmare as the locals reveal their terrifying agenda.',
    138,
    '2019-09-07',
    0,
    'img/midsommar.jpg'
  ),
  (
    7,
    'Gundala',
    'Sancaka hidup di jalanan sejak ditinggal ayah dan ibunya. Menghadapi hidup yang keras, Sancaka belajar untuk bertahan hidup dengan tidak peduli dengan orang lain dan hanya mencoba untuk mendapatkan tempat yang aman bagi dirinya sendiri. Ketika situasi kota semakin tidak aman dan ketidakadilan merajalela di seluruh negeri, Sancaka harus buat keputusan yang berat, tetap hidup di zona amannya, atau keluar sebagai Gundala untuk membela orang-orang yang ditindas.',
    123,
    '2019-08-29',
    0,
    'img/gundala.jpg'
  ),
  (
    8,
    'The Angry Birds Movie 2',
    'Red, Chuck, Bomb and the rest of their feathered friends are surprised when a green pig suggests that they put aside their differences and unite to fight a common threat. Aggressive birds from an island covered in ice are planning to use an elaborate weapon to destroy the fowl and swine way of life. After picking their best and brightest, the birds and pigs come up with a scheme to infiltrate the island, deactivate the device and return to their respective paradises intact.',
    99,
    '2019-08-16',
    0,
    'img/angrybird2.jpg'
  ),
  (
    9,
    'Maleficent: Mistress of Evil',
    'A formidable queen causes a rift between Maleficent and Princess Aurora. Together, they must face new allies and enemies in a bid to protect the magical lands which they share.',
    118,
    '2019-10-16',
    0,
    'img/maleficentMoE.jpg'
  ),
  (
    10,
    'Lampor Keranda Terbang',
    'Edwin (Dion Wiyoko) dan Netta (Adinia Wirasti) bersama dua anak mereka, Agam (Bimasena) dan Sekar (Angelia Livie) kembali ke kampung Netta di Temanggung. Netta disambut curiga dan dianggap pembawa musibah karena kampungnya sedang dilanda teror Lampor, setan pencabut nyawa yang membawa keranda terbang. Edwin berusaha membela Istrinya, tetapi skandal busuk dan kejadian mengerikan muncul menghantui. Edwin mulai curiga bahwa ada rahasia besar menyangkut Netta yang tidak pernah diketahuinya. Apalagi ketika nyawa anak-anak mereka pun terancam, menjadi sasaran Lampor.',
    0,
    '2019-10-31',
    0,
    'img/lamporKT.jpg'
  ),
  (
    11,
    'Pretty Boys',
    'Rahmat and Anugerah, two best friends since childhood, aspire to be famous. Anugerah is always challenged by his father, Jono, because he considers that entertainment world is close to bad things. Anugerah runs away from home and tries his fortune to Jakarta with Rahmat. Fate says otherwise. Their career is just stuck as a waiter and restaurant cooks. Luckily there is Asty who has always been at Anugerah\'s side. One day, Anugerah and Rahmat, who are paid spectators at \"Kembang Gula\" (Candy) talk show, meet Roni, the audience coordinator, and Bayu. This meeting paves the way for the dreams of Rahmat and Anugerah?',
    100,
    '2019-09-19',
    0,
    'img/prettyboys.jpg'
  ),
  (
    12,
    'Tazza: One Eye Jack',
    'Do Il-Chool (Park Jung-Min) has a talent for playing poker and he is the son of Jjakgwi. His father was a gambler and had one ear cut off after he was caught cheating. Il-Chool meets mysterious gambler Aekku (Ryoo Seung-Bum) and gets involved in the master gambling world.',
    147,
    '2019-09-27',
    0,
    'img/tazza.jpg'
  ),
  (
    13,
    'Good Boys',
    'Invited to his first kissing party, 12-year-old Max asks his best friends Lucas and Thor for some much-needed help on how to pucker up. When they hit a dead end, Max decides to use his father\'s drone to spy on the teenage girls next door. When the boys lose the drone, they skip school and hatch a plan to retrieve it before Max\'s dad can figure out what happened.',
    90,
    '2019-09-25',
    0,
    'img/goodboys.jpg'
  ),
  (
    14,
    'Ad Astra',
    'Thirty years ago, Clifford McBride led a voyage into deep space, but the ship and crew were never heard from again. Now his son -- a fearless astronaut -- must embark on a daring mission to Neptune to uncover the truth about his missing father and a mysterious power surge that threatens the stability of the universe.',
    123,
    '2019-09-20',
    0,
    'img/adastra.jpg'
  );

-- --------------------------------------------------------
--
-- Table structure for table `MovieCategory`
--
CREATE TABLE `MovieCategory` (
  `idMovieCategory` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Dumping data for table `MovieCategory`
--
INSERT INTO
  `MovieCategory` (`idMovieCategory`, `idMovie`, `idCategory`)
VALUES
  (1, 1, 5),
  (2, 1, 2),
  (3, 1, 4),
  (4, 2, 6),
  (5, 3, 3),
  (6, 3, 4),
  (7, 4, 7),
  (8, 4, 8),
  (9, 5, 10),
  (10, 5, 9),
  (11, 6, 2),
  (12, 6, 3),
  (14, 7, 1),
  (15, 7, 5),
  (16, 7, 2),
  (17, 8, 1),
  (18, 8, 9),
  (19, 9, 7),
  (20, 9, 1),
  (21, 10, 6),
  (22, 11, 2),
  (23, 11, 10),
  (24, 12, 2),
  (25, 12, 5),
  (26, 13, 9),
  (27, 13, 10),
  (28, 14, 2),
  (29, 14, 7);

-- --------------------------------------------------------
--
-- Table structure for table `Review`
--
CREATE TABLE `Review` (
  `idReview` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `text` varchar(225) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

-- --------------------------------------------------------
--
-- Table structure for table `Schedule`
--
CREATE TABLE `Schedule` (
  `idSchedule` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `seatsLeft` int(2) NOT NULL DEFAULT '30'
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Dumping data for table `Schedule`
--
INSERT INTO
  `Schedule` (`idSchedule`, `idMovie`, `dateTime`, `seatsLeft`)
VALUES
  (1, 1, '2019-10-02 10:30:00', 30),
  (2, 1, '2019-10-02 19:00:00', 30),
  (3, 2, '2019-09-27 20:05:00', 30),
  (4, 2, '2019-09-27 22:30:00', 30),
  (5, 2, '2019-09-28 17:00:00', 30),
  (6, 2, '2019-09-28 20:50:00', 30),
  (7, 1, '2019-10-03 11:30:00', 30),
  (8, 1, '2019-10-03 19:00:00', 30),
  (9, 3, '2019-09-28 16:45:00', 30),
  (10, 3, '2019-09-28 18:10:00', 30),
  (11, 3, '2019-09-29 12:50:00', 30),
  (12, 3, '2019-09-29 18:10:00', 30),
  (13, 4, '2019-09-27 15:30:00', 30),
  (14, 4, '2019-09-27 17:50:00', 30),
  (15, 4, '2019-09-28 19:05:00', 30),
  (16, 4, '2019-09-28 21:25:00', 30),
  (17, 5, '2019-09-29 13:10:00', 30),
  (18, 5, '2019-09-30 21:40:00', 30),
  (19, 6, '2019-09-30 19:00:00', 30),
  (20, 6, '2019-09-30 21:55:00', 30),
  (21, 6, '2019-10-01 19:00:00', 30),
  (22, 6, '2019-10-01 22:00:00', 30),
  (23, 7, '2019-09-27 13:20:00', 30),
  (24, 7, '2019-09-28 17:21:00', 30),
  (25, 8, '2019-09-28 14:30:00', 30),
  (26, 9, '2019-10-16 12:30:00', 30),
  (27, 9, '2019-10-16 20:00:00', 30),
  (28, 9, '2019-10-17 13:30:00', 30),
  (29, 9, '2019-10-17 17:20:00', 30),
  (30, 10, '2019-10-31 22:00:00', 30),
  (31, 10, '2019-10-31 00:00:00', 30),
  (32, 10, '2019-11-01 19:45:00', 30),
  (33, 10, '2019-11-01 23:23:00', 30),
  (34, 11, '2019-09-30 13:10:00', 30),
  (35, 11, '2019-09-30 17:56:00', 30),
  (36, 11, '2019-10-01 17:55:00', 30),
  (37, 11, '2019-10-01 21:55:00', 30),
  (38, 12, '2019-09-30 18:00:00', 30),
  (39, 12, '2019-09-30 21:20:00', 30),
  (40, 12, '2019-10-01 15:10:00', 30),
  (41, 12, '2019-10-01 20:50:00', 30),
  (42, 13, '2019-10-01 16:00:00', 30),
  (43, 13, '2019-10-01 20:00:00', 30),
  (44, 13, '2019-10-02 12:30:00', 30),
  (45, 13, '2019-10-02 16:30:00', 30),
  (46, 14, '2019-09-27 22:00:00', 30),
  (47, 14, '2019-09-27 23:00:00', 30),
  (48, 14, '2019-09-29 13:00:00', 30),
  (49, 14, '2019-09-29 19:30:00', 30),
  (54, 6, '2019-09-28 20:00:00', 30);

-- --------------------------------------------------------
--
-- Table structure for table `User`
--
CREATE TABLE `User` (
  `idUser` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `Book`
--
ALTER TABLE
  `Book`
ADD
  PRIMARY KEY (`idBook`),
ADD
  KEY `idSchedule` (`idSchedule`),
ADD
  KEY `Book_ibfk_3` (`idUser`);

--
-- Indexes for table `Category`
--
ALTER TABLE
  `Category`
ADD
  PRIMARY KEY (`idCategory`);

--
-- Indexes for table `Cookie`
--
ALTER TABLE
  `Cookie`
ADD
  PRIMARY KEY (`idCookie`),
ADD
  KEY `idUser` (`idUser`);

--
-- Indexes for table `Movie`
--
ALTER TABLE
  `Movie`
ADD
  PRIMARY KEY (`idMovie`);

--
-- Indexes for table `MovieCategory`
--
ALTER TABLE
  `MovieCategory`
ADD
  PRIMARY KEY (`idMovieCategory`),
ADD
  KEY `idCategory` (`idCategory`),
ADD
  KEY `idMovie` (`idMovie`);

--
-- Indexes for table `Review`
--
ALTER TABLE
  `Review`
ADD
  PRIMARY KEY (`idReview`),
ADD
  KEY `idMovie` (`idMovie`),
ADD
  KEY `idUser` (`idBook`);

--
-- Indexes for table `Schedule`
--
ALTER TABLE
  `Schedule`
ADD
  PRIMARY KEY (`idSchedule`),
ADD
  KEY `idMovie` (`idMovie`),
ADD
  KEY `dateTime` (`dateTime`);

--
-- Indexes for table `User`
--
ALTER TABLE
  `User`
ADD
  PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `Book`
--
ALTER TABLE
  `Book`
MODIFY
  `idBook` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE
  `Category`
MODIFY
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT for table `Cookie`
--
ALTER TABLE
  `Cookie`
MODIFY
  `idCookie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Movie`
--
ALTER TABLE
  `Movie`
MODIFY
  `idMovie` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 15;

--
-- AUTO_INCREMENT for table `MovieCategory`
--
ALTER TABLE
  `MovieCategory`
MODIFY
  `idMovieCategory` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 30;

--
-- AUTO_INCREMENT for table `Review`
--
ALTER TABLE
  `Review`
MODIFY
  `idReview` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Schedule`
--
ALTER TABLE
  `Schedule`
MODIFY
  `idSchedule` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 55;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE
  `User`
MODIFY
  `idUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `Book`
--
ALTER TABLE
  `Book`
ADD
  CONSTRAINT `Book_ibfk_2` FOREIGN KEY (`idSchedule`) REFERENCES `Schedule` (`idSchedule`),
ADD
  CONSTRAINT `Book_ibfk_3` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`);

--
-- Constraints for table `Cookie`
--
ALTER TABLE
  `Cookie`
ADD
  CONSTRAINT `Cookie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`);

--
-- Constraints for table `MovieCategory`
--
ALTER TABLE
  `MovieCategory`
ADD
  CONSTRAINT `MovieCategory_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `Category` (`idCategory`),
ADD
  CONSTRAINT `MovieCategory_ibfk_2` FOREIGN KEY (`idMovie`) REFERENCES `Movie` (`idMovie`);

--
-- Constraints for table `Review`
--
ALTER TABLE
  `Review`
ADD
  CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`idMovie`) REFERENCES `Movie` (`idMovie`),
ADD
  CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `Book` (`idBook`);

--
-- Constraints for table `Schedule`
--
ALTER TABLE
  `Schedule`
ADD
  CONSTRAINT `Schedule_ibfk_1` FOREIGN KEY (`idMovie`) REFERENCES `Movie` (`idMovie`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;