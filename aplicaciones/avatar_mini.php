<?

            #obtener imagen de perfil de usuario     
            $vector_mini_avatar = consultar("select * from vista_publicacion where idpublicacion=$idpubli and miembro = $dueño_publi and (idtipo_publi = 8 or idtipo_publi = 9) order by  fecha desc, tiempo desc;");
            $cantidad_avatar = count( $vector_mini_avatar );
            if ( $cantidad_avatar > 0 ) {
              for ( $contador = 0 ; $contador <= 0 ; $contador ++ ) {
                ( $contador + 0 );
                $avatar = $vector_mini_avatar[$contador]['imagen'];
              }
              echo "<img src='$avatar' class='img-mini_vitacora_user'/>";
              
            }

#######################################
            #obtener imagen de perfil de usuario     
            $vector_mini_avatar = consultar("
            SELECT 
				imagen 
            FROM 
				vista_publicacion 
			WHERE
				miembro = 1 and 
				(idtipo_publi = 8 or
				idtipo_publi = 10) and
				idpublicacion = (SELECT max(idpublicacion) FROM vista_publicacion);
			;");
            $cantidad_avatar = count( $vector_mini_avatar );
            if ( $cantidad_avatar > 0 ) {
              for ( $contador = 0 ; $contador <= 0 ; $contador ++ ) {
                ( $contador + 0 );
                $avatar = $vector_mini_avatar[$contador]['imagen'];
              }
              echo "<img src='$avatar' class='img-mini_vitacora_user'/>";
              
            }



?>
