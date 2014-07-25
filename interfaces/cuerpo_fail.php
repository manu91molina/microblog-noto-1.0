<?
  include "interfaces/menu.php";
?>

<table width='85%'  border='1'  align='center'>
<?php
  if ( isset( $_SESSION['miembro'] ) )
  {
    ##barra lateral izquierdo
   echo"
          <tr height='80%'>
            <td style='border-style:solid;border-color:F6EFEF' width='20%'>";
   echo"
            </td>
    ";

  }else{
	  
	    include "interfaces/ingreso_fail.php";

  }  
?>

      <td style='border-style:solid;border-color:F6EFEF'  width='80%' align='center'>

            <?php
                if ( isset( $_SESSION['miembro'] ) ) {
						echo "
							  <script type='text/javascript'>
								
								$(document).ready(function() {
									$('.fancybox').fancybox();
								});
							 
                $(document).ready(function() {
                  $('.fancybox-button').fancybox({
                    prevEffect    : 'none',
                    nextEffect    : 'none',
                    closeBtn    : false,
                    helpers   : {
                      title : { type : 'inside' },
                      buttons : {}
                    }
                  });
                });
							 </script>
							";				
					}

                
                
                $contenido = @ $_REQUEST['contenido'];
                switch ( $contenido )
                {
                  case "indicaciones" :
                    include "./interfaces/indicaciones.php";
                  break;
                  case "dbzyzxpggjahvlolmu_plodscskrllx_subir_img" :
                  if ( isset( $_SESSION['miembro'] ) ) 
                    {
                     include "./aplicaciones/app-cargar-img.php";
                    }
                  break;
                  case "app-envio_img" :
                    if ( isset( $_SESSION['miembro'] ) ) 
                    {
                     include "./aplicaciones/app-recibir-img-newname.php";
                    }
                  break;
                  case "5" :
                    {
                      include "./interfaces/cuenta.php";
                    }
                  break;
                  default :
                    if ( ! isset( $_SESSION['miembro'] ) ) 
                    {
                     #echo "fail, asegurate de meter bien la clave o el correyo vich@";
                    }else{
                     include "./aplicaciones/app-mostrar_images.php" ;
                    }

                  break;
                }
            ?>
          </td>
          </tr>
      </table>
