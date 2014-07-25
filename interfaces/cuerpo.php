<?
  include "interfaces/menu.php";
?>

<?php

##############################parte para crear el usuario de administrador o loguear usuario normal #############

 include "./configuraciones/existe_miembro.php";


if ($cantidada_de_miembros > 0) {
  if ( isset( $_SESSION['miembro'] ) ){
    ##poderosa tabla que contendra las interfaces
    echo"<table width='80%' border='1' height='90%' align='center'>";
    ##barra lateral izquierdo
      echo"
          <tr height='80%'>
            <td style='border-style:solid;border-color:FFF' width='20%'>";

         
    echo"
            </td>
    ";

  }else{
    ##poderosa tabla que contendra las interfaces
      echo"<table width='65%' border='0'  align='center'>";
      include "interfaces/caja-ingreso.php";
      include "interfaces/presentacion.php";
  }

}else{
    echo "zona admin";
}


#########################################################################################
?>

      <td style='border-style:solid;border-color:FFF' align='center' width='80%' 
    <?if ( isset( $_SESSION['miembro'])){ echo "align='center'";}?> >

            <?php
            if ( isset( $_SESSION['miembro'] ) ) {
            echo "


              <script type='text/javascript'>
               
                $(document).ready(function() {
                  $('.fancybox-button').fancybox({
                    openEffect : 'elastic',
                    closeEffect: 'elastic',
                    openSpeed  : 600,
                    prevEffect : 'elastic',
                    nextEffect : 'elastic',
                    closeBtn   : false,
                    helpers    : {
                      title : { type : 'inside' },
                      buttons : {}
                    }
                  });
                });
                
                

                  $(document).ready(function() {
                    $('.fancylikeordislike').fancybox({
                      maxWidth  : 800,
                      maxHeight : 600,
                      openSpeed   : 500,
                      fitToView : false,
                      width   : '20%',
                      height    : '20%',
                      autoSize  : false,
                      closeClick  : false,
                      openEffect  : 'elastic',
                      closeEffect : 'elastic',
                      afterLoad   : function() {
                          this.inner.prepend( '' );
                          this.content = '' + this.content.html();
                      }
                    });
                  });


                  $(document).ready(function() {
                    $('.varios').fancybox({
                      maxWidth  : 800,
                      maxHeight : 600,
                      openSpeed   : 500,
                      fitToView : false,
                      width   : '40%',
                      height    : '90%',
                      autoSize  : false,
                      closeClick  : false,
                      openEffect  : 'elastic',
                      closeEffect : 'elastic'
                    });
                  });
                  
                function close_window() {
                  if (confirm('seguro que deseas salir?')) {
                      close();
                   }
                }   
              </script>
              ";

          }

                
                $contenido  = @ $_REQUEST['contenido'];
                #############################
                $publiid  = @ $_REQUEST['id'];
                $nombres  = @ $_REQUEST['nombreurl'];
                $titulo   = @ $_REQUEST['titulourl'];
                ###para ver perfil de miembro##########
                $perfil   = @ $_REQUEST['perfil'];
                $ver_un_perfil  = $perfil;
                $ver_miembro  = @ $_REQUEST['noto'];
                $guion    = "-";
                #######################################


                if ($perfil) {
                    #ver perfil_miembro
                  switch ($perfil){
                    case $ver_un_perfil:
                      if ($ver_un_perfil) {
                        ver_un_perfil ($ver_un_perfil, $ver_miembro);
                      }else{
                        echo "no se puede ver perfil";
                      }                  
                      break;
                      default :
                      if ($cantidada_de_miembros) {
                        include "./configuraciones/correo-idmiembro.php";
                        if ( $miembroid){
                          #include "./interfaces/indicaciones.php";
                          include "./aplicaciones/app-mostrar_publicaciones.php";
                          #include "./configuraciones/correo_admin.php";
                          #echo "$correo_admin";
                        }else{
                          include "./aplicaciones/registrate.php"; 
                        }
                      }else{
                        include "./configuraciones/admin/form_administrador.php";
                      }
                        break;
                  }
                }else{
                  switch ($contenido){
                    #ver publicacion
                    case @$nombres."-".@$titulo."-".@$publiid:
                      if (isset( $_SESSION['miembro'] )){
                        include "./aplicaciones/publicacion.php";
                      }
                    break;
                    #ver mi_perfil
                    include "./configuraciones/alterror_correo-idmiembro.php";             
                    case @$limpionombres."_noto_".@$alteradomiembroid :
                      if ( isset( $_SESSION['miembro'] ) ){
                       include "./aplicaciones/app-ver_perfil.php";
                      }
                    break;
                    #crear publicacion
                    case "dbzyzxpggjahvlolmu_plodscskrllxykcor_crear" :
                    if ( isset( $_SESSION['miembro'] ) ){
                       include "./aplicaciones/app-crear_publicacion.php";
                      }
                    break;
                    case "app-creando_publicacion" :
                      if ( isset( $_SESSION['miembro'] ) ){
                       include "./aplicaciones/app-receptor_creando_publicacion.php";
                      }
                    break;
                    case "app-cambiar_portada" :
                      if ( isset( $_SESSION['miembro'] ) ) 
                      {
                       include "./aplicaciones/app-portada_receptor.php";
                      }
                    break;
                    case "app-dbzyzxpggjs_skrllxykcor_imagen_perfil" :
                      if ( isset( $_SESSION['miembro'] ) ) 
                      {
                       include "./aplicaciones/app-avatar_receptor.php";
                      }
                    break;
                    case "reportar_publicacion" :
                      include "./configuraciones/correo-idmiembro.php";
                      if ( isset( $miembroid ) ) 
                      {
                       include "./aplicaciones/app-enviando_reporte.php";
                      }
                    break;
                    #editar cuenta
                    case "dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta" :
                    if ( isset( $_SESSION['miembro'] ) ){
                       include "./aplicaciones/app-editcuenta.php";
                      }
                    break;
                    case "dbzyzxpggjahvlolmu_y2jrawhhh_ir_a_bandeja" :
                      if ( isset( $_SESSION['miembro'] ) ) 
                      {
                       include "./aplicaciones/app-mostrar_bandeja.php";
                      }
                    break;
                    default :
                    if ($cantidada_de_miembros) {
                      if ( isset( $_SESSION['miembro'] ) ){
                        #include "./interfaces/indicaciones.php";
                        include "./aplicaciones/app-mostrar_publicaciones.php";
                        #include "./configuraciones/correo_admin.php";
                        #echo "$correo_admin";
                      }else{
                        include "./aplicaciones/registrate.php"; 
                      }
                    }else{
                      include "./configuraciones/admin/form_administrador.php";
                    }

                    break;
                  }
                }
            ?>
          </td>
          </tr>
      </table>
