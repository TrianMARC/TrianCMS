<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $link,$es_user,$seccion,$usar_cookies;
	
	if(!$es_user){
		$titulo = 'Con&eacute;ctate';
		if(!$usar_cookies){
			$print = "Es necesario el uso de cookies para poder conectarte.";
			plantilla($print);		
		}else{
	
			$cont = [
						'seccion' => $seccion,
					];
			plantilla(incluir_html($cont,'conexion'),$titulo);
		
		}
	 }else {
		$titulo = 'Panel de Usuario';
		$nick = $_COOKIE['user'];
		$cont = [
				 'nick' => $nick,
				];
		plantilla(incluir_html($cont,'panel_user'),$titulo);		
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
		$result = query("SELECT * FROM ".$prefix."usuarios WHERE user='". $user ."' ");
		$row = mysqli_fetch_object($result);
		mysqli_free_result($result);;
		$pass_db = $row->pass;
		$pass = $_POST['pass'];
		if(password_verify($pass,$pass_db)){
			setcookie('user',$_POST['nick'],$duracion_sesion);
			setcookie('session',$pass_db,$duracion_sesion);
			setcookie('es_user',TRUE,$duracion_sesion);
			header('Location: ./?regresar=1');
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
	global $es_user,$seccion,$prefix;
	if(!$es_user){
	
		$result1=query("SELECT * from ".$prefix."usuarios WHERE user='".escapa($_POST['nick'])."' ");
		$row1=mysqli_fetch_object($result1);
		mysqli_free_result($result1);
		if(strcmp($row1->user,$_POST['nick'])!=0){
			$result1=query("SELECT * from ".$prefix."usuarios WHERE email='".escapa(serialize($_POST['email']))."' ");
			$row1=mysqli_fetch_object($result1);
			mysqli_free_result($result1);
			if(strcmp(unserialize($row1->email),$_POST['email'])!=0){
		
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
					$result=query("INSERT INTO ".$prefix."usuarios values ('','".escapa($nick)."','".escapa($pass)."','".escapa($email)."','','','1')");
					if($result===TRUE){
						plantilla(incluir_html($cont,'registrado'));
					}
					else{
						echo "Error de conexion al insertar. ".mysqli_error();
					}
					mysqli_free_result($result);
				}
			}
			else{
				$cont = [
					'mail_existe' => _USER_ERROR_MAIL_EXISTE,
					'atras' => _USER_ATRAS,
					];
				plantilla(incluir_html($cont,'mail_existe'));
			}
		}
		else{
			$cont = [
					'user_existe' => _USER_ERROR_USER_EXISTE,
					'atras' => _USER_ATRAS,
					];
				plantilla(incluir_html($cont,'user_existe'));
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
	break;
case "editar":
	editar_informacion();
	break;

}

?>
