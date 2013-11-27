<?php 

if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $es_user,$seccion,$tu_cuenta,$es_admin;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$nick = $tu_cuenta['usuario'];
			$cont = [
					'nick' => $nick,
					];	
			plantilla(incluir_html($cont,'inicio'));
		}
	 }
}


switch($_GET['accion']) {
default:
	principal();
	break;
}

?>
