<?php
	echo "Informacion de todos los EMPLEADOS:<br><br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "......ID........|....NOMBRE....|....APELLIDOS....|......DOMICILIO........|...TELEFONO...|.....USUARIO.....|<br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['idEmpleado'] . ".....";
		echo "....." . $result[$i]['nombre'] . ".....";
		echo "....." . $result[$i]['apellidos'] . ".....";
		echo "...." . $result[$i]['domicilio'] . ".....";
		echo "...." . $result[$i]['telefono'] . ".....";
		echo "...." . $result[$i]['usuario'] . ".....";
		echo "<br>";
	}

	
?>

