<?
    $vector_notificaciones = consultar("select 
    							         count (idnotificacion) as veces 
         						     from 
         						 	   notificacion 
         						     where 
         							    publicacion_idpublicacion  = $publicacion_id;");
    
    $cantidad_notificacion = count( $vector_notificaciones );
    if ( $cantidad_notificacion > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_notificacion; $contador ++ ) {
          $veces = $vector_notificaciones[$contador]['veces'];
        }
    }

?>
