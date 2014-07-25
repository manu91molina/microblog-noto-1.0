<?
  if (isset( $_SESSION['miembro'] ) ){

    #en este archivo esta declarado la variable correo y variable id de miembro
    include "./configuraciones/correo-idmiembro.php";
    #vamos a verificar si el miembro nunca ha hecho una publicacion, mostrarle 
    #un mensaje de bienvenida y de ayuda para su primera publicacion
    $vector_primer_publi = consultar("select * from vista_publicacion where (idtipo_publi <> 7 and idtipo_publi <> 9) and miembro = $miembroid");
    $existe = count( $vector_primer_publi );
    if (!$existe){
      echo"<div style='position:fixed; top:60px; left:52px; z-index:2; width:20%; height:50%; margin:auto;'>";
       echo "<div class='alert alert-info fade in'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo"<span class='glyphicon glyphicon-arrow-up'></span>";
        echo"<table border='0' width='86%'>";
        echo  "<tr align=''>";
        echo    "<td width='10%'>";
        echo      "<span class='glyphicon glyphicon-edit'></span>";
        echo    "</td>";
        echo    "<td>";
        echo      "<p class='ayuda'>Crear tus publicaciones</p>";
        echo    "</td>";
        echo  "</tr>";
        echo  "<tr align=''>";
        echo    "<td width='10%'>";
        echo      "<span class='glyphicon glyphicon-log-out'></span>";
        echo    "</td>";
        echo    "<td>";
        echo      "<p class='ayuda'>Cerrar sesión</p>";
        echo    "</td>";
        echo  "</tr>";
        echo  "<tr align=''>";
        echo    "<td width='10%'>";
        echo      "<b>$NOMBRE_BMU</b>";
        echo    "</td>";
        echo    "<td>";
        echo      "<p class='ayuda'>Ir al inicio de las publicaciones</p>";
        echo    "</td>";
        echo  "</tr>";
        echo"</table>";
       echo "</div>";
      echo"</div>";

      echo"<div style='position:fixed; top:60px; left:948px; z-index:1; width:20%; height:50%; margin:auto;'>";
       echo "<div class='alert alert-info fade in'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo  "<span class='glyphicon glyphicon-arrow-up'></span>";
        echo  "<p class='ayuda'>Mira y edita tu perfil seleccionando tu nombre</p>";
       echo "</div>";
      echo"</div>";
    }


      $vector_de_publicaciones = consultar("select * from vista_publicacion where (idtipo_publi <> 6) and (idtipo_publi <> 7) and (idtipo_publi <> 9) and (idtipo_publi <> 10) order by  fecha desc, tiempo desc");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ){
        echo "<pre>
                                       
                     
               </pre>";
        echo "<table  border='0' width='55%' >";
        #echo" <script>setTimeout('document.location.reload()',60000); </script>";
########## podemos decirle cuantas publicaciones nos muestre en la bitacora, dependera de la capacidad del servidor para que responda en #
########## un tiempo considerable la espera de carga de todo el html que contiene cada publicacion, y la frecuencia de publicaciones     #
########## creadas por los usuarios (evaluar estos puntos), por defecto estara mostrando las ultimas 40 publicaciones  ####################
########## el valor que se debe cambiar es a la variable $publicaciones_a_ver. ###########################################################
	$publicaciones_a_ver = 40; 
	if ($cantidad_de_publicaciones > $publicaciones_a_ver){
	  $cantidad_de_publicaciones = $publicaciones_a_ver;
	}
	
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++) {

            ( $contador + 1 );

            $idpubli=$vector_de_publicaciones[$contador]['idpublicacion'];
            $dueño_publi = $vector_de_publicaciones[$contador]['miembro'];
            #se crea esta variable $iddueño_perfil para enviar el identificador del miembro solicitando ver su perfil
            $iddueño_perfil = $dueño_publi + 6;
            ###
            $idtipo_publi = $vector_de_publicaciones[$contador]['idtipo_publi'];
            $idimagen = $vector_de_publicaciones[$contador]['idimagen'];
            $nombres = $vector_de_publicaciones[$contador]['nombres'];
            #$nombre_decode en caso de que el nombre tenga el caracter de comilla simple
            $nombres_decode = mostrar_comilla_simple_nombres ($nombres);
            $limpionombres = @ ereg_replace("[^A-Za-z0-9]", "", $nombres);
            $titulo = $vector_de_publicaciones[$contador]['titulo'];
            $titulo = mostrar_comilla_simple_titulo ($titulo);

            echo "<tr>";
                 echo "<td>";
                 echo     "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil' target='_blank'>".mini_avatar_perfil($dueño_publi)." $nombres_decode</a>:"."<span class='titulo'> $titulo</span>";
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
                 echo   "<button class='report report-default' title= 'quiero denunciar algo acerca de este miembro'><span class='glyphicon glyphicon-bullhorn'></span></button>";
                 echo "</td>";
                 echo"</form>";
                 }
           echo "</tr>";
           echo "<tr>";
                 echo "<td colspan='2'>";
                 $fecha = $vector_de_publicaciones[$contador]['fecha'];
                 $hora = $vector_de_publicaciones[$contador]['tiempo'];
                 echo  "<p class = ayuda >";
                 if($idtipo_publi == 2 || $idtipo_publi== 5 || $idtipo_publi == 8 ){
                    echo"<span class='glyphicon glyphicon-pushpin'></span> ";
                 }
                 echo date("d F 'y", strtotime("$fecha"))."  hora ".date('h:i a', strtotime("$hora"))."</p>"; 

                 $ruta = $vector_de_publicaciones[$contador]['imagen']; 
                 ######
                 /*con esta funcion se establecera las dimenciones de la imagen (si es que existe $ruta)
                 a mostrar*/
                 dimenciones_imagenes_publicaciones ($ruta, @$width, @$height, $titulo, $fecha, $hora, $nombres);                 
                 #######
                 echo "</td>";
           echo "</tr>";
           echo "<tr>";
                 $limpiotitulo = @ ereg_replace("[^A-Za-z0-9]", "", $titulo);
                 echo "<form action='./index.php?contenido=";echo $limpionombres."-".$limpiotitulo."-".$idpubli; echo "' target='_blank' method='post'>";
                 echo "<input type='hidden' name='id' value='$idpubli'>";
                 echo "<input type='hidden' name='nombreurl' value='$limpionombres'>";
                 echo "<input type='hidden' name='titulourl' value='$limpiotitulo'>";

                 echo "<td width='60%' colspan='2'>";
                    $textolargo     = $vector_de_publicaciones[$contador]['texto_publicacion'];
                    $textocortado   =recortar($textolargo, 230); // recortamos 350 caracteres
                    $textocortado   = str_replace("\r","<br>",$textocortado);
                    // mostramos el texto cortado
                    echo "<span class='texto_publicacion'>".$textocortado."</span>";
                    #estas variables servira para mostrar mensaje de "que dices sobre esto?" en caso de que nadie
                    #haya echo un comentario o reaccion "me gusta" o "no me gusta"
                    $comentarios=@$vector_de_publicaciones[$contador]['comentarios'];
                    $chivos=@$vector_de_publicaciones[$contador]['chivos'];
                    $neles=@$vector_de_publicaciones[$contador]['neles'];
                    if (!$comentarios && !$chivos && !$neles ){
                    echo "<center><span class='ayuda'>Que dices sobre esto?</span>";
                    #aquí el boton para ver la publicacion completa, y ahi se podra comentar o aplicar alguna reacion de "me gusta" o "no me gusta"
                    echo "<center><button class='ver b-default' title='ver publicacion' > <span class='glyphicon glyphicon-thumbs-up'></span> te gusta? <span class='glyphicon glyphicon-comment'></span> comentar? <span class='glyphicon glyphicon-eye-open'></span> ver?</button></center>";
                    echo"</form>";
                    }else{
                      #aquí el boton para ver la publicacion completa, y ahi se podra comentar o aplicar alguna reacion de "me gusta" o "no me gusta"
                    echo "<center><button class='ver b-default' title='ver publicacion' >te gusta? | comentar? | ver?</button></center>";
                    }
                 echo"</form>";
                 echo "</td>";
           echo "</tr>";


/***********************eventos****************************/

/*******************AQUI VAN LOS EVENTOS-ME GUSTA-***************************************/
           echo "<tr>";
                 echo "<td colspan='2'>";
                 echo "<span class='ayuda'>score <span class='glyphicon glyphicon-stats'></span></span>";
                 #archivo que genera las vistas de las reacciones, cantidad y quienes la realizaron
                  include "./aplicaciones/plus.php";

                    if (@$cantidad_like_miembro) {
                      echo "<p class='ayuda'>me gusta</p>";
                    }
                    if (@$cantidad_nel_miembro) {
                      echo "<p class='ayuda'>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp no me gusta</p>";
                    }
                  echo "<hr>
                      ";
                 echo "</td>";
         echo "</tr>";
        }
        echo "</table>";
      }
    }


?>
