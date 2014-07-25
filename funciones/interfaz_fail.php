<?php


function validar_usuario() {
  include "./configuraciones/principal.php";
  $contenido = @ $_REQUEST['contenido'];

  if ( $contenido == "evaluaringreso" ) {
      $correo = @ $_REQUEST['correo'];
      $clave   = @ $_REQUEST['clave'];
      $clave = md5($clave);

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
        
        if ( $existe1 && $existe2) {

          $_SESSION["ingreso"]   = "$correo";
		 
		 $vector_de_publicaciones = consultar("select idmiembro, miembro_idmiembro from miembro, correo 
											where clave = '$clave' and correo = '$correo' and idmiembro = miembro_idmiembro;");
		 $cantidad_de_publicaciones = count( $vector_de_publicaciones );			
			
			if ( $cantidad_de_publicaciones > 0 ) {

				for ( $contador = 0 ; $contador < $cantidad_de_publicaciones ; $contador ++ ) {

						( $contador + 1 );
						$id = $vector_de_publicaciones[$contador]['idmiembro'];
          
						$_SESSION["miembro"] = $id;
						$resultado = TRUE;
					}
			}
		}else{
				header('indexwhoever.php');
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

#function validatepassword1( $password1){
  #NO tiene minimo de 4 caracteres o mas de 12 caracteres
  #if(strlen($password1) < 4 || strlen($password1) > 20)
    #return false;
  # SI longitud, NO VALIDO numeros y letras
  #else if(!preg_match("/^[0-9a-zA-Z]+$/", $password1))
    #return false;
  # SI rellenado, SI email valido
  #else
    #return true;
#}
 
#function validatepassword2($password1, $password2){
  //NO coinciden
 # if($password1 != $password2)
    #return false;
  #else
    #return true;
#}

#function validateemail($email){
 
#if ((strlen($email) >= 6) && (preg_match('/gmail.com/',$email)) || (preg_match ('/hotmail.com/',$email)) || (preg_match ('/yahoo.com/',$email)) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
#         if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
#           //miro si tiene caracter . 
#          if (substr_count($email,".")>= 1){ 
#               //obtengo la ter minacion del dominio 
#               $term_dom = substr(strrchr ($email, '.'),1); 
#               //compruebo que la terminación del dominio sea correcta 
#               if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
#                 //compruebo que lo de antes del dominio sea correcto 
#                 $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
#                 $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
#                 if ($caracter_ult != "@" && $caracter_ult != "."){ 
#                     $mail_correcto = 1; 
#                 } 
##               } 
#           } 
#         } 
#    } 
#    if (@ $mail_correcto) 
#         return true; 
#    else 
#         return false; 
#} 


function recortar($texto, $numero){ 
 if(strlen($texto) > $numero){ 
  $texto=substr($texto,0,$numero)."... ver"; 
 }else{ 
  $texto=$texto; 
 } 
 return $texto; 
}  


function cabeza () {
  include "./interfaces/cabeza.php";
}

function cuerpo_fail () {
  include "./interfaces/cuerpo_fail.php";
}

function pie () {
  include "./interfaces/pie.php";
}



include "./funciones/basededatos.php";
?>
