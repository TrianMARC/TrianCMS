<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $link, $es_user,$es_admin,$seccion,$config;
	$modulo = '';
	$cont = [
				'cabecera' => _PORTADA_ULTIMOS_ARTICULOS,
			];
	$modulo .= incluir_html($cont,'articulos_cabecera');
	$result = mysqli_query($link,"SELECT a.*, b.*, c.* FROM ".$config['prefix']."articulos a,".$config['prefix']."usuarios b,".$config['prefix']."secciones c WHERE a.uid=b.id AND a.sid=c.sid ");
	while($row=mysqli_fetch_object($result)){
		if($seccion == $row->seccion){
			$cont = [
				"titulo" => unserialize($row->titulo),
				"resumen" => unserialize($row->resumen),
				'imagen' => $row->imagen,
				'escrito' => _PORTADA_ARTICULO_ESCRITO,
				'escritor' => $row->user,
				'uid' => $row->id,
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
					$cont['editar']='<div class="editar_articulo"><a href="#"><img src=./images/acciones/editar.png title="Editar" alt="editar" width="16px"></a></div>';
					$modulo .= incluir_html($cont,'articulo');
				}
			}
		}
	};
	
	mysqli_free_result($result);
	plantilla($modulo,'Novedades');
}

function insertar(){
	global $link, $config;
	$titulo=serialize("Articulo de prueba");
	$resumen=serialize("Este es un articulo para ver si se carga todo bien");
	$contenido=serialize("Este es un articulo para ver si se carga todo bien Este es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bienEste es un articulo para ver si se carga todo bien");
	$cid='1';
	$uid='6';
	$result=mysqli_query($link,"INSERT INTO ".$config['prefix']."articulos values ('','".$titulo."','".$resumen."','".$contenido."','imagen.jpg','".$cid."','".$uid."') ");
	if($result) $modulo = "INSERT REALIZADO CORRECTAMENTE";
	else $modulo = "INSERT FALLADO".mysqli_error();
	mysqli_free_result($result);
	
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
