-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 12 Nov 2019 pada 03.44
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubes2-wbd`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `Book`
--

CREATE TABLE `Book` (
  `idBook` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idSchedule` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `isRate` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Cookie`
--

CREATE TABLE `Cookie` (
  `idCookie` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  `expiredDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Cookie`
--

INSERT INTO `Cookie` (`idCookie`, `value`, `idUser`, `expiredDate`) VALUES
(1, '1573525222#1208', 1, '2019-11-13 09:20:22'),
(2, '1573525250#1634', 1, '2019-11-13 09:20:50'),
(3, '1573525263#5604', 1, '2019-11-13 09:21:03'),
(4, '1573525268#8205', 1, '2019-11-13 09:21:08'),
(5, '1573525280#8674', 1, '2019-11-13 09:21:20'),
(6, '1573525288#6645', 1, '2019-11-13 09:21:28'),
(7, '1573525369#4329', 1, '2019-11-13 09:22:49'),
(8, '1573525379#4098', 1, '2019-11-13 09:22:59'),
(9, '1573525407#6016', 1, '2019-11-13 09:23:27'),
(10, '1573525414#8576', 1, '2019-11-13 09:23:34'),
(11, '1573525432#5822', 1, '2019-11-13 09:23:52'),
(12, '1573525440#7542', 1, '2019-11-13 09:24:00'),
(13, '1573525451#5266', 1, '2019-11-13 09:24:11'),
(14, '1573525464#4009', 1, '2019-11-13 09:24:24'),
(15, '1573525471#3690', 1, '2019-11-13 09:24:31'),
(16, '1573525623#3786', 1, '2019-11-13 09:29:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Review`
--

CREATE TABLE `Review` (
  `idReview` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `text` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Schedule`
--

CREATE TABLE `Schedule` (
  `idSchedule` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `seatsLeft` int(2) NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `User`
--

CREATE TABLE `User` (
  `idUser` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `User`
--

INSERT INTO `User` (`idUser`, `username`, `email`, `phonenumber`, `password`, `picture`) VALUES
(1, 'abc', 'a@a.com', '1234567890', 'a', 'img/avatar.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `Book`
--
ALTER TABLE `Book`
  ADD PRIMARY KEY (`idBook`),
  ADD KEY `idSchedule` (`idSchedule`),
  ADD KEY `Book_ibfk_3` (`idUser`);

--
-- Indeks untuk tabel `Cookie`
--
ALTER TABLE `Cookie`
  ADD PRIMARY KEY (`idCookie`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`idReview`),
  ADD KEY `idMovie` (`idMovie`),
  ADD KEY `idUser` (`idBook`);

--
-- Indeks untuk tabel `Schedule`
--
ALTER TABLE `Schedule`
  ADD PRIMARY KEY (`idSchedule`),
  ADD KEY `idMovie` (`idMovie`),
  ADD KEY `dateTime` (`dateTime`);

--
-- Indeks untuk tabel `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `Book`
--
ALTER TABLE `Book`
  MODIFY `idBook` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `Cookie`
--
ALTER TABLE `Cookie`
  MODIFY `idCookie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `Review`
--
ALTER TABLE `Review`
  MODIFY `idReview` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `Schedule`
--
ALTER TABLE `Schedule`
  MODIFY `idSchedule` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `User`
--
ALTER TABLE `User`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `Book`
--
ALTER TABLE `Book`
  ADD CONSTRAINT `Book_ibfk_2` FOREIGN KEY (`idSchedule`) REFERENCES `Schedule` (`idSchedule`),
  ADD CONSTRAINT `Book_ibfk_3` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`);

--
-- Ketidakleluasaan untuk tabel `Cookie`
--
ALTER TABLE `Cookie`
  ADD CONSTRAINT `Cookie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`);

--
-- Ketidakleluasaan untuk tabel `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `Book` (`idBook`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
