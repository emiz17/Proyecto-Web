<?php

	class inventarioMdl{
		
		private $driver;
		
		
		function __construct(){
			$host=$user=$pass=$db='';
			require_once("config.inc");
			$this->driver=new mysqli($host, $user, $pass, $db);
			if($this->driver->connect_errno)
				require_once("view/ShowErrorConexion.php");
		}


		/************************************************
		*					INSERT 						*
		*************************************************/
		public function alta($pieza, $severidad, $VIN){

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="INSERT INTO Golpe (pieza, severidad, VIN)
					VALUES (\"$pieza\", \"$severidad\", \"$VIN\" )";

			$r=$this->driver->query($query);
		
			//if($this -> driver -> insert_id){
			//	return $this -> driver -> insert_id;
			//}
			if($r !== FALSE)
				return TRUE;
			return $r;

		}


		
		/************************************************
		*					MODIFY 						*
		*************************************************/
		public function modificar($pieza, $severidad, $VIN){
			$r=FALSE;

			//insertarlos en la base de datos generando un query y posteriormente
			//ejecutandolo
			$query="UPDATE Golpe SET pieza=\"$pieza\", severidad=\"$severidad\" 
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

			$query="SELECT * FROM Golpe WHERE VIN=\"$vin\" ";

			$r=$this->driver->query($query);

			/*while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;*/
			return $row=$r->fetch_assoc();

		}


		/************************************************
		*					SHOW ALL 					*
		*************************************************/
		public function mostrarTodos(){
			
			$query='SELECT * FROM Golpe';

			$r=$this->driver->query($query);

			while($row=$r->fetch_assoc())
				$rows[]=$row;

			return $rows;
		}
		
		
	}

?>