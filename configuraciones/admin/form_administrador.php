<?
###########################################################################################
/*se declaran estas variables para la verificacion de los valores de los campos a         #
ingresar sean los correctos                                                               #
*/                                                                                        #
$name = "";                                                                               #
$apellid = "";                                                                            #
$password1 = "";                                                                          #
$password2 = "";                                                                          #
$mensaje = "Las claves no coinciden";                                                     #
$mensaje_1 = "Mínimo 8 caracteres";                                #
$mensaje_2 = "Ingresa tu correo correctamente";                                           #
$mensaje_3 = "Ingresa tus nombres";                                                       #
$mensaje_4 = "Ingresa tus apellidos";                                                     #
$email1 = "";                                                                             #
$emailValue = "";                                                                         #
                                                                                          #
                                                                                         #
function validatepassword1( $password1){                                                  #
  //NO tiene minimo de 5 caracteres o mas de 12 caracteres                                #
  if(strlen($password1) < 8 || strlen($password1) > 100)                                   #
    return false;                                                                         #
  // SI longitud, NO VALIDO numeros y letras                                              #
  else if(!preg_match("/^[0-9a-zA-Z $#.]+$/", $password1))                                 #
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
}                                                                                         #
                                                                                          #
function validateemail($email){                                                           #
                                                                                          #
  if ((strlen($email) >= 6) && (preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#',$email) ) ){ 
    if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
    //miro si tiene caracter .                                                            #
      if (substr_count($email,".")>= 1){                                                  #
        //obtengo la ter minacion del dominio                                             #
        $term_dom = substr(strrchr ($email, '.'),1);                                      #
        //compruebo que la terminación del dominio sea correcta                           #
        if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){     #
          //compruebo que lo de antes del dominio sea correcto                            #
          $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);           #
          $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);                      # 
          if ($caracter_ult != "@" && $caracter_ult != "."){                              #
            $mail_correcto = 1;                                                           #
          }                                                                               #
        }                                                                                 #
      }                                                                                   #
    }                                                                                     # 
  }                                                                                       #
  if (@ $mail_correcto) {                                                                 #
    return true;                                                                          # 
  }else {                                                                                 #
    return false;                                                                         #
   }                                                                                      #
}                                                                                         # 
                                                                                          #
##########################################################################################

# si existe solicitud send es porque el usuario esta intentando
# crear su cuenta, OJO  el sierre de este if se comentara mas adelante porque
# el proceso es extenso.
if( isset($_POST['send'])) {

  if(! $_REQUEST['name'])
    $name = "error";

  if(!$_POST['apellid'])
    $apellid = "error";

  if(!validatepassword1($_POST['password1']))
    $password1 = "error";


  if(!validatepassword2($_POST['password1'], $_POST['password2']))
    $password2 = "error";

  if(!validateemail($_POST['email']))
    $email1 = "error";

  #la captura de
  date_default_timezone_set("America/El_Salvador");
  $nombres		= $_REQUEST['name'];
  $nombres      = permitir_comilla_simple_nombres ($nombres);
  $apellidos	= $_REQUEST['apellid'];
  $apellidos	= permitir_comilla_simple_apellidos ($apellidos);
  $idmiembro	= @ $_REQUEST['miembro_idmiembro'];
  $correo		= $_POST['email'];
  $clave		= $_POST['password1'];
  $fecha      	= date("d-m-Y");
  $hora 		= date ("H:i:s");


  if(  $password1 != "error" && $password2 != "error" && $email1 != "error"){

    $consulta = "
      select correo
      from correo
      where correo = '$correo'
      ;
    ";
    #para evaluar si ya tenemos registrado el correo a ingresar
    $resultado = consultar ( $consulta );
    $verficar_existencia = count($resultado);

    $verficar_existencia;
    if ( $verficar_existencia > 0 ) {
      echo "<b>ATENCION!! </b> El correo <b> $correo </b> ya existe";
      echo "</br>";
      echo "<a href=\"javascript:history.back()\">Regresar</a>";
    }else{
    #se inserta en la tabla datos y luego a la tabla correo los campos respectivos
      $md5clave = md5($clave);
      $sql="
        insert into
          miembro (
          clave,
          fecha_registro,
          hora
        )
        values (
          '{$md5clave}',
          '$fecha',
          '$hora'
        );
        INSERT into correo (miembro_idmiembro, correo) 
        SELECT idmiembro, '$correo' 
        FROM miembro WHERE clave = '$md5clave' AND fecha_registro = '$fecha' AND hora = '$hora';
      ";
      $resultado1 = ejecutar( $sql );
      $vector_de_publicaciones = consultar("SELECT idmiembro FROM miembro WHERE clave = '$md5clave' AND fecha_registro = '$fecha' AND hora = '$hora';");
      $cantidad_de_publicaciones = count( $vector_de_publicaciones );
      if ( $cantidad_de_publicaciones > 0 ) {
        for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {
            ( $contador + 1 );
            $idmiem = $vector_de_publicaciones[$contador]['idmiembro'];
        }
        $sql="
          INSERT INTO perfil (carrera_idcarrera, carrera_facultad_idfacultad, miembro_idmiembro,
            nombre, apellido, natalicio, domicilio, frase)
          VALUES ('1', '1', '$idmiem', '$nombres', '$apellidos', '1991-01-01',  ' ', ' ');
          INSERT INTO estado (miembro_idmiembro, tipo_estado_idtipo_estado , fecha_estado)
          VALUES  ('$idmiem', '3', '$fecha');
          INSERT INTO publicacion 
            (miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
          VALUES
            ('$idmiem', '7', '2', '$fecha', '$hora', ' ', ' ');
          INSERT INTO publicacion 
            (miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
          VALUES
            ('$idmiem', '9', '3', '$fecha', '$hora', ' ', ' ');
        ";
        $resultado1 = ejecutar( $sql );
        include "./configuraciones/correo_admin.php";
        include "./configuraciones/principal.php";
        mail ( $CORREO_ADMIN, "Bienvenido eres administrador de $NOMBRE_BMU ", "Resiviras a este correo notificaciones
          de nuevos usuarios registrados") ;
      }
      echo "<div style='position:absolute; top:140px; left:330px; z-index: 4; width:48%; height:20%; margin:auto;'>";
        echo "<table  width='52%' height='12%' border='0'  align='center'>";
          echo "<tr align = 'center'>";
          echo   "<td>";
          echo     "<small class='msj_creando_usuario'>Tu cuenta de administrador ha sido creada!</small></br>";
          echo   "</td>";
          echo "</tr>";
          echo "<tr align = 'center'>";
          echo  "<td>";
          echo    "<form action='./index.php' method='post'>";
          echo      "<input type='hidden' name='correo' value='$correo'>";
          echo      "<input type='hidden' name='clave' value='$clave'>";
          echo      "<input type='hidden' name='contenido' value='evaluaringreso'>";
          echo      "<button class='btn btn-primary btn-sm' title='Iniciar Sesión' name='accion'>Continuar &nbsp<span class='glyphicon glyphicon-log-in'></span></button>";
          echo    "</form>";
          echo "</td>";
          echo "</tr>";
        echo "</table>";
      echo "</div>";
    }


  }else{
    
    echo "<div style='position:absolute; top:140px; left:330px; z-index: 4; width:48%; height:20%; margin:auto;'>";
    echo "
         <center><h3>Crear Administrador</h3></center>
         <form role='form' id='form1' action='./' method='post'>
         <table border='0' align='center' width='30%' bordercolor=''>

             <tr align='center'>
               <td>
                 <label for='name'> "; if ($name == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_3; endif; echo "</span>
                 </label>
               </td>
               <td>
                 <label for='apellid'> "; if ($apellid == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_4; endif; echo "</span>
                 </label>
               </td>
             </tr>
             <tr align='center'>
               <td>
                 <input tabindex='1' name='name' id='name' type='text' placeholder='NOMBRE' class='regis $name' value='' />
               </td>
               <td>
                 <input tabindex='2' name='apellid' id='apellid' type='text' placeholder='APELLIDO' class='regis $apellid' value='' />
               </td>
             </tr>

             <tr align='center'>
               <td colspan='2' >
                 <label for='email'> "; if ($email1 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_2; endif; echo "</span>
                 </label>
                 <input tabindex='3' name='email' id='email' type='email' placeholder='CORREO' class='regis $email1' value='' />
               </td>
             </tr>
             <tr align='center'>
               <td colspan='2'>
                 <label for='password1'> "; if ($password1 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_1; endif; echo "</span>
                 </label>
                 <input tabindex='4' name='password1' id='password1' type='password' placeholder='CLAVE' class='regis $password1' value='' />
               </td>
             </tr>
             <tr align='center'>
               <td colspan='2'>
                 
                 <label for='password2'> "; if ($password2 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje; endif; echo"</span>
                 </label>
                 <input tabindex='5' name='password2' id='password2' type='password' placeholder='CONFIRMA CLAVE' class='regis $password2' value='' />
                 </br>
                 <button class='cuenta c-default' >LISTO</button><input tabindex='6' name='send' id='send' type='hidden'>
                 </form>
               </td>
             </tr>
         </table>
         ";
    echo "</div>";
  }

#aqui termina el if que evalua si existe la captura send para crear cuenta.
}else{

    #construir_base_de_datos ();

    echo "<div style='position:absolute; top:140px; left:330px; z-index:4;width:48%; height:20%; margin:auto;'>";
    echo "
         <center><h3>Crear Administrador</h3></center>
         <form role='form' id='form1' action='./' method='post'>
         <table border='0' align='center' width='37%' bordercolor=''>

             <tr align='center'>
               <td>
                 <label for='name'> "; if ($name == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_3; endif; echo "</span>
                 </label>
               </td>
               <td>
                 <label for='apellid'> "; if ($apellid == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_4; endif; echo "</span>
                 </label>
               </td>
             </tr>
             <tr align='center'>
               <td>
                 <input tabindex='1' name='name' id='name' type='text' placeholder='NOMBRE' class='regis $name' value='' />
               </td>
               <td>
                 <input tabindex='2' name='apellid' id='apellid' type='text' placeholder='APELLIDO' class='regis $apellid' value='' />
               </td>
             </tr>

             <tr align='center'>
               <td colspan='2' >
                 <label for='email'> "; if ($email1 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_2; endif; echo "</span>
                 </label>
                 <input tabindex='3' name='email' id='email' type='email' placeholder='CORREO' class='regis $email1' value='' />
               </td>
             </tr>
             <tr align='center'>
               <td colspan='2'>
                 <label for='password1'> "; if ($password1 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje_1; endif; echo "</span>
                 </label>
                 <input tabindex='4' name='password1' id='password1' type='password' placeholder='CLAVE' class='regis $password1' value='' />
               </td>
             </tr>
             <tr align='center'>
               <td colspan='2'>
                 
                 <label for='password2'> "; if ($password2 == "error"): echo "<span style=color:#6282C1 class='ayuda'>"; echo $mensaje; endif; echo"</span>
                 </label>
                 <input tabindex='5' name='password2' id='password2' type='password' placeholder='CONFIRMA CLAVE' class='regis $password2' value='' />
                 </br>
                 <button class='cuenta c-default' >LISTO</button><input tabindex='6' name='send' id='send' type='hidden'>
                 </form>
               </td>
             </tr>
         </table>
         ";
    echo "</div>";

}
?>
