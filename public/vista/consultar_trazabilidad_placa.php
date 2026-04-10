<?php
require './templates/header.html';
?>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- ESTILOS -->
<style>
  <?php include '../css/views/query_plate_traceability.css'; ?>
</style>

<div id="preloader-mini" class="w-full h-screen fixed top-0 left-0 z-[9999] bg-white flex flex-col justify-center items-center">
  <div class="flex-col gap-4 w-full flex items-center justify-center relative">
    <div class="w-28 h-28 border-8 text-blue-600 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-600 rounded-full"></div>
    <div class="gif-container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <img src="../img/carpeta.gif">
    </div>
  </div>
  <p class="m-0 font-medium text-gray-400 text-xl flex gap-1"><span class="animate-wave" style="animation-delay:0s"></span>
    <span class="animate-wave" style="animation-delay:0.1s">C</span>
    <span class="animate-wave" style="animation-delay:0.2s">a</span>
    <span class="animate-wave" style="animation-delay:0.3s">r</span>
    <span class="animate-wave" style="animation-delay:0.4s">g</span>
    <span class="animate-wave" style="animation-delay:0.5s">a</span>
    <span class="animate-wave" style="animation-delay:0.6s">n</span>
    <span class="animate-wave" style="animation-delay:0.7s">d</span>
    <span class="animate-wave" style="animation-delay:0.8s">o</span>
  </p>
</div>

<main class="w-full flex flex-col gap-4" data-route-permission="ver_placas">
  <div class="w-full bg-white px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-orange-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Consulta de placas</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Visualice y consulte la información de las placas registradas en el sistema.</p>
    </div>
    <div class="w-full grid grid-cols-5 items-center gap-4">
      <!-- <span class="text-sm font-medium text-gray-500">Buscar por</span> -->
      <!-- CLIENTE -->
      <div class="flex flex-col w-full relative">
        <select id="cbo-cliente" name="opciones">
        </select>

        <label
          for="cbo-cliente"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Cliente
        </label>
      </div>

      <!-- CONTRATO -->
      <div class="flex flex-col w-full relative">
        <select id="cbo-contrato" name="opciones">
        </select>

        <label
          for="cbo-contrato"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Contrato
        </label>
      </div>

      <!-- LEASING -->
      <div class="flex flex-col w-full relative">
        <select id="cbo-leasing" name="opciones">
        </select>

        <label
          for="cbo-leasing"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Leasing
        </label>
      </div>

      <!-- TERRENO -->
      <div class="flex flex-col w-full relative">
        <select id="cbo-terreno" name="opciones">
        </select>

        <label
          for="cbo-terreno"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Tipo de Terreno
        </label>
      </div>

      <!-- ESTADO -->
      <div class="flex flex-col w-full relative">
        <select id="cbo-estado" name="opciones">
        </select>

        <label
          for="cbo-estado"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Estado
        </label>
      </div>
    </div>

    <table id="listAssign" class="display rounded-md">
      <thead>
        <tr>
          <th></th>
          <th class="bg-yellow-400 !text-white !font-medium">Item</th>
          <th class="bg-yellow-400 !text-white !font-medium">Placa</th>
          <th class="bg-yellow-400 !text-white !font-medium">Año</th>
          <th class="bg-yellow-400 !text-white !font-medium">Color</th>
          <th class="bg-yellow-400 !text-white !font-medium">Marca</th>
          <th class="bg-yellow-400 !text-white !font-medium">Modelo</th>
          <th class="bg-yellow-400 !text-white !font-medium">Terreno</th>
          <th class="bg-green-400 !text-white !font-medium">Leasing</th>
          <th class="bg-green-400 !text-white !font-medium">Fecha Inicio de leasing</th>
          <th class="bg-green-400 !text-white !font-medium">Fecha Fin de leasing</th>
          <th class="bg-blue-400 !text-white !font-medium">Cliente</th>
          <th class="bg-blue-400 !text-white !font-medium">Operacion</th>
          <th class="bg-blue-400 !text-white !font-medium">Contrato/Adenda</th>
          <th class="bg-blue-400 !text-white !font-medium">Fecha Inicio de contrato</th>
          <th class="bg-blue-400 !text-white !font-medium">Plazo</th>
          <th class="bg-blue-400 !text-white !font-medium">Fecha Fin de contrato</th>
          <th class="bg-blue-400 !text-white !font-medium">Tarifa</th>
          <th class="bg-blue-400 !text-white !font-medium">Moneda</th>
          <th class="bg-taupe-600 text-white !font-medium">Fecha de Acta de Entrega</th>
          <th class="bg-taupe-600 text-white !font-medium">Fecha Devolucion</th>
          <th class="bg-taupe-600 text-white !font-medium">% de contrato</th>
          <th class="bg-taupe-600 text-white !font-medium">Condicion</th>
          <th class="bg-taupe-600 text-white !font-medium">Acta</th>
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

<script type="module" src="../js/consulta_trazabilidad_placa.js"></script>
<script type="module">
  import {
    getAssigns,
    getClients,
    getContracts,
    verPdf,
    getLeasings,
    calcularPorcentaje
  } from "../js/consulta_trazabilidad_placa.js";

  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $('#preloader-mini').css('opacity', '1');
    $('#preloader-mini').css('z-index', '99999');
  }

  function hideLoader() {
    activeRequests = Math.max(0, activeRequests - 1);
    if (activeRequests === 0) {
      animate("#preloader-mini", {
        opacity: [1, 0],
      }, {
        duration: 0.45,
        easing: "ease-in"
      })

      setTimeout(() => {
        // $('#preloader-mini').css('opacity', '0');
        $('#preloader-mini').css('z-index', '-99999');
      }, 400)
    }
  }

  let table;

  // window.onload = function() {
  //   setTimeout(() => {
  //     document.body.classList.add('loaded');
  //     document.getElementById('preloader-mini').style.display = 'none';
  //   }, 2000);
  // };

  function transformType(value, object) {
    return object[value];
  }

  // FUNCION PARA VER EL PDF
  $(document).on("click", ".btn-view-pdf", function() {
    const key = $(this).data("key");

    verPdf(key);
  });

  document.addEventListener("DOMContentLoaded", async () => {
    showLoader();

    const param = new URLSearchParams(window.location.search);
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");
    const leasingId = param.get("leasingId")
    const tipoTerr = param.get("tipoTerr")
    const status = param.get("estado")

    const assigns = await getAssigns(clienteId, contratoId, leasingId, tipoTerr, status);

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
        title: `Lista de placas`,
        exportOptions: {
          modifier: {
            selected: true
          }
        },
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
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-taupe-600"></span>
              <p class="text-xs !m-0">Acta</p>
            </div>
          </div>
        `);
      },
      // ordering: false,
      scrollCollapse: true,
      scrollX: true,
      scrollY: 550,
      data: assigns,
      order: [
        [1, 'asc']
      ],
      select: {
        style: 'multi',
        selector: 'td:first-child'
      },
      "columnDefs": [{
          orderable: false,
          render: DataTable.render.select(),
          targets: 0
        },
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
        }
      ],
      columns: [{
          data: null,
          defaultContent: '',
        },
        {
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
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
          data: "cliente",
          width: "200px"
        },
        {
          data: "operacion",
          width: "150px"
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
          data: "plazo",
          render: (data) => {
            return data + ` meses`
          },
          width: "80px"
        },
        {
          data: "fechaFinCon",
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          },
          width: "120px"
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
        {
          data: "archivoPdf",
          render: (data) => {
            if (data) {
              return `
              <div class="w-full flex justify-center items-center">
                <button class="btn-view-pdf w-full flex justify-center items-center gap-1 bg-red-100 text-red-700 border border-red-700 rounded outline-none px-4 py-2 cursor-pointer" data-key="${data}">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                  <span>Ver PDF</span>
                </button>
              </div>`
            } else {
              return `<p class="!text-red-700">Sin acta</p>`
            }
          },
          width: "120px"
        }
      ],
    });

    const listClients = await getClients();

    const optClients = listClients.map(cli => ({
      id: cli.IDCLI,
      text: cli.CLINOM
    }))

    const listContracts = await getContracts();

    const optContracts = listContracts.map(cont => ({
      id: cont.ID,
      text: cont.DESCRIPCION
    }))

    const listLeasing = await getLeasings()

    const optLeasing = listLeasing.map((lea) => ({
      id: lea.NRO_LEASING,
      text: lea.NRO_LEASING
    }))

    $("#cbo-cliente").select2({
      placeholder: "Seleccione un cliente",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Todos",
        },
        ...optClients
      ],
      width: "100%"
    });

    $("#cbo-contrato").select2({
      placeholder: "Seleccione un contrato",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Todos",
        },
        ...optContracts
      ],
      width: "100%"
    });

    $("#cbo-leasing").select2({
      placeholder: "Seleccione un leasing",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Todos",
        },
        ...optLeasing
      ],
      width: "100%"
    });

    $("#cbo-terreno").select2({
      placeholder: "Seleccione un terreno",
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
      ],
      width: "100%"
    });

    $("#cbo-estado").select2({
      placeholder: "Seleccione un estado",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: "T",
          text: "Todos"
        },
        {
          id: "A",
          text: "Activos"
        },
        {
          id: "I",
          text: "Inactivos"
        },
        {
          id: "V",
          text: "Vendidos"
        },
      ],
      width: "100%"
    });

    if (clienteId) $('#cbo-cliente').val(`${clienteId}`).trigger("change");

    if (contratoId) $('#cbo-contrato').val(`${contratoId}`).trigger("change");

    if (leasingId) $('#cbo-leasing').val(`${leasingId}`).trigger("change");

    if (tipoTerr) $('#cbo-terreno').val(`${tipoTerr}`).trigger("change");

    if (status) $('#cbo-estado').val(`${status}`).trigger("change");

    hideLoader();
  })

  $('#cbo-cliente').on('select2:select', async function(e) {
    const clientId = $('#cbo-cliente').val();

    const params = new URLSearchParams(window.location.search);

    if (clientId == 0) {
      params.delete("clienteId")
    } else {
      params.set("clienteId", clientId)
    }

    const contratoId = params.get("contratoId");
    const leasingId = params.get("leasingId");
    const terrId = params.get("tipoTerr");
    const status = params.get("estado")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(clientId == 0 ? null : clientId, contratoId, leasingId, terrId, status);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });

  $('#cbo-contrato').on('change', async function(e) {
    const contractId = $('#cbo-contrato').val();

    const params = new URLSearchParams(window.location.search);

    if (contractId == 0) {
      params.delete("contratoId")
    } else {
      params.set("contratoId", contractId)
    }

    const clienteId = params.get("clienteId");
    const leasingId = params.get("leasingId");
    const terrId = params.get("tipoTerr");
    const status = params.get("estado")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(clienteId, contractId == 0 ? null : contractId, leasingId, terrId, status);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });

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
    const status = params.get("estado")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(clienteId, contratoId, leasingId != 0 ? leasingId : null, terrId, status);

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
    const status = params.get("estado")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(clienteId, contratoId, leasingId, terrId >= 4 ? null : terrId, status);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });


  $('#cbo-estado').on('change', async function(e) {
    const status = $('#cbo-estado').val();

    const params = new URLSearchParams(window.location.search);

    if (status == "T") {
      params.delete("estado")
    } else {
      params.set("estado", status)
    }

    const contratoId = params.get("contratoId");
    const clienteId = params.get("clienteId")
    const leasingId = params.get("leasingId")
    const terrId = params.get("tipoTerr");

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    const assings = await getAssigns(clienteId, contratoId, leasingId, terrId, status == "T" ? null : status);

    table.clear();
    table.rows.add(assings);
    table.draw();
  });
</script>

<?php
require './templates/footer.html';
?>