<?php 

if (!defined('Verificado'))
    die("Acceso no permitido");

function principal(){
	global $es_user,$seccion,$tu_cuenta,$es_admin;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$header = obtener_header_admin();
			$nick = $tu_cuenta['usuario'];
			$cont = [
					'nick' => $nick,
					'seccion' =>$seccion,
					'header' => $header,
					];	
			plantilla(incluir_html($cont,'inicio'));
		}
	 }
}

function obtener_header_admin(){
	global $seccion;
	$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=preferencias">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=articulos">Articulos</a> || </div>';

	return $header;

}

function admin_articulos(){

	global $seccion, $config, $tu_cuenta,$es_user,$es_admin;
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			
			$modulo = obtener_header_admin();
			
			$modulo .= '<br><table style="font-size:14px;text-align:center;">
							<tr>
								<th>ID</th>
								<th>'._ADMIN_ARTICULOS_TITULO.'</th>
								<th>'._ADMIN_ARTICULOS_CATEGORIA.'</th>
								<th>'._ADMIN_ARTICULOS_AUTOR.'</th>
								<th>'._ADMIN_ARTICULOS_SECCION.'</th>
								<th> </th>
							</tr>';
			$result=query("SELECT a.id,a.titulo,c.nombre,s.seccion,u.user FROM ".$config['prefix']."usuarios u,".$config['prefix']."articulos a,
			".$config['prefix']."categoria c,".$config['prefix']."secciones s WHERE a.uid=u.id AND a.sid=s.sid AND a.cid=c.id ");
			while($row=mysqli_fetch_object($result)){
				$modulo .= '
							<tr>
								<td>'.$row->id.'</td>
								<td>'.unserialize($row->titulo).'</td>
								<td>'.$row->nombre.'</td>
								<td>'.$row->user.'</td>
								<td>'.$row->seccion.'</td>
								<td><a href="#">'._ADMIN_ARTICULOS_EDITAR.'</a> | <a href="#">'._ADMIN_ARTICULOS_BORRAR.'</a></td>
							
							</tr>	
									
						 ';
			}
			mysqli_free_result($result);
			$modulo .= '</table>';
			plantilla($modulo);
		
		
		}
	}


}


switch($_GET['accion']) {
default:
	principal();
	break;

case "articulos":
	admin_articulos();
	break;

}

?>
