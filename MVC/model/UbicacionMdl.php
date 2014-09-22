<?php
class UbicacionMdl{
	private $driver;
	function __contruct(){
		//aqui van los datos de conexion a la bd
		// el driver 
	}

	function alta($vin, $accion, $motivo, $ubicacion,$movidoPor,$fecha,$hora){
		return true;
	}

	function mostrarUbicacion($vin){
	//se busca en la base de datos	
		$ubic= "A1";
		return $ubic;

	}

	function mostrarUbicacionTodos(){
		//realiza una consulta para obtener todos los vin registrados y se envian al
		//controlador para que los muestre con su ubicacion
		//en este ejemplo solo regresa estos datos.
		return array("12345678901234567","A1");
	}

}


?>
