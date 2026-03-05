<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_documents_by_contract.css'; ?>
</style>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS DATATABLE -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />

<!-- JS DATATABLE -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<div id="preloader-mini">
  <div class="gif-container">
    <img src="../img/carpeta.gif" alt="Cargando...">
  </div>
  <div class="welcome-message">
    <p>¡Cargando!.....</p>
  </div>
</div>

<main class="main-query-doc">
  <div class="header-title">
    <h1>Documentos de contrato</h1>
  </div>
  <p>Pintar parametro: <span id="parametroPintado"></span></p>

  <table id="listDocuments" class="display">
    <thead>
      <tr>
        <th>Item</th>
        <th>N° Documento</th>
        <th>Fecha Firma</th>
        <th>Duracion</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th>Item</th>
        <th>N° Documento</th>
        <th>Fecha Firma</th>
        <th>Duracion</th>
        <th>Cantidad</th>
      </tr>
    </tfoot>
  </table>
</main>

<div id="modal-documents">
  <div class="modal-container">
    <div class="modal-header">
      <i class="bi bi-info-circle"></i>
      <h2>Detalles</h2>
    </div>
    <div class="modal-body">
      Data: <span id="info-row"></span>
    </div>
    <div class="modal-footer">
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<script src="../js/consulta_documentos_por_contrato.js"></script>
<script type="module">
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
  };

  document.addEventListener("DOMContentLoaded", async () => {
    const param = new URLSearchParams(window.location.search);
    const contratoId = param.get("contratoId");

    if (!contratoId) alert("No se encontro ningun parametro")

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = contratoId;

    const table = await getDocuments(contratoId);

    $("#listDocuments tbody").on("click", "tr", function() {

      console.log("FILA", this);

      const data = table.row(this).data();

      $("#info-row").text(data.nroDocumento);
      const modal = document.getElementById("modal-documents");
      modal.style.display = "flex";
    })
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-documents");
    modal.style.display = "none";
  })
</script>

<?php
require './templates/footer.html';
?>