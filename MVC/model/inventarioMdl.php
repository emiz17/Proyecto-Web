<?php

	class inventarioMdl{
		public $kilometraje;
		public $cantCombustible;
		public $piezasGolpeadas;
		public $severidadGolpe;
		
			
		public function alta($kilometraje, $cantCombustible, $piezasGolpeadas, $severidadGolpe){
			

			//colocarlos como atributos
			$this->kilometraje=$kilometraje;
			$this->cantCombustible=$cantCombustible;
			$this->piezasGolpeadas=$piezasGolpeadas;
			$this->severidadGolpe=$severidadGolpe;
			
			return true;
		}
		
		public function mostrarTodos(){
			//Mas adelante regresara una consulta de la DB
			return $this;
		}
		
		
	}

?>