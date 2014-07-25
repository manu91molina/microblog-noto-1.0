<?
include"./configuraciones/correo-idmiembro.php";
      $vector_carreras = consultar("select * from carrera where idcarrera <> $carreraid;");
      $cantidad_carreras = count( $vector_carreras );
      if ( $cantidad_carreras > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_carreras; $contador ++ ) {
        	$namecarreras = $vector_carreras[$contador]['carrera'];
        	$idcarrera = $vector_carreras[$contador]['idcarrera'];
			echo" <option value ='$idcarrera'>$namecarreras</option>";
        }
      }

?>