<?php

/* Fichero que contiene algunas de las funciones utilizadas en el cms */

if (!defined('Verificado'))
    die("Acceso no permitido");

function obtener_seccion(){
	global $seccion,$seccion_pred;

	if(!$_GET['seccion']) $seccion=$seccion_pred;
	else $seccion=$_GET['seccion'];
}

function comprobar_usuario(){
	global $es_user,$tu_cuenta;
	if($_COOKIE['es_user']==TRUE){
		$tu_cuenta['usuario']=$_COOKIE['user'];
		$es_user=TRUE;
	}
	else
		$es_user=FALSE;
}

function incluir_html($cont,$html){
	global $seccion;
	 $thefile = file_get_contents('./secciones/'.$seccion.'/html/'.$html.'.html');
	 $thefile = str_replace('"', '\"', $thefile);
	 $thefile = preg_replace('#\{([^\}\\n\\r]+)\}#is', '".$1."', $thefile);

  	eval("\$print=\"" . $thefile . "\";");
	return($print);

}

function encriptar($password, $digito = 7) {  
	$options = [
		'cost' => $digito,
		'salt' => 'a3sd5rsaf4/34fd3/1fg35',
		];
	return password_hash($password, PASSWORD_BCRYPT, $options);
}
 
function escapa($valor)
{
	//if(get_magic_quotes_gpc()) $valor = stripslashes($valor);
	if (!is_numeric($valor))
		return mysql_real_escape_string($valor);
	else
		return intval($valor);
}
 

function obtener_idioma($lugar,$clase,$tipo = NULL)
{
  	global $idioma;

    if ($clase == 0) {
		if (file_exists('./language/' . $idioma . '/blocks/' . $lugar . '.php'))
    		@include_once('./language/' . $idioma . '/blocks/' . $lugar . '.php');
        else
    		@include_once('./language/' . $idioma . '/blocks/' . $lugar . '.php');
	} else if ($clase == 1) {
		if (file_exists('./language/' . $idioma . '/secciones/' . $lugar . '/' . $tipo . '.php'))
    		@include_once('./language/' . $idioma . '/secciones/' . $lugar . '/' . $tipo . '.php');
        else
    		@include_once('./language/' . $idioma . '/secciones/' . $lugar . '/' . $tipo . '.php');
	} else if ($clase == 2) {
		if (file_exists('./language/' . $idioma . '/global/' . $lugar . '.php'))
    		@include_once('./language/' . $idioma . '/global/' . $lugar . '.php');
        else
    		@include_once('./language/' . $idioma . '/global/' . $lugar . '.php');
	} else if ($clase == 3) {
		if (file_exists('./language/' . $idioma . '/plugins/' . $lugar . '.php'))
    		@include_once('./language/' . $idioma . '/plugins/' . $lugar . '.php');
        else
    		@include_once('./language/' . $idioma . '/plugins/' . $lugar . '.php');
	}
}

?>