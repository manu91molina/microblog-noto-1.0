<?
      $vector_reportes_publicacion = consultar("
      	select 
            count (idnotificacion) as veces,
            publicacion_idpublicacion
        from 
            notificacion 
        group by publicacion_idpublicacion
		order by  veces desc");

      $cantidad_reportes_publicacion = count( $vector_reportes_publicacion );
      if ( $cantidad_reportes_publicacion > 0 ) {
        echo    "<table class='table table-striped'>";

        for ( $contador = 0 ; $contador < $cantidad_reportes_publicacion ; $contador ++ ) {

            ( $contador + 1 );
            $veces_denunciada 	 = $vector_reportes_publicacion[$contador]['veces'];
            $publicacion_id      = $vector_reportes_publicacion[$contador]['publicacion_idpublicacion'];
            echo  "<tr>";
            echo    "<td class='warning'>";
                      if ($tiponotificacion_id == "1"){
                        otra_forma_sentencia_publicacion ($publicacion_id, $veces_denunciada);
            echo    "</td>";
                      }else{
                      	#hacer nada
                      }
            echo    "</td>";
            echo  "</tr>";
        }
        echo    "</table>";
    }
?>