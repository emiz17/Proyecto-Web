<?php
	echo "Informacion de todos los vehiculos:<br><br>";
	echo "---------------------------------------------------------------------------------------------<br>";
	echo ".....VIN.....|....UBICACION....|...NOMBRE DEL CHOFER...|...MOTIVO...|...FECHA...|....HORA...|<br>";
	echo "---------------------------------------------------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['VIN'] . ".....";
		echo "....." . $result[$i]['ubicacion'] . ".....";
		echo "....." . $result[$i]['idEmpleado'] . ".....";
		echo "...." . $result[$i]['motivo'] . ".....";
		echo "...." . $result[$i]['fecha'] . ".....";
		echo "...." . $result[$i]['hora'] . ".....";
		echo "<br>";
	}

?>
