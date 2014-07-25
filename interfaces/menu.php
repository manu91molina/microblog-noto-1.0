<?

include "./configuraciones/correo-idmiembro.php";

if ( $miembroid) { 

  #obtener nombres del usuario  
  $vector_de_publicaciones = consultar("select * from vista_perfil where miembro = $miembroid");
  $cantidad_de_publicaciones = count( $vector_de_publicaciones );
  if ( $cantidad_de_publicaciones > 0 ) {
	for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
                $nombres = $vector_de_publicaciones[$contador]['nombres'];
                $nombres_actual = mostrar_comilla_simple_nombres ($nombres);
          }
  }
  #obtener imagen de perfil de usuario     
  $vector_img_portada = consultar("select * from vista_publicacion where miembro = $miembroid and (idtipo_publi = 8 or idtipo_publi = 9 or idtipo_publi = 10)  order by fecha desc, tiempo desc;");
  $cantidad_img_portada = count( $vector_img_portada );
  if ( $cantidad_img_portada > 0 ) {
    for ( $contador = 0 ; $contador <= 0 ; $contador ++ ) {
      $imagen = $vector_img_portada[$contador]['imagen'];      
    }
  }



   include "./configuraciones/nombre_bmu.php";
  echo "
      <div class='navbar navbar-inverse navbar-fixed-top'>
      <div class='container'>
        <div class='option-header'>
          <a class='titlepanel' href='./'><b>$NOMBRE_BMU</b></a>   
        </div>        
        <div class='optcion-header'>
          <ul class='nav navbar-nav'>
            <li><a href='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcor_crear' class='onpublic public-default' title='crear publicación'><span class='glyphicon glyphicon-edit'></span></a></form></li>
            <li class='dropdown'><a href='#' class='onpublic public-default' data-toggle='dropdown' title='Configurar Cuenta' ><span class='glyphicon glyphicon-cog'></span></a>
              <ul class='dropdown-menu'>
                <li>
                  <a href='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta' title='Editar clave'>Editar clave</a>
                </li>
              </ul>
            </li>
          ";
  include "./configuraciones/verificar-estado_miembro.php";
          if ($tipo_estadoid == 3){
            echo"<li><a href='./index.php?contenido=dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja' class='onpublic public-default' title='bandeja de denucias'><span class='glyphicon glyphicon-exclamation-sign'></span></a></form>
                 </li>
                 ";
	        }
          
  echo"     <li class='dropdown'><a href='#' class='onpublic public-default' data-toggle='dropdown' title='Cerrar Sesión' ><span class='glyphicon glyphicon-log-out'></span></a>
              <ul class='dropdown-menu'>
                <li><a href='./index.php?contenido=cerrarsesion' title='salir'>Cerrar</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div class='navbar-header'>
       ";
	
      if ($nombres_actual){
		  include "./configuraciones/alterror_correo-idmiembro.php";
           # echo "<div style='position:absolute; top:32.5px; left:1170px; z-index: 4; width:4%; height:2%; margin:auto;'>";
            #  echo   "<img src='$imagen' class='img-mini_panel_user'/>";
            #echo"</div>";
			echo"<a class='usuario' title='ver mi perfil' href='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'>$nombres_actual <img src='$imagen' class='img-mini_panel_user'/></a> ";
		}else{
			echo"<a class='usuario' href='./'> $correo</a>";
		}
          
    echo"      
        </div>        
        <!--/.nav-collapse -->
      </div>
    </div>
  
  ";
}

#<li class='#'> <a";  echo $_SESSION['ingreso']; echo" </li>


##<li><a href='./index.php?contenido=5'>Editar</a></li>
?>
