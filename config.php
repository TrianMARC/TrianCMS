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

$link = mysql_connect($host,$usuario,$pass);
mysql_select_db($db,$link) OR DIE ("Error, no se ha podido conectar a la base de datos");

?>