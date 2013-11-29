<?php
if (!defined('Verificado'))
    die("Acceso no permitido");
	
$usuario = "root";
$pass = "deladmin";
$db = "delegacion";
$host = "localhost";

$link = mysqli_connect($host,$usuario,$pass,$db);

$config = [
			'ruta' => '/var/www/test',
			'duracion_sesion' => time()+3600,
			'prefix' => '',
			'idioma' => 'es_es',
			'template' => 'Delegacion',
			'sitename' => 'Prueba',
			'avatar_max' => 4194304,
	];





?>