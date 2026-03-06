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
    <p>Nro de contrato consultado: <span id="parametroPintado"></span></p>
  </div>

  <div class="container-data">
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
  </div>
</main>

<div id="modal-documents">
  <div class="modal-container">
    <div class="modal-header">
      <i class="bi bi-info-circle"></i>
      <h2>Detalles</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-success" id="btn-document">
        <span>Ver documento</span>
        <i class="bi bi-file-earmark-arrow-down-fill"></i>
      </button>
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

    $("#listDocuments tbody").on("click", "tr", async function() {

      const data = table.row(this).data();

      const detailDocument = await getDetailDocument(data.nroDocumento);

      $("#modal-body-info").append(`
        <div class="info-document">
          <div class="info-col">
            <p>N° <b>${detailDocument.nroDocumento}</b></p>
            <p>Firmado el <b>${convertirFecha(detailDocument.fechaFirma)}</b></p>
            <p>Duración de <b>${detailDocument.duracion.toString()}</b> meses</p>
            <p>Tipo <b>${detailDocument.tipoDocumento.toString()}</b></p>
          </div>
          <div class="info-col">
            <div class="row-data">
              <h3>Cantidad</h3>
              <p>${detailDocument.cantVehi.toString()} veh.</p>
            </div>
            <div class="row-data">
              <h3>Km Total</h3>
              <p>${detailDocument.kmTotal.toString()}</p>
            </div>
            <div class="row-data">
              <h3>Km Adicional</h3>
              <p>${detailDocument.kmAdi.toString()}</p>
            </div>
            <div>
              <ul>
                <li>
                  <span>Sup</span>
                  ${detailDocument.vehSup.toString()}
                </li>
                <li><span>Sev</span>${detailDocument.vehSev.toString()}</li>
                <li><span>Soc</span>${detailDocument.vehSoc.toString()}</li>
                <li><span>Ciu</span>${detailDocument.vehCiu.toString()}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="info-description">
          <h3>Descripcion</h3>
          <p>${detailDocument.descripcion != "" ? detailDocument.descripcion.toString() : "Sin descripción"}</p>
        </div>
      `);
      const modal = document.getElementById("modal-documents");
      modal.style.display = "flex";

      $("#btn-document").off("click").on("click", () => {
        window.open(detailDocument.archivoPdf, '_blank');
      })
    })
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-documents");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>