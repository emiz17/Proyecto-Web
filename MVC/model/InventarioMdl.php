<?php

	class InventarioMdl{
		
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
		public function alta($vin, $kilometraje, $combustible){

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Inventario (kilometraje, combustible, VIN)
					VALUES (\"$kilometraje\", \"$combustible\", \"$vin\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		
		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($vin, $kilometraje, $combustible){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Inventario SET kilometraje=\"$kilometraje\", combustible=\"$combustible\" 
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
		
			$rows=FALSE;

			$query="SELECT * FROM Inventario WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			$row=$r->fetch_assoc();

			if($row===NULL)
				$row=FALSE;

			return $row;

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		public function mostrarTodos(){
			$rows=FALSE;
			
			$query='SELECT * FROM Inventario';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			if($rows===NULL)
				$rows=FALSE;
			
			return $rows;
		}
		
		
	}

?>