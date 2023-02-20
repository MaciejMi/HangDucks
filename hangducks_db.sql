-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Lut 2023, 18:08
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `hangducks_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `words`
--

CREATE TABLE `words` (
  `word` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `category_fk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `level` enum('easy','normal','hard','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `words`
--

INSERT INTO `words` (`word`, `category_fk`, `level`) VALUES
('Birma', 'geografia', 'normal'),
('dzik', 'zwierzęta\r\n', 'easy'),
('Honduras', 'geografia', 'hard'),
('kaczka', 'zwierzęta\r\n', 'easy'),
('komputer', 'inne\r\n', 'normal'),
('kura', 'zwierzęta\r\n', 'easy'),
('lis', 'zwierzęta\r\n', 'easy'),
('Mjanma', 'geografia', 'normal'),
('Nigeria', 'geografia', 'normal'),
('Tajlandia', 'geografia', 'hard');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`word`),
  ADD KEY `words_categories_fk` (`category_fk`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_categories_fk` FOREIGN KEY (`category_fk`) REFERENCES `categories` (`category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
