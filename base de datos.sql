-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-11-2024 a las 13:51:06
-- Versión del servidor: 10.11.9-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u256984127_nelly`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `Documento_identidad` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`Documento_identidad`, `Contraseña`) VALUES
('123456', '$2y$10$HPnA.S3BFnU6nOXD1sTfe.ib5q9uhjOt7VErwoEdHcg'),
('123456', '$2y$10$bfFMDtbIx8CQcBetRwfFCe6ZnOv4ctCJ1AO9S.v9bzz'),
('123456', '$2y$10$QVUH6tEyQL2vua2D2/TidOoBQgM1FSG/9ISs7RqL/36'),
('123456', '$2y$10$0sdb/BEXwYpawY.m.KlpAuCF7P.LQ8K1/TwFA8Ou48e'),
('123456', '$2y$10$Du03NF39QZICC7gTua8RI.9E/JDMELuYnFr1oY5DiJr'),
('123456', '$2y$10$jVuWjdwgMdAkLwWSpOU.uu5I0F8wW.OFbRaD0l4bH3i'),
('123456', '$2y$10$V7l.12VAAM1EN/Yj3rBkwusaZg1tSXd52I9D.vs7mxT'),
('88233738', '$2y$10$WP7FFwOGuao5GWwW1Q6zIONzAufS6iqlJVzCZCdkk3j'),
('88233738', '$2y$10$o2Y9zncN8HGFcblWNT7F3OJ0AAdb64YLuzWqhmkYVbv'),
('88233738', '$2y$10$uSokzaeKn6dQITqyrqnIw.8Ugx58hiAlkOIMMBsSH7u'),
('88233738', '$2y$10$T1PMteQzlg0Py02tfRlx..i8HQuqpqDv6EM.YxMhb/u'),
('88233738', '$2y$10$EHUh3SUAOv9hbOUObmuNJeefN14AQtbFEqIPtIBIzt/'),
('88233738', '$2y$10$.Jw4PHQJ2zSJ4jTopDP8BOd58yLOOi9tuYkusi5r85j'),
('88233738', '$2y$10$aD21LjhupPMEze7ordwH3uZMYaplN4XHv/v6pIpJWC6'),
('88233738', '$2y$10$BX5UJjk3t8iUqjoDKOhd7.cbkDPPBv0OvJ6ZCZbhTef'),
('123456', 'admin123'),
('109134', '123'),
('123456', 'Nose2008');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `documento_identidad` varchar(50) DEFAULT NULL,
  `tipo_permiso` varchar(50) DEFAULT NULL,
  `fecha_permiso` datetime DEFAULT current_timestamp(),
  `estado` enum('Pendiente','Aprobado','Rechazado') DEFAULT 'Pendiente',
  `nombre` varchar(50) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `riesgo` varchar(20) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `fecha_solicitud` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duracion` int(11) DEFAULT NULL,
  `unidad_duracion` enum('horas','dias','meses') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `Motivo` varchar(255) DEFAULT NULL,
  `comentario_admin` text DEFAULT NULL,
  `otro_motivo` varchar(255) DEFAULT NULL,
  `motivo_otro` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `documento_identidad`, `tipo_permiso`, `fecha_permiso`, `estado`, `nombre`, `celular`, `riesgo`, `documento`, `fecha_solicitud`, `duracion`, `unidad_duracion`, `email`, `fecha_inicio`, `fecha_fin`, `usuario_id`, `Motivo`, `comentario_admin`, `otro_motivo`, `motivo_otro`) VALUES
(19, '654321', 'Viaje', '2024-10-27 00:00:00', 'Rechazado', NULL, NULL, NULL, NULL, '2024-10-27 00:00:00', NULL, 'horas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '654321', 'Cita medica', '2024-10-28 00:00:00', 'Aprobado', NULL, NULL, NULL, NULL, '2024-10-27 00:00:00', NULL, 'horas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '654321', 'Boda', '2024-11-09 00:00:00', 'Rechazado', NULL, NULL, NULL, NULL, '2024-10-27 00:00:00', NULL, 'horas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '654321', 'jjqk', '2024-11-06 00:00:00', 'Rechazado', NULL, NULL, NULL, 'Manuales de uso aparaots electronicos.docx', '2024-10-27 00:00:00', NULL, 'horas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '654321', 'Boda Renumerado', '2024-11-06 00:00:00', 'Aprobado', 'Nelly Fabiola Cano Oviedo', '1091360390', 'bajo', 'Solicitud de apoyo para campaña de concientización ambiental RECICLAFESC (1).pdf', '2024-10-27 00:00:00', NULL, 'horas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '654321', 'No Remunarado', '2024-10-25 00:00:00', 'Aprobado', 'Maria del Carmen Oviedo Garcia', '3103456023', 'bajo', 'Corrección Articulo de Reflexión (1).docx', '2024-10-29 00:00:00', 24, 'horas', 'est_nf_cano@fesc.edu.co', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '654321', 'Renumerado', '2024-11-09 00:00:00', 'Aprobado', 'Martin Emilio Cano Arias', '3103456023', 'bajo', 'Informe inventario.docx', '2024-10-29 00:00:00', 2, 'dias', 'est_nf_cano@fesc.edu.co', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '654321', 'Renumerado', '2024-11-09 00:00:00', 'Rechazado', 'Maria Nery Garcia', '3108895042', 'bajo', 'Solicitud de apoyo para campaña de concientización ambiental RECICLAFESC.docx', '2024-10-29 00:00:00', 10, 'dias', 'nellyfabiola669@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '654321', 'No Remunarado', '2024-10-09 00:00:00', 'Rechazado', 'Diannis Oviedo', '3103456023', 'bajo', 'Manuales de uso aparaots electronicos (1).docx', '2024-10-29 00:00:00', 20, 'horas', 'nellycano800@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '654321', 'renumerado', '2024-10-29 00:00:00', 'Aprobado', 'Neco Duran', '3108895042', 'bajo', 'detalles_solicitud (9).pdf', '2024-10-30 00:00:00', 4, 'horas', 'nellyfabiola669@gmail.com', '2024-11-09', '2024-11-09', NULL, NULL, NULL, NULL, NULL),
(29, '1091360390', 'renumerado', '2024-10-30 00:00:00', 'Aprobado', 'Melanie ', '3108895042', 'bajo', 'Carta a EPS Sanitas.pdf', '2024-10-30 00:00:00', 1, 'meses', 'nellyfabiola669@gmail.com', '2024-11-09', '2024-11-30', NULL, NULL, NULL, NULL, NULL),
(30, '1091360390', 'renumerado', '2024-10-30 00:00:00', 'Aprobado', 'Melanie ', '3108895042', 'bajo', 'Carta a EPS Sanitas.pdf', '2024-10-30 00:00:00', 1, 'meses', 'nellyfabiola669@gmail.com', '2024-11-09', '2024-11-30', NULL, NULL, NULL, NULL, NULL),
(34, '1091360390', 'renumerado', '2024-10-30 00:00:00', 'Rechazado', 'Melanie ', '3108895042', 'bajo', 'Carta a EPS Sanitas.pdf', '2024-10-30 00:00:00', 1, 'meses', 'nellyfabiola669@gmail.com', '2024-11-09', '2024-11-30', NULL, NULL, NULL, NULL, NULL),
(35, '1091360390', 'no renumerado', '2024-10-30 00:00:00', 'Rechazado', 'Melanie ', '3108895042', 'bajo', 'Carta a EPS Sanitas.pdf', '2024-10-30 00:00:00', 1, 'meses', 'nellyfabiola669@gmail.com', '2024-11-09', '2024-11-30', NULL, NULL, NULL, NULL, NULL),
(36, '1091360390', 'No Remunarado', '2024-12-02 00:00:00', 'Rechazado', 'Nick', '3108895042', 'medio', NULL, '2024-11-06 00:00:00', 24, 'horas', 'sumercecomb+261tf@gmail.com', '2024-11-08', '2024-10-30', NULL, NULL, NULL, NULL, NULL),
(37, '37391752', 'renumerado', '2024-11-07 00:00:00', 'Aprobado', 'Maria del Carmen Oviedo Garcia', '3108895042', 'medio', NULL, '2024-11-07 00:00:00', 4, 'horas', 'nellycano800@gmail.com', '2024-11-20', '2024-11-20', NULL, NULL, NULL, NULL, NULL),
(38, '1091360390', 'no Renumerado', '2024-11-07 00:00:00', 'Aprobado', 'Jhojan Oviedo', '3108895042', 'medio', 'detalles_solicitud.pdf', '2024-11-07 00:00:00', 1, 'dias', 'nellycano800@gmail.com', '2024-11-14', '2024-11-15', NULL, NULL, NULL, NULL, NULL),
(39, '1091360390', 'no_remunerado', '2024-11-07 00:00:00', 'Rechazado', 'Nelly Fabiola Cano Oviedo', '3108895042', 'medio', NULL, '2024-11-26 22:47:45', 5, 'horas', 'jjk@gmail.com', '2024-11-21', '2024-11-21', NULL, 'otro', NULL, 'Viaje', NULL),
(40, '1091360390', 'remunerado', '2024-11-07 00:00:00', 'Aprobado', 'Dana Hernandez', '3100230', 'alto', NULL, '2024-11-08 00:00:00', 3, 'dias', 'g@gmail.com', '2024-11-14', '2024-11-14', NULL, 'estudio', NULL, NULL, NULL),
(42, '1091360390', 'remunerado', '2024-11-13 00:00:00', 'Aprobado', 'Juan Galindo O', '3108895042', 'alto', 'detalles_solicitud (7).pdf', '2024-11-13 00:00:00', 4, 'horas', 'est_nf_cano@fesc.edu.co', '2024-12-25', '2024-12-25', NULL, 'estudio', NULL, NULL, NULL),
(43, '1102358366', 'No se', '2024-11-13 00:00:00', 'Aprobado', 'Javier martinez ', '313 3402359 ', 'bajo', NULL, '2024-11-14 00:00:00', 1, 'dias', 'est_wj_martinez@fesc.edu.co', '2024-11-16', '2024-11-16', NULL, NULL, NULL, NULL, NULL),
(44, '1102634968', 'Permiso de estrangero ', '2024-11-13 00:00:00', 'Aprobado', 'Marlon Padilla ', '3161516601', 'alto', NULL, '2024-11-14 00:00:00', 7, 'meses', 'marlon20872j@gmail.com', '2024-11-13', '2031-01-31', NULL, NULL, NULL, NULL, NULL),
(45, '1005030227', 'Tipo de permiso viaje por una cirugía ', '2024-11-13 00:00:00', 'Aprobado', 'Ferney eduardo fernandez ', '1005030227', 'bajo', NULL, '2024-11-14 00:00:00', 30, 'dias', 'Ferneyeuardof@gmail.com', '2024-11-16', '2024-11-21', NULL, NULL, NULL, NULL, NULL),
(46, '1091360390', 'no_remunerado', '2024-11-14 00:00:00', 'Aprobado', 'Nelly Fabiola Cano Oviedo', '3108895042', 'medio', NULL, '2024-11-26 21:51:33', 1, 'dias', 'sumercecomb+261tf@gmail.com', '2024-11-21', '2024-11-22', NULL, 'salud', NULL, NULL, NULL),
(47, '123456789', 'Vacaciones', '2024-11-25 00:00:00', 'Aprobado', 'Juan Pérez', '1234567890', 'Bajo', 'ruta_del_documento.pdf', '0000-00-00 00:00:00', 7, 'dias', 'juan.perez@example.com', '2024-11-26', '2024-12-02', 1, 'Vacaciones anuales', NULL, NULL, NULL),
(48, '1091360390', 'no_remunerado', '2024-11-20 00:00:00', 'Aprobado', 'nelly', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 8, 'dias', 'nellycano800@gmail.com', '2024-11-21', '2024-11-28', NULL, 'Salud', NULL, '', NULL),
(49, '123456', 'remunerado', '2024-11-20 00:00:00', 'Aprobado', 'Pepito', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 8, 'dias', 'nellycano800@gmail.com', '2024-11-21', '2024-11-28', NULL, 'Familiar', NULL, '', NULL),
(50, '123456', 'no_remunerado', '2024-11-20 00:00:00', 'Aprobado', 'Pepito', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 2, 'dias', 'est_nf_cano@fesc.edu.co', '2024-11-28', '2024-11-30', NULL, 'Otro', NULL, 'EY EY EY', NULL),
(51, '1148454407', 'remunerado', '2024-11-20 00:00:00', 'Rechazado', 'Javi', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 4, 'dias', 'nellycano800@gmail.com', '2024-11-22', '2024-11-26', NULL, 'Otro', NULL, 'EY EY EY', NULL),
(52, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Nelly Fabiola Cano Oviedo', NULL, 'Alto', NULL, '0000-00-00 00:00:00', 4, 'dias', 'nellycano800@gmail.com', '2024-11-26', '2024-11-30', NULL, 'Estudios', NULL, '', NULL),
(53, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Nelly Fabiola Cano Oviedo', NULL, 'Bajo', NULL, '2024-11-26 22:25:23', 10, 'dias', 'est_nf_cano@fesc.edu.co', '2024-11-11', '2024-11-23', NULL, 'Otro', NULL, 'Vacaciones', NULL),
(54, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Maria del Carmen Oviedo Garcia', NULL, 'Medio', NULL, '2024-11-26 22:38:42', 30, 'dias', 'Olive.Gilmorehg@students.clatsopcc.edu', '2024-12-02', '2024-11-05', NULL, 'Salud', NULL, '', NULL),
(55, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Maria del Carmen Oviedo Garcia', NULL, 'Medio', NULL, '2024-11-26 22:48:14', 30, 'dias', 'Olive.Gilmorehg@students.clatsopcc.edu', '2024-12-02', '2024-11-05', NULL, 'Salud', NULL, '', NULL),
(56, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Pendiente', 'Maria del Carmen Oviedo Garcia', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 25, 'dias', 'Olive.Gilmorehg@students.clatsopcc.edu', '2024-12-02', '2024-11-05', NULL, 'Estudios', NULL, '', NULL),
(57, '1091360390', 'no_remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Maria del Carmen Oviedo Garcia', NULL, 'Bajo', NULL, '2024-11-26 22:48:27', 25, 'horas', 'Olive.Gilmorehg@students.clatsopcc.edu', '2024-12-02', '2024-11-05', NULL, 'Estudios', NULL, '', NULL),
(58, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Pendiente', 'Juan David', NULL, 'Alto', NULL, '0000-00-00 00:00:00', 1, 'dias', 'juandavid@gmail.com.co', '2024-11-26', '2024-11-27', NULL, 'Otro', NULL, 'Operación ', NULL),
(59, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Pendiente', 'Daiver', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 14, 'dias', 'daiver@gmail.com.co', '2024-11-13', '2024-11-27', NULL, 'Estudios', NULL, '', NULL),
(60, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Pendiente', 'javier martinez', NULL, 'Medio', NULL, '0000-00-00 00:00:00', 98, 'horas', 'javiermartinez@fesc.edu.co', '2024-11-19', '2024-12-04', NULL, 'Salud', NULL, '', NULL),
(61, '1091360390', 'no_remunerado', '2024-11-26 00:00:00', 'Pendiente', 'Joel Gutierrez', NULL, 'Alto', NULL, '0000-00-00 00:00:00', 30, 'horas', 'Olive.Gilmorehg@students.clatsopcc.edu', '2024-11-26', '2024-12-03', NULL, 'Salud', NULL, '', NULL),
(62, '1091360390', 'remunerado', '2024-11-26 00:00:00', 'Aprobado', 'Martin Emilio Cano Arias', NULL, 'Medio', 'uploads/detalles_solicitud (25).pdf', '2024-11-26 21:55:35', 8, 'dias', 'martincano@gmail.com.co', '2024-11-27', '2024-12-04', NULL, 'Otro', NULL, 'Cirugía de hernia abdominal', NULL),
(63, '13391117', 'remunerado', '2024-11-26 00:00:00', 'Pendiente', 'Martin Emilio Cano Arias', NULL, 'Alto', 'uploads/detalles_solicitud (26).pdf', '0000-00-00 00:00:00', 8, 'dias', 'martincano@gmail.com.co', '2024-11-30', '2024-12-07', NULL, 'Salud', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Documento_identidad` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL,
  `Rol` enum('admin','usuario') DEFAULT 'usuario',
  `token` varchar(100) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Documento_identidad`, `Nombre`, `Email`, `Contraseña`, `Rol`, `token`, `token_expiracion`, `role`) VALUES
('654321', 'Juan Pérez', 'juan@example.com', 'usuario123', 'usuario', NULL, NULL, 'user'),
('1091360390', 'Nelly Fabiola Cano Oviedo', 'nellycano800@gmail.com', 'nelly123', 'usuario', NULL, NULL, 'user'),
('37391752', 'Maria del Carmen Oviedo Garcia', 'nellycano800@gmail.com', 'maria123', 'usuario', NULL, NULL, 'user'),
('5678', 'Daiver', 'nellycano800@gmail.com', '1234', 'usuario', NULL, NULL, 'admin'),
('1090503840', 'Jhojan Oviedo', 'nellycano800@gmail.com', 'jhojan123', 'usuario', NULL, NULL, 'user'),
('1102358366', 'javier', 'est_wj_martinez@fesc.edu.co', '1102358366', 'usuario', NULL, NULL, 'user'),
('1148454407', 'Damian Moreno', 'nellycano800@gmail.com', 'Damian123', 'usuario', NULL, NULL, 'user'),
('1102634968', 'Marlon', 'nellycano800@gmail.com', 'Marlon123', 'usuario', NULL, NULL, 'user'),
('1005030227', 'Ferney', 'nellycano800@gmail.com', 'Ferney123', 'usuario', NULL, NULL, 'user'),
('60304709', 'Vilma Teresa García Bautista ', 'nellycano800@gmail.com', 'vilma123', 'usuario', NULL, NULL, 'user'),
('13391117', 'Martin Cano', 'martincano@gmail.com.co', 'martin123', 'usuario', NULL, NULL, 'user'),
('13391117', 'Martin Cano', 'martincano@gmail.com.co', 'martin123', 'usuario', NULL, NULL, 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
