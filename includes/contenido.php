<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
	$ruta_sec=$fichero.'/index.php';
	obtener_idioma('inicio',2);
	obtener_idioma($seccion,1,'inicio');
	include_once($ruta_sec);
	
?>	
