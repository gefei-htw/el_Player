-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 31. Jan 2017 um 06:40
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbradio`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `state`
--

CREATE TABLE `state` (
  `ccover` varchar(255) DEFAULT NULL,
  `ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `state`
--

INSERT INTO `state` (`ccover`, `ID`) VALUES
('2247-tinykingdom.jpg', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_genre`
--

CREATE TABLE `tbl_genre` (
  `genre` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_genre`
--

INSERT INTO `tbl_genre` (`genre`) VALUES
('Alternative'),
('Blues'),
('Classical'),
('Country'),
('Dance Music'),
('Easy Listening'),
('Electronic Music'),
('European Music'),
('DHip Hop / Rap'),
('Indie Pop'),
('Inspirational'),
('Asian Pop'),
('Jazz'),
('Latin Music'),
('New Age'),
('Opera'),
('DHip Hop / Rap'),
('Pop'),
('R&B / Soul'),
('Reggae'),
('Rock'),
('World Music'),
('Singer / Songwriter'),
('Abstract');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_uploads`
--

CREATE TABLE `tbl_uploads` (
  `id` bigint(20) NOT NULL,
  `file` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `uploaddate` varchar(100) NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `upvotes` bigint(20) DEFAULT NULL,
  `downvotes` bigint(20) DEFAULT NULL,
  `totalupvotes` bigint(20) DEFAULT NULL,
  `totaldownvotes` bigint(20) DEFAULT NULL,
  `isplaying` varchar(10) DEFAULT NULL,
  `reset` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_uploads`
--

INSERT INTO `tbl_uploads` (`id`, `file`, `type`, `size`, `artist`, `title`, `genre`, `uploaddate`, `comments`, `cover`, `upvotes`, `downvotes`, `totalupvotes`, `totaldownvotes`, `isplaying`, `reset`) VALUES
(1, '81157-kognitif-yeahyeahyeah.mp3', 'audio/mp3', 242, 'Welcome', 'to el Player', 'Abstract', '2017-01-31', 'Share your Songs with everyone around', '2247-tinykingdom.jpg', 0, 0, 0, 0, 'no', 0),
(2, '58663-playing_for_change-sitting_on_the_dock.mp3', 'audio/mp3', 248, 'Playing For Change', 'Sitting on the Dock of the Bay', 'Blues', '2017-01-31', 'Connecting and Inspiring the World Through Music', '40200-fritzthecat.png', 0, 0, 0, 0, 'no', 0),
(3, '61023-tape-five----geraldines-routine.mp3', 'audio/mp3', 181, 'Tape Five', 'Geraldines Routine', 'Dance Music', '2017-01-31', 'Let it Swing', 'taefive.jpg', 0, 0, 0, 0, 'no', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `tbl_uploads`
--
ALTER TABLE `tbl_uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_uploads`
--
ALTER TABLE `tbl_uploads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
