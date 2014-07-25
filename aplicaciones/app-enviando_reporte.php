<?
  if (isset( $_SESSION['ingreso']) ){
  $miembro_reporta = @$_REQUEST ["idmiembro_reporta"];
  $idimagen = @$_REQUEST ["idimagen"];
  $idtipo_publi = @$_REQUEST ["idtipo_publi"];
  $dueño_publi = @$_REQUEST ["dueño_publi"];
  $idpublicacion = @$_REQUEST ["idpubli"];
  $tipo_reporte = @$_REQUEST ["reporte"];
  $fecha = date("d/m/Y");
  $hora = date("H:i:s");

  /*echo "<br><br><br><br>miembro reporta :".$miembro_reporta."<br>";
  echo "idimagen :".$idimagen."<br>";
  echo "idtipo_publi :".$idtipo_publi."<br>";
  echo "de miembro :".$dueño_publi."<br>";
  echo "publicacion :".$idpublicacion."<br>";
  echo "tipo de reporte :".$tipo_reporte."<br>";*/

  $vector_de_publicaciones = consultar("select * from vista_publicacion where idpublicacion = $idpublicacion");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
            $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];
            $dueño_publi = $vector_de_publicaciones[$contador]['miembro'];
            $idtipo_publi = $vector_de_publicaciones[$contador]['idtipo_publi'];
            $idimagen = $vector_de_publicaciones[$contador]['idimagen'];
            $nombres = $vector_de_publicaciones[$contador]['nombres'];
            $titulo = $vector_de_publicaciones[$contador]['titulo'];

        echo "<table  border='0' width='48%' >";
           echo "<tr>";
                 echo "<td>";
                         echo "</br></br>";
                         echo  "<b>".$nombres.":</b>"." $titulo";
                         echo "</td>";
           echo "</tr>";
           echo "<tr>";
                 echo "<td colspan='2'>";
                 
                 $fecha = $vector_de_publicaciones[$contador]['fecha'];
                 $hora = $vector_de_publicaciones[$contador]['tiempo'];
                 echo  "<p class = ayuda >".date("d/m/y", strtotime("$fecha"))."  hora ".date('h:i a', strtotime("$hora"))."</p>";
                 $ruta = $vector_de_publicaciones[$contador]['imagen'];

                 ######
                 /*con esta funcion se establecera las dimenciones de la imagen (si es que existe $ruta)
                 a mostrar*/
                 dimenciones_imagenes_publicaciones ($ruta, @$width, @$height, $titulo, $fecha, $hora, $nombres);                 
                 #######                 

                 echo "</td>";
           echo "</tr>";
           echo "<tr>";
                 echo "<td width='60%' colspan='2'>";
                    $textolargo = $vector_de_publicaciones[$contador]['texto_publicacion'];
                    echo "<p>".$textolargo." &nbsp &nbsp </p>";
                 echo "</td>";
                 echo"</form>";
           echo "</tr>";
        echo "</table>";
          }
      }



  $reporte_existe = consultar("
                            select
                                tipo_notificacion_idtipo_notificacion,
                                publicacion_idpublicacion
                            from
                                notificacion
                            where
                                miembro_idmiembro = $miembro_reporta and
                                publicacion_idpublicacion = $idpublicacion and
                                tipo_notificacion_idtipo_notificacion = $tipo_reporte;
                           ");
  $reporte_ya_realizado = count( $reporte_existe );

  if ($tipo_reporte) {
    #tipo de reporte ya realizado por este miembro a la publicacion
    if ($reporte_ya_realizado) {
       echo"<div class='modal-content'>";
            echo"<div class='modal-header'>";
                  include "./configuraciones/nombre_bmu.php";
                  echo"<p class='indicacion'>Ya realizaste anteriormente este tipo de reporte. <br>
                       los administradores de <b>$NOMBRE_BMU</b> se encuentra estudiando el caso.</p>";
                  echo" <a class='btn btn-default btn-xs' href='#' onclick='close_window();return false;'>Salir&nbsp <span class='glyphicon glyphicon-share-alt'></span></a>";
            echo"</div>";
       echo"</div>";
    }else{ #el miembro no notificado este tipo de reporte aun a la publicacion
        $sql="
          INSERT INTO notificacion 
            ( tipo_notificacion_idtipo_notificacion, estado_notificacion_idestado_notificacion, miembro_idmiembro, publicacion_img_idimg,
              publicacion_tipo_publicacion_idtipo_publicacion, publicacion_miembro_idmiembro, publicacion_idpublicacion, fecha_notificacion, hora_notificacion)
          VALUES
            ('$tipo_reporte', '1', '$miembro_reporta', '$idimagen', '$idtipo_publi', '$dueño_publi', '$idpublicacion', '$fecha', '$hora');
        ";
      $resultado = ejecutar($sql);
   echo"<div class='modal-content'>";
        echo"<div class='modal-header'>";
              include "./configuraciones/nombre_bmu.php";
              echo"<p class='indicacion'>Se ha enviado el reporte a la administración de <b>$NOMBRE_BMU</b>. <br>
                   $NOMBRE_BMU estudiara este caso, verificara esta publicación, por ende se determinira el bloqueo de la misma.
                   Si persisten muchas denuncias sobre esta publicación o de otras publicaciones echas por este mismo miembro,
                   se realizará el cierre de la cuenta de este miembro. Gracias por colaborar!</p>";
              echo" <a class='btn btn-default btn-xs' href='#' onclick='close_window();return false;'>Salir &nbsp <span class='glyphicon glyphicon-share-alt'></span></a>";
        echo"</div>";
   echo"</div>";
    }

  }else{
  $vector_de_publicaciones = consultar("select * from vista_publicacion where idpublicacion = $idpublicacion");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
            $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];
            $dueño_publi = $vector_de_publicaciones[$contador]['miembro'];
            $idtipo_publi = $vector_de_publicaciones[$contador]['idtipo_publi'];
            $idimagen = $vector_de_publicaciones[$contador]['idimagen'];
            $nombres = $vector_de_publicaciones[$contador]['nombres'];
          }
      }
   include "./configuraciones/correo-idmiembro.php";
   echo"<div class='modal-content'>";
        echo"<div class='modal-header'>";
              #echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
              echo"<p class='indicacion'>Quiero reportar anomalías sobre esta publicación. </p></br>";
                         echo "<form action='./index.php?contenido=reportar_publicacion' method='post'>";
                          echo "<input type='hidden' name='idmiembro_reporta' value='$miembroid'>";
                          echo "<input type='hidden' name='idimagen' value='$idimagen'>";
                          echo "<input type='hidden' name='idtipo_publi' value='$idtipo_publi'>";
                          echo "<input type='hidden' name='dueño_publi' value='$dueño_publi'>";
                          echo "<input type='hidden' name='idpubli' value='$idpubli'>";
              echo "<table  border='0' width='75%' >";
                echo "<tr>";
                  echo "<td width=''>";
                    echo "<p class='ayuda'>denuncio esto como</p>";
                  echo "</td>";
                  echo "<td width=''>";
                         echo"<select class='select-reporte' title='selecciona el reporte sobre esta publicacion' name='reporte'>";
                            echo "<option></option>";
                            echo "<option value='1'>contenido ofenso-inadecuado</option>";
                            echo "<option value='2'>miembro con publicaciones ofensivos-inadecuados</option>";
                         echo"</select>";
                   echo "</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<td align='center' width=''>";
                    echo"&nbsp";
                  echo"</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<td align='center' width=''>";
                    echo "<p class='ayuda'>enviar?</p>";
                  echo "</td>";
                  echo "<td width=''>";
                    echo "<button class='btn btn-default btn-xs' title= 'enviar reporte'>Si</button> &nbsp &nbsp <a class='btn btn-default btn-xs' href='#' onclick='close_window();return false;'>No, Cancelar y Salir &nbsp <span class='glyphicon glyphicon-share-alt'></span></a>";
                  echo "</td>";
                echo "</tr>";
              echo "</table>";
        echo"</div>";
   echo"</div>";
  }

 }

?>
