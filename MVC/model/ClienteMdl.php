<?php
	class ClienteMdl{
		
		private $driver;


		function __construct(){
			$host=$user=$pass=$db='';
			require_once("../config.inc");
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
			$query="INSERT INTO Cliente (nombre, apellidos, domicilio, telefono, usuario)
					VALUES ( \"$nombre\", \"$apellidos\", \"$domicilio\", \"$telefono\", \"$usuario\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($idCliente, $nombre, $apellidos, $domicilio, $telefono){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Cliente SET nombre=\"$nombre\", apellidos=\"$apellidos\", domicilio=\"$domicilio\", telefono=\"$telefono\"
			WHERE idCliente=\"$idCliente\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($idCliente){
		
			$row=FALSE;

			$query="SELECT * FROM Cliente WHERE idCliente=\"$idCliente\" ";

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

			$query='SELECT * FROM Cliente';

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
		function eliminar($idCliente){
			//se elimmina de la base de datos
			$query1="SELECT id FROM Cliente WHERE id=\"$idCliente\"";
			$query2="DELETE FROM Cliente WHERE id=\"$idCliente\"";

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