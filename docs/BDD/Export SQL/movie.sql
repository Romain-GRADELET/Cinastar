-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `casting`;
CREATE TABLE `casting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_order` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D11BBA508F93B6FC` (`movie_id`),
  KEY `IDX_D11BBA50217BBB47` (`person_id`),
  CONSTRAINT `FK_D11BBA50217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_D11BBA508F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `casting` (`id`, `role`, `credit_order`, `movie_id`, `person_id`) VALUES
(1,	'Mario',	1,	2,	1),
(2,	'Princess Peach',	2,	2,	2),
(3,	'Luigi',	3,	2,	3),
(4,	'Bowser',	4,	2,	4),
(5,	'Tommy Shelby',	1,	3,	5),
(6,	'Tante Polly Gray',	2,	3,	6),
(7,	'Arthur Shelby',	3,	3,	7),
(8,	'Gina Gray',	4,	3,	2),
(9,	'Star Lord',	1,	4,	1),
(10,	'Gamora',	2,	4,	8),
(11,	'Drax le destructeur',	3,	4,	9),
(12,	'Yondu',	4,	4,	10);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230427131727',	'2023-04-27 15:19:13',	26),
('DoctrineMigrations\\Version20230427133333',	'2023-04-27 15:34:28',	44),
('DoctrineMigrations\\Version20230427134141',	'2023-04-27 15:42:57',	26),
('DoctrineMigrations\\Version20230427134451',	'2023-04-27 15:45:07',	25),
('DoctrineMigrations\\Version20230428122445',	'2023-04-28 14:25:09',	28),
('DoctrineMigrations\\Version20230428124820',	'2023-04-28 14:49:40',	41),
('DoctrineMigrations\\Version20230428144627',	'2023-04-28 16:46:45',	24),
('DoctrineMigrations\\Version20230502151441',	'2023-05-02 17:15:30',	87),
('DoctrineMigrations\\Version20230502151841',	'2023-05-02 17:18:56',	37),
('DoctrineMigrations\\Version20230502152039',	'2023-05-02 17:20:46',	35),
('DoctrineMigrations\\Version20230502152315',	'2023-05-02 17:23:26',	46),
('DoctrineMigrations\\Version20230502152423',	'2023-05-02 17:24:29',	42);

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `genre` (`id`, `name`) VALUES
(122,	'Action'),
(123,	'Animation'),
(124,	'Aventure'),
(125,	'Comédie'),
(126,	'Dessin Animé'),
(127,	'Documentaire'),
(128,	'Drame'),
(129,	'Espionnage'),
(130,	'Famille'),
(131,	'Fantastique'),
(132,	'Historique'),
(133,	'Policier'),
(134,	'Romance'),
(135,	'Science-Fiction'),
(136,	'Thriller'),
(137,	'Western');

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `rating` double NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `synopsis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  `country` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D5EF26FC54C8C93` (`type_id`),
  CONSTRAINT `FK_1D5EF26FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie` (`id`, `title`, `type_id`, `duration`, `rating`, `summary`, `synopsis`, `release_date`, `country`, `poster`) VALUES
(2,	'Super Mario Bros, le film',	1,	92,	4.2,	'Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.',	'Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.\r\n\r\nDans sa quête, il peut compter sur l’aide du champignon Toad, habitant du Royaume Champignon, et les conseils avisés, en matière de techniques de combat, de la Princesse Peach, guerrière déterminée à la tête du Royaume. C’est ainsi que Mario réussit à mobiliser ses propres forces pour aller au bout de sa mission. ',	'2023-05-04',	'USA',	'https://fr.web.img6.acsta.net/c_150_200/pictures/23/03/20/14/57/4979368.jpg'),
(3,	'Peaky Blinders',	2,	52,	4.5,	'En 1919, à Birmingham, soldats, révolutionnaires politiques et criminels combattent pour se faire une place dans le paysage industriel de l\'après-Guerre.',	'En 1919, à Birmingham, soldats, révolutionnaires politiques et criminels combattent pour se faire une place dans le paysage industriel de l\'après-Guerre. Le Parlement s\'attend à une violente révolte, et Winston Churchill mobilise des forces spéciales pour contenir les menaces. La famille Shelby compte parmi les membres les plus redoutables. Surnommés les \"Peaky Blinders\" par rapport à leur utilisation de lames de rasoir cachées dans leurs casquettes, ils tirent principalement leur argent de paris et de vol. Tommy Shelby, le plus dangereux de tous, va devoir faire face à l\'arrivée de Campbell, un impitoyable chef de la police qui a pour mission de nettoyer la ville. Ne doit-il pas se méfier tout autant de la ravissante Grace Burgess ? Fraîchement installée dans le voisinage, celle-ci semble cacher un mystérieux passé et un dangereux secret. ',	'2013-01-01',	'UK',	'https://fr.web.img5.acsta.net/c_150_200/pictures/22/06/07/11/57/5231272.jpg'),
(4,	'Les Gardiens de la Galaxie 2',	1,	136,	4.1,	'Musicalement accompagné de la \"Awesome Mixtape n°2\" (la musique qu\'écoute Star-Lord dans le film), Les Gardiens de la galaxie 2 poursuit les aventures de l\'équipe alors qu\'elle traverse les confins du cosmos. Les gardiens doivent combattre pour rester unis alors qu\'ils découvrent les mystères de la filiation de Peter Quill. Les vieux ennemis vont devenir de nouveaux alliés et des personnages bien connus des fans de comics vont venir aider nos héros et continuer à étendre l\'univers Marvel. ',	'Musicalement accompagné de la \"Awesome Mixtape n°2\" (la musique qu\'écoute Star-Lord dans le film), Les Gardiens de la galaxie 2 poursuit les aventures de l\'équipe alors qu\'elle traverse les confins du cosmos. Les gardiens doivent combattre pour rester unis alors qu\'ils découvrent les mystères de la filiation de Peter Quill. Les vieux ennemis vont devenir de nouveaux alliés et des personnages bien connus des fans de comics vont venir aider nos héros et continuer à étendre l\'univers Marvel. ',	'2017-04-26',	'USA',	'https://fr.web.img6.acsta.net/c_310_420/pictures/17/03/01/11/10/438835.jpg');

DROP TABLE IF EXISTS `movie_genre`;
CREATE TABLE `movie_genre` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`genre_id`),
  KEY `IDX_FD1229648F93B6FC` (`movie_id`),
  KEY `IDX_FD1229644296D31F` (`genre_id`),
  CONSTRAINT `FK_FD1229644296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FD1229648F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie_genre` (`movie_id`, `genre_id`) VALUES
(2,	122),
(2,	123),
(2,	124),
(2,	125),
(3,	128),
(3,	132),
(3,	133),
(4,	122),
(4,	125),
(4,	135);

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `person` (`id`, `firstname`, `lastname`) VALUES
(1,	'Chris',	'Pratt'),
(2,	'Anya',	'Taylor-Joy'),
(3,	'Charlie',	'Day'),
(4,	'Jack',	'Black'),
(5,	'Cillian',	'Murphy'),
(6,	'Helen',	'McCrory'),
(7,	'Paul',	'Anderson'),
(8,	'Zoe',	'Saldana'),
(9,	'Dave',	'Bautista'),
(10,	'Michael',	'Rooker');

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type` (`id`, `name`) VALUES
(1,	'Film'),
(2,	'Série');

-- 2023-05-03 12:00:51