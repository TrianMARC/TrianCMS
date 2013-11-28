<?php 
if (!defined('Verificado'))
    die("Acceso no permitido");

function informacion(){
	global $link, $seccion,$es_user,$es_admin,$prefix,$tu_cuenta;
	
	$uid = $_GET['id'];
	$result=mysqli_query($link,"SELECT * FROM ".$prefix."usuarios WHERE id='".$uid."' ");
	$row=mysqli_fetch_object($result);
	mysqli_free_result($result);
	if($row){
	$result2=mysqli_query($link,"SELECT * FROM ".$prefix."usuarios_rangos WHERE id='".$row->rango."' ");
	$row2=mysqli_fetch_object($result2);
	mysqli_free_result($result2);
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
	global $link, $seccion,$es_user,$prefix,$tu_cuenta;
	$uid = 0;
	$uid = $_GET['id'];
	$result=mysqli_query($link,"SELECT * FROM ".$prefix."usuarios WHERE id='".$uid."' ");
	$row=mysqli_fetch_object($result);
	mysqli_free_result($result);

	if(strcmp($row->user,$tu_cuenta['usuario']) == 0){
		$cont = [
				'uid' => $row->id,
				'c_user' => _USUARIO_CAMPO_USUARIO,
				'user' => $row->user,
				'c_email' => _USUARIO_CAMPO_EMAIL,
				'email' => unserialize($row->email),
				'c_pass' => _USUARIO_CAMPO_PASS,
				'c_pass_conf' => _USUARIO_CAMPO_PASS_CONFIRMAR,
				'enviar' => _ENVIAR,
				'atras' => _VOLVER_ATRAS,
				'guardar' => _GUARDAR,
		];	
		plantilla(incluir_html($cont,editar_perfil));
	}
	else header('Location: ./?seccion='.$seccion);

}

function informacion_editada(){
		global $link, $seccion,$es_user,$prefix,$tu_cuenta;

	$id=$_POST['uid'];
	
/*Por implementar*/
}

?>