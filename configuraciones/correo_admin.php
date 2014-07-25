<?
      $vector_correos = consultar("select * from correo_admin;");
      $cantidad_correos = count( $vector_correos );
      if ( $cantidad_correos > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_correos; $contador ++ ) {
          $CORREO_ADMIN = $vector_correos[$contador]['correo'];
        }
      }
?>