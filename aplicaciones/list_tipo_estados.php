<?
include"./configuraciones/correo-idmiembro.php";
      $vector_tipo_estados = consultar("select * from tipo_estado where idtipo_estado <> $tipo_estadoid and idtipo_estado <> 3;");
      $cantidad_tipo_estados = count( $vector_tipo_estados );
      if ( $cantidad_tipo_estados > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_tipo_estados; $contador ++ ) {
			$estadoid = $vector_tipo_estados[$contador]['idtipo_estado'];
			$estado = $vector_tipo_estados[$contador]['tipo_estado'];
			echo" <option name='estado' value='$estadoid'>$estado</option>";
        }
      }


?>
