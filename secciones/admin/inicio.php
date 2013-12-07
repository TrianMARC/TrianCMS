<?php 

/* TrianCMS ~ Content Management System
Desarrollado por Víctor Sánchez del Río ( http://twitter.com/trianmarc ) 
Víctor Sánchez del Río © Todos los derechos reservados.
Proyecto desarrollado para Uname Junior Empresa
*/


if (!defined('Verificado'))
    die("Acceso no permitido");

/********************************************************************************************************
	Funcion: principal()																					
	Descripcion: Función encargada de cargar el panel global de control de la administración del sitio.
	Parametros:			
																			
*********************************************************************************************************/

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

/********************************************************************************************************
	Funcion: obtener_header_admin()																					
	Descripcion: Carga el menu para poder acceder a todas las opciones del panel de administración.
	Parametros:			
																			
*********************************************************************************************************/

function obtener_header_admin(){
	global $seccion,$config;
	if($config['rewrite']!=1){
	$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=preferencias">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./?seccion='.$seccion.'&amp;accion=articulos">Articulos</a> || </div>';
	}
	else{
		$header='<div>Panel de Control del Sitio</div>
			<div>|| <a style="text-decoration:none" href="./'.$seccion.'-preferencias.html">Preferencias</a> || Secciones || 
			<a style="text-decoration:none" href="./'.$seccion.'-articulos.html">Articulos</a> || </div>';

	}
	return $header;

}

/********************************************************************************************************
	Funcion: admin_articulos()																				
	Descripcion: Obtiene un listado en una tabla todos los articulos de la base de datos y dá 
				 la opcion de editarlos y borrarlos.
	Parametros:			
																			
*********************************************************************************************************/

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
				if($config['rewrite']!=1){
					$url_edit='./?seccion=admin&accion=editar_articulo&id='.$row->id;
					$url_borrar='./?seccion=admin&accion=borrar_articulo&id='.$row->id;
				}
				{
					$url_edit='./admin-editar_articulo-'.$row->id;
					$url_borrar='./admin-borrar_articulo-'.$row->id;
				}
				$modulo .= '
							<tr>
								<td>'.$row->id.'</td>
								<td>'.unserialize($row->titulo).'</td>
								<td>'.$row->nombre.'</td>
								<td>'.$row->user.'</td>
								<td>'.$row->seccion.'</td>
								<td><a href="'.$url_edit.'">'._ADMIN_ARTICULOS_EDITAR.'</a> | <a href="'.$url_borrar.'">'._ADMIN_ARTICULOS_BORRAR.'</a></td>
							
							</tr>	
									
						 ';
			}
			mysqli_free_result($result);
			$modulo .= '</table>';
			plantilla($modulo,'Administrar Art&iacute;culos');
		
		
		}
	}


}


/********************************************************************************************************
	Funcion: editar_articulo()																					
	Descripcion: Función que se encarga de cargar el formulario de edición de los articulos desde el panel de
				 administración.
	Parametros:			
																			
*********************************************************************************************************/

function editar_articulo(){
	global $config,$es_admin,$es_user;
	
	if(!$es_user){
		header('Location: ./?seccion=users');
	}
	else {
		if(!$es_admin){
			header('Location: ./');
		}
		else{
			$aid= $_GET['id'];
			$result=query("SELECT a.*, c.nombre, c.imagen as cat_img, s.seccion FROM ".$config['prefix']."articulos a,".$config['prefix']."categoria c,".$config['prefix']."secciones s WHERE s.sid=a.id AND a.id='".$uid."' AND a.cid = c.id ");
			$row=mysqli_fetch_object($result);
			mysqli_free_result($result);
			$cont = [
					'seccion' => $seccion,
					'enviar' => _ENVIAR,
					'categoria_n' => $row->nombre,
					'categoria_i' => $row->cat_img,
					'titulo' => unserialize($row->titulo),
					'imagen' => $row->imagen,
					'resumen' => unserialize($row->resumen),
					'texto' => unserialize($row->contenido),
					'seccion_a' => $row->seccion,					
			];
			
			plantilla(incluir_html($cont,editar_articulo),'Editar Art&iacute;culo');
		
		
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

case "editar_articulo":
	editar_articulo();
	break;

}

?>
