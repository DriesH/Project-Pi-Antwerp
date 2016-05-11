-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 mei 2016 om 13:32
-- Serverversie: 10.1.10-MariaDB
-- PHP-versie: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

CREATE DATABASE mydb;
USE mydb;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `idCategorie` int(10) NOT NULL,
  `naam` varchar(45) DEFAULT NULL,
  `icon_class` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`idCategorie`, `naam`, `icon_class`) VALUES
(5, 'Verkeer', 'fa fa-car'),
(7, 'Infrastructuur', 'fa fa-building'),
(9, 'Openbare werken', 'fa fa-wrench');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) CHARACTER SET utf8 NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `phases`
--

CREATE TABLE `phases` (
  `idFase` int(10) NOT NULL,
  `faseNummer` int(11) DEFAULT NULL,
  `title` varchar(35) DEFAULT NULL,
  `uitleg` longtext,
  `foto` varchar(45) DEFAULT NULL,
  `status` enum('not-started','in-progress','done','') NOT NULL DEFAULT 'not-started',
  `isLocked` tinyint(1) DEFAULT NULL,
  `start_datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idProject` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `phases`
--

INSERT INTO `phases` (`idFase`, `faseNummer`, `title`, `uitleg`, `foto`, `status`, `isLocked`, `start_datum`, `idProject`) VALUES
(1, 1, 'Lorum Ipsum', 'In tincidunt, risus in posuere dapibus, quam nisi maximus massa, eu congue leo ligula quis erat. Suspendisse imperdiet est eget dui maximus, sit amet volutpat justo semper. Curabitur auctor erat ut sollicitudin vestibulum. Curabitur sagittis ultricies nibh, ac fringilla urna consectetur nec. Maecenas lacus nisi, volutpat sit amet orci a, finibus faucibus massa. Vestibulum ac arcu odio. Nunc lacinia vel eros at suscipit. Maecenas mattis lobortis lectus at dignissim. Aenean est neque, elementum a lectus ac, porta dictum ipsum. Ut in ligula ex. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Interdum et malesuada fames ac ante ipsum primis in faucibus.', NULL, 'done', 0, '2016-05-07 15:23:31', 3),
(2, 2, 'Lorem Ipsum Dolor', 'In tincidunt, risus in posuere dapibus, quam nisi maximus massa, eu congue leo ligula quis erat. Suspendisse imperdiet est eget dui maximus, sit amet volutpat justo semper. Curabitur auctor erat ut sollicitudin vestibulum. Curabitur sagittis ultricies nibh, ac fringilla urna consectetur nec. Maecenas lacus nisi, volutpat sit amet orci a, finibus faucibus massa. Vestibulum ac arcu odio. Nunc lacinia vel eros at suscipit. Maecenas mattis lobortis lectus at dignissim. Aenean est neque, elementum a lectus ac, porta dictum ipsum. Ut in ligula ex. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Interdum et malesuada fames ac ante ipsum primis in faucibus.', NULL, 'in-progress', 0, '2016-05-07 15:23:57', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE `projects` (
  `idProject` int(10) NOT NULL,
  `naam` varchar(45) DEFAULT NULL,
  `uitleg` longtext,
  `locatie` varchar(45) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `huidige_fasenr` int(11) DEFAULT '0',
  `isActief` tinyint(1) DEFAULT NULL,
  `isAfgerond` tinyint(1) DEFAULT '0',
  `idCategorie` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `projects`
--

INSERT INTO `projects` (`idProject`, `naam`, `uitleg`, `locatie`, `foto`, `huidige_fasenr`, `isActief`, `isAfgerond`, `idCategorie`, `created_at`) VALUES
(3, 'Lorem Ipsum', 'Etiam venenatis dui eget dolor pharetra, et vulputate felis luctus. Etiam luctus viverra diam, eget tempus lectus tincidunt vitae. Nulla molestie venenatis magna, sed porttitor leo finibus eu. Aliquam lobortis felis eu lorem dignissim congue congue nec tellus. Nunc at cursus risus. Donec aliquam dignissim convallis. Integer dictum nisl id elit aliquam, eget molestie risus suscipit. Integer congue tellus a rhoncus placerat. Ut nec purus a ante tincidunt rhoncus. Duis porta bibendum tristique. Sed sit amet varius nibh. Donec justo ante, tristique non fermentum in, faucibus a purus. Integer vel finibus erat.', 'Hoboken', '/pictures/uploads/5731c4e59ef86.jpg', 0, 1, 0, 5, '2016-05-06 13:17:25'),
(4, 'Project: Lorum Ipsum', 'Aliquam erat volutpat. Proin auctor, tellus at dapibus tincidunt, ipsum odio varius libero, ut aliquet sapien urna at leo. Integer convallis euismod lorem, vel imperdiet nibh pharetra vel. Nunc id leo facilisis, luctus nibh at, venenatis orci. Mauris sit amet pharetra tellus, a facilisis nulla. Nulla facilisi. Suspendisse sed lectus dapibus, finibus tellus eu, venenatis est. Phasellus quam nunc, lacinia vitae euismod sed, pellentesque vitae justo.', 'Antwerpen', '/pictures/uploads/572c9e558e057.jpg', 0, 1, 0, 9, '2016-05-06 13:26:09'),
(5, 'Lorem Ipsum', 'Morbi at condimentum nisl. In id felis eget turpis varius ultrices. In volutpat luctus pellentesque. Donec aliquam id lectus ut aliquam. Morbi sollicitudin posuere magna non faucibus. Cras vel faucibus felis. In eu urna luctus, laoreet neque sit amet, aliquam dolor. Phasellus elementum ante id vulputate vulputate.', 'Antwerpen', '/pictures/uploads/5731c510e4444.png', 0, 1, 0, 7, '2016-05-06 13:29:01'),
(6, 'Nieuw project', 'Donec congue dui nec neque consequat tempus. Ut ac tincidunt est, quis vulputate ipsum. Nulla nec magna leo. Maecenas blandit erat eget dapibus bibendum. Fusce id porttitor erat. Maecenas vulputate mauris sit amet quam ornare viverra. Ut aliquet magna quam, quis tincidunt odio tempus at.', 'Antwerpen', '/pictures/uploads/5731fe3e7667d.jpg', 0, 1, 0, 9, '2016-05-10 15:29:02'),
(7, 'Test project', 'Cras volutpat tortor vitae elementum malesuada. Nulla facilisi. Nulla ornare convallis consequat. Sed venenatis, sapien ut fringilla venenatis, ex quam efficitur massa, in mattis sapien odio id sapien. Etiam fringilla nulla eros, vel pretium quam efficitur sit amet. Mauris purus libero, elementum et molestie nec, tempus id nunc. Maecenas semper diam ut posuere mollis. Suspendisse iaculis convallis vulputate. Mauris ac lacus laoreet, ultrices nisl sit amet, dignissim ex. In sit amet gravida dolor. Praesent convallis luctus dui, quis aliquam velit ultrices molestie. Aliquam quis nisl vitae lacus consectetur semper. Nulla in massa feugiat, facilisis ante placerat, lacinia orci.', 'Hoboken', '/pictures/uploads/5731fec3f2f46.jpg', 0, 1, 0, 7, '2016-05-10 15:31:15'),
(8, 'Test project 2', 'Cras volutpat tortor vitae elementum malesuada. Nulla facilisi. Nulla ornare convallis consequat. Sed venenatis, sapien ut fringilla venenatis, ex quam efficitur massa, in mattis sapien odio id sapien. Etiam fringilla nulla eros, vel pretium quam efficitur sit amet. Mauris purus libero, elementum et molestie nec, tempus id nunc. Maecenas semper diam ut posuere mollis. Suspendisse iaculis convallis vulputate. Mauris ac lacus laoreet, ultrices nisl sit amet, dignissim ex. In sit amet gravida dolor. Praesent convallis luctus dui, quis aliquam velit ultrices molestie. Aliquam quis nisl vitae lacus consectetur semper. Nulla in massa feugiat, facilisis ante placerat, lacinia orci.', 'Antwerpen', '/pictures/uploads/5731fedb375fa.jpg', 0, 1, 0, 9, '2016-05-10 15:31:39'),
(9, 'Test project 3', 'test', 'test', '/pictures/uploads/57324c3c8777a.jpg', 0, 1, 0, 7, '2016-05-10 21:01:48'),
(10, 'test', 'test', 'test', '/pictures/uploads/57324c5975775.jpg', 0, 1, 0, 9, '2016-05-10 21:02:17'),
(11, 'test', 'etest', 'setest', '/pictures/uploads/57324c6275abb.jpg', 0, 1, 0, 7, '2016-05-10 21:02:26');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `questions`
--

CREATE TABLE `questions` (
  `idVraag` int(11) NOT NULL,
  `vraag` mediumtext,
  `soort_vraag` int(11) DEFAULT NULL,
  `idFase` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `questions`
--

INSERT INTO `questions` (`idVraag`, `vraag`, `soort_vraag`, `idFase`) VALUES
(2, 'In tincidunt, risus in posuere dapibus, quam nisi maximus massa, eu congue leo ligula quis erat?', 0, 1),
(3, 'Suspendisse imperdiet est eget dui maximus, sit amet volutpat justo semper?', 1, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Dries Heyninck', 'test-user@test.be', '$2y$10$4GaEQkFcs0jn81AAFI15pu/f6q/vrd3.ty0k0RkFMVranNsDjs4L.', 'A4F7KBZRehy31PyUblanE9OssepPdk053all6DaKaMX909dnYwAdDnwniPq7', '2016-05-06 11:04:30', '2016-05-10 14:09:15', 10),
(2, 'Joren Hemel', 'joren_sexy@lala.com', '$2y$10$vqT.e6pylq56LqQuFYUsUOjQ8rPjXtz9Evz3byXZ/emLgGIxzw/qa', '0JX1s6dyLrIiGI7ufkR8Gisvyg5Q9x5tMVlW0LSBQ8bCKJcLKaMiEy6FRpsp', '2016-05-10 09:34:46', '2016-05-10 14:09:36', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_follows`
--

CREATE TABLE `user_follows` (
  `id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_follows`
--

INSERT INTO `user_follows` (`id`, `created_at`, `updated_at`, `user_id`, `project_id`) VALUES
(31, '2016-05-10 15:35:06', '2016-05-10 15:35:06', 2, 8),
(32, '2016-05-10 15:35:10', '2016-05-10 15:35:10', 2, 6),
(34, '2016-05-10 20:59:52', '2016-05-10 20:59:52', 1, 5);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Indexen voor tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexen voor tabel `phases`
--
ALTER TABLE `phases`
  ADD PRIMARY KEY (`idFase`),
  ADD KEY `fk_Fase_Project1_idx` (`idProject`);

--
-- Indexen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`idProject`),
  ADD KEY `fk_Project_Categorie_idx` (`idCategorie`);

--
-- Indexen voor tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`idVraag`),
  ADD KEY `fk_Vraag_Fase1_idx` (`idFase`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexen voor tabel `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idx` (`user_id`),
  ADD KEY `project_id_idx` (`project_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategorie` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT voor een tabel `phases`
--
ALTER TABLE `phases`
  MODIFY `idFase` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `idProject` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT voor een tabel `questions`
--
ALTER TABLE `questions`
  MODIFY `idVraag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `phases`
--
ALTER TABLE `phases`
  ADD CONSTRAINT `Fase_Project1` FOREIGN KEY (`idProject`) REFERENCES `projects` (`idProject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `Project_Categorie` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `Vraag_Fase1` FOREIGN KEY (`idFase`) REFERENCES `phases` (`idFase`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`idProject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
