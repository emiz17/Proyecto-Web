<?php

	class inventarioMdl{
		private static invID;
		private $kilometraje;
		private $cantCombustible;
		private $piezasGolpeadas;
		private	$severidadGolpe;
		
			
		public function alta($kilometraje, $cantCombustible, $piezasGolpeadas, $severidadGolpe){
			
			//limpiar los datos
			
			
			//colocarlos como atributos
			$this->kilometraje=$kilometraje;
			$this->cantCombustible=$cantCombustible;
			$this->piezasGolpeadas=$piezasGolpeadas;
			$this->severidadGolpe=$severidadGolpe;
			
			return $this;
		}
		
		public function baja(){
			unset($this);
		}
	
		
		
	}

?>