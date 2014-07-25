<?
  date_default_timezone_set("America/El_Salvador");
  $idpublicacion 	= @$_REQUEST ["id"];
  $percepcion 		= @$_REQUEST ["cn"];
  $cambio_percepcion 	= @$_REQUEST ["cambiar"];
  $miembro 		= @$_REQUEST ["idmiembro"];
  $dueño 		=  @$_REQUEST ["dueno"];
  $idimg 		=  @$_REQUEST ["idim"];
  $tipo 		=  @$_REQUEST ["tipo"];
  $fecha     		= date("d/m/Y");
  $hora      		= date("H:i:s");
  $texto 		= @$_REQUEST ["coment"];
  $texto_comilla = permitir_comilla_simple_texto ($texto);
  $ver_todos_coments 	= @$_REQUEST ["comentarios"];
/*
	echo "<br><br><br><br>publicacion :".$idpublicacion."<br>";
	echo "tipo percepcion :".$percepcion."<br>";
	echo "de miembro :".$miembro."<br>";
	echo "dueño-publica :".$dueño."<br>";
	echo "imagen :".$idimg."<br>";
	echo "tipo :".$tipo."<br>";
  echo "peticion: ".$ver_todos_coments;
*/
#Para ingresar comentario

if ($texto) {
  $texto_encode = htmlentities($texto_comilla);
  echo "$texto";
  $verficar_comentario = consultar("
                            select
                              miembro_coment,
                              publicacion,
                              coment
                            from
                              vista_comentario
                            where
                              miembro_coment = $miembro and
                              publicacion = $idpublicacion and
                              coment = '$texto_encode';
                          ");
  $confirmar_comentario = count( $verficar_comentario );
  if ($confirmar_comentario) {
    #hacer nada
  }else{
      $sql="
          INSERT INTO comentario
            (miembro_idmiembro, publicacion_img_idimg, publicacion_tipo_publicacion_idtipo_publicacion,
              publicacion_miembro_idmiembro, publicacion_idpublicacion,fecha, hora, texto)
          VALUES
            ('$miembro', '$idimg', '$tipo', '$dueño', '$idpublicacion', '$fecha', '$hora', '$texto_comilla');";
      $resultado = ejecutar($sql);
  }
  
}else{
        #echo "NO cayo nada de texto!";
}




# c de la palabra chivo y n de nel (palabras de jerga salvadoreño), en este if se verifica, si ya ingreso uno de los dos tipos
# de percepcion (chivo = me gusta, nel = no me gusta).
  if (isset($_POST['cn'])) {
    $verficar = consultar("
                          select
                            miembro_persive,
                            numero_publicacion
                          from
                            who_percepcionchivo
                          where
                            miembro_persive = $miembro and
                            numero_publicacion = $idpublicacion;
                        ");
    $confirmar = count( $verficar );

    $verficar1 = consultar("
                            select
                              miembro_persive,
                              numero_publicacion
                            from
                              who_percepcionel
                            where
                              miembro_persive = $miembro and
                              numero_publicacion = $idpublicacion;
                          ");
  $confirmar1 = count( $verficar1 );

#aqui se confirmara si ya realizo una de las dos percepciones, si no a echo ninguna, pasara a ingresar a la bd
    if ($confirmar || $confirmar1) {
      #no puede ingresar esa percepcion por que ya esta registrado (no ingresara una percepcion ya echa por el mismo miembro).
    }else{
        $sql="
          INSERT INTO percepcion 
            (miembro_idmiembro,
             tipo_percepcion_idtipo_percepcion, 
             publicacion_miembro_idmiembro, 
             publicacion_idpublicacion,
             publicacion_img_idimg,
             publicacion_tipo_publicacion_idtipo_publicacion)
          VALUES
            ('$miembro',
             '$percepcion', 
             '$dueño', 
             '$idpublicacion', 
             '$idimg', 
             '$tipo');
        ";
	$resultado = ejecutar($sql);
    }
  }

#para cambiar de percepcion.
  if (isset($_POST['cambiar'])) {
    $sql="
      update
        percepcion 
      set
        tipo_percepcion_idtipo_percepcion ='$cambio_percepcion'
      where 
        miembro_idmiembro ='$miembro' and
        publicacion_idpublicacion = '$idpublicacion';
        ";
      $resultado = ejecutar($sql);
  }

#quitar percepcion
  if (isset($_POST['quitar_p'])) {
    $sql="
      DELETE FROM 
        percepcion 
      where 
        miembro_idmiembro ='$miembro' and
        publicacion_idpublicacion = '$idpublicacion';
        ";
      $resultado = ejecutar($sql);
  }



      
  if (isset( $_SESSION['ingreso'] ) ){

####boton de  salir#############
  echo "</br></br>";
   echo"<div class='modal-footer'>";
              #echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
              echo"<p class='ayuda'>salir de esta publicación</p>";
              echo" <a class='btn btn-default btn-xs' title= 'salir de aquí' href='#' onclick='close_window();return false;'>Salir &nbsp <span class='glyphicon glyphicon-share-alt'></span></a>";
   echo"</div>";
#########################
   echo "<div id='plus'>";
     $vector_de_publicaciones = consultar("select * from vista_publicacion where  idpublicacion = $idpublicacion");
     $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {
        echo "</br>";
        echo "<table border='0' width='65%'>";
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {

            ( $contador + 1 );

                 $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];
                 $dueño_publi = $vector_de_publicaciones[$contador]['miembro'];
                 #se crea esta variable $iddueño_perfil para enviar el identificador del miembro solicitando ver su perfil
                 $iddueño_perfil = $dueño_publi + 6;
                 ###
                 $idtipo_publi = $vector_de_publicaciones[$contador]['idtipo_publi'];
                 $idimagen = $vector_de_publicaciones[$contador]['idimagen'];
                 $nombres = $vector_de_publicaciones[$contador]['nombres'];
                 $nombres_decode = mostrar_comilla_simple_nombres ($nombres);
                 $limpionombres = @ ereg_replace("[^A-Za-z0-9]", "", $nombres);
                 $titulo = $vector_de_publicaciones[$contador]['titulo'];
                 $titulo = mostrar_comilla_simple_titulo ($titulo);
            echo "<tr>";
                 echo "<td>";
                 echo     "<a class='' title='ver perfil' href='./index.php?perfil=$$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>:"."<span class='titulo'> $titulo</span>";
                 echo "</td>";
                 #en este archivo esta declarado la variable correo y variable id de miembro
                 include "./configuraciones/correo-idmiembro.php";
                 if ($dueño_publi == $miembroid) {
                   # hacer nada jeje. No mostrar el formulario de reporte, por que no querra reportar su propia publicacion
                 }else{
                  #el formulario para reportar anomalias de publicaciones o miembros
                         echo "<form action='./index.php?contenido=reportar_publicacion' target='_blank' method='post'>";
                          echo "<input type='hidden' name='idmiembro_reporta' value='$miembroid'>";
                          echo "<input type='hidden' name='idimagen' value='$idimagen'>";
                          echo "<input type='hidden' name='idtipo_publi' value='$idtipo_publi'>";
                          echo "<input type='hidden' name='dueño_publi' value='$dueño_publi'>";
                          echo "<input type='hidden' name='idpubli' value='$idpubli'>";
                 echo "<td width='01%'>";
                    echo"<button class='report report-default' title= 'quiero denunciar algo acerca de esto'><span class='glyphicon glyphicon-bullhorn'></span></button>";
                 echo "</td>";
                        echo"</form>";
                 }
           echo "</tr>";
           echo "<tr>";
                 echo "<td colspan='2'>";
                 $fecha = $vector_de_publicaciones[$contador]['fecha'];
                 $hora = $vector_de_publicaciones[$contador]['tiempo'];
                 echo  "<p class = ayuda >".date("d/F/y", strtotime("$fecha"))."  hora ".date('h:i a', strtotime("$hora"))."</p>";
                 $ruta = $vector_de_publicaciones[$contador]['imagen'];
                 ######
                 /*con esta funcion se establecera las dimenciones de la imagen (si es que existe $ruta)
                 a mostrar*/
                 dimenciones_imagenes_publicaciones ($ruta, @$width, @$height, $titulo, $fecha, $hora, $nombres);                 
                 #######
               echo "</td>";
                 echo "<td align= 'left' width='20%'>";

                 echo "</td>";
           echo "</tr>";
           echo "<tr >";
                 echo "<td width='80%'>";
                 
                    $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];

                    $textolargo = $vector_de_publicaciones[$contador]['texto_publicacion'];
                    $textolargo = mostrar_comilla_simple_textolargo($textolargo);
                    $textolargo   = str_replace("\r","<br>",$textolargo);
                    echo "<span class='texto_publicacion'>".$textolargo."<span>";
                    
                 echo "</td>";
         echo "</tr>";
           echo "<tr >";
                 echo "<td>";
                    #esta parte es para enviar los parametros al switch del cuerpo.php y comprovar que
                    #se envian a esta misma publicacion###############################################
                    $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];
                    $limpiotitulo = @ ereg_replace("[^A-Za-z0-9]", "", $titulo);
                    $limpionombres = @ ereg_replace("[^A-Za-z0-9]", "", $nombres);
                    echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                    echo "<input type='hidden' name='id' value='$idpubli'>";
                    echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                    echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                    #########################################################################################
                    
                    $miembro=$_SESSION['miembro'];
                    $dueño_public=$vector_de_publicaciones[$contador]['miembro'];
                    $idimagen=$vector_de_publicaciones[$contador]['idimagen'];
                    $tipo_publi=$vector_de_publicaciones[$contador]['idtipo_publi'];
                    $comentarios=$vector_de_publicaciones[$contador]['comentarios'];
                    $chivos=$vector_de_publicaciones[$contador]['chivos'];
                    $neles=$vector_de_publicaciones[$contador]['neles'];
                    $none = 0;

                        $vector_like = consultar("
                                          select
                                            miembro_persive,
                                            numero_publicacion
                                          from
                                            who_percepcionchivo
                                          where
                                            miembro_persive = $miembro and
                                            numero_publicacion = $idpubli;
                                      ");
                        $cantidad_like_miembro = count( $vector_like );

                        $vector_nel = consultar("
                                          select
                                            miembro_persive,
                                            numero_publicacion
                                          from
                                            who_percepcionel
                                          where
                                            miembro_persive = $miembro and
                                            numero_publicacion = $idpubli;
                                      ");
                        $cantidad_nel_miembro = count( $vector_nel );

                    if (!$comentarios && !$chivos && !$neles){
                      echo "<center><p class='ayuda'>Que dices sobre esto?</p></center>";
                    }

                    if (!$chivos && $cantidad_nel_miembro){
                      #nadie le a dado me gusta, pero le has dado no me gusta
                     echo "<button class='lik l-default' title='cambiar a: esta chivo' name='cambiar' value='1' ><span class='glyphicon glyphicon-thumbs-up'></span></button> &nbsp &nbsp &nbsp";
                    }
                    if (!$chivos && !$cantidad_nel_miembro){
                      #nadie le Ha dado me gusta, pero si existen no me gusta
                      echo "<button class='lik l-default' title='esta chivo' name='cn' value='1' ><span class='glyphicon glyphicon-thumbs-up'></span></button> &nbsp &nbsp";
                        }
                    if ( $chivos && $cantidad_like_miembro ) {
                          #le has dado me gusta: aparece encendido, si le das de nuevo retiras el me gusta
                          #echo "<button class='ylik yl-default' title='retirar' name='quitar_p' value='1'><span class='glyphicon glyphicon-thumbs-up'></span></button><b>".$chivos."</b>  &nbsp &nbsp";
                     verlikesy_boton ($idpubli, $chivos);

                    }
                    if ($chivos && $cantidad_nel_miembro && !$cantidad_like_miembro) {
                          #no le has dado me gusta: aparece apagado
                      verlikes_boton_cambiar($idpubli, $chivos);
                    }
                    if ($chivos && !$cantidad_nel_miembro && !$cantidad_like_miembro) {
                          #no le has dado me gusta ni no me gusta pero si otros le han dado me gusta: aparece apagado
                      verlikes_boton ($idpubli, $chivos);
                    }

                    if (!$neles && $cantidad_like_miembro){
                      #nadie le a dado no me gusta, pero le has dado me gusta
                      echo "<button class='nel n-default' title='no me gusta' name='cambiar' value='2'><span class='glyphicon glyphicon-thumbs-down'></span></button>";
                    }
                    if ( !$neles && !$cantidad_like_miembro) {
                      echo "<button class='nel n-default' title='no me gusta' name='cn' value='2'><span class='glyphicon glyphicon-thumbs-down'></span></button>";
                    }
                    if ($neles && $cantidad_nel_miembro) {
                      #le has dado no me gusta: aparece encendido, si le das de nuevo retiras el no me gusta
                      nelesy_boton($idpubli, $neles);
                    }
                    if ($neles && $cantidad_like_miembro && !$cantidad_nel_miembro) {
                          #no le has dado no me gusta: aparece apagado
                      neles_boton_cambiar($neles, $idpubli);
                    }
                    if ($neles && !$cantidad_like_miembro && !$cantidad_nel_miembro) {
                          #no le has dado no me gusta pero otros si le han dado no me gusta: aparece apagado
                      neles_boton($neles, $idpubli);
                    }

                    if (@$cantidad_like_miembro) {
                      echo "<p class='ayuda'>me gusta</p>";
                    }
                    if (@$cantidad_nel_miembro) {
                      echo "<p class='ayuda'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp no me gusta</p>";
                    }

                  echo "<input type='hidden' name='id' value='$idpubli'>";
                  echo "<input type='hidden' name='idmiembro' value='$miembro'>";
                  echo "<input type='hidden' name='dueno' value='$dueño_public'>";
                  echo "<input type='hidden' name='idim' value='$idimagen'>";
                  echo "<input type='hidden' name='tipo' value='$tipo_publi'>";
                  echo "</form>";


                  #echo "<hr>";
######################## aqui se evaluan quien es el mayor chivos(me gusta) ó neles(no me gusta), dependiendo de eso el icono de ##########
######################## comentario cambiara al mismo color del de los chivos o neles. ####################################################
                    if (!$comentarios){
                     echo " <button class='iconlike vistalike-default' title='ninguno aún' ><span class='glyphicon glyphicon-comment'></span></button></br>";
                    }
                    if ($comentarios && $chivos >= $neles) {
                        if ($ver_todos_coments) {
                          $limpiotitulo = @ereg_replace("[^A-Za-z0-9]", "", $titulo);
                          $limpionombres = @ereg_replace("[^A-Za-z0-9]", "", $nombres);
                          echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                          echo "<input type='hidden' name='id' value='$idpubli'>";
                          echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                          echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                          echo "<button class='yvistadown yvistadown-default' title='ya puedes ver el historial de comentarios' name='comentarios' value=''><span class='glyphicon glyphicon-arrow-down'></span></button>
                          <button class='ylik yl-default' title='ver solo los utitmos 5 comentarios' name='comentarios' value=''><span class='glyphicon glyphicon-comment'></span> <b>".$comentarios."</b></button></br>";
                        }else{
                          $limpiotitulo = @ereg_replace("[^A-Za-z0-9]", "", $titulo);
                          $limpionombres = @ereg_replace("[^A-Za-z0-9]", "", $nombres);
                          echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                          echo "<input type='hidden' name='id' value='$idpubli'>";
                          echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                          echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                          echo "<button class='lik l-default' title='ver historial cronológico de comentarios' name='comentarios' value='opc1'><span class='glyphicon glyphicon-comment'></span> <b>".$comentarios."</b></button></br>";
                        }
                    }
                    if ($comentarios && $chivos < $neles) {
                        if ($ver_todos_coments) {
                          $limpiotitulo = @ereg_replace("[^A-Za-z0-9]", "", $titulo);
                          $limpionombres = @ereg_replace("[^A-Za-z0-9]", "", $nombres);
                          echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                          echo "<input type='hidden' name='id' value='$idpubli'>";
                          echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                          echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                          echo "<button class='yvistadown yvistadown-default' title='ya puedes ver el historial de comentarios' name='comentarios' value=''><span class='glyphicon glyphicon-arrow-down'></span></button>
                          <button class='ynel yn-default' title='ver solo los utitmos 5 comentarios' name='comentarios' value=''><span class='glyphicon glyphicon-comment'></span> <b>".$comentarios."</b></button>";
                        }else{
                          $limpiotitulo = @ereg_replace("[^A-Za-z0-9]", "", $titulo);
                          $limpionombres = @ereg_replace("[^A-Za-z0-9]", "", $nombres);
                          echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                          echo "<input type='hidden' name='id' value='$idpubli'>";
                          echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                          echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                          echo "<button class='nel n-default' title='ver historial cronológico de comentarios' name='comentarios' value='opc1'><span class='glyphicon glyphicon-comment'></span> <b>".$comentarios."</b></button>";
                        }
                    }
                 echo "</form>";
                 echo "</td>";
         echo "</tr>";
         echo "<tr>";
                 echo "<td>";

/*********************** mostrar los comentarios*****************************************************************************************/

                  if($ver_todos_coments){
                    $vector_de_comentarios = consultar("select * from vista_comentario where  publicacion = $idpublicacion order by datefecha, datehora;");
                    $cantidad_de_comentarios = count( $vector_de_comentarios );
                    if ( $cantidad_de_comentarios > 0) {
                      for ( $contador = 0 ; $contador < $cantidad_de_comentarios ; $contador ++ ) {
                          ( $contador + 1 );
                               $miembro_coment = $vector_de_comentarios[$contador]['miembro_coment'];
                               $nombres        = $vector_de_comentarios[$contador]['nombres'];
                               $nombres_decode = mostrar_comilla_simple_nombres ($nombres);
                               $publicacion = $vector_de_comentarios[$contador]['publicacion'];
                               $dueño_publi     = $vector_de_comentarios[$contador]['miembro_coment'];
                               $iddueño_perfil  = $dueño_publi + 6;
                               $textolargo      = $vector_de_comentarios[$contador]['coment'];
                               $textolargo      = mostrar_comilla_simple_textolargo ($textolargo);
                               $textolargo   = str_replace("\r","<br>",$textolargo);
                               $wholike = consultar("select miembro_persive, numero_publicacion from who_percepcionchivo 
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $whonel = consultar("select miembro_persive, numero_publicacion from who_percepcionel
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $datefecha = $vector_de_comentarios[$contador]['datefecha'];
                               $datehora = $vector_de_comentarios[$contador]['datehora'];
                               if ($wholike) {
                                 echo "<div class='comentlike alert-coment-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                 echo "</div>";
                               }
                               if ($whonel) {
                                   echo "<div class='comentnolike alert-comentfail-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                               }
                               if (!$whonel && !$wholike) {
                                   echo "<div class='comentnone alert-comentnone-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                                 }
                        }
                      }
                  }


                  if(!$ver_todos_coments){
                    $vector_de_comentarios = consultar("select * from vista_comentario where  publicacion = $idpublicacion order by datefecha, datehora;");
                    $cantidad_de_comentarios = count( $vector_de_comentarios );
                    if ( $cantidad_de_comentarios <= 5) {
                      for ( $contador = 0 ; $contador < $cantidad_de_comentarios ; $contador ++ ) {
                          ( $contador + 1 );
                               $miembro_coment  =  $vector_de_comentarios[$contador]['miembro_coment'];
                               $nombres         = $vector_de_comentarios[$contador]['nombres'];
                               $nombres_decode  = mostrar_comilla_simple_nombres ($nombres);
                               $publicacion     = $vector_de_comentarios[$contador]['publicacion'];
                               $dueño_publi     = $vector_de_comentarios[$contador]['miembro_coment'];
                               $iddueño_perfil  = $dueño_publi + 6;
                               $textolargo      = $vector_de_comentarios[$contador]['coment'];
                               $textolargo      = mostrar_comilla_simple_textolargo ($textolargo);
                               $textolargo   = str_replace("\r","<br>",$textolargo);
                               $wholike = consultar("select miembro_persive, numero_publicacion from who_percepcionchivo 
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $whonel = consultar("select miembro_persive, numero_publicacion from who_percepcionel
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $datefecha = $vector_de_comentarios[$contador]['datefecha'];
                               $datehora = $vector_de_comentarios[$contador]['datehora'];
                               if ($wholike) {
                                 echo "<div class='comentlike alert-coment-default'>";
                                 echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                 echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                 echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                 echo "</div>";
                               }
                               if ($whonel) {
                                   echo "<div class='comentnolike alert-comentfail-default'>";
                                 echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                 echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                 echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                               }
                               if (!$whonel && !$wholike) {
                                   echo "<div class='comentnone alert-comentnone-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                                 }
                        }
                      }else{
                        
                        if ($cantidad_de_comentarios > 5) {
                        $vector_5_comentarios = consultar("select * from vista_comentario where publicacion = $idpublicacion order by datefecha desc, datehora desc limit 5;");
                        $cantidad_5_comentarios = count( $vector_5_comentarios );
                        echo  "<p class= 'ayuda'>Los ultimos 5 comentarios</p>";
                          for ( $contador = 0 ; $contador < $cantidad_5_comentarios ; $contador ++ ) {
                              ( $contador + 1 );
                                   $miembro_coment  = $vector_5_comentarios[$contador]['miembro_coment'];
                                   $nombres         = $vector_5_comentarios[$contador]['nombres'];
                                   $nombres_decode  = mostrar_comilla_simple_nombres ($nombres);
                                   $publicacion     = $vector_5_comentarios[$contador]['publicacion'];
                                   $dueño_publi     = $vector_5_comentarios[$contador]['miembro_coment'];
                                   $iddueño_perfil  = $dueño_publi + 6;
                                   $textolargo      = $vector_5_comentarios[$contador]['coment'];
                                   $textolargo      = mostrar_comilla_simple_textolargo ($textolargo);
                                   $textolargo   = str_replace("\r","<br>",$textolargo);
                                   $wholike = consultar("select miembro_persive, numero_publicacion from who_percepcionchivo 
                                                        where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                                   $whonel = consultar("select miembro_persive, numero_publicacion from who_percepcionel
                                                        where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                                   $datefecha = $vector_5_comentarios[$contador]['datefecha'];
                                   $datehora = $vector_5_comentarios[$contador]['datehora'];

                                   if ($wholike) {
                                     echo "<div class='comentlike alert-coment-default'>";
                                       echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                       echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                       echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                     echo "</div>";
                                   }
                                   if ($whonel) {
                                       echo "<div class='comentnolike alert-comentfail-default'>";
                                       echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                       echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                       echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                       echo "</div>";
                                   }
                                   if (!$whonel && !$wholike) {
                                       echo "<div class='comentnone alert-comentnone-default'>";
                                       echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                       echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                       echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                       echo "</div>";
                                     }
                            }
                        }
                      }
                  }

                  /*if(!$ver_todos_coments){
                    $vector_de_comentarios = consultar("select * from vista_comentario where  publicacion = $idpublicacion order by datefecha, datehora;");
                    $cantidad_de_comentarios = count( $vector_de_comentarios );
                    if ( $cantidad_de_comentarios > 5) {
                    echo  "<p class= 'ayuda'>Los 5 recientes comentarios</p>";
                    $vector_5_comentarios = consultar("select * from vista_comentario  where  publicacion = $idpublicacion order by datefecha desc, datehora desc limit 5;");
                    $cantidad_5_comentarios = count( $vector_5_comentarios );
                      for ( $contador = 0 ; $contador < $cantidad_5_comentarios ; $contador ++ ) {
                          ( $contador + 1 );
                               $miembro_coment  = $vector_5_comentarios[$contador]['miembro_coment'];
                               $nombres         = $vector_5_comentarios[$contador]['nombres'];
                               $nombres_decode  = mostrar_comilla_simple_nombres ($nombres);
                               $publicacion     = $vector_5_comentarios[$contador]['publicacion'];
                               $dueño_publi     = $vector_de_comentarios[$contador]['miembro_coment'];
                               $iddueño_perfil  = $dueño_publi + 6;
                               $textolargo      = $vector_de_comentarios[$contador]['coment'];
                               $textolargo      = mostrar_comilla_simple_textolargo ($textolargo);
                               $textolargo   = str_replace("\r","<br>",$textolargo);
                               $wholike = consultar("select miembro_persive, numero_publicacion from who_percepcionchivo 
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $whonel = consultar("select miembro_persive, numero_publicacion from who_percepcionel
                                                    where miembro_persive = '$miembro_coment' and numero_publicacion = '$publicacion';");
                               $datefecha = $vector_5_comentarios[$contador]['datefecha'];
                               $datehora = $vector_5_comentarios[$contador]['datehora'];

                               if ($wholike) {
                                 echo "<div class='comentlike alert-coment-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                 echo "</div>";
                               }
                               if ($whonel) {
                                   echo "<div class='comentnolike alert-comentfail-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                               }
                               if (!$whonel && !$wholike) {
                                   echo "<div class='comentnone alert-comentnone-default'>";
                                   echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)."$nombres_decode</a>";
                                   echo  "<spam class= 'ayuda'>".date("d/F/y", strtotime("$datefecha"))." a las ".date('h:i a', strtotime("$datehora"))."</spam>";
                                   echo  "<spam class= 'textcoment'>".$textolargo."</spam>";
                                   echo "</div>";
                                 }
                        }
                      }
                    }*/
                     #echo "</form>";
/*****************************************************************************************************************************************/
                 echo "</td>";
         echo "</tr>";
         echo "<tr>";
                 echo "<td>";

/***********************************formulario para enviar comentario y datos necesarios para ingresarlo a la bd***************************/

                      $limpiotitulo = @ereg_replace("[^A-Za-z0-9]", "", $titulo);
                      $limpionombres = @ereg_replace("[^A-Za-z0-9]", "", $nombres);
                      echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' method='post'>";
                      echo"<textarea class='form-coment' name='coment' placeholder='Comentar...' rows='2'></textarea>";
                      echo "<input type='hidden' name='id' value='$idpubli'>";
                      echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                      echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";
                      echo "<input type='hidden' name='idmiembro' value='$miembro'>";
                      echo "<input type='hidden' name='idim' value='$idimagen'>";
                      echo "<input type='hidden' name='tipo' value='$tipo_publi'>";
                      echo "<input type='hidden' name='dueno' value='$dueño_public'>";
                 echo "</td>";
                 echo "<td>";
                      echo "<button class='lik l-default' title='listo' name='comentario' ><span class='glyphicon glyphicon-send'></span></button>";
                  echo "</form>";
                  echo "</td>";
         echo "</tr>";
        }
        echo "</table>";
        echo "<hr>";
 echo "</div>"; 
      }
    }



?>
