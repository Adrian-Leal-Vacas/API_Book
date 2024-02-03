<?php
// IMPORTACIONES
require_once 'Response.inc.php';
require_once 'FileXML.inc.php';
require_once './variablesEntorno.inc.php';
/**
 * La clase CatalogoLibros es la encargada de comprobar los datos que nos introduce por la url
 * y la respuesta a si es permitidos esos parametro o no son permitidos
 */
class CatalogoLibros extends FileXML
{
	//indicamos los parámetros válidos para las peticiones get mediante un array
	private $allowedConditions_get = array(
		'id',
		'autor',
		'genero',
		'pagina',
	);
	/**
	 * Método get: recibe los parámetros de la petición get,
	 * los recorre para comprobar si son válidos,
	 * si no lo son los elimina y devuelve una respuesta json de error,
	 * si lo son realiza la consulta a DB y devuelve un json con la respuesta correcta
	 *
	 * @param array $params Los parámetros get usados en BD
	 * @return [array | void] Los usuarios de la BD
	 */
	public function get($params)
	{
		//Recorremos los parámetros get
		foreach ($params as $key => $param) {
			//si los parámetros no están permitidos...
			if (!in_array($key, $this->allowedConditions_get)) {
				//eliminamos los parámetros
				unset($params[$key]);
				//creamos el array de error
				$response = array(
					'result' => 'error',
					'details' => 'Error en la solicitud'
				);
				//devolvemos la petición de error convertida a json
				Response::result(BAD_REQUEST, $response);
				exit;
			}
		}
		//llamamos 
		$catalogo = parent::getData($params);
		return $catalogo;
	}
}
?>