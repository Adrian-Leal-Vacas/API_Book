<?php
/**
 * La clase FileXML es la encargada de leer el fichero xml y devolverte un array con los datos obtenidos
 */
class FileXML
{
	// ATRIBUTOS
	private $tipoParametro = null;
	private $valorParametro = null;
	// METODOS GETTERS ANS SETTERS
	// TipoParametro
	public function getTipoParametro()
	{
		return $this->tipoParametro;
	}
	public function setTipoParametro($tipoParametro)
	{
		$this->tipoParametro = $tipoParametro;
	}
	// ValorParametro
	public function getValorParametro()
	{
		return $this->valorParametro;
	}
	public function setValorParametro($valorParametro)
	{
		$this->valorParametro = $valorParametro;
	}
	// METODOS
	/**
	 * Esta función lee el fichero books.xml y lo pasa a un array asociativo 
	 * que lo retorna siempre que haya podido leer el archivo books.xml
	 * @return Array $libros es un array asociativo
	 */
	private function lecturaXML()
	{
		$libros = [];
		if (!$xml = simplexml_load_file(__DIR__ . '/books.xml')) {
			echo "No se ha podido cargar el archivo";
		} else {
			foreach ($xml as $libro) {
				$libros[] = [
					'id' => (string) $libro['id'],
					'autor' => (string) $libro->author,
					'titulo' => (string) $libro->title,
					'genero' => (string) $libro->genre,
					'precio' => (float) $libro->price,
					'año de publicación' => (string) $libro->publish_date,
					'descripción' => (string) $libro->description,
				];
			}
		}
		return $libros;
	}
	/**
	 * Esta función pide un parametro de forma opcional, 
	 * si no hay parametro devuelve todos los libros que ha recuperado de la funcion lecturaXML()
	 * si introduce un parametro lo descompone en clave/valor 
	 * y utiliza como tipo de parametro la clave y como valor del parametro el valor
	 * y devuelve los datos que coincida excepto si el parametro la clave es pagina que muestra los libros indicados
	 * @param Array|null $parametro es un array asociativo
	 * @return Array $datosObtenidos es un array asociativo
	 */
	public function getData($parametro = null)
	{
		// Obtengos los datos de la función lecturaXML() y lo guardo en un array asociativo
		$libros = $this->lecturaXML();
		// Compruebo las posibilidades que puede tener $parametro
		if ($parametro != null) {
			foreach ($parametro as $key => $data) {
				$this->setTipoParametro($key);
				$this->setValorParametro($data);
			}
			// Realización de la páginación si la clave es pagina y su valor es superior a 0 (he entendido como páginación mostrar los libros indicados)
			if ($this->getTipoParametro() == 'pagina') {
				if ($this->getValorParametro() > 0 && $this->getValorParametro() < count($libros) +1) {
					$arrayDatos = [];
					for ($i = $this->getValorParametro() - 1; $i >= 0; $i--) {
						array_push($arrayDatos, $libros[$i]);
					}
					return array_reverse($arrayDatos);
				} else {
					return []; // Devuelvo array vacio porque es 0 o inferior o es superior a la longitud de la lista el valor pasado
				}
			} else {
				// Compruebo que el tipo y el valor del parametros son diferentes a null si alguno no lo cumple retorno todos los libros
				if ($this->getTipoParametro() != null && $this->getValorParametro() != null) {
					$arrayDatos = [];
					foreach ($libros as $libro) {
						if ($libro[$this->getTipoParametro()] == $this->getValorParametro()) {
							array_push($arrayDatos, $libro);
						}
					}
					return $arrayDatos;
				} else {
					return $libros;
				}
			}
		} else {
			return $libros;
		}
	}
}
?>