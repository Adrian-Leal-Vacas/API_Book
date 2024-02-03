<?php
// INPORTACIONES 
require_once 'classes/Response.inc.php';
require_once 'classes/CatalogoLibro.inc.php';
require_once 'variablesEntorno.inc.php';
//Creamos el objeto de la clase CatalogoLibros para manejar el endpoint
$catLib = new CatalogoLibros();
//Comprobamos de qué tipo es la petición al endpoint
switch ($_SERVER['REQUEST_METHOD']) {
		//Método get
	case 'GET':
		//Recogemos los parámetros de la petición get
		$params = $_GET;
		//Llamamos al método get de la clase CatalogoLibros, le pasamos los 
		//parámetros get y comprobamos:
		//1º) si recibimos parámetros
		//2º) si los parámetros están permitidos
		$catalogo = $catLib->get($params);
		//Creamos la respuesta en caso de realizar una petición correcta
		$response = array(
			'catalogo' => $catalogo
		);
		Response::result(SUCCESS, $response); //devolvemos la respuesta a la petición correcta
		break;
	default:
		//creamos el array de error
		$response = array(
			'result' => 'error'
		);
		//devolvemos la respuesta
		Response::result(RESOURCE_NO_FOUND, $response);
		break;
}
?>