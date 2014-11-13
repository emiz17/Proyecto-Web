<?php
	echo "Informacion de todos los USUARIOS<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "....USUARIO....|...CLAVE...|...TIPO...|...STATUS...|.....EMAIL......<br>";
	echo "-------------------------------------------------------------------<br>";
	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "....." . $result[$i]['usuario'] . ".....";
		echo "....." . $result[$i]['clave'] . ".....";
		echo "...." . $result[$i]['tipo_usuario'] . ".....";
		echo "...." . $result[$i]['status'] . ".....";
		echo "...." . $result[$i]['email'] . ".....";
		echo "<br>";
	}
	
?>
