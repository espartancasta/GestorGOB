<form id="uploadForm" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="fileInput">Seleccionar Archivo:</label>
    <input type="file" name="file" id="fileInput" class="form-control-file">
  </div>
  <button type="submit" class="btn btn-primary">Subir Archivo</button>
</form>

<div id="uploadStatus" class="mt-3"></div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  let form = this;
  let formData = new FormData(form);
  let statusDiv = document.getElementById('uploadStatus');
  statusDiv.innerHTML = '<span class="text-info">Subiendo...</span>';

  fetch("{{ route('upload.file') }}", {
    method: 'POST',
    body: formData // FormData incluye el archivo y el token CSRF
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.innerHTML = `<span class="text-success">${data.message} (${data.filename})</span>`;
      form.reset(); // Limpiar el formulario
    } else {
      statusDiv.innerHTML = `<span class="text-danger">${data.message}</span>`;
    }
  })
  .catch(error => {
    console.error('Error:', error);
    statusDiv.innerHTML = '<span class="text-danger">❌ Error en la conexión o el servidor.</span>';
  });
});
</script>