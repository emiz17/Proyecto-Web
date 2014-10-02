<?php

	class inventarioMdl{
		
		private $driver;
		
		
		function __construct(){
			require_once("config.inc");
			$this->driver=new mysqli($host, $user, $pass, $db);
			if($this->driver->connect_errno)
				require_once("view/showErrorConexion.php");
		}


		/************************************************
		*					INSERT 						*
		*************************************************/
		public function alta($kilometraje, $cantCombustible, $VIN){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Inventario (kilometraje, combustible, VIN)
					VALUES (\"$kilometraje\", \"$cantCombustible\", \"$VIN\" )";

			$r=$this->driver->query($query);
		
			//if($this -> driver -> insert_id){
			//	return $this -> driver -> insert_id;
			//}
			if($r !== FALSE)
				return TRUE;

		}


		
		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($kilometraje, $cantCombustible, $VIN){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Inventario SET kilometraje=\"$kilometraje\", combustible=\"$cantCombustible\" 
			WHERE VIN=\"$VIN\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		public function mostrarTodos(){
			
			$query='SELECT * FROM Inventario';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;
		}
		
		
	}

?>