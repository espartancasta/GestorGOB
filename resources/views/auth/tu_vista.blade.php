<form id="uploadForm" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="fileInput">Seleccionar archivo:</label>
    <input type="file" name="file" id="fileInput" class="form-control-file">
  </div>
  <button type="submit" class="btn btn-primary">Subir archivo</button>
</form>

<div id="uploadStatus" class="mt-3"></div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  let form = this;
  let formData = new FormData(form);
  let statusDiv = document.getElementById('uploadStatus');
  statusDiv.innerHTML = '<span class="text-info">Subiendo el archivo...</span>';

  fetch("{{ route('upload.file') }}", {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.innerHTML = `<span class="text-success">✔ Archivo subido correctamente: ${data.filename}</span>`;
      form.reset();
    } else {
      statusDiv.innerHTML = `<span class="text-danger">❌ ${data.message}</span>`;
    }
  })
  .catch(error => {
    console.error('Error:', error);
    statusDiv.innerHTML = '<span class="text-danger">❌ Error en la conexión o en el servidor.</span>';
  });
});
</script>
