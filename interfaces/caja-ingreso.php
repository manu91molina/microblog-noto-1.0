<?
echo"
          <tr >
            <td>
            <div style='position:absolute; top:32px; left:30px; z-index: 5; width:48%; height:20%; margin:auto;'>
              <img src='./recursos/logo_name.png' width='19%' height='35%' alt=''/>
            </div>
              <form action='./index.php' method='post'>
              <br>
              <br>
              <div style='position:absolute; top:34px; left:120px; z-index: 6; width:48%; height:20%; margin:auto;'>
                <table  width='90%' border='0'  align='center'>
                  <tr>
                    <td>
                    <input type='text' name='correo' placeholder='Correo' class='ingresar' size='20' />
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
              </div>
              </form>
          </td>
          </tr>
 ";
?>
