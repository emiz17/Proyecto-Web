<?php
	class EmpleadoMdl{
		
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
		function alta($nombre, $apellidos, $domicilio, $telefono, $usuario){
			
			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Empleado (nombre, apellidos, domicilio, telefono, usuario)
					VALUES ( \"$nombre\", \"$apellidos\", \"$domicilio\", \"$telefono\", \"$usuario\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($idEmpleado, $nombre, $apellidos, $domicilio, $telefono){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Empleado SET nombre=\"$nombre\", apellidos=\"$apellidos\", domicilio=\"$domicilio\", telefono=\"$telefono\"
			WHERE idEmpleado=\"$idEmpleado\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($idEmpleado){
		
			$row=FALSE;

			$query="SELECT * FROM Empleado WHERE idEmpleado=\"$idEmpleado\" ";

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

			$query='SELECT * FROM Empleado';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			if($rows===NULL)
				$rows=FALSE;
			
			return $rows;
		}


		/************************************************
		*					DELETE  					*
		*************************************************/
		function eliminar($idEmpleado){
			//se elimmina de la base de datos
			$query1="SELECT idEmpleado FROM Empleado WHERE idEmpleado=\"$idEmpleado\"";
			$query2="DELETE FROM Empleado WHERE idEmpleado=\"$idEmpleado\"";

			$r=$this->driver->query($query1);
			if($r->num_rows!==0) {

				$r=$this->driver->query($query2);

				if($r !== FALSE)
					$r=TRUE;

			}else{
				$r=FALSE;
			}//fin del if-else
			return $r;
		}//fin del function eliminar

	}//fin de clase

?>