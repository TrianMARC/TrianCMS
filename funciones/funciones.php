<?php

/* Fichero que contiene algunas de las funciones utilizadas en el cms */

if (!defined('Verificado'))
    die("Acceso no permitido");

function obtener_seccion(){
	global $link,$seccion,$seccion_pred;

	if(!$_GET['seccion']) $seccion=$seccion_pred;
	else $seccion=$_GET['seccion'];
}

function comprobar_usuario(){
	global $link,$es_user,$tu_cuenta,$es_admin;
	if($_COOKIE['es_user']==TRUE){
		$result = mysqli_query($link,"SELECT * FROM ".$prefix."usuarios WHERE user='".escapa($_COOKIE['user'])."' ");
		$row = mysqli_fetch_object($result);
		mysqli_free_result($result);
		if(strcmp($_COOKIE['session'],$row->pass)==0){
			if(intval($row->rango) >= 2) 
			$es_admin=TRUE;
			else
				$es_admin=FALSE;
			$tu_cuenta['usuario'] = $row->user;
			$tu_cuenta['avatar'] = $row->avatar;
			$tu_cuenta['email'] = $row->email;
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

function comprobar_cookies(){
	
	global $usar_cookies,$cook_com;
	$usar_cookies=$_COOKIE['cookies_acept'];
	if($usar_cookies==FALSE){
		$print = '<div style="margin:10px;margin-left:100px;font-family:sans-serif;"><img style="float:left" src="./images/cookies.png" alt="cookies" width="64" ><form method="post" action="./?cookies=aceptadas" name="cook" >Este sitio usa cookies para almacenar los datos de los usuarios,
			para que la web funcione correctamente te recomendamos aceptar.<br>
			<input type="hidden" name="cookiesaceptadas" value="1">
			<input type="submit" name="aceptar" value="Aceptar"></form></div>';
		echo $print;
	}
	
}
function cookies_comprobadas(){
	global $usar_cookies,$cook_com,$cookies,$duracion_sesion;
	
	$cookies=$_POST['cookiesaceptadas'];
	if($cookies==1){
		$cook_com = TRUE;
		setcookie('cookies_acept',TRUE,time()+3600*24);
		header('Location: ./');
	
	}
	else{
		if ($cookies!=0) $cook_com = TRUE;
	}
}

function incluir_html($cont,$html){
	global $link,$seccion;
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
	global $link;
	//if(get_magic_quotes_gpc()) $valor = stripslashes($valor);
	if (!is_numeric($valor))
		return mysqli_real_escape_string($link,$valor);
	else
		return intval($valor);
}
 

function obtener_idioma($lugar,$clase,$tipo = NULL)
{
  	global $link,$idioma;

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