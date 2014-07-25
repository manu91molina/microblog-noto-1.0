<?
###########################################################################################
/*se declaran estas variables para la verificacion  de los valores de los campos a        	#
ingresar.                                                                                 	#
*/                                                                                        	#
$clave_actual		= @$_REQUEST['clave'];                                                #
$cambiar_clave  = @$_REQUEST['cambiar_clave'];                                              #
$validar        = @$_REQUEST['validar'];                                                    #
$password1      = "";                                                                          #
$password2      = "";                                                                          #
$mensaje        = "Las claves no coinciden";                                                   #
$mensaje_1      = "Debe ser mínimo 8 caracteres";                                              #
                                                                                            #
function validatepassword1( $password1){                                                  #
  //NO tiene minimo de 8 caracteres                                                       #
  if(strlen($password1) < 8)                                                              #
    return false;                                                                         #
  // SI longitud, NO VALIDO numeros y letras                                              #
  else if(!preg_match("/^[0-9a-zA-Z $#]+$/", $password1))                                 #
    return false;                                                                         #
  // SI rellenado, SI pass valido                                                         #
  else                                                                                    #
    return true;                                                                          #
}                                                                                         #
                                                                                          #
function validatepassword2($password1, $password2){                                       #
  //NO coinciden                                                                          #
  if($password1 != $password2)                                                            #
    return false;                                                                         #
  else                                                                                    #
    return true;                                                                          #
}
##########################################################################################

#aditar clave
#archivo para obtener id de usuario
include"./configuraciones/correo-idmiembro.php";

if ($cambiar_clave) {
  if(!validatepassword1($_POST['password1']))
    $password1 = "error";
  if(!validatepassword2($_POST['password1'], $_POST['password2']))
    $password2 = "error";

  if(  $password1 != "error" && $password2 != "error"){
    #aditando clave
    $nuevaclave = @$_REQUEST['password1'];
    $md5clave = md5($nuevaclave);
    $sql = "UPDATE miembro SET clave = '$md5clave' WHERE idmiembro ='$miembroid';";
    $resultado = ejecutar($sql);
    include "./configuraciones/principal.php";
    include "./configuraciones/correo_admin.php";
    mail ( $correo, "$NOMBRE_BMU: Has editado tu cuenta ", "Te informamos que tu clave se ha editado. Si tu no has sido tu el que a editado tu clave, contáctanos al correo de administracion de $NOMBRE_BMU $CORREO_ADMIN");
    echo"<div class='modal-content'>";
      echo"<div class='modal-header'>";
        echo "<p class='indicacion'><span class='glyphicon glyphicon-ok-circle'></span> tu nueva clave se guardo exitosamente!.
            Te hemos enviado un correo informando que has cambiado tu clave <a title='inicio' href='./'>ir a inicio</a></p>";
      echo "</div>";
    echo "</div>";
  }else{
        #fromulario para ingresar nueva clave
        #tabla principal
        echo "<table border='0' align='center' width='60%'>";
          echo "<tr>";
            echo "<td align =''>";
              #tabla1
              echo "<table border='0' align='left' width='30%'>";
                echo "<tr>";
                  echo "<td align ='left'>";
                  echo  "<b><span class='glyphicon glyphicon-wrench'></span> Editar Clave</b>";
                  echo"</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td align ='left'>";
                      echo  "<span class='indicacion'> nueva clave:</span>";
                      echo "</td>";
                    echo "</tr>";
              echo "</table>";
              #cierre tabla1
                  echo "<br/>";
                  echo "<br/>";
                  echo "<br/>";
                  echo "<form role='form' id='form1' action='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta' method='post'>";
              #tabla2
              echo "<table border='0' align='center' width='60%'>";
                echo "<tr>";
                  echo "<td align =''>";
                    echo "<label for='password1'> "; if ($password1 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_1; endif; echo"</span></label>";
                    echo " <input tabindex='4' name='password1' id='password1' type='password' placeholder='Nueva clave' class='regis $password1' value='' />";
                  echo"</td>";
                echo "</tr>";
                echo "<tr>";
                  echo "<td>";
                    echo "<label for='password2'> "; if ($password2 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje; endif; echo"</span></label>";
                    echo " <input tabindex='4' name='password2' id='password2' type='password' placeholder='Confirmar nueva clave' class='regis $password2' value='' />";
                  echo"</td>";
                  echo "<td>";
                    echo "<button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok-sign'></span> ok</button>";
                  echo "</td>";
              echo "</table>";
              #cierre tabla2
              echo "<input type='hidden' name='cambiar_clave' value='cambiar_clave'>";
              echo "</form>";
            echo "</td>";
          echo "</tr>";
       echo "</table>";
       #cierre tabla princial
  }

}else{
    #primer paso para editar clave: comprobar la clave actual
    if($clave_actual){
      $clave_actual  = md5($clave_actual);
      #para comprobar que es la lave actual de este usuario
            $consulta = "
            select * from miembro where clave = '$clave_actual' and idmiembro = '$miembroid';
          ";
          $resultado = consultar ( $consulta );
          $verficar_existencia = count($resultado);
          if ( $verficar_existencia > 0 ) {
            #formulario para ingresar nueva clave
            #tabla principal
            echo "<table border='0' align='center' width='60%'>";
              echo "<tr>";
                echo "<td align =''>";
                  #tabla1
                  echo "<table border='0' align='left' width='30%'>";
                    echo "<tr>";
                      echo "<td align ='left'>";
                      echo  "<b><span class='glyphicon glyphicon-wrench'></span> Editar Cuenta</b>";
                      echo"</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td align ='left'>";
                      echo  "<span class='indicacion'> nueva clave:</span>";
                      echo "</td>";
                    echo "</tr>";
                  echo "</table>";
                  #cierre tabla1
                      echo "<br/>";
                      echo "<br/>";
                      echo "<br/>";
                      echo "<form role='form' id='form1' action='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta' method='post'>";
                  #tabla2
                  echo "<table border='0' align='center' width='60%'>";
                    echo "<tr>";
                      echo "<td align =''>";
                        echo " <input tabindex='1' name='password1' id='password1' type='password' placeholder='Nueva clave' class='regis' />";
                      echo"</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td>";
                        echo " <input tabindex='2' name='password2' id='password2' type='password' placeholder='Confirmar nueva clave' class='regis' />";
                      echo"</td>";
                      echo "<td>";
                    echo "<button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok-sign'></span> ok</button>";
                      echo "</td>";
                  echo "</table>";
                  #cierre tabla2
                  echo "<input type='hidden' name='cambiar_clave' value='cambiar_clave'>";
                  echo "</form>";
                echo "</td>";
              echo "</tr>";
           echo "</table>";
           #cierre tabla princial
          }else{
            echo"<div style='position:fixed; top:78px; left:150px; z-index: 5; width:28%; height:20%; margin:auto;'>";
             echo "<div class='alert alert-danger fade in'>";
              echo "<span class='ayuda'>digita correctamente tu clave actual.</span>";
             echo "</div>";
            echo"</div>";
            #formulario para ingresar clave actual
            echo "<table border='0' align='center' width='60%'>";
              echo "<tr>";
                echo "<td align =''>";
                  echo "<table border='0' align='left' width='30%'>";
                    echo "<tr>";
                      echo "<td align ='left'>";
                      echo  "<b><span class='glyphicon glyphicon-wrench'></span> Editar Cuenta</b>";
                      echo"</td>";
                    echo "</tr>";
                    echo "<tr>";
                      echo "<td align ='left'>";
                      echo  "<span class='indicacion'> clave actual:</span>";
                      echo "</td>";
                    echo "</tr>";
                  echo "</table>";
                      echo "<br/>";
                      echo "<br/>";
                      echo "<br/>";
                      echo "<form role='form' id='form1' action='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta' method='post'>";
                  echo "<table border='0' width='60%'>";
                    echo "<tr>";
                      echo "<td >";
                        echo"<input type='password' name='clave' class='uplo-img' placeholder='Ingresa clave actual' />";
                      echo"</td>";
                      echo "<td>";
                        echo "<button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok-sign'></span> ok</button>";
                      echo "</td>";
                    echo "</tr>";
                  echo "</table>";
                  echo "</form>";
                echo "</td>";
              echo "</tr>";
            echo "</table>";
        }
      }

    if (!$clave_actual) {
    #formulario para ingresar clave actual
      echo "<table border='0' align='center' width='60%'>";
        echo "<tr>";
          echo "<td align =''>";
            echo "<table border='0' align='left' width='30%'>";
              echo "<tr>";
                echo "<td align ='left'>";
                echo  "<b><span class='glyphicon glyphicon-wrench'></span> Editar Cuenta</b>";
                echo"</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td align ='left'>";
                echo  "<span class='indicacion'> clave actual:</span>";
                echo "</td>";
              echo "</tr>";
            echo "</table>";
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";
                echo "<form role='form' id='form1' action='./index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcocenationjustbringit_edit_cuenta' method='post'>";
            echo "<table border='0' width='60%'>";
              echo "<tr>";
                echo "<td >";
                  echo"<input type='password' name='clave' class='uplo-img' placeholder='Ingresa clave actual' />";
                echo"</td>";
                echo "<td>";
                  echo "<button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-ok-sign'></span> ok</button>";
                echo "</td>";
              echo "</tr>";
            echo "</table>";
            echo "</form>";
          echo "</td>";
        echo "</tr>";
      echo "</table>";
    }

}






?>