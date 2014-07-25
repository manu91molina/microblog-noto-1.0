<?
      $vector_estado = consultar("select * from estado_fase1 where miembro = $miembroid;");
      $cantidad_estados = count( $vector_estado );
      if ( $cantidad_estados > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_estados; $contador ++ ) {
        	$tipo_estadoid = $vector_estado[$contador]['idestado_tipo'];
        	$actual_estado = $vector_estado[$contador]['estado'];
        	$fecha_de_estado = $vector_estado[$contador]['fecha'];
        }
      }

?>
