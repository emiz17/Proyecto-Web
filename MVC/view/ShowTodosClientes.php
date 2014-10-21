<?php
	echo "Informacion de todos los CLIENTES:<br><br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "......ID........|....NOMBRE....|...AP. PATERNO...|...AP. MATERNO...|......DOMICILIO........|...TELEFONO...|...CORREO...|...ID LOGIN...|<br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";

	//print_r($result);
	for($i=0; $i<count($result); $i++) {
		echo "...." . $result[$i]['id'] . ".....";
		echo "....." . $result[$i]['nombres'] . ".....";
		echo "....." . $result[$i]['apPaterno'] . ".....";
		echo "...." . $result[$i]['apMaterno'] . ".....";
		echo "...." . $result[$i]['domicilio'] . ".....";
		echo "...." . $result[$i]['telefono'] . ".....";
		echo "...." . $result[$i]['correo'] . ".....";
		echo "...." . $result[$i]['idLogin'] . ".....";
		echo "<br>";
	}

	
?>
