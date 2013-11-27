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
	global $es_user,$tu_cuenta,$es_admin;
	if($_COOKIE['es_user']==TRUE){
		$result = mysql_query("SELECT * FROM ".$prefix."usuarios WHERE User='".escapa($_COOKIE['user'])."' ");
		$row = mysql_fetch_object($result);
		mysql_free_result($result);
		if(strcmp($_COOKIE['session'],$row->Pass)==0){
			if(intval($row->Rango) >= 2) 
			$es_admin=TRUE;
			else
				$es_admin=FALSE;
			$tu_cuenta['usuario']=$_COOKIE['user'];
			$es_user=TRUE;
		}
		else{
			unset($_COOKIE['user']);
			unset($_COOKIE['pass']);
			setcookie('user', null, -1);
			setcookie('session', null, -1);
			setcookie('es_user',null,-1);
			echo "Intento de hackeo de cuenta, tu ip ha sido guardada en el sistema, se te revocará el acceso";
		}
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