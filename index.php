<?php

define('Verificado',true);

/*Variable global para indicar la duracion de la sesion en el fichero config.php*/
$duracion_sesion=null;

include_once('config.php');

/*Variable global para indicar la zona en la que nos encontramos*/
$seccion = null;

/*Definimos la variable de identificacion de usuario a false*/
$es_user = FALSE;




include_once('funciones.php');

obtener_seccion();
comprobar_usuario();


if($seccion==null) {
	$fichero=$ruta;
}
else {	
	$fichero=$ruta.'secciones/'.$seccion;
	}

include_once('include.php');



?>

