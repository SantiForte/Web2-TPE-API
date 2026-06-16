SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `club` (
  `id_club` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `fecha_fundacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `club` (`id_club`, `nombre`, `pais`, `ciudad`, `fecha_fundacion`) VALUES
(1, 'inter de milan', 'italia', 'milan', '1994-04-04'),
(2, 'inter de miami', 'Estados Unidos', 'Miami', '1994-04-04'),
(3, 'boca', 'Argentina', 'buenos aires', '1904-03-19');

CREATE TABLE `futbolista` (
  `id_jugador` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `posicion` varchar(50) DEFAULT NULL,
  `id_club` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `futbolista` (`id_jugador`, `nombre`, `apellido`, `fecha_nacimiento`, `nacionalidad`, `posicion`, `id_club`) VALUES
(1, 'lautaro', 'martinez', '1998-05-08', 'argentina', 'delantero', 1),
(2, 'luis', 'henrique', '1998-07-08', 'brasil', 'extremo', 1),
(3, 'lionel', 'messi', '1998-07-04', 'argentina', 'extremo', 2),
(4, 'barella', '', NULL, NULL, 'mediocampista', 1);

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `rol` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `rol`) VALUES
(1, 'webadmin', '$2y$10$/seXIPVC.hyxnMAIdY2/M.F.I3dtl04KQs/0N1AyWTTEs/Kt2kysi', 'admin');


ALTER TABLE `club`
  ADD PRIMARY KEY (`id_club`);

ALTER TABLE `futbolista`
  ADD PRIMARY KEY (`id_jugador`),
  ADD KEY `futbolista_ibfk_1` (`id_club`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);


ALTER TABLE `club`
  MODIFY `id_club` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `futbolista`
  MODIFY `id_jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `futbolista`
  ADD CONSTRAINT `futbolista_ibfk_1` FOREIGN KEY (`id_club`) REFERENCES `club` (`id_club`) ON DELETE CASCADE ON UPDATE CASCADE;
  
 ALTER TABLE `club` ADD `foto` VARCHAR(250) NULL AFTER `fecha_fundacion`;

 UPDATE `club` SET `foto` = 'https://tn.com.ar/resizer/v2/el-topo-gigio-que-juan-roman-riquelme-le-dedico-a-mauricio-macri-en-plena-bombonera-telam-QLNSCUL7PZIBGS27B4XQPOQ4EU.jpg?auth=37146e2df3e18468cfc46fb149722cff2a5ec4d5253a642e253ab63d7a143d30&width=1440' WHERE `club`.`id_club` = 3

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
