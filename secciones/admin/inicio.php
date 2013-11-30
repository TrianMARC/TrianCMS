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
			$header = obtener_header_admin();
			$nick = $tu_cuenta['usuario'];
			$cont = [
					'nick' => $nick,
					'seccion' =>$seccion,
					'header' => $header,
					];	
			plantilla(incluir_html($cont,'inicio'));
		}
	 }
}

function obtener_header_admin(){
	global $seccion;
	$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=preferencias">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=articulos">Articulos</a> || </div>';

	return $header;

}

function admin_articulos(){

	global $seccion, $config, $tu_cuenta;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
		
			
		
		}
	}


}


switch($_GET['accion']) {
default:
	principal();
	break;

case "articulos":
	admin_articulos();
	break;

}

?>
