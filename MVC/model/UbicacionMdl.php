<?php
	class UbicacionMdl{

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
		function alta($vin, $ubicacion, $movidoPor, $motivo, $fecha, $hora){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Ubicacion (ubicacion, nombre_chofer, motivo, fecha, hora, VIN )
					VALUES ( \"$ubicacion\", \"$movidoPor\", \"$motivo\", \"$fecha\", \"$hora\", \"$vin\" )";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
		}


		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($vin, $ubicacion, $movidoPor, $motivo, $fecha, $hora){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Ubicacion SET ubicacion=\"$ubicacion\", nombre_chofer=\"$movidoPor\", motivo=\"$motivo\", fecha=\"$fecha\", hora=\"$hora\"
			WHERE VIN=\"$VIN\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarUbicacion($vin){
			//se busca en la base de datos	
			$query="SELECT * FROM Ubicacion WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		function mostrarUbicacionTodos(){
			
			$query='SELECT * FROM Ubicacion';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;

		}

	}

?>
