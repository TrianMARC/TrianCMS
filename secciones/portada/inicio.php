<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $es_user,$seccion;
	if(!$es_user){
		$cont = [
				 'seccion' => $seccion,
				];
		plantilla(incluir_html($cont,'conexion'));
		
	 }else {
	 
		$nick = $_COOKIE['user'];
		$cont = [
				 'nick' => $nick,
				];
		plantilla(incluir_html($cont,'inicio'));
			
	 }
}


switch($_GET['accion']) {
default:
	principal();
	break;

}

?>
