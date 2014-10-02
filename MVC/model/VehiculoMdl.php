<?php
	class VehiculoMdl{
		
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
		function alta($vin,$marca,$modelo,$color){
			
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Vehiculo (VIN, marca, modelo, color)
					VALUES ( \"$vin\", \"$marca\", \"$modelo\", \"$color\" )";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($vin){
		
		$query="SELECT * FROM Vehiculo WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		function mostrarTodos(){

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
			$query="DELETE Vehiculo WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;

		}

	}


?>