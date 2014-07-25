<?
 $alteradomiembroid= $_SESSION['miembro'];
 $alteradocorreo =  $_SESSION['ingreso'];
 $alteradomiembroid= 6 + $alteradomiembroid;
 if ( isset( $_SESSION['ingreso'] ) ) {
 include "./configuraciones/correo-idmiembro.php";
 
      $vector_de_publicaciones = consultar("select * from vista_perfil where miembro = $miembroid");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {                                       
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
                $nombres = $vector_de_publicaciones[$contador]['nombres'];
          }
		$limpionombres = @ ereg_replace("[^A-Za-z0-9]", "", $nombres);
       }
 }
?>
