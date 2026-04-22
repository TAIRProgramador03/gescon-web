<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_leasing_by_contract.css'; ?>
</style>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DATATABLE CSS -->
<link
  href="https://cdn.datatables.net/v/dt/dt-2.3.7/fh-4.0.6/datatables.min.css"
  rel="stylesheet"
  integrity="sha384-7Hrw81H4xX5hYX7S8L0eMfpG12eNpu/o/EJa19nQ3b9LlwFZ+knIhQdpUWrM1GG0"
  crossorigin="anonymous" />
<link
  rel="stylesheet"
  href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css" />

<!-- DATATABLE JS -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script
  src="https://cdn.datatables.net/v/dt/dt-2.3.7/fh-4.0.6/datatables.min.js"
  integrity="sha384-CNOVKT615Y5C0jlUJ8NQOcckxgpoWtMsl4+LFWMwh/asaMKYPG8K0hlZayw/GSa+"
  crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- TOASTR CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- MOTION -->
<script src="https://cdn.jsdelivr.net/npm/motion@10/dist/motion.min.js"></script>

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

<main class="main-query-lea" data-route-permission="ver_leasing">
  <div class="w-full flex gap-2 items-center p-2 rounded-xl border border-gray-300 bg-white">
    <a id="crumb-first" href="" class="px-3 py-1 flex justify-center items-center gap-1 rounded-md text-blue-800 hover:bg-blue-800 hover:text-white transition-colors">
      <i class="bi bi-archive-fill"></i>
      Contratos
    </a>
    <span>/</span>
    <a id="crumb-active" class="px-3 py-1 flex justify-center items-center bg-blue-800 text-white rounded-md">
      Leasing
    </a>
  </div>

  <div class="w-full grid grid-cols-[1fr_auto] gap-6">
    <div class="w-full flex flex-col gap-3 relative px-9 py-7 bg-white border border-gray-200 rounded-xl overflow-hidden">
      <div class="w-full h-3 bg-cyan-700 absolute top-0 left-0"></div>
      <div class="w-full flex flex-col justify-center gap-2">
        <h3 class="text-5xl text-[#002141] font-semibold">Administración de leasings</h3>
        <p class="!m-0 text-base font-normal text-gray-500">Visualice y consulte la información de los leasing asociados un contrato.</p>
      </div>
      <table id="listLeasing" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">N° Leasing</th>
            <th class="text-gray-500 !font-medium">Fecha Inicio</th>
            <th class="text-gray-500 !font-medium">Fecha Fin</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
      <!-- <div class="item-result">
        <label for="descripcion-result">Descripción</label>
        <textarea id="descripcion-result" readonly></textarea>
      </div> -->
      <div class="input flex flex-col w-full relative">
        <textarea
          id="descripcion-result" name="story"
          type="text"
          placeholder="Vacío"
          class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 h-24 text-sm resize-none" disabled></textarea>
        <label
          for="descripcion-result"
          class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
          Descripción
        </label>
      </div>
    </div>

    <div class="flex flex-col gap-5 px-9 py-7 bg-white border border-gray-200 rounded-xl relative overflow-hidden">
      <div class="w-full h-3 bg-cyan-700 absolute top-0 left-0"></div>
      <div class="w-full">
        <h3 class="text-2xl text-[#002141] font-semibold">Resumen</h3>
      </div>
      <div id="skeleton-contract" class="w-[302px] hidden flex-col gap-5 items-center">
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full grid grid-cols-2 gap-2">
          <div class="w-full h-[114px] bg-slate-100 rounded animate-pulse"></div>
          <div class="w-full h-[114px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[64px] bg-slate-100 rounded animate-pulse"></div>
        </div>
      </div>
      <div id="data-leasing" class="flex flex-col gap-5">
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="vence-result" class="w-1/2">Vencimiento:</label>
          <input id="vence-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="estado-result" class="w-1/2">Estado:</label>
          <input id="estado-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="per-gra-result" class="w-1/2">Periodo de Gracia:</label>
          <input id="per-gra-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full grid grid-cols-2 gap-4">
          <div id="view-vehicle" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-cyan-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">N° Vehiculos</span>
            <div class="w-full px-2 py-3 flex flex-col justify-center items-center text-black">
              <i class="bi bi-car-front-fill text-cyan-800 text-2xl"></i>
              <p id="vehicle-result" class="!m-0 text-sm">0</p>
            </div>
          </div>
          <div id="view-assign" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-cyan-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">Veh. Asignados</span>
            <div class="w-full px-2 py-3 flex flex-col justify-center items-center text-black">
              <i class="bi bi-check-circle-fill text-cyan-800 text-2xl"></i>
              <p id="assign-result" class="!m-0 text-sm">0</p>
            </div>
          </div>
        </div>
        <button
          type="button"
          id="btn-leasing"
          class="cursor-pointer bg-red-800 text-center w-full rounded-2xl h-16 relative text-xl hidden justify-center items-center font-semibold border-4 border-white group">
          <div
            class="bg-red-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
            <i class="bi bi-file-earmark-pdf-fill"></i>
          </div>
          <p class="translate-x-4 !m-0 !text-white text-base font-medium">Ver archivo</p>
        </button>
      </div>
    </div>
  </div>
</main>

<div id="modal-leasing">
  <div class="modal-container">
    <div class="modal-header text-white">
      <i class="bi bi-info-circle text-base"></i>
      <h2 id="modal-title" class="font-medium">Detalles</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<script src="../js/consulta_leasing_por_contrato.js"></script>
<script type="module">
  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  document.title = "Administración de leasings | Gescon";

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

  let activeSkeleton = 0;

  function showSkeleton() {
    activeSkeleton++;
    $('#skeleton-contract').addClass("flex");
    $('#skeleton-contract').removeClass("hidden");

    $('#data-leasing').addClass("hidden");
    $('#data-leasing').removeClass("flex");
  }

  function hideSkeleton() {
    activeSkeleton--;
    if (activeSkeleton <= 0) {
      setTimeout(() => {
        $('#skeleton-contract').addClass("hidden");
        $('#skeleton-contract').removeClass("flex");

        $('#data-leasing').addClass("flex");
        $('#data-leasing').removeClass("hidden");
      }, 400)
    }
  }

  // window.onload = function() {
  //   setTimeout(() => {
  //     document.body.classList.add('loaded');
  //     document.getElementById('preloader-mini').style.display = 'none';
  //   }, 2000);
  // };

  function transformType(value, object) {
    return object[value];
  }

  let table;

  document.addEventListener("DOMContentLoaded", async () => {
    showLoader();

    const param = new URLSearchParams(window.location.search);
    const leasingId = param.get("leasingId");
    const nroLeasing = param.get("nroLeasing");
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");

    $('#crumb-first').prop('href', `consultar_contratos.php?clienteId=${clienteId}&contratoId=${contratoId}`);

    if (!contratoId || !clienteId) {
      toastr.warning("Faltan parametros obligatorios para realizar la consulta", "Advertencia");
    }

    table = await getLeasings(contratoId, clienteId);

    if (leasingId && nroLeasing && clienteId && contratoId) {
      $("#crumb-active").text(`${nroLeasing}`);

      const detailLeasing = await getDetailLeasing(leasingId, nroLeasing, clienteId, contratoId)

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

      $("#btn-leasing").addClass("flex");
      $("#btn-leasing").removeClass("hidden");

      $("#btn-leasing").off("click").on("click", () => {
        verPdf(detaiLeasing.archivoPdf);
      })
    }

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })

    hideLoader();
  })

  $("#listLeasing tbody").on("click", "tr", async function(e) {
    if (table.row(this).data()) {
      showSkeleton();

      $('tr').removeClass("selected-row");

      $(this).addClass("selected-row");
      const data = table.row(this).data();

      const param = new URLSearchParams(window.location.search);
      const clienteId = param.get("clienteId");
      const contratoId = param.get("contratoId");

      param.set("nroLeasing", data.nroLeasing)
      param.set("leasingId", data.id)

      $("#crumb-active").text(`${data.nroLeasing}`);

      const nuevaURL = `${window.location.pathname}?${param.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      const detaiLeasing = await getDetailLeasing(data.id, data.nroLeasing, clienteId, contratoId);

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

      $("#btn-leasing").addClass("flex");
      $("#btn-leasing").removeClass("hidden");

      $("#btn-leasing").off("click").on("click", () => {
        verPdf(detaiLeasing.archivoPdf);
      })

      hideSkeleton();
    }
  })

  $("#view-vehicle").on("click", async () => {

    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    $("#modal-title").text("N° de vehiculos detallados");

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
            <th class="!font-medium bg-yellow-500 text-white">Item</th>
            <th class="!font-medium bg-yellow-500 text-white">Placa</th>
            <th class="!font-medium bg-yellow-500 text-white">Marca</th>
            <th class="!font-medium bg-yellow-500 text-white">Modelo</th>
            <th class="!font-medium bg-yellow-500 text-white">Año</th>
            <th class="!font-medium bg-yellow-500 text-white">Color</th>
            <th class="!font-medium bg-yellow-500 text-white">Condicion</th>
            <th class="!font-medium bg-yellow-500 text-white">Terreno</th>
            <th class="!font-medium bg-yellow-500 text-white">Operación</th>
            <th class="!font-medium bg-green-500 text-white">Leasing</th>
            <th class="!font-medium bg-green-500 text-white">Fecha Inicio</th>
            <th class="!font-medium bg-green-500 text-white">Fecha Fin</th>
            <th class="!font-medium bg-green-500 text-white">Vencimiento</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVeh").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
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
          </div>
        `);
      },
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del leasing ${leasingId}`,
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
      data: vehicles,
      columnDefs: [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          className: "dt-center",
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12],
        },
      ],
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
          data: "marca",
        },
        {
          data: "modelo",
        },
        {
          data: "año",
        },
        {
          data: "color",
        },
        {
          data: "condicion",
        },
        {
          data: "terreno",
        },
        {
          data: "operacion",
        },
        {
          data: "nroLeasing"
        },
        {
          data: "fechaIni",
          render: function(data) {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            const fechaTsf = convertirFecha(data);
            const dias = obtenerDiasVencimiento(fechaTsf);
            if (dias > 0) {
              return `<p>${dias} dias</p>`
            } else if (dias < 0) {
              return `<p class="text-red-600">Hace ${Math.abs(dias)} dias</p>`
            } else {
              return `Vence hoy`
            }
          }
        }
      ],
    })

    Motion.animate(
      ".modal-container", {
        opacity: [0, 1],
        scale: [0.7, 1.05, 1],
      }, {
        duration: 0.45,
        easing: "ease-out",
      },
    );

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "flex";
  })

  $("#view-assign").on("click", async () => {

    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    $("#modal-title").text("Placas asignadas");

    const param = new URLSearchParams(window.location.search);
    const nroLeasing = param.get("nroLeasing");
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");

    if (!nroLeasing) {
      toastr.info("Debes seleccionar un leasing", "Aviso");
      return;
    }

    const vehicles = await getAssignByLeasing(nroLeasing, clienteId, contratoId);

    $("#modal-body-info").append(`
      <table id="listVehAssign" class="display">
        <thead>
          <tr>
            <th class="!font-medium bg-yellow-500 text-white">Item</th>
            <th class="!font-medium bg-yellow-500 text-white">Placa</th>
            <th class="!font-medium bg-yellow-500 text-white">Marca</th>
            <th class="!font-medium bg-yellow-500 text-white">Modelo</th>
            <th class="!font-medium bg-yellow-500 text-white">Año</th>
            <th class="!font-medium bg-yellow-500 text-white">Color</th>
            <th class="!font-medium bg-yellow-500 text-white">Condicion</th>
            <th class="!font-medium bg-yellow-500 text-white">Terreno</th>
            <th class="!font-medium bg-yellow-500 text-white">Operación</th>
            <th class="!font-medium bg-green-500 text-white">Leasing</th>
            <th class="!font-medium bg-green-500 text-white">Fecha Inicio</th>
            <th class="!font-medium bg-green-500 text-white">Fecha Fin</th>
            <th class="!font-medium bg-green-500 text-white">Vencimiento</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVehAssign").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
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
          </div>
        `);
      },
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del leasing ${nroLeasing}`,
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
      data: vehicles,
      columnDefs: [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          className: "dt-center",
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        },
      ],
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
          data: "marca",
        },
        {
          data: "modelo",
        },
        {
          data: "año",
        },
        {
          data: "color",
        },
        {
          data: "condicion",
        },
        {
          data: "terreno",
        },
        {
          data: "operacion",
        },
        {
          data: "nroLeasing"
        },
        {
          data: "fechaIni",
          render: function(data) {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            const fechaTsf = convertirFecha(data);
            const dias = obtenerDiasVencimiento(fechaTsf);
            if (dias > 0) {
              return `<p>${dias} dias</p>`
            } else if (dias < 0) {
              return `<p class="text-red-600">Hace ${Math.abs(dias)} dias</p>`
            } else {
              return `Vence hoy`
            }
          }
        }
      ],
    })

    Motion.animate(
      ".modal-container", {
        opacity: [0, 1],
        scale: [0.7, 1.05, 1],
      }, {
        duration: 0.45,
        easing: "ease-out",
      },
    );

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "flex";
  })

  $("#btn-close").on("click", async function() {
    const anim = Motion.animate(
      ".modal-container", {
        opacity: [1, 0],
        scale: [1, 1.05, 0.7],
      }, {
        duration: 0.45,
        easing: "ease-in",
      },
    );

    await anim.finished;

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>