<?
#Cambio avatar en perfil##############
function random(){

            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz1234567890";
            $cad = "";
            for($i=0;$i<10;$i++) {
                $cad .= substr($str,rand(0,120),1);
            }

    return $cad;
}

  if($_FILES["files"]["type"]){

 	$peso = @$_FILES["files"]["size"];

 	if ($peso <= 1586398 ) {

	 	$rutaservidor='./gabeta';

	 	date_default_timezone_set("America/El_Salvador");
	  	$titulo = "cambié la imagen de mi perfil";
	  	$texto = "";
	  	$tipo = @$_REQUEST ["tipo"];
	  	$idmiembro = @$_REQUEST ["idmiembro"];
	  	$fecha      = date("d/m/Y");
	  	$hora      = date("H:i:s");
		$tipo_imagen = @$_FILES["files"]["type"];
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
	  	#echo $titulo."<br>" ;
	  	#echo $texto ."<br>";
	  	#echo $tipo."<br>"; ;
	  	#echo $idmiembro."<br>" ;
	  	#echo $fecha."<br>";
	  	#echo $hora ."<br>" ;
	  	#echo $tipo_imagen ."<br>" ;

	    $tipo_imagen = @$_FILES["files"]["type"];
	    
	    switch ( $tipo_imagen ){

	        case "image/jpeg" :
	        /*Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error],
			que almacena un valor booleano (1 o 0).*/
			if (@$_FILES["files"]["error"] > 0) {
				echo @$_FILES["files"]["error"] . "";
			} else {
				# Si no hubo ningun error, usamos la funcion random para cambiar  nombre original de la imagen        
				$nombreimagen = $_FILES['files']['name'];
				$nombreimagen=random().".jpeg";
				$rutadestino=$rutaservidor."/".$nombreimagen;
				$rutabasededato = "./gabeta/$nombreimagen";

				if(move_uploaded_file($_FILES['files']['tmp_name'], $rutadestino)){
					
					$sql="INSERT INTO img (ruta)
				    values('$rutabasededato');";
				    $resultado = ejecutar($sql);
				    #echo "El archivo ha sido cargado correctamente<br>";

					list($width, $height) = getimagesize($rutadestino);
					#echo "Ancho: " .$width;
					#echo '<br />';
					#echo "Alto: " .$height;
					#echo '<br />';
					if (!($width > 450 && $width < 3000 ) && !($height > 350 && $height < 3500 ) ) {
						echo "El ancho y altura no es indicado para imagen de perfil<br>";
					}else{
					#para evaluar
						$vector_de_rutadestino = consultar ( "select * from img where ruta = '$rutabasededato';" );
						$verficar_existencia = count($vector_de_rutadestino);
						#echo "<br>".$verficar_existencia."<br>";

						if ( $verficar_existencia > 0 ) {
							for ( $contador = 0 ; $contador < $verficar_existencia; $contador ++ ) {
								( $contador + 1 );
								$idimg = $vector_de_rutadestino[$contador]['idimg'];
								#echo $idimg."<br>";
								$sql="
							    	INSERT INTO publicacion 
							    		(miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
									VALUES
										('$idmiembro', '$tipo', '$idimg', '$fecha', '$hora', '{$titulo}', '{$texto}' );
							    	";
								$resultado = ejecutar($sql);

								echo "<form name='form1' method='post' action='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'>";
								echo 	"<span class='glyphicon glyphicon-ok-circle'></span> Guardado exitosamente! <button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-user'></span>ir a mi perfil</button>";
								echo 	"<input type='hidden' name='perfil_foto' value='perfil_foto'>";
								echo 	"<input type='hidden' name='idimg' value='$idimg'>";
								echo "</form>";
							}
						}else{
						    	echo "Hubo un error al almacenar la publicacion, favor intentan mas tarde";
				    	}

					}
				}else{
					echo "Hubo un error al almacenar la publicacion :( , favor intentan mas tarde";
				}
			}

	        break;

	        case "image/png" :
	        /*Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error],
			que almacena un valor booleano (1 o 0).*/
			if (@$_FILES["files"]["error"] > 0) {
				echo @$_FILES["files"]["error"] . "";
			} else {
				# Si no hubo ningun error, usamos la funcion random para cambiar  nombre original de la imagen        
				$nombreimagen = $_FILES['files']['name'];
				$nombreimagen=random().".png";
				$rutadestino=$rutaservidor."/".$nombreimagen;
				$rutabasededato = "./gabeta/$nombreimagen";

				if(move_uploaded_file($_FILES['files']['tmp_name'], $rutadestino)){
					
					$sql="INSERT INTO img (ruta)
				    values('$rutabasededato');";
				    $resultado = ejecutar($sql);
				    #echo "El archivo ha sido cargado correctamente<br>";

					list($width, $height) = getimagesize($rutadestino);
					#echo "Ancho: " .$width;
					#echo '<br />';
					#echo "Alto: " .$height;
					#echo '<br />';
					if (!($width > 450 && $width < 3000 ) && !($height > 350 && $height < 3500 )) {
						echo "El ancho y altura no es indicado para imagen de perfil<br>";
					}else{
					#para evaluar
					$vector_de_rutadestino = consultar ( "select * from img where ruta = '$rutabasededato';" );
					$verficar_existencia = count($vector_de_rutadestino);

						if ( $verficar_existencia > 0 ) {
							for ( $contador = 0 ; $contador < $verficar_existencia; $contador ++ ) {
								( $contador + 1 );
								$idimg = $vector_de_rutadestino[$contador]['idimg'];
								#echo $idimg."<br>";
								$sql="
							    	INSERT INTO publicacion 
							    		(miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
									VALUES
										('$idmiembro', '$tipo', '$idimg', '$fecha', '$hora', '{$titulo}', '{$texto}' );
							    	";
								$resultado = ejecutar($sql);

								echo "<form name='form1' method='post' action='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'>";
								echo 	"<span class='glyphicon glyphicon-ok-circle'></span> Guardado exitosamente! <button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-user'></span>ir a mi perfil</button>";
								echo 	"<input type='hidden' name='perfil_foto' value='perfil_foto'>";
								echo 	"<input type='hidden' name='idimg' value='$idimg'>";
								echo "</form>";
							}
						}else{
						    	echo "Hubo un error al almacenar la publicacion, favor intentan mas tarde";
				    	}

					}
				}else{
					echo "Hubo un error al almacenar la publicacion :( , favor intentan mas tarde";
				}
			}

	        break;


	        case "image/gif" :
	        echo "Imagenes gif No permitido";
	        break;
			default :

				if ( ! isset( $_SESSION['ingreso'] ) ){
				    include "./aplicaciones/caja-ingreso.php";
				}else{
					echo "<div class='modal-content'>";
					echo	"<div class='modal-header'>";
					echo 		"<p class ='indicacion'><span class='glyphicon glyphicon-remove-circle'></span> Error, selecciona una imagen de formato jpeg ó png.</p>";
					echo 		"<a class='btn btn-primary btn-sm' href='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"' role='buttom'><span class='glyphicon glyphicon-repeat'> regresar</span></a></p>";
					echo 	"</div>";
					echo "</div>";
				}
	        break;
	    }
 	}else{

		echo "<div class='modal-content'>";
		echo	"<div class='modal-header'>";
 		echo 		"<p class ='indicacion'><span class='glyphicon glyphicon-remove-circle'></span> Imagen muy pesada, procura elegir una imagen que no exeda 1.5MB (1549kiB)<br>";
 		echo 		"<a class='btn btn-primary btn-sm' href='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"' role='buttom'><span class='glyphicon glyphicon-repeat'> regresar</span></a></p>";
		echo 	"</div>";
		echo "</div>";
 	}
  }else{
	echo "<div class='modal-content'>";
	echo	"<div class='modal-header'>";
	echo 		"<p class ='indicacion'><span class='glyphicon glyphicon-remove-circle'></span> Error, selecciona una imagen de formato jpeg ó png.</p>";
	echo 		"<a class='btn btn-primary btn-sm' href='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"' role='buttom'><span class='glyphicon glyphicon-repeat'> regresar</span></a></p>";
	echo 	"</div>";
	echo "</div>";
  }

 

?>
