<?

 function random(){

            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz234567890";
            $cad = "";
            for($i=0;$i<10;$i++) {
                $cad .= substr($str,rand(0,120),1);
            }

    return $cad;
  }


 $con_img= @$_REQUEST["con_img"];

 if(@$_FILES["files"]["type"] && $con_img){

 	$peso = @$_FILES["files"]["size"];

 	if ($peso <= 1586398 ) {

	 	$rutaservidor='./img';
	 	date_default_timezone_set("America/El_Salvador");
	 	$titulo 	= @$_REQUEST ["titulo"];
	 	$titulo 	= permitir_comilla_simple_titulo ($titulo);
	  	$texto 		= @$_REQUEST ["descripcion"];
	  	$texto 		= permitir_comilla_simple_texto ($texto);
	  	$tipo 			= @$_REQUEST ["tipo"];
	  	$idmiembro 		= @$_REQUEST ["idmiembro"];
	  	$fecha      	= date("d/m/Y");
	  	$hora      		= date("H:i:s");
		$tipo_imagen	= @$_FILES["files"]["type"];
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
			$rutabasededato = "./img/$nombreimagen";



				if(move_uploaded_file($_FILES['files']['tmp_name'], $rutadestino)){
					
					$sql="INSERT INTO img (ruta)
				    values('$rutabasededato');";

				    $resultado = ejecutar($sql);

				    #echo "El archivo ha sido cargado correctamente<br>";
				    list($width, $height) = getimagesize($rutadestino);
				    #echo "peso: " .$peso."<br>";
					#echo "Ancho: " .$width;
					#echo '<br />';
					#echo "Alto: " .$height;
					#echo '<br />';
					#echo "<br /><br />$ulr";


					############para obtener el id de img almacenada e ingresarlo a publicacion
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
								('$idmiembro', '$tipo', '$idimg', '$fecha', '$hora', '{$titulo}', '{$texto}');
						    ";
							$resultado = ejecutar($sql);
							echo "publicación realizada con éxito <a href='./index.php'>ir a inicio <span class='glyphicon glyphicon-home'></a>";
						}
					}else{
					    	echo "Hubo un error al almacenar la publicacion, favor intentan mas tarde";
			    	}
			    	#############################################################################################




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
			$rutabasededato = "./img/$nombreimagen";



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

				    
					
					#para obtener idimg e ingresarlo a publicacion
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
							echo "publicación realizada con éxito <a href='./index.php'>ir a inicio <span class='glyphicon glyphicon-home'></a>";
						}
					}else{
					    	echo "Hubo un error al almacenar la publicacion, favor intentan mas tarde";
			    	}

				}else{
					echo "Hubo un error al almacenar la publicacion :( , favor intentan mas tarde";
				}
			}
	        break;


	        case "image/gif" :
	        /*Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error],
			que almacena un valor booleano (1 o 0).*/
			if (@$_FILES["files"]["error"] > 0) {
				echo @$_FILES["files"]["error"] . "";
			} else {
			# Si no hubo ningun error, usamos la funcion random para cambiar  nombre original de la imagen        
			$nombreimagen = $_FILES['files']['name'];
			$nombreimagen=random().".gif";
			$rutadestino=$rutaservidor."/".$nombreimagen;
			$rutabasededato = "./img/$nombreimagen";



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

					#para obtener idimg e ingresarlo a publicacion
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
							echo "publicación realizada con éxito <a href='./index.php'>ir a inicio <span class='glyphicon glyphicon-home'></a>";
						}
					}else{
					    	echo "Hubo un error al almacenar la publicacion, favor intentan mas tarde";
			    	}

				}else{
					echo "Hubo un error al almacenar la publicacion :( , favor intentan mas tarde";
				}
			}
	        break;
			default :

				if ( ! isset( $_SESSION['ingreso'] ) ){
				    include "./aplicaciones/caja-ingreso.php";
				}else{
				    include "./aplicaciones/app-mostrar_publicaciones.php" ;
				}
	        break;
	    }
 	}else{

 		echo "<p class ='indicaciones'>Lo sentimos, imagen muy pesada, procura elegir una imagen que no exeda 1.5MB (1549kiB)<br>";
 		echo "<a class='btn btn-primary btn-sm' href='/index.php?contenido=dbzyzxpggjahvlolmu_plodscskrllxykcor_crear' role='buttom'><span class='glyphicon glyphicon-repeat'>regresar</span></a></p>";
 	}


 }else{

 	date_default_timezone_set("America/El_Salvador");
 	$titulo 	= @$_REQUEST ["titulo"];
 	$titulo 	= permitir_comilla_simple_titulo ($titulo);
  	$texto 		= @$_REQUEST ["descripcion"];
  	$texto 		= permitir_comilla_simple_texto ($texto);
  	$tipo 		= @$_REQUEST ["tipo"];
  	$idmiembro 	= @$_REQUEST ["idmiembro"];
  	$fecha 		= date("d/m/Y");
  	$hora      	= date("H:i:s");

  	if (!$titulo && !$texto) {
  		echo "Tu publicación esta bacía, puedes mejorar eso!!";
  	}else{
  		#echo "<br>"."<br>"."<br>".$titulo."<br>" ;
	  	#echo $texto ."<br>";
	  	#echo $tipo."<br>"; ;
	  	#echo $idmiembro."<br>" ;
	  	#echo $fecha."<br>";
	  	#echo $hora ."<br>" ;
	  	#echo "echo!!";
		$sql="
		INSERT INTO publicacion 
			(miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg, fecha, hora, titulo, texto_publicacion)
		VALUES
			('$idmiembro', '$tipo', '1', '$fecha', '$hora', '{$titulo}' , '{$texto}');
		";
		$resultado = ejecutar($sql);
		echo "publicación realizada con éxito <a href='./index.php'>ir a inicio <span class='glyphicon glyphicon-home'></a>";
  	}
 }


?>
