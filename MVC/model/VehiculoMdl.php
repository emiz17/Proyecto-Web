<?php
class VehiculoMdl{
	private $driver;
	function __contruct(){
		//aqui van los datos de conexion a la bd
		// el driver y eso
	}

	function alta($vin,$marca,$modelo,$color){
		return true;
	}

	function mostrarDatos($vin){
	//se busca en la base de datos	
		return array("12345678901234567","Jeep","Jeep Liberty KJ","azul");

	}

	function mostrarTodos(){
		//realiza una consulta para obtener todos los vin registrados y se envian al
		//controlador para que los muestre
		//en este ejemplo solo regresa estos datos.
		return array("12345678901234567","Jeep","Jeep Liberty KJ","azul");
	}

	function eliminar($vin){
		//se elimmina de la base de datos
		return true;
	}

}


?>