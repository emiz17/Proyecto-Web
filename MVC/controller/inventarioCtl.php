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
						require_once("view/addInventario.php");
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
							require_once("view/showInventario.php");
						}else{
							require_once("view/errorInventario.php");
						}
						
							
					}
				break;
				case "mostrarTodos":
					$inventario = $this -> model -> mostrarTodos();
					require_once("view/showInventario.php");
				break;
				default:
					require_once("view/Default.php");
			}
		}
	
	}

?>