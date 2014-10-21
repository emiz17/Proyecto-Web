<?php
	echo "Informacion de todos los USUARIOS<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "......ID........|....USUARIO....|...CLAVE...|...TIPO...|...STATUS...|<br>";
	echo "-------------------------------------------------------------------<br>";
	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['id'] . ".....";
		echo "....." . $result[$i]['nomUsuario'] . ".....";
		echo "....." . $result[$i]['clave'] . ".....";
		echo "...." . $result[$i]['tipoUsuario'] . ".....";
		echo "...." . $result[$i]['status'] . ".....";
		echo "<br>";
	}
	
?>
