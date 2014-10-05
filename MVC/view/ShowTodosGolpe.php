<?php

	echo "Informacion de todos los vehiculos:<br><br>";
	echo "----------------------------------------------------<br>";
	echo "......VIN........|.......PIEZA.......|..SEVERIDAD..|<br>";
	echo "----------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['VIN'] . ".....";
		echo "....." . $result[$i]['pieza'] . ".....";
		echo "....." . $result[$i]['severidad'] . ".....";
		echo "<br>";
	}
	
?>