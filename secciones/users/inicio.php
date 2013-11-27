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
function desconectar(){
	global $es_user;
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
	global $es_user,$duracion_sesion;
	$cont = [
				 'seccion' => $seccion,
				 'user' => $_POST['nick'],
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
		$result = mysql_query("SELECT * FROM ".$prefix."usuarios WHERE User='". $user ."' ");
		$row = mysql_fetch_object($result);
		mysql_free_result($result);
		$pass_db = $row->Pass;
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
	global $es_user,$seccion;
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
	global $es_user,$seccion;
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
			$result=mysql_query("INSERT INTO ".$prefix."usuarios values ('','".escapa($nick)."','".escapa($pass)."','".escapa($email)."','1')");
			if($result!=FALSE){
				plantilla(incluir_html($cont,'registrado'));
			}
			else{
				echo "Error de conexion";
			}
			mysql_free_result($result);
			
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

}

?>
