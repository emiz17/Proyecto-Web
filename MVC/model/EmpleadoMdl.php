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
		function alta($nombre, $apPaterno, $apMaterno, $domicilio, $telefono, $correo, $idLogin){
			
			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO empleados (nombres, apPaterno, apMaterno, domicilio, telefono, correo, idLogin)
					VALUES ( \"$nombres\", \"$apPaterno\", \"$apMaterno\", \"$domicilio\", \"$telefono\", \"$correo\", \"$idLogin\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($idEmpleado,$domicilio, $telefono, $correo, $idLogin){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE empleados SET domicilio=\"$domicilio\", telefono=\"$telefono\", correo=\"$correo\", idLogin=\"$idLogin\"
			WHERE id=\"$idEmpleado\" ";

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

			$query="SELECT * FROM empleados WHERE id=\"$idEmpleado\" ";

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

			$query='SELECT * FROM empleados';

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
			$query1="SELECT id FROM clientes WHERE id=\"$idEmpleado\"";
			$query2="DELETE FROM clientes WHERE id=\"$idEmpleado\"";

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

		/************************************************
		*					OBTENER CORREO 					*
		*************************************************/
		function obtenerCorreo($idEmpleado){
			$row=FALSE;

			$query="SELECT correo FROM empleados WHERE id=\"$idEmpleado\" ";

			$r=$this->driver->query($query);

			
			$row=$r->fetch_assoc();

			if($row===NULL)
				$row=FALSE;

			return $row;
		}

	}//fin de clase


?>