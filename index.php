<?php

define('Verificado',true);

/*Variable global para indicar la duracion de la sesion en el fichero config.php*/
$duracion_sesion=NULL;

include_once('config.php');

$usar_cookies=FALSE;
$cook_com=FALSE;
$cookies = 0;

/*Variable global para indicar la zona en la que nos encontramos*/
$seccion = NULL;

$seccion_pred= 'portada';

/*Definimos la variable de identificacion de usuario a false*/
$es_user = FALSE;
$es_admin = FALSE;

$tu_cuenta = [];

$regresar = 0;



include_once('./funciones/funciones.php');

$mostrar_cookies=FALSE;

comprobar_cookies();


switch($_GET['cookies']){

case cookies_comprobadas();
	break;
}

if(intval($_GET['regresar'])==1) { $regresar=1; }

obtener_seccion();
comprobar_usuario();



if($seccion==NULL) {
	$fichero='./';
}
else {	
	$fichero='./secciones/'.$seccion;
	}

include_once('include.php');

mysqli_close($link);
?>

