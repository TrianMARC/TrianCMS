-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-12-2013 a las 16:47:16
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.5.6-1+debphp.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `titulo`, `resumen`, `contenido`, `imagen`, `cid`, `uid`, `sid`) VALUES
(1, 's:18:"Articulo de prueba";', 's:50:"Este es un articulo para ver si se carga todo bien";', 's:251:"Este es un articulo para ver si se carga todo bien Este es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bien";', 'imagen.jpg', 1, 6, 1),
(2, 's:18:"Articulo de prueba";', 's:50:"Este es un articulo para ver si se carga todo bien";', 's:251:"Este es un articulo para ver si se carga todo bien Este es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bien";', 'imagen.jpg', 1, 6, 1);

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `imagen`, `descripcion`) VALUES
(1, 'Prueba', 'prueba.jpg', 'Categoria de prueba');

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`sid`, `seccion`, `bloques_centrales_sup`, `bloques_centrales_inf`, `bloques_laterales_der`, `bloques_laterales_izq`) VALUES
(1, 'portada', 0, 0, 0, 0),
(2, 'admin', 0, 0, 0, 0),
(3, 'users', 0, 0, 0, 0);

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `pass`, `email`, `mostrar_email`, `avatar`, `rango`) VALUES
(6, 'TrianMARC', '$2y$07$a3sd5rsaf4/34fd3/1fg3u72CwN1d/dsu/iwkslmrQZlO9PRV9WHe', 's:21:"trianmarc91@gmail.com";', 0, 'TrianMARC.jpeg', 2),
(7, 'kabe', '$2y$07$a3sd5rsaf4/34fd3/1fg3uU7ZsZ2iV7T75xtEY/oHvem7vTBLzg1S', 's:19:"kabecilla@gmail.com";', 0, 'nada.png', 1),
(14, 'ernar', '$2y$07$a3sd5rsaf4/34fd3/1fg3utre.48iMpE/WJuRza.5WdnJXfIzKt2q', 's:21:"luismihtc89@gmail.com";', 0, 'ernar.jpeg', 1);

--
-- Volcado de datos para la tabla `usuarios_rangos`
--

INSERT INTO `usuarios_rangos` (`id`, `nombre`) VALUES
(1, 'Usuario'),
(2, 'Administrador');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
