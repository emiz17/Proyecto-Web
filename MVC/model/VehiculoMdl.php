<?php
	class VehiculoMdl{
		
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
		function alta($vin,$marca,$modelo,$color){
			
			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Vehiculo (VIN, marca, modelo, color)
					VALUES ( \"$vin\", \"$marca\", \"$modelo\", \"$color\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($vin, $marca, $modelo, $color){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Vehiculo SET marca=\"$marca\", modelo=\"$modelo\", color=\"$color\"
			WHERE VIN=\"$VIN\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($vin){
		
			$rows=FALSE;

			$query="SELECT * FROM Vehiculo WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			/*while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;*/
			return $row=$r->fetch_assoc();

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		function mostrarTodos(){

			$rows=FALSE;

			$query='SELECT * FROM Vehiculo';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;
		}


		/************************************************
		*					DELETE  					*
		*************************************************/
		function eliminar($vin){
			//se elimmina de la base de datos
			$query="DELETE FROM Vehiculo WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

	}


?>