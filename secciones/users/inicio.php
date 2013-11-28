<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
<<<<<<< HEAD
	global $link,$es_user,$seccion,$usar_cookies;
=======
	global $link,$es_user,$seccion;
>>>>>>> master
	if(!$es_user){
		if(!$usar_cookies){
			$print = "Es necesario el uso de cookies para poder conectarte.";
			plantilla($print);		
		}else{
	
			$cont = [
						'seccion' => $seccion,
					];
			plantilla(incluir_html($cont,'conexion'));
		
		}
	 }else {
	 
		$nick = $_COOKIE['user'];
		$cont = [
				 'nick' => $nick,
				];
		plantilla(incluir_html($cont,'panel_user'));		
	 }
}
function desconectar(){
	global $link,$es_user;
	if($es_user){
		$cont = [
			'volver' => _USER_VOLVER,
			'desconectado' => _USER_DESCONECTADO,
			];
		unset($_COOKIE['user']);
        unset($_COOKIE['session']);
        setcookie('user', null, -1);
        setcookie('session', null, -1);
		setcookie('es_user',null,-1);
		plantilla(incluir_html($cont,'desconexion'));
		
	}
	else{
		header('Location: ./?seccion='.$seccion);
	}
}

function conectar(){
	global $link,$es_user,$duracion_sesion;
	$cont = [
				 'seccion' => $seccion,
				 'nick' => $_POST['nick'],
				 'pass_inc' => _USER_ERROR_PASSWORD,
				 'nick_vac' => _USER_ERROR_FALTA_NICK,
				 'pass_vac' => _USER_ERROR_FALTA_PASS,
				 'atras' => _USER_ATRAS,
			];
	
	
	if($_POST['nick']==""){
		plantilla(incluir_html($cont,'error_nick'));
	}
	elseif($_POST['pass']==""){
		plantilla(incluir_html($cont,'error_pass'));
	}
	else{
		$user = $_POST['nick'];
		$user = escapa($user);
		$result = mysqli_query($link,"SELECT * FROM ".$prefix."usuarios WHERE user='". $user ."' ");
		$row = mysqli_fetch_object($result);
		mysqli_free_result($result);
		$pass_db = $row->pass;
		$pass = $_POST['pass'];
		if(password_verify($pass,$pass_db)){
			setcookie('user',$_POST['nick'],$duracion_sesion);
			setcookie('session',$pass_db,$duracion_sesion);
			setcookie('es_user',TRUE,$duracion_sesion);
			plantilla(incluir_html($cont,'panel_user'));
		}
		else{
			plantilla(incluir_html($cont,'pass_mal'));
		}	
	}
}

function registro(){
	global $link,$es_user,$seccion;
	if(!$es_user){
		$cont = [
				 'seccion' => $seccion,
				 'atras' => _USER_ATRAS,
				];
		plantilla(incluir_html($cont,'registro'));
	}
	else{
		header('Location: ./?seccion='.$seccion);
	}
}


function registrado(){
	global $link,$es_user,$seccion;
	if(!$es_user){
		$cont = [
				 'seccion' => $seccion,
				 'atras' => _USER_ATRAS,
				 'registrado' => _USER_REGISTRADO,
				];
		if($_POST['pass'] != $_POST['pass_confirm']){
		$cont = [
				 'pass_error' => _USER_ERROR_PASS_NO_COINCIDE,
				 'atras' => _USER_ATRAS,
				];
			plantilla(incluir_html($cont,'pass_nocoincide'));
		}
		else{
			$nick=$_POST['nick'];
			$pass=encriptar($_POST['pass']);
			$email=serialize($_POST['email']);
			$result=mysqli_query($link,"INSERT INTO ".$prefix."usuarios values ('','".escapa($nick)."','".escapa($pass)."','".escapa($email)."','1')");
			if($result!=FALSE){
				plantilla(incluir_html($cont,'registrado'));
			}
			else{
				echo "Error de conexion";
			}
			mysqli_free_result($result);
			
		}
	}
	else{
		header('Location: ./?seccion='.$seccion);
	}
}

switch($_GET['accion']) {
default:
	principal();
	break;
case "conectar":
	conectar();
	break;	
case "desconectar":
	desconectar();
	break;
case "registro":
	registro();
	break;
case "registrado":
	registrado();
	break;
case "informacion":
	informacion();

}

?>
