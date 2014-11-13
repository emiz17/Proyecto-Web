<?php
	echo "Informacion de todos los vehiculos:<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "......VIN........|....MARCA....|...MODELO...|...COLOR...|...IDCLIENTE...<br>";
	echo "-------------------------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['VIN'] . ".....";
		echo "....." . $result[$i]['marca'] . ".....";
		echo "....." . $result[$i]['modelo'] . ".....";
		echo "...." . $result[$i]['color'] . ".....";
		echo "...." . $result[$i]['idCliente'] . ".....";
		echo "<br>";
	}

	
?>
