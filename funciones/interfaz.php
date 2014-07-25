<?php


function validar_usuario() {
  include "./configuraciones/principal.php";
  $contenido = @ $_REQUEST['contenido'];

  if ( $contenido == "evaluaringreso" ) {
      $correo =  $_REQUEST['correo'];
      $clave  =  $_REQUEST['clave'];
      $clave  = md5($clave);

        #En caso de que no sea igual al correo de la configuración se procede a la búsuqeda en la base
        #de datos para encontrar el correo y su identificador.
        
        $sql = "
          select
            *
          from
            miembro
          where
            clave  = '$clave';
            ";
        $sql2 = "
          select
            *
          from
            correo
          where
            correo  = '$correo';
             ";
       $existe1 = consultar ( $sql);
       $verficar_existencia1 = count($existe1);
       $existe2 = consultar2 ( $sql2);
       $verficar_existencia2 = count($existe2);
        
     if ( $existe1 && $existe2 ) {
		 
		 $vector_miembros = consultar("select idmiembro, miembro_idmiembro from miembro, correo
											where clave = '$clave' and correo = '$correo' and idmiembro = miembro_idmiembro;");
		 $existe_miembro = count( $vector_miembros );
			
			if ( $existe_miembro > 0 ) {

				for ( $contador = 0 ; $contador < $existe_miembro ; $contador ++ ) {

						( $contador + 1 );
						$id = $vector_miembros[$contador]['idmiembro'];
						$_SESSION["ingreso"] = "$correo";
						$_SESSION["miembro"] = $id;
						$resultado = TRUE;
					}
			}else{
			  header('Location: indexwhoever.php');
			}
		}else{
      if ($existe2 && !$existe1) {
        $_SESSION["ingreso"] = "$correo";
        header('Location: indexwhoever.php');
      }else{
        echo"<div style='position:fixed; top:-58px; left:-174px; z-index: 5; width:48%; height:20%; margin:auto;'>";
         echo "<div class='alert alert-danger fade in'>";
          echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
          echo"<p class='ayuda'>Probablemente introdujo mal su correo, intente de nuevo.</p>";
         echo "</div>";
        echo"</div>";
      }
		}
        
  }
    

  if ( $contenido == "cerrarsesion" ) {
      $_SESSION["ingreso"]   = NULL;
      $_SESSION["correo"]   = NULL;
      $_SESSION["miembro"] = NULL;
      session_destroy();
    unset( $_SESSION['ingreso'] );
  }
}



function dimenciones_imagenes_publicaciones($ruta, $width, $height, $titulo, $fecha, $hora, $nombres){
  if ($ruta == "none") {
    echo "";
  }else{
    list($width, $height) = getimagesize($ruta);
    if ($width <= 500 && $width >=200 && $width > $height) {
      echo "<a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta' width='375' height='150' alt=''/></a>";
    }else{
       if ($width <= 700 && $width >=501 && $width > $height) {
         echo "<center><a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta' width='360' height='230' alt=''/></center></a>";
       }else{
         if ($width <= 999 && $width >=701 && $width > $height) {
         echo "<center><a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta' width='300' height='230' alt=''/></center></a>";
         }else{
           if ($width <= 1399 && $width >=1000 && $width > $height) {
             echo "<a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta' width='390' height='250' alt=''/></a>";
           }else{
             if ($width <= 5999 && $width >=1400 && $width > $height) {
               echo "<a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta' width='390' height='250' alt=''/></a>";
             }else{
               echo "<center><a class='fancybox-button' rel='fancybox-button' href='$ruta' title='$nombres: $titulo... publicado el ".date("d/m/y", strtotime("$fecha"))." a las ".date('h:i a', strtotime("$hora"))."'><img src='$ruta'width='195' height='290' alt=''/></a></center>";                          
             }
           }
         }
       }
     }
  }
}

function ver_un_perfil($ver_un_perfil, $ver_miembro){
  $ver_miembro = $ver_miembro - 6;
  $vector_perfil = consultar("select * from perfil where miembro_idmiembro = $ver_miembro;");
  $cantidad_perfil = count( $vector_perfil );
  if ( $cantidad_perfil > 0 ) {
    include "./aplicaciones/app-visitar_perfil.php";
  }else{
    echo "<div style='position:fixed; top:60px; left:24px; z-index: 0; width:27%; height:50%; margin:auto;'>";
    echo  "<div class='alert alert-danger fade in'>";
    echo    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo    "<span class='glyphicon glyphicon-remove-circle'></span> ERROR: ¿Adonde quieres ir?";
    echo  "</div>";
    echo "</div>"; 
  }


  #if ($ver_un_perfil && $miembro) {
   # include "./aplicaciones/app-visitar_perfil.php";
    #echo "</br><b>Estamos en construcción...</b><br>";
    #echo "<img class='img-circle' src='./recursos/Beavis_construllendo.gif' title='[codigo... codigo...]' alt=''/>";

  #}
}


function recortar($texto, $numero){ 
  if(strlen($texto) > $numero){ 
    $texto=substr($texto,0,$numero)."...";
    $texto = str_replace("&amp;#39", "'", $texto);
     }else{ 
      $texto=$texto;
      $texto = str_replace("&amp;#39", "'", $texto);
     } 
        return $texto; 
}

function recortar_nombre($nombres, $caracteres){ 
  if(strlen($nombres) > $caracteres){ 
    $nombres=substr($nombres,0,$caracteres)."..."; 
     }else{ 
      $nombres=$nombres; 
     } 
        return $nombres; 
} 


function mini_avatar_perfil ($dueño_publi){
  #obtener imagen de perfil de usuario     
  $vector_mini_avatar = consultar("
    SELECT 
      imagen,
      miembro,
      idpublicacion
    FROM 
      mini_avatar 
    WHERE
      miembro = $dueño_publi
    order by  fecha desc, tiempo desc;;
  ");
  $cantidad_avatar = count( $vector_mini_avatar );
  if ( $cantidad_avatar > 0 ) {
    for ( $contador = 0 ; $contador <=0 ; $contador ++ ) {
      ( $contador + 0 );
      $avatar = $vector_mini_avatar[$contador]['imagen'];
      #echo $avatar = $vector_mini_avatar[$contador]['miembro'];
    }
    echo "<img src='$avatar' class='img-mini_vitacora_user'/>";
  }else{
    echo "<img src='./recursos/default-user.png' class='img-mini_vitacora_user'/>";
  }

}

/* aun sin funcionar: permitir comillas simples en nombres y apellidos
function permitir_comilla_simple_nombres ($nombres){
    $nombres  = str_replace("'", "&#39", $nombres);
    return $nombres; 
}

function permitir_comilla_simple_apellidos ($apellidos){
    $apellidos  = str_replace("'", "&#39", $apellidos);
    return $apellidos; 
}
*/
function permitir_comilla_simple_titulo ($titulo){
    $titulo  = str_replace("'", "&#39", $titulo);
    return $titulo; 
}

function permitir_comilla_simple_texto ($texto){
    $texto  = str_replace("'", "&#39", $texto);
    return $texto; 
}

function permitir_comilla_simple_frase ($frase){
    $frase  = str_replace("'", "&#39", $frase);
    return $frase; 
}

function permitir_comilla_simple_nombres ($nombres){
    $nombres  = str_replace("'", "&#39", $nombres);
    return $nombres; 
}

function permitir_comilla_simple_apellidos ($apellidos){
    $apellidos  = str_replace("'", "&#39", $apellidos);
    return $apellidos; 
}

function mostrar_comilla_simple_titulo ($titulo){
  $titulo= str_replace("&amp;#39", "'", $titulo);
  return $titulo; 
}

function mostrar_comilla_simple_textolargo ($textolargo){
  $textolargo= str_replace("&amp;#39", "'", $textolargo);
  return $textolargo; 
}


function mostrar_comilla_simple_frase ($frase){
  $frase= str_replace("&amp;#39", "'", $frase);
  return $frase; 
}

function mostrar_comilla_simple_nombres ($nombres){
  $nombres= str_replace("&amp;#39", "'", $nombres);
  return $nombres; 
}

function mostrar_comilla_simple_apellidos ($apellidos){
  $apellidos= str_replace("&amp;#39", "'", $apellidos);
  return $apellidos; 
}
########################BOTONES LIKE (CHIVO, ME GUSTA) Y NELES(DISLIKE, NO ME GUSTA)################################################
function verlikesy_boton($idpubli, $chivos){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionchivo
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
    $idpubli= $idpubli-1;
               echo"<button class='ylik yl-default' title='retirar me gusta' name='quitar_p' value='1' ><span class='glyphicon glyphicon-thumbs-up'></span></button><a href='#$idpubli' class='fancylikeordislike likesy' title='les gusta'><b> &nbsp".$chivos."</b></a> &nbsp
              <div id='$idpubli' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
                  
        }
        echo "
          </div>";
      }

}

function verlikes_boton($idpubli, $chivos){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionchivo
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
      $idpubli= $idpubli-1;
               echo"<button class='lik l-default' title='esta chivo' name='cn' value='1' ><span class='glyphicon glyphicon-thumbs-up'></span></button><a href='#$idpubli' class='fancylikeordislike likesy' title='les gusta'>".$chivos."</a> &nbsp
              <div id='$idpubli' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
        }
        echo "
          </div>";
      }

}

function verlikes_boton_cambiar($idpubli, $chivos){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionchivo
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
    $idpubli= $idpubli-1;
               echo"<button class='lik l-default' title='esta chivo' name='cambiar' value='1' ><span class='glyphicon glyphicon-thumbs-up'></span></button><a href='#$idpubli' class='fancylikeordislike likesy' title='les gusta'>".$chivos."</a> &nbsp 
              <div id='$idpubli' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
        }
        echo "
          </div>";
      }

}
function nelesy_boton($idpubli, $neles){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionel
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
        $idpublica= $idpubli+1;
               echo"<button class='ynel yn-default' title='retirar' name='quitar_p' value='2'><span class='glyphicon glyphicon-thumbs-down'></span></button><a href='#$idpublica' class='fancylikeordislike nelesy' title='no les gusta'><b> &nbsp".$neles."</b></a> &nbsp
              <div id='$idpublica' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
        }
        echo "
          </div>";
      }

}

function neles_boton($neles, $idpubli){
  #echo "hola";
      $neles_vector = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionel
                      where 
                      numero_publicacion = $idpubli;
       ");
      $neles_cantidad = count( $neles_vector );
      if ( $neles_cantidad > 0 ) {
        $idpublica= $idpubli+1;
               echo"<button class='nel n-default' title='no me gusta' name='cn' value='2'><span class='glyphicon glyphicon-thumbs-down'></span></button><a href='#$idpublica' class='fancylikeordislike neles' title='no les gusta'>".$neles."</a> &nbsp
              <div id='$idpublica' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $neles_cantidad ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $neles_vector[$contador]['nombres'];
            $dueño_publi  = $neles_vector[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
        }
        echo "
          </div>";
      }

}

function neles_boton_cambiar($neles, $idpubli){
  #echo "hola";
      $neles_vector = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionel
                      where 
                      numero_publicacion = $idpubli;
       ");
      $neles_cantidad = count( $neles_vector );
      if ( $neles_cantidad > 0 ) {
        $idpublica= $idpubli+1;
               echo"<button class='nel n-default' title='no me gusta' name='cambiar' value='2'><span class='glyphicon glyphicon-thumbs-down'></span></button><a href='#$idpublica' class='fancylikeordislike neles' title='no les gusta'>".$neles."</a> &nbsp
              <div id='$idpublica' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $neles_cantidad ; $contador ++ ) {
            ( $contador + 1 );
            $nombres      = $neles_vector[$contador]['nombres'];
            $dueño_publi  = $neles_vector[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
        }
        echo "
          </div>";
      }

}

####################SENTENCIA DE REPORTES DE PUBLICACIONES#################
function sentencia_publicacion ($publicacion_id, $nombres_notificador_corto, $notificacion_id, $idestado_notificacion){
      #notificacion no vista (no se a aplicado sentencia)
      if ($idestado_notificacion == 1) {
        $vector_publi_id = consultar("select * from vista_publicacion where idpublicacion  = $publicacion_id");
        $cantidad_publi = count( $vector_publi_id );
        if ( $cantidad_publi > 0 ) {
          include "./aplicaciones/publicacion_veces_denunciada.php";
          for ( $contador = 0 ; $contador < $cantidad_publi ; $contador ++ ) {
            ( $contador + 1 );

            $idtipo_publi = $vector_publi_id[$contador]['idtipo_publi'];
            if ($idtipo_publi == 6) {
              echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
              echo "<input type='hidden' name='notificacion_id' value='$notificacion_id'>";
              echo "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
              echo "<span class='glyphicon glyphicon-eye-close' title='la publicación se encuentra oculta'></span> <b>$nombres_notificador_corto denuncia publicación #$publicacion_id | veces denunciada: $veces | <a class='varios' href='#$publicacion_id'>ver</a> |</b> <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
              echo "</form>";
              echo"<div id='$publicacion_id' style='display:none;width:200px;'>";
                echo "<table border='0' width='150%'>";
     
                  include "./aplicaciones/app-publicacion_sentencia.php";
            }else{
              echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
              #echo "<input type='hidden' name='idpubli' value='$publicacion_id'>";
              echo "<input type='hidden' name='notificacion_id' value='$notificacion_id'>";
              echo "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
              echo "<span class='glyphicon glyphicon-eye-open' title='la publicación se encuentra visible'></span><b>$nombres_notificador_corto denuncia publicación #$publicacion_id | veces denunciada: $veces | <a class='varios' href='#$publicacion_id'>ver</a> |</b> <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
              echo "</form>";
              echo"<div id='$publicacion_id' style='display:none;width:200px;'>";
                echo "<table border='0' width='150%'>";
     
                  include "./aplicaciones/app-publicacion_sentencia.php";
            }

          }
              echo "</table>";
            echo"</div>";
        }
      # si se a aplicado sentencia
      }else{
        $vector_publi_id = consultar("select * from vista_publicacion where idpublicacion  = $publicacion_id");
        $cantidad_publi = count( $vector_publi_id );
        if ( $cantidad_publi > 0 ) {
          include "./aplicaciones/publicacion_veces_denunciada.php";
          for ( $contador = 0 ; $contador < $cantidad_publi ; $contador ++ ) {
            ( $contador + 1 );

              $idtipo_publi = $vector_publi_id[$contador]['idtipo_publi'];
              if ($idtipo_publi == 6) {
              echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
              echo "<input type='hidden' name='notificacion_id' value='$notificacion_id'>";
              echo "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
                echo"<span class='glyphicon glyphicon-eye-close' title='la publicación se encuentra oculta'></span>$nombres_notificador_corto denuncia publicación #$publicacion_id | veces denunciada: $veces | <a class='varios' href='#$publicacion_id'>ver</a> | <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
              echo "</form>";
                echo"<div id='$publicacion_id' style='display:none;width:200px;'>";
                  echo "<table border='1' width='150%'>";
       
                    include "./aplicaciones/app-publicacion_sentencia.php";
              }else{
              echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
              echo "<input type='hidden' name='notificacion_id' value='$notificacion_id'>";
              echo "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
                echo"<span class='glyphicon glyphicon-eye-open' title='la publicación se encuentra visible'></span>$nombres_notificador_corto denuncia publicación #$publicacion_id | veces denunciada: $veces | <a class='varios' href='#$publicacion_id'>ver</a> | <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
              echo "</form>";
                echo"<div id='$publicacion_id' style='display:none;width:200px;'>";
                  echo "<table border='1' width='150%'>";
       
                    include "./aplicaciones/app-publicacion_sentencia.php";               
              }

            }
                  echo "</table>";
                echo"</div>";
        }
      }

}


######## 2nda forma de sentencias a publicaciones ############################

function otra_forma_sentencia_publicacion ($publicacion_id, $veces_denunciada){
  $vector_publi_id = consultar("select * from vista_publicacion where idpublicacion  = $publicacion_id");
  $cantidad_publi = count( $vector_publi_id );
  if ( $cantidad_publi > 0 ) {
    for ( $contador = 0 ; $contador < $cantidad_publi ; $contador ++ ) {
      ( $contador + 1 );

       $idtipo_publi = $vector_publi_id[$contador]['idtipo_publi'];
      if ($idtipo_publi == 6) {
        echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
        echo  "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
        echo  "<span class='glyphicon glyphicon-eye-close' title='la publicación se encuentra oculta'></span> publicacion #$publicacion_id | veces denunciada: $veces_denunciada | <a class='varios' href='#$publicacion_id'>ver</a> | <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
        echo "</form>";
        echo "<div id='$publicacion_id' style='display:none;width:200px;'>";
        echo  "<table border='1' width='150%'>";
         
                  include "./aplicaciones/app-publicacion_sentencia.php";
      }else{
        echo "<form action='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' method='post'>";
        echo  "<input type='hidden' name='eliminar_denuncia' value='eliminar_denuncia'>";
        echo  "<span class='glyphicon glyphicon-eye-open' title='la publicación se encuentra visible'></span> publicación #$publicacion_id | veces denunciada: $veces_denunciada | <a class='varios' href='#$publicacion_id'>ver</a> | <button class='btn btn-default btn-xs' title='eliminar denuncia'><span class='glyphicon glyphicon-trash'></span> eliminar denuncia</button>";
        echo "</form>";
        echo "<div id='$publicacion_id' style='display:none;width:200px;'>";
        echo  "<table border='1' width='150%'>";
         
        include "./aplicaciones/app-publicacion_sentencia.php";               
      }

    }
        echo  "</table>";
        echo "</div>";

  }


}






####################################################################################

######################VISTA Y CANTIDAD DE LOS ME GUSTA Y NO ME GUSTA EN BITACORA DE PUBLICACIONES#################################################################################################
function verlikesy($idpubli, $chivos){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionchivo
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
		  $idpubli= $idpubli-1;
              echo"<span class='yiconlike yvistalike-default' title='esta chivo' ><span class='glyphicon glyphicon-thumbs-up'></span></span><a href='#$idpubli' class='fancylikeordislike likesy' title='les gusta'><b> &nbsp".$chivos."</b></a> &nbsp
              <div id='$idpubli' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {

            ( $contador + 1 );
            $nombres      = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
                  
        }
        echo "</div>";
      }

}

function verlikes($idpubli, $chivos){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionchivo
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
			$idpubli= $idpubli-1;
               echo"<span class='iconlike vistalike-default' title='' ><span class='glyphicon glyphicon-thumbs-up'></span></span><a href='#$idpubli' class='fancylikeordislike likes' title='les gusta'>".$chivos."</a> &nbsp
              <div id='$idpubli' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {

            ( $contador + 1 );
            $nombres = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
                  
        }
        echo "
          </div>";
      }

}


function nelesy($idpubli, $neles){
      $vectorwholk = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionel
                      where 
                      numero_publicacion = $idpubli;
       ");
      $cantidad_wholk = count( $vectorwholk );
      if ( $cantidad_wholk > 0 ) {
				$idpublica= $idpubli+1;
               echo"<span class='yiconnolike yvistanolike-default' title='no me gusta' ><span class='glyphicon glyphicon-thumbs-down'></span></span><a href='#$idpublica' class='fancylikeordislike nelesy' title='no les gusta'><b> &nbsp".$neles."</b></a>
              <div id='$idpublica' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $cantidad_wholk ; $contador ++ ) {

            ( $contador + 1 );
            $nombres = $vectorwholk[$contador]['nombres'];
            $dueño_publi  = $vectorwholk[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
                  
        }
        echo "
          </div>";
      }

}


function neles($neles, $idpubli){
      $whonelesvector = consultar("
                      select 
                      nombres,
                      miembro_persive
                      from 
                      who_percepcionel
                      where 
                      numero_publicacion = $idpubli;
       ");
      $neles_cantidad = count( $whonelesvector );
      if ( $neles_cantidad > 0 ) {
				$idpublica= $idpubli+1;
               echo"<span class='iconnolike vistanolike-default' title='' ><span class='glyphicon glyphicon-thumbs-down'></span></span><a href='#$idpublica' class='fancylikeordislike neles' title='no les gusta'>".$neles."</a>
              <div id='$idpublica' style='display:none;width:300px;'>";
        for ( $contador = 0 ; $contador < $neles_cantidad ; $contador ++ ) {

            ( $contador + 1 );
            $nombres = $whonelesvector[$contador]['nombres'];
            $dueño_publi  = $whonelesvector[$contador]['miembro_persive'];
            $iddueño_perfil = $dueño_publi + 6;
                  echo "<br>";
                  echo  "<a class='' title='ver perfil' href='./index.php?perfil=$dueño_publi&noto=$iddueño_perfil'>".mini_avatar_perfil($dueño_publi)." $nombres</a>";
                  
        }
        echo "
          </div>";
      }

}
###################################################################################################

function cabeza () {
  include "./interfaces/cabeza.php";
}

function cuerpo () {
  include "./interfaces/cuerpo.php";
}

function pie () {
  include "./interfaces/pie.php";
}



include "./funciones/basededatos.php";


?>
