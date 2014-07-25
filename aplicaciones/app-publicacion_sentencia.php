<?
           echo "<tr>";
                 #echo "</td>"; 
                if ($idtipo_publi == 6 ) {
                 echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
                 echo "<input type='hidden' name='idpubli' value='".@$publicacion_id."'>";
                 echo "<input type='hidden' name='notificacion_id' value='".@$notificacion_id."'>";
                 echo "<input type='hidden' name='regresar' value='regresar'>";
                 echo "<td width=''>";
                 echo   "<button class='btn btn-default btn-xs' title= 'quitar modo oculto'><span class='glyphicon glyphicon-eye-open' title='la publicación se encuentra oculta'></span> Quitar modo oculto</button>";
                 echo "</td>";                 
                 echo "</form>";
                }else{
                 echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
                 echo "<input type='hidden' name='idpubli' value='".@$publicacion_id."'>";
                 echo "<input type='hidden' name='notificacion_id' value='".@$notificacion_id."'>";
                 echo "<input type='hidden' name='ocultar' value='ocultar'>";
                 echo "<td width=''>";
                 echo   "<button class='btn btn-default btn-xs' title= 'Ocultar esta publicación'><span class='glyphicon glyphicon-eye-close' title='la publicación se encuentra visible'></span> Ocultar publicación</button>";
                 echo "</td>";
                 echo "</form>"; 
                 echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
                 echo "<input type='hidden' name='idpubli' value='".@$publicacion_id."'>";
                 echo "<input type='hidden' name='notificacion_id' value='".@$notificacion_id."'>";
                 echo "<input type='hidden' name='mantener' value='mantener'>";
                 echo "<td width=''>";
                 echo   "<button class='btn btn-default btn-xs' title= 'Mantener esta publicación'><span class='glyphicon glyphicon-eye-open' title='la publicación se encuentra visible'></span> Mantener publicación</button>";
                 echo "</td>";                 
                 echo "</form>";
                }
           echo "<tr>";
                 echo "<td colspan='2' >";
                 
                 $idpubli=$vector_publi_id[$contador]['idpublicacion'];
                 $dueño_publi = $vector_publi_id[$contador]['miembro'];
                 #se crea esta variable $iddueño_perfil para enviar el identificador del miembro solicitando ver su perfil
                 $iddueño_perfil = $dueño_publi + 6;
                 ###
                 $idimagen = $vector_publi_id[$contador]['idimagen'];
                 $nombres = $vector_publi_id[$contador]['nombres'];
                 #$nombre_decode en caso de que el nombre tenga el caracter de comilla simple
                $nombres_decode = mostrar_comilla_simple_nombres ($nombres);
                $limpionombres = @ ereg_replace("[^A-Za-z0-9]", "", $nombres);
                $titulo = $vector_publi_id[$contador]['titulo'];
                $titulo = mostrar_comilla_simple_titulo ($titulo);
                echo "publicación <b>#$publicacion_id</b></br>";
                 echo  "<a class='' title='ver perfil' href='./index.php?perfil=$limpionombres&noto=$iddueño_perfil' target='_blank'>$nombres_decode</a>:  $titulo";
                 echo "</td>";
           echo "</tr>";
           echo "<tr>";
                 echo "<td colspan='3'>";
                 $fecha = $vector_publi_id[$contador]['fecha'];
                 $hora = $vector_publi_id[$contador]['tiempo'];
                 echo  "<p class = ayuda >".date("d/m/y", strtotime("$fecha"))."  hora ".date('h:i a', strtotime("$hora"))."</p>";
                 $ruta = $vector_publi_id[$contador]['imagen'];
                 ######
                 /*con esta funcion se establecera las dimenciones de la imagen (si es que existe $ruta)
                 a mostrar*/
                 dimenciones_imagenes_publicaciones ($ruta, @$width, @$height, $titulo, $fecha, $hora, $nombres);                 
                 #######
               echo "</td>";
            echo "</tr>";
            echo "<tr>";
                 echo "<td>";
                 echo "</td>";
                 echo "<td>";
                 echo "</td>";
                 echo "<td>";
                 echo "</td>";
            echo "</tr>";
            echo "<tr>";
                 echo "<td colspan='3'>";
                    $textolargo = $vector_publi_id[$contador]['texto_publicacion'];
                    echo $textolargo;                   
                 echo "</td>";
         echo "</tr>";

?>