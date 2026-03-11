<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_assign_by_contract.css'; ?>
</style>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS DATATABLE -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />

<!-- JS DATATABLE -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

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
    <h1>Vehiculos asignados</h1>
    <p>ID de contrato consultado: <span id="parametroPintado"></span></p>
  </div>

  <div class="container-data">
    <div class="filter-table">
      <span>Buscar por</span>
      <div class="contain-filter">
        <label for="cbo-leasing">Leasing</label>
        <select id="cbo-leasing" name="opciones" class="cbo-filter"></select>
      </div>
      <div class="contain-filter">
        <label for="cbo-terreno">Tipo de terreno</label>
        <select id="cbo-terreno" name="opciones" class="cbo-filter"></select>
      </div>
    </div>

    <table id="listAssign" class="display">
      <thead>
        <tr>
          <th>Item</th>
          <th>Placa</th>
          <th>Año</th>
          <th>Color</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Tarifa</th>
          <th>Terreno</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
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
          <th>Año</th>
          <th>Color</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Tarifa</th>
          <th>Terreno</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Leasing</th>
        </tr>
      </tfoot>
    </table>
  </div>
</main>

<div id="modal-assign">
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

<script src="../js/consulta_asignacion_por_contrato.js"></script>
<script type="module">
  // const IP_LOCAL = "localhost";
  let table;

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
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");
    const leasingId = param.get("leasingId")
    const tipoTerr = param.get("tipoTerr")

    if (!contratoId || !clienteId) alert("No se encontraron los parametros necesarios")

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = contratoId;

    const assigns = await getAssigns(contratoId, clienteId, leasingId, tipoTerr);

    // INTEGRAMOS LA LIBRERIA DATATABLE
    table = $("#listAssign").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      data: assigns,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "placa",
          width: "10%",
        },
        {
          data: "año",
          width: "5%",
        },
        {
          data: "color",
          width: "10%",
        },
        {
          data: "marca",
          width: "10%",
        },
        {
          data: "modelo",
          width: "10%",
        },
        {
          data: "tarifa",
        },
        {
          data: "terreno",
          render: function(data) {
            return transformType(data, {
              0: "Superficie",
              1: "Socavon",
              2: "Ciudad",
              3: "Servero",
            });
          },
          width: "15%",
        },
        {
          data: "fechaIni",
          render: function(data) {
            return convertirFecha(data);
          },
          width: "10%",
        },
        {
          data: "fechaFin",
          render: function(data) {
            return convertirFecha(data);
          },
          width: "10%",
        },
        {
          data: "leasing",
          width: "15%"
        },
      ],
    });

    const listLeasing = await getLeasings(contratoId, clienteId)

    const dataCleaned = listLeasing.map((lea) => ({
      id: lea.nroLeasing,
      text: lea.nroLeasing
    }))

    $("#cbo-leasing").select2({
      placeholder: "Seleccione un leasing",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Sin selección",
        },
        ...dataCleaned
      ]
    });

    $("#cbo-terreno").select2({
      placeholder: "Seleccione un contrato",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 4,
          text: "Sin selección"
        },
        {
          id: 0,
          text: "Superficie"
        },
        {
          id: 1,
          text: "Socavon"
        },
        {
          id: 2,
          text: "Ciudad"
        },
        {
          id: 3,
          text: "Severo"
        }
      ]
    });

    if (leasingId) $('#cbo-leasing').val(`${leasingId}`).trigger("change");

    if (tipoTerr) $('#cbo-terreno').val(`${tipoTerr}`).trigger("change");
  })

  $('#cbo-leasing').on('change', async function(e) {
    const leasingId = $('#cbo-leasing').val();

    const params = new URLSearchParams(window.location.search);

    if (leasingId == 0) {
      params.delete("leasingId")
    } else {
      params.set("leasingId", leasingId)
    }

    const contratoId = params.get("contratoId");
    const clienteId = params.get("clienteId");
    const terrId = params.get("tipoTerr");

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(contratoId, clienteId, leasingId != 0 ? leasingId : null, terrId);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });

  $('#cbo-terreno').on('change', async function(e) {
    const terrId = $('#cbo-terreno').val();

    const params = new URLSearchParams(window.location.search);

    if (terrId >= 4) {
      params.delete("tipoTerr")
    } else {
      params.set("tipoTerr", terrId)
    }

    const contratoId = params.get("contratoId");
    const clienteId = params.get("clienteId")
    const leasingId = params.get("leasingId")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(contratoId, clienteId, leasingId, terrId >= 4 ? null : terrId);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });
</script>

<?php
require './templates/footer.html';
?>