<?php
	class UbicacionMdl{

		private $driver;

		function __construct(){
				$host=$user=$pass=$db='';
				require_once("config.inc");
				$this->driver=new mysqli($host, $user, $pass, $db);
				if($this->driver->connect_errno)
					require_once("view/ShowErrorConexion.php");
		}


		function connection_successful(){
			if(!$this->driver->connect_errno)
				return TRUE;
			return FALSE;
		}

		/************************************************
		*					INSERT 						*
		*************************************************/
		function alta($vin, $ubicacion, $idEmpleado, $motivo, $fecha, $hora){

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Ubicacion (ubicacion, idEmpleado, motivo, fecha, hora, VIN )
					VALUES ( \"$ubicacion\", \"$idEmpleado\", \"$motivo\", \"$fecha\", \"$hora\", \"$vin\" )";

			$r=$this->driver->query($query);

			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($vin, $ubicacion, $idEmpleado, $motivo, $fecha, $hora){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Ubicacion SET ubicacion=\"$ubicacion\", idEmpleado=\"$idEmpleado\", motivo=\"$motivo\", fecha=\"$fecha\", hora=\"$hora\"
			WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($vin){
			//se busca en la base de datos	
			$query="SELECT * FROM Ubicacion WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			$row=$r->fetch_assoc();

			if($row===NULL)
				$row=FALSE;

			return $row;

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		function mostrarTodos(){
			$rows=FALSE;
			
			$query='SELECT * FROM Ubicacion';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			if($rows===NULL)
				$rows=FALSE;
			
			return $rows;

		}

	}

?>
