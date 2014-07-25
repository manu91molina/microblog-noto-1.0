<?
 $alteradomiembroid= $_SESSION['miembro'];
 $alteradomiembroid= 14 + $alteradomiembroid;
if ( isset( $_SESSION['ingreso'] ) ) {
include "./configuraciones/correo-idmiembro.php";
 
      $vector_de_publicaciones = consultar("select * from vista_publicacion where idpublicacion = $idpubli;");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {                                       
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
                $titulo = $vector_de_publicaciones[$contador]['titulo'];
                $nombres = $vector_de_publicaciones[$contador]['titulo'];
                $publiid = $vector_de_publicaciones[$contador]['titulo'];
                
          }
		$limpiotitulo = ereg_replace("[^A-Za-z0-9]", "", $titulo);
		$limpionombres = ereg_replace("[^A-Za-z0-9]", "", $nombres);
       }
}
?>
