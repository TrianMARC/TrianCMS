<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
function plantilla($modulo,$pagetitle = NULL,$keywords = NULL,$description = NULL,$extra = NULL)
{
	global $seccion,$es_user,$template,$tu_cuenta,$sitename;
	
	$mostrar = [
			"theme" => $template,
			'sitename' => $sitename,
			'user' => ($es_user) ? '&nbsp;&nbsp;' . _BIENVENIDO . ' ' . $tu_cuenta['usuario'] . '!' : '&nbsp;&nbsp;' . _BIENVENIDO . ' Invitado!',
			'modulo' => $modulo,
	];
	
	if (file_exists('./template/' . $template . '/' . $seccion . '/plantilla.html'))
  		$thefile = file_get_contents('./template/' . $template . '/' . $seccion . '/plantilla.html');
  	else
		$thefile = file_get_contents('./template/' . $template . '/plantilla.html');

  	$thefile = str_replace('"', '\"', $thefile);
    $thefile = preg_replace('#\{([^\}]+)\}#is', '".$1."', $thefile);

  	eval("\$print=\"" . $thefile . "\";");
	echo $print;
	

}

?>