<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function informacion(){
	global $seccion,$es_user,$es_admin,$prefix,$tu_cuenta;
	
	$uid = $_GET['id'];
	$result=mysql_query("SELECT * FROM ".$prefix."usuarios WHERE id='".$uid."' ");
	$row=mysql_fetch_object($result);
	mysql_free_result($result);
	if($row){
	$result2=mysql_query("SELECT * FROM ".$prefix."usuarios_rangos WHERE id='".$row->rango."' ");
	$row2=mysql_fetch_object($result2);
	mysql_free_result($result2);
	$cont = [
			 'user' => $row->user,
			 'avatar' => '<img src="./images/users/avatars/'.$row->avatar.'" width="100px">',
			 'rango' => $row2->nombre,
		];
	if($row->mostrar_email == 1) $cont['email'] = unserialize($row->email);
	if($es_admin){
		$cont['editar_user'] = '<div><a href="#"><img src=./images/acciones/editar.png title="Editar" width="16px"></a></div>';
	}
	plantilla(incluir_html($cont,'ver_informacion'));
	}
	else {
		$cont['error'] = _USUARIO_INFORMACION_ERROR;
		plantilla(incluir_html($cont,'ver_informacion_error'));
	}
	
}
function editar_informacion(){
	global $seccion,$es_user,$es_admin,$prefix,$tu_cuenta;
	$uid = $_GET['id'];
	$result=mysql_query("SELECT * FROM ".$prefix."usuarios WHERE id='".$uid."' ");
	$row=mysql_fetch_object($result);
	mysql_free_result($result);
	if($tu_cuenta['usuario'] == $row->user)(
		
	)
	else Header('Location: ./?seccion='.$seccion.);

}

?>