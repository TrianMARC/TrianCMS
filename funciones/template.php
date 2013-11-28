<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
function plantilla($modulo,$pagetitle = NULL,$keywords = NULL,$description = NULL,$extra = NULL)
{
	global $seccion,$es_user,$template,$tu_cuenta,$sitename,$regresar;
	
	$mostrar = [
			"template" => $template,
			'sitename' => $sitename,
			'user' => ($es_user) ? '&nbsp;&nbsp;' . _BIENVENIDO . '<b> ' . $tu_cuenta['usuario'] . '</b>!' : '&nbsp;&nbsp;' . _BIENVENIDO . ' Invitado!',
			'modulo' => $modulo,
			'pagetitle' => ' || '.$pagetitle,
	];
	if($regresar == 1) {
		$mostrar['regresar'] = '<script type="text/javascript">window.setTimeout(function(){window.history.go(-2)},5000);</script>';
		$mostrar['regresando'] = _REGRESAR_EN_5_SECS;
		$regresar = 0;
		$mostrar['modulo'] = '';
	}
	
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