<?php
	class UsuarioMdl{
		
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
		function alta($nombreUsuario, $clave, $tipoUsuario, $status){
			
			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO usuario (usuario, clave, tipoUsuario, status)
					VALUES ( \"$nombreUsuario\", \"$clave\", \"$tipoUsuario\",\"$status\" )";

			$r=$this->driver->query($query);
			if($r !== FALSE)
				return TRUE;
			return $r;

		}

		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($idUsuario,$nombreUsuario, $clave, $tipoUsuario, $status){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE usuario SET clave=\"$clave\", tipo_usuario=\"$tipoUsuario\", status=\"$status\"
			WHERE usuario=\"$idUsuario\" ";

			$r=$this->driver->query($query);
		
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		/************************************************
		*					 SHOW 						* 
		*************************************************/
		function mostrarDatos($idUsuario){
		
			$row=FALSE;

			$query="SELECT * FROM usuario WHERE usuario=\"$idUsuario\" ";

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

			$query='SELECT * FROM usuario';

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
		function eliminar($idUsuario){
			//se elimmina de la base de datos
			$query1="SELECT usuario FROM usuario WHERE usuario=\"$idUsuario\"";
			$query2="DELETE FROM usuario WHERE usuario=\"$idUsuario\"";

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