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
			$query="INSERT INTO usuarios (nomUsuario, clave, tipoUsuario, status)
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
			$query="UPDATE usuarios SET nomUsuario=\"$nomUsuario\", clave=\"$clave\", tipoUsuario=\"$tipoUsuario\", status=\"$status\"
			WHERE id=\"$idUsuario\" ";

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

			$query="SELECT * FROM usuarios WHERE id=\"$idUsuario\" ";

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

			$query='SELECT * FROM usuarios';

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
			$query1="SELECT id FROM usuarios WHERE id=\"$idUsuario\"";
			$query2="DELETE FROM usuarios WHERE id=\"$idUsuario\"";

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
		function obtenerTipo($Usuario){
			$row=FALSE;

			$query="SELECT tipoUsuario FROM usuarios WHERE nomUsuario=\"$Usuario\" ";

			$r=$this->driver->query($query);

			
			$row=$r->fetch_assoc();

			return $row['tipoUsuario'];
		}

		function existeUsuario($usuario, $pass){
			$row=FALSE;

			$query="SELECT COUNT(*) AS cont FROM usuarios WHERE nomUsuario=\"$usuario\" AND clave=\"$pass\" ";

			$r=$this->driver->query($query);

			
			$row=$r->fetch_assoc();
			//var_dump($row); 
			//echo "<br>cont:  " .$row['cont'];
			if($row['cont']==0)
				$row=false;
			else 
				$row=true;
			return $row;
		}

	}//fin de clase
?>