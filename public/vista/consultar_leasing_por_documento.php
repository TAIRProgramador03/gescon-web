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

<!-- TOASTR CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
        <label for="vence-result">Vencimiento</label>
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
        <div id="view-assign" class="card-result">
          <span>Veh. Asignados</span>
          <div class="card-info">
            <i class="fa fa-cars" style="color: #0e2e67;"></i>
            <p id="assign-result">0</p>
          </div>
        </div>
      </div>
      <button class="btn-success" id="btn-leasing">
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

  let table;

  document.addEventListener("DOMContentLoaded", async () => {
    const param = new URLSearchParams(window.location.search);
    const leasingId = param.get("leasingId");
    const nroLeasing = param.get("nroLeasing");
    const clienteId = param.get("clienteId");
    const documentoId = param.get("documentoId");

    if (!documentoId || !clienteId) {
      toastr.warning("Faltan parametros obligatorios para realizar la consulta", "Advertencia");
    }

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = documentoId;

    table = await getLeasings(documentoId, clienteId);

    if (leasingId && nroLeasing && clienteId && documentoId) {
      const detailLeasing = await getDetailLeasing(leasingId, nroLeasing, clienteId, documentoId)

      const fechaFin = convertirFecha(detailLeasing.fechaFin);
      const diasVencer = obtenerDiasVencimiento(fechaFin);
      const estado = obtenerEstado(fechaFin);

      // INPUTS DE DATOS
      if (diasVencer > 0) {
        $("#vence-result").val(`Faltan ${diasVencer} dias`);
      } else if (diasVencer < 0) {
        $("#vence-result").val(`Vencio hace ${Math.abs(diasVencer)} dias`);
      } else {
        $("#vence-result").val(`Vence hoy`);
      }

      $("#estado-result").val(estado);
      $("#per-gra-result").val(`${detailLeasing.periGracia.toString()} meses`);

      // CANTIDAD VEHICULOS
      $("#vehicle-result").text(detailLeasing.cantVehi);
      $("#assign-result").text(detailLeasing.cantAsign);

      $("#btn-leasing").off("click").on("click", () => {
        window.open(detailLeasing.archivoPdf, '_blank');
      })
    }
  })

  $("#listLeasing tbody").on("click", "tr", async function(e) {
    $('tr').removeClass("selected-row");

    $(this).addClass("selected-row");
    
    const data = table.row(this).data();

    const param = new URLSearchParams(window.location.search);
    const clienteId = param.get("clienteId");
    const documentoId = param.get("documentoId");

    param.set("nroLeasing", data.nroLeasing)
    param.set("leasingId", data.id)

    const nuevaURL = `${window.location.pathname}?${param.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const detaiLeasing = await getDetailLeasing(data.id, data.nroLeasing, clienteId, documentoId);

    const fechaFin = convertirFecha(detaiLeasing.fechaFin);
    const diasVencer = obtenerDiasVencimiento(fechaFin);
    const estado = obtenerEstado(fechaFin);

    // INPUTS DE DATOS
    if (diasVencer > 0) {
      $("#vence-result").val(`Faltan ${diasVencer} dias`);
    } else if (diasVencer < 0) {
      $("#vence-result").val(`Vencio hace ${Math.abs(diasVencer)} dias`);
    } else {
      $("#vence-result").val(`Vence hoy`);
    }

    $("#estado-result").val(estado);
    $("#per-gra-result").val(`${detaiLeasing.periGracia.toString()} meses`);

    // CANTIDAD VEHICULOS
    $("#vehicle-result").text(detaiLeasing.cantVehi);
    $("#assign-result").text(detaiLeasing.cantAsign);

    $("#btn-leasing").off("click").on("click", () => {
      window.open(detaiLeasing.archivoPdf, '_blank');
    })

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })
  })

  $("#view-vehicle").on("click", async () => {
    const param = new URLSearchParams(window.location.search);
    const leasingId = param.get("leasingId");

    if (!leasingId) {
      toastr.info("Debes seleccionar un leasing", "Aviso");
      return;
    }

    const vehicles = await getVehByLeasing(leasingId);

    $("#modal-body-info").append(`
      <table id="listVeh" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Cantidad</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Fecha Fin</th>
            <th>Vence en</th>
            <th>Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Cantidad</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Fecha Fin</th>
            <th>Vence en</th>
            <th>Leasing</th>
          </tr>
        </tfoot>
      </table>
    `);

    $("#listVeh").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      select: true,
      data: vehicles,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "placa",
        },
        {
          data: "modelo",
        },
        {
          data: "marca",
        },
        {
          data: "terreno",
        },
        {
          data: "cantidad",
        },
        {
          data: "año",
        },
        {
          data: "color",
        },
        {
          data: "operacion",
        },
        {
          data: "fechaFin",
          render: function(data) {
            return convertirFecha(data);
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            const fechaTsf = convertirFecha(data);
            const dias = obtenerDiasVencimiento(fechaTsf);
            if (dias > 0) {
              return `${dias} dias`
            } else if (dias < 0) {
              return `Hace ${Math.abs(dias)} dias`
            } else {
              return `Vence hoy`
            }
          }
        },
        {
          data: "nroLeasing"
        }
      ],
    })

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "flex";
  })

  $("#view-assign").on("click", async () => {
    const param = new URLSearchParams(window.location.search);
    const nroLeasing = param.get("nroLeasing");
    const clienteId = param.get("clienteId");
    const documentoId = param.get("documentoId");

    if (!nroLeasing) {
      toastr.info("Debes seleccionar un leasing", "Aviso");
      return;
    }

    const vehicles = await getAssignByLeasing(nroLeasing, clienteId, documentoId);

    $("#modal-body-info").append(`
      <table id="listVehAssign" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Leasing</th>
          </tr>
        </tfoot>
      </table>
    `);

    $("#listVehAssign").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      select: true,
      data: vehicles,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "placa",
        },
        {
          data: "modelo",
        },
        {
          data: "marca",
        },
        {
          data: "terreno",
        },
        {
          data: "año",
        },
        {
          data: "color",
        },
        {
          data: "operacion",
        },
        {
          data: "nroLeasing"
        }
      ],
    })

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "flex";
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