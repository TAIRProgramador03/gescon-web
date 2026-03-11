<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_leasing_by_document.css'; ?>
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
    <h1>Leasing's de documento</h1>
    <p>Id documento: <span id="parametroPintado"></span></p>
  </div>

  <div class="container-data">
    <div class="column-table">
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
      <div class="item-result">
        <label for="descripcion-result">Descripción</label>
        <textarea id="descripcion-result" readonly></textarea>
      </div>
    </div>

    <div class="result-search">
      <h3>Resumen</h3>
      <hr />
      <div class="item-result">
        <label for="vence-result">Vence en</label>
        <input id="vence-result" readonly>
      </div>
      <div class="item-result">
        <label for="estado-result">Estado</label>
        <input id="estado-result" readonly>
      </div>
      <div class="item-result">
        <label for="per-gra-result">Periodo de gracia</label>
        <input id="per-gra-result" readonly>
      </div>
      <div class="card-view">
        <div id="view-vehicle" class="card-result">
          <span>N° Vehiculos</span>
          <div class="card-info">
            <i class="fa fa-cars" style="color: #0e2e67;"></i>
            <p id="vehicle-result">0</p>
          </div>
        </div>
        <div id="view-vehicle" class="card-result">
          <span>Veh. Asignados</span>
          <div class="card-info">
            <i class="fa fa-cars" style="color: #0e2e67;"></i>
            <p id="vehicle-result">0</p>
          </div>
        </div>
      </div>
      <button class="btn-success" id="btn-document">
        Ver leasing
        <i class="bi bi-file-earmark-arrow-down-fill"></i>
      </button>
    </div>
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

<script src="../js/consulta_leasing_por_documento.js"></script>
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
    const documentoId = param.get("documentoId");

    if (!documentoId || !clienteId) alert("No se encontraron los parametros necesarios")

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = documentoId;

    const table = await getLeasings(documentoId, clienteId);

    $("#listLeasing tbody").on("click", "tr", async function() {

      const data = table.row(this).data();

      param.set("leasingId", data.id)

      const nuevaURL = `${window.location.pathname}?${param.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      const detaiLeasing = await getDetailLeasing(data.id);

      console.log(detaiLeasing);

      const fechaFin = convertirFecha(detaiLeasing.fechaFin);
      const diasVencer = obtenerDiasVencimiento(fechaFin);
      const estado = obtenerEstado(fechaFin);

      // INPUTS DE DATOS
      $("#vence-result").val(`${diasVencer} dias`);
      $("#estado-result").val(estado);
      $("#per-gra-result").val(`${detaiLeasing.periGracia.toString()} meses`);

      // CANTIDAD VEHICULOS
      $("#vehicle-result").text(detaiLeasing.cantVehi);

      $("#btn-leasing").off("click").on("click", () => {
        window.open(detaiLeasing.archivoPdf, '_blank');
      })
    })
  })

  // $("#modal-body-info").append(`
  //   <div class="info-document">
  //     <div class="info-col">
  //       <p>N° <b>${detaiLeasing.nroLeasing}</b></p>
  //       <p>Inicio el <b>${convertirFecha(detaiLeasing.fechaInicio)}</b></p>
  //       <p>Finaliza el <b>${convertirFecha(detaiLeasing.fechaInicio)}</b></p>
  //       <p>Periodo de gracia de <b>${detaiLeasing.periGracia.toString()}</b> meses</p>
  //       <p>Tipo <b>${detaiLeasing.tipo}</b></p>
  //     </div>
  //     <div class="info-col">
  //       <div class="row-data">
  //         <h3>Cantidad</h3>
  //         <p>${detaiLeasing.cantVehi.toString()} veh.</p>
  //       </div>
  //       <div class="row-data">
  //         <h3>Banco</h3>
  //         <p>${transformType(detaiLeasing.banco, {
  //           1: "BANBIF",
  //           2: "BBVA",
  //           3: "BCP",
  //           4: "HSBC",
  //           5: "INTERBANK",
  //           6: "SCOTIABANK",
  //           7: "TAIR",
  //           8: "SANTANDER"
  //         })}</p>
  //       </div>

  //     </div>
  //   </div>
  //   <div class="info-description">
  //     <h3>Descripcion</h3>
  //     <p>${detaiLeasing.descripcion != "" ? detaiLeasing.descripcion.toString() : "Sin descripción"}</p>
  //   </div>
  // `);
  // const modal = document.getElementById("modal-leasing");
  // modal.style.display = "flex";

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-leasing");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>