<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $es_user,$seccion,$prefix;
	$modulo = '';
	$cont = [
				'cabecera' => _PORTADA_ULTIMOS_ARTICULOS,
			];
	$modulo .= incluir_html($cont,'articulos_cabecera');
	$result = mysql_query("SELECT * FROM ".$prefix."articulos ");
	while($row=mysql_fetch_object($result)){
		$cont = [
				"titulo" => unserialize($row->titulo),
				"resumen" => unserialize($row->resumen),
				'imagen' => $row->imagen,
		];
		$modulo .= incluir_html($cont,'articulo');
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
