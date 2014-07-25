<?
      $vector_de_nombres = consultar("select * from vista_perfil where miembro = $ver_miembro ;");
      $cantidad_de_nombres = count( $vector_de_nombres );
      if ( $cantidad_de_nombres > 0 ) {
        echo "</br>";
        echo "</br>"; 
        echo "<table border='0' width='100%' >";
           echo "<tr>";
                 echo "<td>";
                 include "./aplicaciones/img-portada_otromiembro.php";
                echo "</td>";
           echo "</tr>";
        echo "</table>";
        echo "<table border='0' width='95%' >";
        for ( $contador = 0 ; $contador < $cantidad_de_nombres ; $contador ++ ) {

            ( $contador + 1 );
           $nombres           = $vector_de_nombres[$contador]['nombres'];
           $nombres           = mostrar_comilla_simple_nombres ($nombres);
           $reside            = $vector_de_nombres[$contador]['vive en'];
           $carrera           = $vector_de_nombres[$contador]['cursando carrera de'];
           $estado            = $vector_de_nombres[$contador]['estado'];
           $fecha_estado      = $vector_de_nombres[$contador]['fecha'];
           $fecha_nacimiento  = $vector_de_nombres[$contador]['nació el'];
           $frase             = $vector_de_nombres[$contador]['frases'];
           $ver_miembro           = $vector_de_nombres[$contador]['miembro'];

           echo "<tr>";
              echo "<td>";
                echo"
                  <!-- Nav tabs -->
                  <ul class='nav nav-tabs'>
                    <li><a href='#perfil' data-toggle='tab'><b class='perfil-name'>".$nombres."</b></a></li>
                    <li><a href='#evento' data-toggle='tab'><span class='glyphicon glyphicon-pushpin'></span> Eventos</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class='tab-content'>";
              echo "<div class='tab-pane active' id='perfil'>";
                    include "./aplicaciones/datos-perfil.php";
              echo "</div>";
              echo "<div class='tab-pane' id='evento'>";
                    include "./aplicaciones/publicaciones-eventos_otromiembro.php";
              echo "</div>";
            echo "</div>
                ";
              echo"</td>";
           echo "</tr>";
        }
    	echo "</table>";
      }

?>
