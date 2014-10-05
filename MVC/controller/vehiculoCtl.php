<?php
Class VehiculoCtl{
	private $model;

	public function execute(){
		require_once("model/VehiculoMdl.php");
		$this -> model = new VehiculoMdl();
		$act=isset($_GET['act'])?$_GET['act']:"";
		switch ($act){
			case "alta":
				if(empty($_POST)){
					if($this->model->connection_successful())
						require_once("view/IngresaDatos.php");
				}
				else{
				    //Obtener las variables para la alta
				    //y limpiarlas
				    $vin = $_POST["vin"];
				    //en lo que se obtiene exactamente lo que significa el contenido del vin
				    //de las siguientes se borraran la de marca y modelo menos la del color
				    $marca = $_POST["marca"];
					$modelo = $_POST["modelo"];
					$color = $_POST["color"];

					addslashes($vin);
					addslashes($marca);
					addslashes($modelo);
					addslashes($color);

					//el vin se puede validar pero aun no se encuentra un estandar
  					//que usar-> 17 caracteres , cualquiera menos I,O,Q y Ñ
  					// primerods 3 son WMI
  					//sig 6 son VDS
  					//ultimos VIS
  					//basado en http://www.guiaautomotrizcr.com/Articulos/numero_VIN.php

					$resultado = $this -> model -> alta($vin, $marca, $modelo, $color);
					if($resultado!==FALSE){
					    require_once("view/AddVehiculo.php");
					}
					else
						require_once("view/ErrorOperacion.php");
					}
			break;
			case "mostrar":
				if(empty($_POST)){
					//Cargo la vista de agrega datos
					if($this->model->connection_successful())
						require_once("view/InsertVIN.php");
				}
				else{
					$vin = $_POST["vin"];
					addslashes($vin);
					
					//se checara en la bd si el vin esta registrado y de ser asi
					//del vin se extraera la informacion del auto y se mostrara
					//esto es en lo que se obtiene exactamente lo que significa el contenido del vin
					//despues se contara con un diccionario 
					//para saber que dato nos proporciona el vin y mostrarlos
					$result=$this -> model -> mostrarDatos($vin);
					require_once("view/ShowVehiculo.php");
				}
			break;
			case "mostrarTodos":
					//despues se contara con un diccionario 
					//para saber que dato nos proporciona el vin y mostrarlos
				if($this->model->connection_successful()){
					$result= $this -> model -> mostrarTodos();
					require_once("view/ShowTodosVehiculos.php");
				}
			break;
			case "eliminar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/IngresaDatos.php");
					}
					else{
						$vin = $_POST["vin"];
						addslashes($vin);
						$resultado = $this -> model -> eliminar($vin);
						if($resultado!==FALSE){
							require_once("view/VehiculoEliminado.php");
						}
						else
							require_once("view/ErrorOperacion.php");
					}
				break;
				default:
					require_once("view/Default.php");
			}//Fin de switch

		}//Fin de function execute

}//Fin de clase

?>