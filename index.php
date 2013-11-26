<?php

define('Verificado',true);

/*Variable global para indicar la duracion de la sesion en el fichero config.php*/
$duracion_sesion=NULL;

include_once('config.php');



/*Variable global para indicar la zona en la que nos encontramos*/
$seccion = NULL;

$seccion_pred= 'portada';

/*Definimos la variable de identificacion de usuario a false*/
$es_user = FALSE;

$tu_cuenta = [
				'seccion' => 'users',
				'usuario' => '',
				
			];


include_once('./funciones/funciones.php');

obtener_seccion();
comprobar_usuario();


if($seccion==NULL) {
	$fichero=$ruta;
}
else {	
	$fichero=$ruta.'secciones/'.$seccion;
	}

include_once('include.php');



?>

