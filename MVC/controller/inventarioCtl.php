<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/InventarioMdl.php");
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
					
						$vin				= $_POST['vin'];
						$kilometraje 		= $_POST['kilometraje'];
						$cantCombustible	= $_POST['cantCombustible'];
						
						addslashes($vin);
						addslashes($kilometraje);
						addslashes($cantCombustible);

						$result=$this->model->alta($kilometraje, $cantCombustible, $vin);
						
						if($result!=FALSE){
							require_once("view/AddInventario.php");
						}else{
							require_once("view/ErrorOperacion.php");
						}
						
							
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
						require_once("view/ShowInventario.php");

						//Se escribiran de nuevo los datos insertados
						$kilometraje 		= $_POST['kilometraje'];
						$cantCombustible	= $_POST['cantCombustible'];

						addslashes($kilometraje);
						addslashes($cantCombustible);

						$result=$this -> model -> modificar($kilometraje, $cantCombustible, $vin);
						if($result!==FALSE){
						    require_once("view/ModifyInventario.php");
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