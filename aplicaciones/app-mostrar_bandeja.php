<?
$mantener = @$_REQUEST ['mantener'];
$ocultar = @$_REQUEST ['ocultar'];
$eliminar = @$_REQUEST ['eliminar_denuncia'];
$regresar = @$_REQUEST ['regresar'];

#editar el tipo de publicacion, para ocultarlo
if ($ocultar) {
$idpublicacion = @$_REQUEST ["idpubli"];
$idnotificacion = @$_REQUEST ["notificacion_id"];
#echo "hola .l.";
    $sql="
      update
      publicacion
      SET 
      tipo_publicacion_idtipo_publicacion = '6'
      WHERE 
      idpublicacion = $idpublicacion;
      ";
      $resultado = ejecutar($sql);
    if ($idnotificacion) {
      $sql ="
        update
        notificacion
        SET 
        estado_notificacion_idestado_notificacion = '2'
        WHERE 
        idnotificacion = $idnotificacion;      
        ";
      $resultado = ejecutar($sql);
    }else{
      #nada
    }
}

#la publicacion no es ocultada solo cambiará a ser de tipo evento, si ya es un evento entonces se mantendra, 
#y la notificaion cambiara de estado de no_visto a visto
  if ($mantener) {
$idpublicacion = @$_REQUEST ["idpubli"];
$idnotificacion = @$_REQUEST ["notificacion_id"];
echo "idpubli: $idpublicacion";
echo "idnotificacion = $idnotificacion";
    if ($idnotificacion) {
      $sql ="
        update
        notificacion
        SET 
        estado_notificacion_idestado_notificacion = '2'
        WHERE 
        idnotificacion = $idnotificacion;      
        ";
      $resultado = ejecutar($sql);
    }else{
      #nada
    }
  }

  if ($regresar) {
    $idpublicacion = @$_REQUEST ["idpubli"];
    $idnotificacion = @$_REQUEST ["notificacion_id"];
    echo "idpubli: $idpublicacion";
    echo "idnotificacion = $idnotificacion";
      $sql="
        update
        publicacion
        SET 
        tipo_publicacion_idtipo_publicacion = '2'
        WHERE 
        idpublicacion = $idpublicacion;";
      $resultado = ejecutar($sql);
    if ($idnotificacion) {
      $sql ="
        update
        notificacion
        SET 
        estado_notificacion_idestado_notificacion = '2'
        WHERE 
        idnotificacion = $idnotificacion;      
        ";
      $resultado = ejecutar($sql);
    }else{
      #nada
    }

  }

  if ($eliminar) {
$idpublicacion = @$_REQUEST ["idpubli"];
$idnotificacion = @$_REQUEST ["notificacion_id"];
echo "idpubli: $idpublicacion";
echo "idnotificacion = $idnotificacion";
    $sql="
      update
      notificacion
      SET 
      estado_notificacion_idestado_notificacion = '3'
      WHERE 
      idnotificacion = $idnotificacion;          
      ";
      $resultado = ejecutar($sql);
  }


echo "</br>";
echo "</br>";
echo "</br>";
echo "</br>";

echo "<h3>Bandeja de denuncias <a class='btn btn-default' href='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' title='actualizar' role='button'><span class='glyphicon glyphicon-refresh'></span></a></h3>";
echo"<div class='modal-footer'>";
  echo "<p class='text-left indicacion'><span class='glyphicon glyphicon-eye-open'></span> publicación visible</br>";
  echo "<span class='glyphicon glyphicon-eye-close'></span> publicación oculta";
  echo "</p>";
echo "</div>";
  if (isset( $_SESSION['miembro'] ) ){
      $vector_reportes = consultar("select * from notificacion_fase1 where estadonotificacion_id <> 3 order by  fecha desc, hora desc");
      $cantidad_reportes = count( $vector_reportes );
      if ( $cantidad_reportes > 0 ) {

        echo "<!-- Nav tabs -->";
        echo "<ul class='nav nav-tabs'>";
          echo "<li><a href='#principal' data-toggle='tab'><b>Principal</b></a></li>";
          echo "<li><a href='#publicacion' data-toggle='tab'>Por publicación</a></li>";
          echo "<li><a href='#miembro' data-toggle='tab'>Por miembro</a></li>";
        echo "</ul>";

        echo"<!-- Tab panes -->";
        echo"<div class='tab-content'>";
        #echo "</br>";
        echo  "<div class='tab-pane active' id='principal'>";
        echo    "<table class='table table-striped'>";

        for ( $contador = 0 ; $contador < $cantidad_reportes ; $contador ++ ) {

            ( $contador + 1 );
            $notificacion_id = $vector_reportes[$contador]['notificacion_id'];
            $nombres_notificador = $vector_reportes[$contador]['nombres_notificador'];
            $tiponotificacion_id = $vector_reportes[$contador]['tiponotificacion_id'];
            $publicacion_id      = $vector_reportes[$contador]['publicacion_id'];
            $tiponotificacion    = $vector_reportes[$contador]['tipo_notificacion'];
            $idestado_notificacion = $vector_reportes[$contador]['estadonotificacion_id'];
            $nombre_dueño_publi  = $vector_reportes[$contador]['nombre_dueño_publi'];
            $apellido_dueño_publi= $vector_reportes[$contador]['apellido_dueño_publi'];
            $dueño_publi_id      = $vector_reportes[$contador]['dueño_publi_id'];
            $idtipo_publi        = $vector_reportes[$contador]['tipopublicacion_id'];
            $nombres_notificador_corto = recortar_nombre($nombres_notificador, 26);
            echo  "<tr>";
            echo    "<td class='";
                      if ($tiponotificacion_id == "1"){
                        echo"warning'>";
                       #echo"$nombres_notificador_corto denuncia una publicación id #$publicacion_id <a class='varios' href='#$publicacion_id'>Inline</a>";
                        sentencia_publicacion ($publicacion_id, $nombres_notificador_corto, $notificacion_id, $idestado_notificacion);
                        #include "./aplicaciones/app-sentencia_publicacion.php";
            echo    "</td>";
                      }else{
                        echo"danger'>";
            echo        "$nombres_notificador_corto denuncia a $nombre_dueño_publi $apellido_dueño_publi |<a class='varios'>denuncias:</a> 5 | <a class='varios' href='#$publicacion_id'> ver </a> | <a class='varios' href='#$publicacion_id'>eliminar denuncia</a>";
            echo    "</td>";
                      }
            echo    "</td>";
            echo  "</tr>";
        }
        echo    "</table>";
        echo  "</div>";
      }
        echo  "<div class='tab-pane' id='publicacion'>";
                  include"./aplicaciones/app-denuncia_de_publicaciones.php";
        echo  "</div>";
        echo  "<div class='tab-pane' id='miembro'>";
                   #include "./aplicaciones/.php";
        echo   "</div>";
        echo "</div>";

  }
?>