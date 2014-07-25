<?
echo"
          <tr height='100%'>
            <td>
";
include "./configuraciones/correo-idmiembro.php";
              echo"<div style='position:absolute; top:40px; left:310px; z-index: 5; width:48%; height:20%; margin:auto;'>";
                          #echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo"<div class='error_ingreso_usuario'>";
                  echo"<div class='modal-header'>";
                          echo"<p class='msj_creando_usuario'>Por favor, asegurate de introducir correctamente tu clave. </p>
                                <p class='ayuda'>* asegúrate de que el bloqueo de mayúsculas no esté activado e inténtalo de nuevo.</p>";
                          echo"  <form action='./index.php' method='post'>
                            <br>
                            <br>
                              <table  width='64%' border='0'  align='center'>
                                <tr>
                                  <td>
                                  <input type='text' name='correo' value='$correo' placeholder='Correo' class='ingresar' size='20' />
                                  </td>
                                  <td>
                                  <input type='password' name='clave' placeholder='Clave' class='ingresar' size='20' />
                                  </td>  
                                  <td>
                                    <button class='btn btn-primary btn-sm' title='Iniciar Sesión' name='accion' >Iniciar &nbsp<span class='glyphicon glyphicon-log-in'></span></button>
                                   
                                  </td>
                                </tr>
                                  <input type='hidden' name='contenido' value='evaluaringreso'>
                              </table>
                            </form>
                           ";
				  echo"</div>";
			    echo"</div>";
              echo"</div>";
          echo"</td>";
        echo"</tr>";
?>
