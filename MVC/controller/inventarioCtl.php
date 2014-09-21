<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/inventarioMdl.php");
			$this->model=new InventarioMdl();
			switch($_GET['act']){
				case "alta":
					if(empty($_POST)){
						require_once("vista/addInventario.php");
					}else{
						//Obtener las variables para la alta
					
						$kilometraje 		= $_POST["kilometraje"];
						$cantCombustible	= $_POST["cantComb"];
						$piezasGolpeadas 	= $_POST["piezasGolp"];
						$severidadGolpe 	= $_POST["severidadGolp"];
						
						
						addslashes($kilometraje);
						addslashes($cantCombustible);
						addslashes($piezasGolp);
						addslashes($severidadGolp);
						
						$resultado=$this->model->alta($kilometraje, $cantCombustible, $piezasGolpeadas, $severidadGolpe);
						if($resultado!=false){
							require_once("view/showInventario.php");
						}else{
							require_once("view/errorInventario.php");
						}
						
							
					}
				break;
				case "mostrarTodos":
					$Inventario = $this -> model -> mostrarTodos();
					require_once("view/showInventario.php");
				break;
				default:
					require_once("view/Default.php");
			}
		}
	
	}

?>