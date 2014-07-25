<?
      $vector_img_portada = consultar("select * from vista_publicacion where miembro = $ver_miembro and (idtipo_publi = 8 or idtipo_publi = 9 or idtipo_publi = 10)  order by fecha desc, tiempo desc;");
      $cantidad_img_portada = count( $vector_img_portada );
      if ( $cantidad_img_portada > 0 ) {
        for ( $contador = 0 ; $contador <= 0 ; $contador ++ ) {
            $imagen = $vector_img_portada[$contador]['imagen'];
            $fecha = $vector_img_portada[$contador]['fecha'];
            $hora = $vector_img_portada[$contador]['tiempo'];
            $nombres = $vector_img_portada[$contador]['nombres'];
            echo "
            <script type='text/javascript'>
              
            $(document).ready(function() {
                $('#single_2').fancybox({
                    openEffect : 'elastic',
                    closeEffect: 'elastic',
                    openSpeed  : 600,
                    prevEffect : 'elastic',
                    nextEffect : 'elastic',
                    helpers: {
                        title : {
                            type : 'float'
                        }
                    }
                });
            });
            </script>
            ";
        #echo"<div class='modal-user_photo'>";
            echo "<center><a id='single_2' href='$imagen' title='$nombres: imagen de mi perfil desde " .date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$imagen' class='img-perfil_user'/></a></center>";
        #echo "</div>";

        }
      }
?>
