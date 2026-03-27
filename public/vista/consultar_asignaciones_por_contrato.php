<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_assign_by_contract.css'; ?>
</style>

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
  <div class="header-title border border-gray-300 shadow-lg">
    <h1 class="text-2xl font-bold">Vehiculos asignados</h1>
    <p>Cliente ID: <span id="paramClient"></span></p>
    <p id="paramContText" class="hidden">Contrato ID: <span id="paramContract"></span></p>
  </div>

  <div class="container-data border border-gray-300">
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

    <table id="listAssign" class="display rounded-md">
      <thead>
        <tr>
          <th class="text-gray-500 !font-medium">Item</th>
          <th class="text-gray-500 !font-medium">Cliente</th>
          <th class="text-gray-500 !font-medium">Operacion</th>
          <th class="bg-yellow-400 !text-white !font-medium">Placa</th>
          <th class="bg-yellow-400 !text-white !font-medium">Año</th>
          <th class="bg-yellow-400 !text-white !font-medium">Color</th>
          <th class="bg-yellow-400 !text-white !font-medium">Marca</th>
          <th class="bg-yellow-400 !text-white !font-medium">Modelo</th>
          <th class="bg-yellow-400 !text-white !font-medium">Terreno</th>
          <th class="bg-green-400 !text-white !font-medium">Leasing</th>
          <th class="bg-green-400 !text-white !font-medium">Fecha Inicio de leasing</th>
          <th class="bg-green-400 !text-white !font-medium">Fecha Fin de leasing</th>
          <th class="bg-blue-400 !text-white !font-medium">Contrato/Adenda</th>
          <th class="bg-blue-400 !text-white !font-medium">Fecha Inicio de contrato</th>
          <th class="bg-blue-400 !text-white !font-medium">Fecha Fin de contrato</th>
          <th class="bg-blue-400 !text-white !font-medium">Plazo</th>
          <th class="bg-blue-400 !text-white !font-medium">Tarifa</th>
          <th class="bg-blue-400 !text-white !font-medium">Moneda</th>
          <th class="text-gray-500 !font-medium">Fecha de Acta de Entrega</th>
          <th class="text-gray-500 !font-medium">Fecha Devolucion</th>
          <th class="text-gray-500 !font-medium">% de contrato</th>
          <th class="text-gray-500 !font-medium">Condicion</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        </tr>
      </tbody>
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

    if (!clienteId) toastr.error("No se encontraron los parametros necesarios")

    $("#paramClient").text(clienteId);
    if(contratoId) {
      $("#paramContText").removeClass("hidden");
      $("#paramContract").text(contratoId);
    }


    const assigns = await getAssigns(clienteId, contratoId, leasingId, tipoTerr);

    // INTEGRAMOS LA LIBRERIA DATATABLE
    table = $("#listAssign").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clienteId}`,
        customize: function(xlsx) {
          var sheet = xlsx.xl.worksheets['sheet1.xml'];

          // 1. Cambiar el color del Título (Celda A1)
          // Usamos el estilo '51' que suele ser fondo gris/azul con texto blanco
          $('row c[r^="A1"]', sheet).attr('s', '51');

          // 2. Personalizar los Headers (Fila de encabezados)
          // Buscamos todas las celdas de la fila 2 (donde suelen estar los headers)
          // El estilo '2' es negrita, '42' es fondo azul claro, etc.
          $('row:eq(1) c', sheet).attr('s', '22'); // 22 es un estilo predefinido (negrita + borde)

          // 3. Si quieres colores manuales más específicos (estilos personalizados)
          // Tienes que editar el diccionario de estilos de JSZip (más complejo)
          // Pero DataTables trae estilos incorporados del 0 al 60:
          // 2: Negrita, 5: Centrado, 15: Bordes, 20: Azul, 22: Blanco sobre Azul
        },
      }],
      initComplete: function() {
        $(".leyendas").html(`
          <div class="w-full flex justify-center items-center gap-4">
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-yellow-400"></span>
              <p class="text-xs !m-0">Unidad</p>
            </div>
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-green-400"></span>
              <p class="text-xs !m-0">Leasing</p>
            </div>
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-blue-400"></span>
              <p class="text-xs !m-0">Contrato</p>
            </div>
          </div>
        `);
      },
      ordering: false,
      scrollX: true,
      data: assigns,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "cliente",
          width: "200px"
        },
        {
          data: "operacion",
          width: "150px"
        },
        {
          data: "placa",
          width: "80px"
        },
        {
          data: "año"
        },
        {
          data: "color",
          width: "100px"
        },
        {
          data: "marca",
          width: "80px"
        },
        {
          data: "modelo",
          width: "150px"
        },
        {
          data: "terreno",
          render: (data) => {
            return transformType(data, {
              0: "Superficie",
              1: "Socavón",
              2: "Ciudad",
              3: "Severo"
            })
          },
          width: "100px"
        },
        {
          data: "leasing",
          width: "120px"
        },
        {
          data: "fechaIniLea",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "fechaFinLea",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "contrato",
          width: "150px"
        },
        {
          data: "fechaIniCon",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "fechaFinCon",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "plazo",
          render: (data) => {
            return data + ` meses`
          },
          width: "80px"
        },
        {
          data: "tarifa",
          render: (data) => {
            return data.toFixed(2);
          }
        },
        {
          data: "moneda"
        },
        {
          data: "fechaIni",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "fechaFin",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "porcentaje",
          render: (data, type, row) => {

            const fechaIni = dayjs(row.fechaIni).format("YYYY-MM-DD")
            const fechaFin = dayjs(row.fechaFin).format("YYYY-MM-DD")

            const result = calcularPorcentaje(fechaIni, fechaFin);

            if (typeof result == "string") {
              return `<span style="color: red;">${result}</span>`;
            } else {
              const color = result > 0 && result <= 25 ? "red-relleno" : result > 25 && result <= 60 ? "yellow-relleno" : "green-relleno";
              const colorText = result > 0 && result <= 25 ? "black-porcentaje" : result > 25 && result <= 60 ? "black-porcentaje" : "white-porcentaje";
              return `
                <div class="contenedor-barra">
                  <div class="progreso-relleno ${color}" style="width: ${result}%;"></div>
                  <span class="numero-porcentaje ${colorText}">${result}%</span>
                </div>
              `
            }
          },
          width: "120px"
        },
        {
          data: "condicion",
          render: (data, type, row) => {
            const status = row.idOpeActual == 109 ? "Vendido" : row.idOpe != row.idOpeActual ? "Inactivo" : "Activo";
            const color = row.idOpeActual == 109 ? "tag-yellow" : row.idOpe != row.idOpeActual ? "tag-red" : "tag-green";

            return `<span class="tag-estado ${color}">${status}</span>`
          }
        },
      ],
    });

    const listLeasing = await getLeasings(clienteId, contratoId)

    const dataCleaned = listLeasing.map((lea) => ({
      id: lea.nroLeasing,
      text: lea.nroLeasing
    }))

    $("#cbo-leasing").select2({
      placeholder: "Seleccione un leasing",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Todos",
        },
        ...dataCleaned
      ]
    });

    $("#cbo-terreno").select2({
      placeholder: "Seleccione un contrato",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 4,
          text: "Todos"
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

    const assings = await getAssigns(clienteId, contratoId, leasingId != 0 ? leasingId : null, terrId);

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

    const assings = await getAssigns(clienteId, contratoId, leasingId, terrId >= 4 ? null : terrId);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });
</script>

<?php
require './templates/footer.html';
?>