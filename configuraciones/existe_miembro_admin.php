<?
include"./configuraciones/correo-idmiembro.php";
      $vector_estado_admin = consultar("select * from estado_fase1 where idestado_tipo = 4 and miembro = $miembroid;");
      $cantidad_estado_admin = count( $vector_estado_admin );
      if ( $cantidad_estado_admin > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_estado_admin; $contador ++ ) {
			$administrador = $vector_estado_admin[$contador]['idestado_tipo'];
        }
      }

      $vector_estado_admin = consultar("select * from estado_fase1 where idestado_tipo <> 3 and miembro = $miembroid;");
      $cantidad_estado_admin = count( $vector_estado_admin );
      if ( $cantidad_estado_admin > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_estado_admin; $contador ++ ) {
			$usuario_miembro = $vector_estado_admin[$contador]['idestado_tipo'];
        }
      }

?>