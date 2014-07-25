<?

include"./configuraciones/correo-idmiembro.php";
      $vector_de_datos = consultar("select * from perfil_fase1 where n_miembro = $miembroid;");
      $cantidad_datos = count( $vector_de_datos );
      if ( $cantidad_datos > 0 ) {

        for ( $contador = 0 ; $contador < $cantidad_datos ; $contador ++ ) {
            ( $contador + 1 );

	        $nombres 		= $vector_de_datos[$contador]['nombres'];
    		$nombres 		= mostrar_comilla_simple_nombres ($nombres);
    		$nombres_actual = utf8_decode($nombres);        
	        $apellidos 		= $vector_de_datos[$contador]['apellidos'];
    		$apellidos  	= mostrar_comilla_simple_apellidos ($apellidos);
    		$apellidos 		= utf8_decode($apellidos);		
			$carreraid 		= $vector_de_datos[$contador]['carreraid'];
			$carrera 		= $vector_de_datos[$contador]['cursando carrera de'];
	      	echo"<form name='form2' method='post' action='./index.php?contenido=app-cambiar_portada' enctype='multipart/form-data'>";
	        echo"</br>";
	        echo "<b><span class='glyphicon glyphicon-picture'></span> Cambiar imagene de portada</b>
				  <div class='form-group'>
				     <p class='help-block'>recomendable: altura mayor a 650 píxeles y ancho mayor a 1000 píxeles.</p>
				     <input type='file' name= 'files' />
				  </div>
				 
                 <button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-picture'></span>  Guardar imagen de portada</button>   
			";
            echo "<input type='hidden' name='idmiembro' value='$miembroid'>";
            echo "<input type='hidden' name='tipo' value='5'>";
            echo "</form>";
	        echo"<hr>";

	      	echo"<form name='form2' method='post' action='./index.php?contenido=app-dbzyzxpggjs_skrllxykcor_imagen_perfil' enctype='multipart/form-data'>";
	        echo "<b><span class='glyphicon glyphicon-user'></span> Cambiar imagen de perfil</b>
				  <div class='form-group'>
				     <p class='help-block'></p>
				     <input type='file' name= 'files' />
				  </div>
				 
                 <button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-user'></span> Guardar imagen de perfil</button>   
			";
            echo "<input type='hidden' name='idmiembro' value='$miembroid'>";
            echo "<input type='hidden' name='perfil_foto' value='perfil_foto'>";
            echo "<input type='hidden' name='tipo' value='10'>";
            echo "</form>";
	        echo"<hr>";

	        include "./configuraciones/alterror_correo-idmiembro.php";
	      	echo"<form name='form4' method='post' action='./index.php?contenido=";echo $limpionombres."_noto_".$alteradomiembroid;echo"'>";
	      	echo "<b><span class='glyphicon glyphicon-list-alt'></span> Editar datos de Perfil</b>";
			echo "<table border='0' width='100%'>";
				echo "<tr>";
			 		echo "<td align='left'>";
			 			echo"Nombres:";
			 		echo"</td>";
			 		echo "<td width='35%'>";
			 			echo"<input type='text' name='nombres' value='$nombres_actual' class='uplo-img' placeholder=''>";
			 		echo"</td>";
			 		echo "<td align='left' width='5%'>";
			 			echo"Apellidos:";
			 		echo"</td>";
			 		echo "<td>";
			 			echo"<input type='text' name='apellidos' width='15%' value='$apellidos' class='uplo-img' placeholder=''>";
			 		echo"</td>";
			 	echo"</tr>";
				echo "<tr>";
			 		echo "<td align='left'>";
			 			echo"Carrera:";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			echo"<select name='carrera' class='select-multiple'>";
							 echo" <option value ='$carreraid'>$carrera</option>";
							 include "./aplicaciones/lista-carreras.php";
			 			echo"</select>";
			 		echo"</td>";
				echo "<tr>";
				echo "<tr>";
			 		echo "<td align='left'>";
			 			echo"Estado:";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			include"./aplicaciones/app-ver_estado.php";
			 		echo"</td>";

		 }
	  }

      $vector_mas_datos = consultar("select * from vista_perfil where miembro = $miembroid;");
      $cantidad_mas_datos = count( $vector_mas_datos );
      if ( $cantidad_mas_datos > 0 ) {

        for ( $contador = 0 ; $contador < $cantidad_mas_datos ; $contador ++ ) {
            ( $contador + 1 );

            $fecha_estado 		= $vector_mas_datos[$contador]['fecha'];
            $fecha_nacimiento	= $vector_mas_datos[$contador]['nació el'];
            $residencia			= $vector_mas_datos[$contador]['vive en'];
            $frase				= $vector_mas_datos[$contador]['frases'];
            $frase              = mostrar_comilla_simple_frase ($frase);
            $frase_decode 		= utf8_decode($frase);

					echo "<link href='./recursos/calendario/calendario.css' type='text/css' rel='stylesheet'>";
					echo "<script src='./recursos/calendario/calendar.js' type='text/javascript'></script>";
					echo "<script src='./recursos/calendario/calendar-es.js' type='text/javascript'></script>";
					echo "<script src='./recursos/calendario/calendar-setup.js' type='text/javascript'></script>";

			 		echo "<td align='15%'>";
			 			echo "desde el: ";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			echo "<input type='text' name='fecha_estado' class='uplo-img' id='ingresar' value='".date("d/m/y", strtotime("$fecha"))."' readonly='readonly' /> ";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			echo "<span class='yiconlike yvistalike-default' id='estado' title='buscar fecha' ><span class='glyphicon glyphicon-calendar'></span></span> ";
			 		echo"</td>";
			 	echo"</tr>";
			 	echo "<tr >";
			 		echo "<td align='left'>";
			 			echo"Nacimiento:";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			echo "<input type='text' name='fecha_nacimiento' class='uplo-img' id='ingresar_natalicio' value='".date("d/m/y", strtotime("$fecha_nacimiento"))."' readonly='readonly'/> ";
			 		echo"</td>";
			 		echo "<td align=''>";
			 			echo "<span class='yiconlike yvistalike-default' id='natalicio' title='buscar fecha' ><span class='glyphicon glyphicon-calendar'></span></span> ";
			 		echo"</td>";
			 	echo"</tr>";
			 	echo "<tr>";
			 		echo "<td align='left'>";
			 			echo"Resido en:";
			 		echo"</td>";
			 		echo "<td width='35%'>";
			 			echo"<input type='text' name='residencia' value='$residencia' class='uplo-img' placeholder=''>";
			 		echo"</td>";
			 	echo "</tr>";
			 	echo "<tr>";
			 		echo "<td align='left' height='50%'>";
			 			echo"Citar una frase:";
			 		echo"</td>";
			 		echo "<td>";
			 			echo "<textarea id='texto' onkeypress='return limita(event, 164);' onkeyup='actualizaInfo(164)' class='form-frase' name='frase' rows='9'>$frase</textarea>";
			 		echo "</td>";
			 	echo "</tr>";
			echo "</table>";
			echo "<button class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-list-alt'></span> Guardar datos</button>";
            echo "<input type='hidden' name='editar_perfil' value='true'>";
            echo "</form>";
          	echo "  
				<script type='text/javascript'>
				function limita(elEvento, maximoCaracteres) {
				  var elemento = document.getElementById('texto');

				  // Obtener la tecla pulsada 
				  var evento = elEvento || window.event;
				  var codigoCaracter = evento.charCode || evento.keyCode;
				  // Permitir utilizar las teclas con flecha horizontal
				  if(codigoCaracter == 37 || codigoCaracter == 39) {
				    return true;
				  }

				  // Permitir borrar con la tecla Backspace y con la tecla Supr.
				  if(codigoCaracter == 8 || codigoCaracter == 46) {
				    return true;
				  }
				  else if(elemento.value.length >= maximoCaracteres ) {
				    return false;
				  }
				  else {
				    return true;
				  }
				}

				function actualizaInfo(maximoCaracteres) {
				  var elemento = document.getElementById('texto');
				  var info = document.getElementById('info');

				  if(elemento.value.length >= maximoCaracteres ) {
				    info.innerHTML = 'M�ximo '+maximoCaracteres+' caracteres';
				  }
				}
	</script>
          	";
				echo "<!-- script que define y configura el calendario--> 
						<script type='text/javascript'> 
						   Calendar.setup({ 
						    inputField     :    'ingresar',     // id del campo de texto 
						     ifFormat     :     '%d/%m/%Y',     // formato de la fecha que se escriba en el campo de texto 
						     button     :    'estado'     // el id del botón que lanzará el calendario 
						}); 
					</script>
				";
				echo "<!-- script que define y configura el calendario--> 
						<script type='text/javascript'> 
						   Calendar.setup({ 
						    inputField     :    'ingresar_natalicio',     // id del campo de texto 
						     ifFormat     :     '%d/%m/%Y',     // formato de la fecha que se escriba en el campo de texto 
						     button     :    'natalicio'     // el id del botón que lanzará el calendario 
						}); 
					</script>
				";

		 }
	  }
			 	/*echo 	"<td width=''align='center' colspan = '4'>";
			 		  		echo "</br><b>Estamos en construcción...</b><br>";
	  						echo "<img class='img-circle' src='./recursos/Beavis_construllendo.gif' title='[codigo... codigo...]' alt=''/>";
			 	echo 	"</td>";
			 	echo "</tr>";*/

/*
<label>de donde eres:</label>
<input type="text" name="pais" id="pais" list="paises"/>
<datalist id="paises">
<option value="España" />
<option value="México" />
<option value="Argentina" />
<option value="Perú" />
<option value="Colombia" />
<option value="Otro país" /> 
</datalist>
*/
?>

