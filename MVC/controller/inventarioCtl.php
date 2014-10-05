<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/inventarioMdl.php");
			$this->model=new InventarioMdl();
			$act=isset($_GET['act'])?$_GET['act']:"";
			switch($act){
				case "alta":
					if(empty($_POST)){
						//carga la vista alumno sin post
						if($this->model->connection_successful())
							require_once("view/IngresaDatos.php");
					}else{
						//Obtener las variables para la alta y limpiarlas
					
						$kilometraje 		= $_POST["kilometraje"];
						$cantCombustible	= $_POST["cantComb"];
						$piezasGolpeadas 	= $_POST["piezasGolp"];
						$severidadGolpe 	= $_POST["severidadGolp"];
						
						addslashes($kilometraje);
						addslashes($cantCombustible);
						addslashes($piezasGolp);
						addslashes($severidadGolp);
						
						$resultado=$this->model->alta($kilometraje, $cantCombustible);
						
						if($resultado!=FALSE){
							require_once("view/AddInventario.php");
						}else{
							require_once("view/ErrorOperacion.php");
						}
						
							
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
						require_once("view/ShowInventario.php");
					}
				break;
				case "mostrarTodos":
					if($this->model->connection_successful()){
						$result= $this -> model -> mostrarTodos();
						require_once("view/showTodosInventario.php");
					}
				break;
				default:
					require_once("view/Default.php");
			}
		}
	
	}

?>