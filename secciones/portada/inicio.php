<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $es_user,$es_admin,$seccion,$prefix;
	$modulo = '';
	$cont = [
				'cabecera' => _PORTADA_ULTIMOS_ARTICULOS,
			];
	$modulo .= incluir_html($cont,'articulos_cabecera');
	$result = mysql_query("SELECT a.*, b.* FROM ".$prefix."articulos a,".$prefix."usuarios b WHERE a.uid=b.id ");
	while($row=mysql_fetch_object($result)){
		$cont = [
				"titulo" => unserialize($row->titulo),
				"resumen" => unserialize($row->resumen),
				'imagen' => $row->imagen,
				'escrito' => _PORTADA_ARTICULO_ESCRITO,
				'escritor' => $row->User,
				'leermas' => _PORTADA_ARTICULO_LEER,
			];
		if(!$es_user){
			$modulo .= incluir_html($cont,'articulo');
		}
		else{
			if(!$es_admin){
				$modulo .= incluir_html($cont,'articulo');
			}
			else{
				$cont['editar']='<div id="editar_articulo"><a href="#"><img src=./images/acciones/editar.png title="Editar" width="16px"></a></div>';
				$modulo .= incluir_html($cont,'articulo');
			}
		}
		
	};
	
	mysql_free_result($result);
	plantilla($modulo,'Novedades');
}

function insertar(){
	global $prefix;
	$titulo=serialize("Articulo de prueba");
	$resumen=serialize("Este es un articulo para ver si se carga todo bien");
	$contenido=serialize("Este es un articulo para ver si se carga todo bien Este es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bien");
	$cid='1';
	$uid='6';
	$result=mysql_query("INSERT INTO ".$prefix."articulos values ('','".$titulo."','".$resumen."','".$contenido."','imagen.jpg','".$cid."','".$uid."') ");
	if($result) $modulo = "INSERT REALIZADO CORRECTAMENTE";
	else $modulo = "INSERT FALLADO".mysql_error();
	mysql_free_result($result);
	
	plantilla($modulo,'Novedades');
};

switch($_GET['accion']) {
default:
	principal();
	break;
case "insertinto":
	insertar();
	break;

}

?>
