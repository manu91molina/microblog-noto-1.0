<?
include "./configuraciones/nombre_bmu.php";
echo "
	<html>
	  <head>
	    <title>
		$NOMBRE_BMU
	    </title>
  	    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>	 
	    <link rel='shortcut icon' href='./recursos/noto.ico' />
    	<link href='./recursos/bootstrap/dist/css/bootstrap-respondive.css' rel='stylesheet' media='screen'>
    	";

    	include "./configuraciones/existe_miembro_admin.php";
    	if (isset( $_SESSION['ingreso']) && @$administrador) {
    		echo "<link href='./recursos/bootstrap/dist/css/bootstrap-admin.css' rel='stylesheet' media='screen'>";
    	}else{
    		if (isset( $_SESSION['ingreso'])&& @$usuario_miembro) {
    			echo "<link href='./recursos/bootstrap/dist/css/bootstrap.css' rel='stylesheet' media='screen'>";
    		}else{
    			"./configuraciones/correo-idmiebro.php";
    			if (!$miembroid ) {
    				echo "<link href='./recursos/bootstrap/dist/css/bootstrap.css' rel='stylesheet' media='screen'>";
    			}else{
			    	if (!@$administrador && !@$usuario_miembro){
			    		echo "<link href='./recursos/bootstrap/dist/css/bootstrap-admin.css' rel='stylesheet' media='screen'>";	
					}
    			}
    		}
    	}

    	
echo"
    	<script src='./recursos/js/jquery.js'></script>
    	<script src='./recursos/bootstrap/dist/js/bootstrap.js'></script>
    	<script src='./recursos/js/modernizr.custom.js'></script>
    	";
 
 include "./configuraciones/existe_miembro.php";
	if ($cantidada_de_miembros > 0) {    	
    	 if ( isset( $_SESSION['miembro'] ) ) {
    		echo "
    			<script type='text/javascript' src='./recursos/fancybox/jquery/jquery-1.10.2.min.js'></script>
				<script type='text/javascript' src='./recursos/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
				<link rel='stylesheet' href='./recursos/fancybox/source/jquery.fancybox.css?v=2.1.5' type='text/css' media='screen' />
				<script type='text/javascript' src='./recursos/fancybox/source/jquery.fancybox.pack.js?v=2.1.5'></script>
				<link rel='stylesheet' href='./recursos/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5' type='text/css' media='screen' />
				<script type='text/javascript' src='./recursos/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>
				<script type='text/javascript' src='./recursos/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'></script>
				<link rel='stylesheet' href='./recursos/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7' type='text/css' media='screen' />
				<script type='text/javascript' src='./recursos/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>
			";
		  }else{
		  	include "./interfaces/zone_visitante.php";
		  }
	}else{
		include "./interfaces/zone_admin.php";
	}

echo "
    		 <SCRIPT LANGUAGE='JavaScript'>
<!-- 
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else 
countfield.value = maxlimit - field.value.length;
}
// -->

</script>
   
	    
	  </head>";
if ($cantidada_de_miembros > 0) { 
	if ( isset( $_SESSION['miembro'] ) ) {
		echo "<body>";
	}else{
		echo"<body onload='start()' onresize='resize()' onorientationchange='resize()'>";
	    echo"
	    <div id='canvasesdiv' style='position:fixed; width:80%; height:80%'>
		<canvas id='starfield' style='z-index: 1'></canvas>
	    <canvas id='overlay' style='z-index: 2'></canvas>
	    <canvas id='foreground' style='z-index: 3'></canvas>
		</div>
	    ";
	}
}else{
	echo"<body onload='start()' onresize='resize()' onorientationchange='resize()'>";
    echo"
    <div id='canvasesdiv' style='position:fixed; width:80%; height:80%'>
		<canvas id='starfield' style='z-index: 1'></canvas>
    	<canvas id='overlay' style='z-index: 2'></canvas>
    	<canvas id='foreground' style='z-index: 3'></canvas>
	</div>
    ";
}

#<script src='./recursos/js/ajax.js'></script> 
