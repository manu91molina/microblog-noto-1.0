
<form id="form1" name="form1" method="post" action="./index.php?contenido=app-creando_publicacion" enctype="multipart/form-data">

<style>
  .thumb {
    height: 200px;
    border: 1px solid #000;
    margin: 50px 10px 0 0;
  }
</style>
<p class="ayuda">presentar con una imagen: (peso de imagen menor a 1.5MB aprox.)</p>
<p id='elegir-archivo'>
  <input type="file" id="files" name="files" />
  <input type='hidden' name='con_img' value='con_img'>
<p/>

<?
  echo "</br></br>";
  echo"<div class='modal-footer'>";
        #echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo"<p class='indicacion'>Crear publicación <span class='glyphicon glyphicon-arrow-right'></span></p>";
  echo"</div>";
?>
<output id="list-miniatura"></output>

<script>
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
 
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
 
      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }
 
      var reader = new FileReader();
 
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<br><br><br><img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/><br><br><br>'].join('');
          document.getElementById('list-miniatura').insertBefore(span, null);
        };
      })(f);
 
      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }
 
  document.getElementById('files').addEventListener('change', handleFileSelect, false);

</script>

<br>
<table border='0' width='50%'>
  <tr align=''>
    <td width='08%'>
      &nbsp
    </td>
    <td>
      <textarea name='titulo' class="uplo-img" placeholder="Título"></textarea>
    </td>
  </tr>
  <tr align=''>
    <td width='08%'>
      &nbsp
    </td>
    <td>
    </br>
      <textarea class="form-control" name='descripcion' placeholder="Contenido..." rows="2"></textarea>
    </td>
  </tr>
</table>
<br>

<p class="indicacion">¿sobre que es tu publicación?  &nbsp &nbsp
  <input type="radio" name="tipo"  value="1" title= "sobre algo en particular"checked>
  <b>libre &nbsp &nbsp

  <input type="radio" name="tipo" value="2" title= "anunciar un evento próximo">
  evento &nbsp
  </b>
  <button class='btn btn-primary btn-sm' name='cargar' value='publicar'><span class='glyphicon glyphicon-ok-sign'></span> ok</button>
</p>

<input type='hidden' name='idmiembro' value='<?echo $_SESSION['miembro'];?>'>
</form>

