<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
$usuario = "root";
$pass = "deladmin";
$db = "delegacion";
$host = "localhost";
$ruta = './';
$duracion_sesion = time()+3600;
$prefix = '';
$idioma = 'es_es';
$template = 'Delegacion';
$sitename = 'Prueba';

$link = mysqli_connect($host,$usuario,$pass,$db);


?>