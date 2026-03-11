<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_leasing_by_contract.css'; ?>
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

<main class="main-query-lea">
  <div class="header-title">
    <h1>Leasing's de contrato</h1>
    <p>Nro de contrato consultado: <span id="parametroPintado"></span></p>
  </div>

  <div class="container-data">
    <table id="listLeasing" class="display">
      <thead>
        <tr>
          <th>Item</th>
          <th>N° Leasing</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
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
          <th>N° Leasing</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Cantidad</th>
        </tr>
      </tfoot>
    </table>
  </div>
</main>

<div id="modal-leasing">
  <div class="modal-container">
    <div class="modal-header">
      <i class="bi bi-info-circle"></i>
      <h2>Detalles</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-success" id="btn-leasing">
        <span>Ver leasing</span>
        <i class="bi bi-file-earmark-arrow-down-fill"></i>
      </button>
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<script src="../js/consulta_leasing_por_contrato.js"></script>
<script type="module">
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
  };

  function transformType(value, object) {
    return object[value];
  } 

  document.addEventListener("DOMContentLoaded", async () => {
    const param = new URLSearchParams(window.location.search);
    const clienteId = param.get("clienteId")
    const contratoId = param.get("contratoId");

    if (!contratoId || !clienteId) alert("No se encontraron los parametros necesarios")

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = contratoId;

    const table = await getLeasings(contratoId, clienteId);

    $("#listLeasing tbody").on("click", "tr", async function() {

      const data = table.row(this).data();

      const detaiLeasing = await getDetailLeasing(data.nroLeasing);

      $("#modal-body-info").append(`
        <div class="info-document">
          <div class="info-col">
            <p>N° <b>${detaiLeasing.nroLeasing}</b></p>
            <p>Inicio el <b>${convertirFecha(detaiLeasing.fechaInicio)}</b></p>
            <p>Finaliza el <b>${convertirFecha(detaiLeasing.fechaInicio)}</b></p>
            <p>Periodo de gracia de <b>${detaiLeasing.periGracia.toString()}</b> meses</p>
            <p>Tipo <b>${detaiLeasing.tipo}</b></p>
          </div>
          <div class="info-col">
            <div class="row-data">
              <h3>Cantidad</h3>
              <p>${detaiLeasing.cantVehi.toString()} veh.</p>
            </div>
            <div class="row-data">
              <h3>Banco</h3>
              <p>${transformType(detaiLeasing.banco, {
                1: "BANBIF",
                2: "BBVA",
                3: "BCP",
                4: "HSBC",
                5: "INTERBANK",
                6: "SCOTIABANK",
                7: "TAIR",
                8: "SANTANDER"
              })}</p>
            </div>
            
          </div>
        </div>
        <div class="info-description">
          <h3>Descripcion</h3>
          <p>${detaiLeasing.descripcion != "" ? detaiLeasing.descripcion.toString() : "Sin descripción"}</p>
        </div>
      `);
      const modal = document.getElementById("modal-leasing");
      modal.style.display = "flex";

      $("#btn-leasing").off("click").on("click", () => {
        window.open(detaiLeasing.archivoPdf, '_blank');
      })
    })
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-leasing");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>