<?php
Class ubicacionCtl{
	private $model;
	//y realizar la validacion de las palabras
	//prueba.....
	public function execute(){
	    require_once("model/UbicacionMdl.php");
	    $this -> model = new UbicacionMdl();
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
					$accion = $_POST["accion"];
					$motivo = $_POST["motivo"];
					$ubicacion = $_POST["ubicacion"];
					$movidoPor = $_POST["movidoPor"];
					$fecha = $_POST["fecha"];
					$hora = $_POST["hora"];

  					addslashes($vin);
  					addslashes($accion);
  					addslashes($motivo);
  					addslashes($ubicacion);
  					addslashes($movidoPor);
  					addslashes($fecha);
  					addslashes($hora);

  					//el vin se puede validar pero aun no se encuentra un estandar
  					//que usar-> 17 caracteres , cualquiera menos I,O,Q y Ñ
  					// primerods 3 son WMI
  					//sig 6 son VDS
  					//ultimos VIS
  					//basado en http://www.guiaautomotrizcr.com/Articulos/numero_VIN.php

  					$trueFecha= $this->validar_fecha($fecha);
  					$trueHora= $this->validar_hora($hora);

					$resultado = $this -> model -> alta($vin, $accion, $motivo, $ubicacion,$movidoPor,$fecha,$hora);
					if($resultado!==FALSE){
					   require_once("view/AddUbicacion.php");
					}
					 else
					   require_once("view/ErrorOperacion.php");
				}
				break;
				case "modificar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/InsertVIN.php");
					}
					else{
						//se buscara el vehiculo por VIN
						$vin = $_POST["vin"];
						addslashes($vin);
						
						//Se muestran los datos actuales
						$result=$this -> model -> mostrarDatos($vin);
						require_once("view/ShowUbicacion.php");

						//Se escribiran de nuevo los datos insertados
						$ubicacion = $_POST["ubicacion"];
						$movidoPor = $_POST["movidoPor"];
						$motivo = $_POST["motivo"];
						$fecha = $_POST["fecha"];
						$hora = $_POST["hora"];

						addslashes($ubicacion);
						addslashes($movidoPor);
	  					addslashes($motivo);
	  					addslashes($fecha);
	  					addslashes($hora);

						$result=$this -> model -> modificar($vin, $ubicacion, $movidoPor, $motivo, $fecha, $hora);
						if($result!==FALSE){
						    require_once("view/ModifyUbicacion.php");
						}
						else
							require_once("view/ErrorOperacion.php");
						}
						
				break;
				case "mostrarUbicacion":
					if(empty($_POST)){
					   //Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/InsertVIN.php");
					}
					else{						
					   $vin = $_POST["vin"];
					   addslashes($vin);

					   $result = $this -> model -> mostrarUbicacion($vin);
					   require_once("view/ShowUbicacion.php");
					}
				break;
				case "mostrarUbicacionTodos":
					if($this->model->connection_successful()){
					 	$result= $this -> model -> mostrarUbicacionTodos();
					 	require_once("view/ShowTodosUbicacion.php");
					}
				break;
				default:
					 require_once("view/Default.php");
			}
		}

		//formato MM/DD/YYYY 
		private function validar_fecha($fecha){
			$pattern="/^\d{1,2}\/\d{1,2}\/\d{4}$/";
			if (preg_match($pattern,$fecha))
				return true;
			return false;
			}

		private function validar_hora($hora) {
			$pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/";
			if(preg_match($pattern,$hora)) 
				return true; 
			return false; 
		}
}

?>
