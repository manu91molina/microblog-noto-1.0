<?


date_default_timezone_set("America/El_Salvador");
##### con estasvariable verificaremos si el usuario quiere publicar imagen de perfil
$perfil_foto      	= @$_REQUEST['perfil_foto'];
$publicar_foto_perfil  	= @$_REQUEST['publicar_foto_p'];
$no_publicar_foto_perfil   = @$_REQUEST['no_publicar_foto_p'];
$idimg            	= @$_REQUEST['idimg'];
$tipo             	= @$_REQUEST['tipo'];
#########
$nombres          = @$_REQUEST['nombres'];
$nombres          = permitir_comilla_simple_nombres ($nombres);
$apellidos        = @$_REQUEST['apellidos'];
$apellidos        = permitir_comilla_simple_apellidos ($apellidos);
$idcarrera          = @$_REQUEST['carrera'];
$idestado           = @$_REQUEST['estado'];
$fecha_estado       = @$_REQUEST['fecha_estado'];
$fecha_nacimiento   = @$_REQUEST['fecha_nacimiento'];
$residencia         = @$_REQUEST['residencia'];
$frase              = @$_REQUEST['frase'];
$frase              = permitir_comilla_simple_frase ($frase);
$editar_perfil      = @$_REQUEST['editar_perfil'];
$fecha              = date("d-m-Y");
$hora               = date ("H:i:s");

###preguntar si existe un cambio de foto de perfil
if ($perfil_foto) {
  echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
  echo  "<div class='alert alert-info fade in'>";
  #echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "La imagen de perfil no se a publicado. <br>";
  echo "¿Deseas publicarla?";
  echo      "<form name='form1' method='post' action='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'><button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok'> si</span></button><input type='hidden' name='publicar_foto_p' value='publicar_foto_p'><input type='hidden' name='tipo' value='8'><input type='hidden' name='idimg' value='$idimg'></form>";
echo      "<form name='form1' method='post' action='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'><button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-remove'> no</span></button><input type='hidden' name='no_publicar_foto_p' value='no_publicar_foto_p'><input type='hidden' name='tipo' value='10'><input type='hidden' name='idimg' value='$idimg'></form>";
  echo  "</div>";
  echo "</div>";
}

if ($publicar_foto_perfil) {
  #editar publicacion
  $sql = "
      UPDATE
        publicacion 
        SET
          tipo_publicacion_idtipo_publicacion   = '$tipo'
        WHERE 
          img_idimg ='$idimg';
          ";
        $resultado = ejecutar($sql);

  #confirmar si fue editada la publicacion
  $vector_tipo_publi = consultar("select tipo_publicacion_idtipo_publicacion from publicacion where img_idimg = $idimg and tipo_publicacion_idtipo_publicacion = 8;");
  $cantidad_tipo_publi = count( $vector_tipo_publi );
  if ( $cantidad_tipo_publi > 0 ) {
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-info fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-ok-circle'></span> imagen publicada exitosamente!";
    echo  "</div>";
    echo "</div>"; 

  }else{
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-danger fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-remove-circle'></span> error, por favor intente más tarde :(";
    echo  "</div>";
    echo "</div>"; 
  }

}

if ($no_publicar_foto_perfil) {
  #editar publicacion
  $sql = "
      UPDATE
        publicacion 
        SET
          tipo_publicacion_idtipo_publicacion   = '$tipo'
        WHERE 
          img_idimg ='$idimg';
          ";
        $resultado = ejecutar($sql);

  #confirmar si fue editada la publicacion
  $vector_tipo_publi = consultar("select tipo_publicacion_idtipo_publicacion from publicacion where img_idimg = $idimg and tipo_publicacion_idtipo_publicacion = 10;");
  $cantidad_tipo_publi = count( $vector_tipo_publi );
  if ( $cantidad_tipo_publi > 0 ) {
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-info fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-ok-circle'></span> La imagen no se ha publicado. Solo estará visible en la sección de eventos en tu perfil.";
    echo  "</div>";
    echo "</div>"; 

  }else{
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-danger fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-remove-circle'></span> error intente más tarde :(";
    echo  "</div>";
    echo "</div>"; 
  }

}


include"./configuraciones/correo-idmiembro.php";
#obtener el id facultad a partir de id de carrera a ingresar
$vector_carreras = consultar("select * from carrera where idcarrera = $idcarrera;");
$cantidad_carreras = count( $vector_carreras );
if ( $cantidad_carreras > 0 ) {
  for ( $contador = 0 ; $contador < $cantidad_carreras; $contador ++ ) {
    $idfacultad = $vector_carreras[$contador]['facultad_idfacultad'];
  }
}


#realizar la actualizacion de los datos,
#si el usuario no envia nombre y apellido, el nombre a asignar sera su correo electronico
if ($editar_perfil) {
  if (!$nombres && !$apellidos) {
    $nombres = $correo;
    $sql="
      UPDATE
        perfil 
        SET
          carrera_idcarrera           = '$idcarrera',
          carrera_facultad_idfacultad = '$idfacultad',
          miembro_idmiembro           = '$miembroid',
          nombre                      = '$nombres',
          apellido                    = '$apellidos',
          natalicio                   = '$fecha_nacimiento',
          domicilio                   = '$residencia',
          frase                       = '$frase'
        WHERE 
          miembro_idmiembro ='$miembroid';
      UPDATE
        estado 
        SET
          tipo_estado_idtipo_estado   = '$idestado',
          fecha_estado                = '$fecha_estado'
        WHERE 
          miembro_idmiembro ='$miembroid';
          ";
        $resultado = ejecutar($sql);

     #comoprovar si la frase fue editada       
    $vector_frase = consultar("select * from vista_perfil where miembro = $miembroid;");
    $cantidad_frase = count( $vector_frase );
    if ( $cantidad_frase > 0 ) {
      for ( $contador = 0 ; $contador < $cantidad_frase; $contador ++ ) {
        $frase_actual = $vector_frase[$contador]['frases'];
      }
    }

    if ($frase_actual == $frase) {
      #nada
    }else{
      #publicarla debido a que fue cambiada o editada
    $sql="
        INSERT INTO publicacion 
          (miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
        VALUES
          ('$miembroid', '2', '1', '$fecha', '$hora', 'Actualice mi frase', '{$frase}' );
          ";
        $resultado = ejecutar($sql);      
    }

    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-info fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-ok-circle'></span> tus datos se han actualizado exitosamente!";
    echo  "</div>";
    echo "</div>";
  }else{
    $sql="
      UPDATE
        perfil 
        SET
          carrera_idcarrera           = '$idcarrera',
          carrera_facultad_idfacultad = '$idfacultad',
          miembro_idmiembro           = '$miembroid',
          nombre                      = '$nombres',
          apellido                    = '$apellidos',
          natalicio                   = '$fecha_nacimiento',
          domicilio                   = '$residencia',
          frase                       = '$frase'
        WHERE 
          miembro_idmiembro ='$miembroid';
      UPDATE
        estado 
        SET
          tipo_estado_idtipo_estado   = '$idestado',
          fecha_estado                = '$fecha_estado'
        WHERE 
          miembro_idmiembro ='$miembroid';
          ";
    $resultado = ejecutar($sql);
    $nombres    = mostrar_comilla_simple_nombres ($nombres);
    $apellidos  = mostrar_comilla_simple_apellidos ($apellidos);   
        
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-info fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-ok-circle'></span> tus datos se han actualizado exitosamente!";
    echo  "</div>";
    echo "</div>";
  }

}


      $vector_de_nombres = consultar("select * from vista_perfil where miembro = $miembroid;");
      $cantidad_de_nombres = count( $vector_de_nombres );
      if ( $cantidad_de_nombres > 0 ) {
        echo "</br>";
        echo "<table border='0' width='100%' >";
           echo "<tr>";
                 echo "<td>";
                 include "./aplicaciones/img-portada.php";
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
           $frase_decode      = mostrar_comilla_simple_frase($frase);
           echo "<tr>";
              echo "<td>";
                echo"
                  <!-- Nav tabs -->
                  <ul class='nav nav-tabs'>
                    <li><a href='#perfil' data-toggle='tab'><b class='perfil-name'>".$nombres."</b></a></li>
                    <li><a href='#libre' data-toggle='tab'><span class='glyphicon glyphicon-fullscreen'></span> Libre</a></li>
                    <li><a href='#evento' data-toggle='tab'><span class='glyphicon glyphicon-pushpin'></span> Eventos</a></li>
                    <li><a href='#editar_perfil' data-toggle='tab'><span class='glyphicon glyphicon-pencil'></span> Editar Perfil</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class='tab-content'>";
              echo "<div class='tab-pane active' id='perfil'>";
                    include "./aplicaciones/datos-perfil.php";
              echo "</div>";
              echo"<div class='tab-pane' id='libre'>";
                    include "./aplicaciones/publicaciones-libres.php";
              echo "</div>";
              echo "<div class='tab-pane' id='evento'>";
                    include "./aplicaciones/publicaciones-eventos.php";
              echo "</div>";
              echo "<div class='tab-pane' id='editar_perfil'>";
                    include "./aplicaciones/app-edit_perfil.php";
              echo "</div>";
            echo "</div>
                ";
              echo"</td>";
           echo "</tr>";
        }
    	echo "</table>";
      }

?>
