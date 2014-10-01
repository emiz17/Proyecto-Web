<?php

	class inventarioMdl{
		private $driver;
		
		
		function __construct(){
			require_once("config.inc");
			$this->driver=new mysqli($host, $user, $pass, $db);
			if($this->driver->connect_errno)
				require_once("view/showErrorConexion.php");
		}


		public function alta($kilometraje, $cantCombustible, $piezasGolpeadas, $severidadGolpe){
			
			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Inventario (kilometraje, combustible)
					VALUES (\"$kilometraje\", \"$cantCombustible\")";

			$r=$this->driver->query($query);
		
			if($this -> driver -> insert_id){
				return $this -> driver -> insert_id;
			}elseif($r === FALSE)
				return FALSE;
			}
		}


		public function mostrarTodos(){
			//Mas adelante regresara una consulta de la DB
			return $this;
		}
		
		
	}

?>