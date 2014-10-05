<?php

	echo "Informacion de todos los vehiculos:<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "......VIN........|.KILOMETRAJE.|.COMBUSTIBLE.|<br>";
	echo "-------------------------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['VIN'] . ".....";
		echo "....." . $result[$i]['kilometraje'] . ".....";
		echo "....." . $result[$i]['combustible'] . ".....";
		echo "<br>";
	}
	
?>