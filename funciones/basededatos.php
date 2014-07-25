<?php

  function conectar() {
    include "./configuraciones/principal.php";
    $parametros  = "host='$SERVIDOR_DE_BASE_DE_DATOS' ";
    $parametros .= "port='5432' ";
    $parametros .= "dbname='$BASE_DE_DATOS' ";
    $parametros .= "user='$USUARIO_DE_BASE_DE_DATOS' ";
    $parametros .= "password='$CLAVE_DE_BASE_DE_DATOS'";
    $conexion = @ pg_connect( $parametros );
    if ( !$conexion ) {
      echo "<br>No se pudo establecer la conexi&oacute;n a la base de datos<br>";
    }
    return $conexion;
  };

  function existe_conexion () {
    include "./configuraciones/principal.php";
    $parametros  = "host='$SERVIDOR_DE_BASE_DE_DATOS' ";
    $parametros .= "port='5432' ";
    $parametros .= "dbname='$BASE_DE_DATOS' ";
    $parametros .= "user='$USUARIO_DE_BASE_DE_DATOS' ";
    $parametros .= "password='$CLAVE_DE_BASE_DE_DATOS'";
    $conexion = @ pg_connect( $parametros );
    if ( $conexion ) {
      $resultado = TRUE;
      pg_close( $conexion );
    } else {
      $resultado = FALSE;
    }
    return $resultado;
  }

  function consultar( $sql ){
    $conexion = conectar();
    $resultado = array();
    if ( $conexion ) {
      $consulta = @ pg_query( $conexion, $sql );
      if ( $consulta ) {
        while ( $fila = pg_fetch_array( $consulta ) ) {
            $resultado[] = $fila;
        }
      } else {
        # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
       #echo "<br>No se ejecuto la sentencia <br><pre> $sql</pre> <br>";
      }
    } else {
      echo "<br>No hay conexi&oacute;n<br>";
    }
    return $resultado;
  }

  function consultar2( $sql2 ){
    $conexion = conectar();
    $resultado = array();
    if ( $conexion ) {
      $consulta = @ pg_query( $conexion, $sql2 );
      if ( $consulta ) {
        while ( $fila = pg_fetch_array( $consulta ) ) {
            $resultado[] = $fila;
        }
      } else {
        # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
       echo "<br>No se ejecuto la sentencia <br><pre>sql , $sql2</pre> <br>";
      }
    } else {
      echo "<br>No hay conexi&oacute;n<br>";
    }
    return $resultado;
  }

  function ejecutar( $sql ){
    $conexion = conectar();
    $resultado = FALSE;
    if ( $conexion ) {
      $consulta = @ pg_query( $conexion, htmlentities($sql) );
      if ( $consulta ) {
        $resultado = TRUE;
      } else {
        # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
        echo "<br>No se ejecuto la sentencia <br><pre>$sql</pre> <br>";
      }
    } else {
      echo "<br>No hay conexi&oacute;n<br>";
    }
    return $resultado;
  }
  
 /* 
 function construir_base_de_datos () {
    $conexion = conectar();
    if ( $conexion ) {
  
    }
*/
?>
