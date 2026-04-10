<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_documents_by_contract.css'; ?>
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

<main class="main-query-doc" data-route-permission="ver_documentos">
  <div class="w-full flex gap-2 items-center p-2 rounded-xl border border-gray-300 bg-white">
    <a id="crumb-first" href="" class="px-3 py-1 flex justify-center items-center gap-1 rounded-md text-blue-800 hover:bg-blue-800 hover:text-white transition-colors">
      <i class="bi bi-archive-fill"></i>
      Contratos
    </a>
    <span>/</span>
    <a id="crumb-active" class="px-3 py-1 flex justify-center items-center bg-blue-800 text-white rounded-md">
      Documentos
    </a>
  </div>

  <div class="w-full grid grid-cols-[1fr_auto] gap-6">
    <div class="w-full flex flex-col gap-3 relative px-9 py-7 bg-white border border-gray-200 rounded-xl overflow-hidden">
      <div class="w-full h-3 bg-taupe-700 absolute top-0 left-0"></div>
      <div class="w-full flex flex-col justify-center gap-2">
        <h3 class="text-5xl text-[#002141] font-semibold">Administración de documentos</h3>
        <p class="!m-0 text-base font-normal text-gray-500">Visualice y consulte la información de los documentos asociados un contrato.</p>
      </div>
      <table id="listDocuments" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">N° Documento</th>
            <th class="text-gray-500 !font-medium">Fecha Firma</th>
            <th class="text-gray-500 !font-medium">Duracion</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
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
      <div class="w-full h-3 bg-taupe-700 absolute top-0 left-0"></div>
      <div class="w-full">
        <h3 class="text-2xl text-[#002141] font-semibold">Resumen</h3>
      </div>

      <div id="skeleton-contract" class="w-[271px] hidden flex-col gap-5 items-center">
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full grid grid-cols-4 gap-2">
          <div class="w-full h-[82px] bg-slate-100 rounded animate-pulse"></div>
          <div class="w-full h-[82px] bg-slate-100 rounded animate-pulse"></div>
          <div class="w-full h-[82px] bg-slate-100 rounded animate-pulse"></div>
          <div class="w-full h-[82px] bg-slate-100 rounded animate-pulse"></div>
        </div>
        <div class="w-full h-[110px] bg-slate-100 rounded animate-pulse"></div>
        <div class="w-full">
          <div class="w-full h-[64px] bg-slate-100 rounded animate-pulse"></div>
        </div>
      </div>

      <div id="data-document" class="flex flex-col gap-5">
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="fec-fin-result" class="w-1/2">Fecha Fin:</label>
          <input id="fec-fin-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="estado-result" class="w-1/2">Estado:</label>
          <input id="estado-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="tipo-result" class="w-1/2">Tipo de Doc:</label>
          <input id="tipo-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="motivo-result" class="w-1/2">Motivo:</label>
          <input id="motivo-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="km-total-result" class="w-1/2">Km Total:</label>
          <input id="km-total-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="w-full flex items-center gap-3 justify-evenly text-sm">
          <label for="km-adi-result" class="w-1/2">Km Adicional:</label>
          <input id="km-adi-result" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>

        <ul class="w-full grid grid-cols-4 gap-2">
          <li id="sup-modal" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-taupe-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">Sup</span>
            <p id="sup-result" class="w-full px-2 py-3 flex flex-col justify-center items-center text-black !m-0 text-sm">0</p>
          </li>
          <li id="sev-modal" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-taupe-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">Sev</span>
            <p id="sev-result" class="w-full px-2 py-3 flex flex-col justify-center items-center text-black !m-0 text-sm">0</p>
          </li>
          <li id="soc-modal" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-taupe-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">Soc</span>
            <p id="soc-result" class="w-full px-2 py-3 flex flex-col justify-center items-center text-black !m-0 text-sm">0</p>
          </li>
          <li id="ciu-modal" class="flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
            <span class="w-full bg-taupe-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">Ciu</span>
            <p id="ciu-result" class="w-full px-2 py-3 flex flex-col justify-center items-center text-black !m-0 text-sm">0</p>
          </li>
        </ul>
        <div id="view-leasings" class="leasing-result flex flex-col border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
          <span class="w-full bg-taupe-800 flex justify-center items-center px-2 py-2 text-white text-sm font-medium">N° Leasings</span>
          <div class="card-lea w-full px-2 py-3 flex flex-col justify-center items-center text-black">
            <i class="fa fa fa-book text-taupe-800 text-2xl"></i>
            <p id="leasing-result" class="!m-0 text-sm">0</p>
          </div>
        </div>
        <button
          type="button"
          id="btn-document"
          class="cursor-pointer bg-indigo-800 text-center w-full rounded-2xl h-16 relative text-xl hidden justify-center items-center font-semibold border-4 border-white group">
          <div
            class="bg-indigo-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
            <i class="bi bi-box-arrow-up-right"></i>
          </div>
          <p class="translate-x-4 !m-0 !text-white text-base font-medium">Ver archivo</p>
        </button>
      </div>
    </div>
  </div>
</main>

<div id="modal-documents">
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

<script src="../js/consulta_documentos_por_contrato.js"></script>
<script type="module">
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

  let activeSkeleton = 0;

  function showSkeleton() {
    activeSkeleton++;
    $('#skeleton-contract').addClass("flex");
    $('#skeleton-contract').removeClass("hidden");

    $('#data-document').addClass("hidden");
    $('#data-document').removeClass("flex");
  }

  function hideSkeleton() {
    activeSkeleton--;
    if (activeSkeleton <= 0) {
      setTimeout(() => {
        $('#skeleton-contract').addClass("hidden");
        $('#skeleton-contract').removeClass("flex");

        $('#data-document').addClass("flex");
        $('#data-document').removeClass("hidden");
      }, 400)
    }
  }

  // window.onload = function() {
  //   setTimeout(() => {
  //     document.body.classList.add('loaded');
  //     document.getElementById('preloader-mini').style.display = 'none';
  //   }, 2000);
  // };

  document.addEventListener("DOMContentLoaded", async () => {
    showLoader();

    const param = new URLSearchParams(window.location.search);
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");
    const documentoId = param.get("documentoId")
    const nroDoc = param.get("nroDoc")

    $('#crumb-first').prop('href', `consultar_contratos.php?clienteId=${clienteId}&contratoId=${contratoId}`);

    if (!contratoId || !clienteId) alert("No se encontraron los parametros necesarios")

    const documents = await getDocuments(contratoId, clienteId);

    const table = $("#listDocuments").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "500px",
      scrollCollapse: true,
      dom: 'rt<"inferior"i<"derecha-inferior"lp>>',
      data: documents,
      columnDefs: [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          className: "dt-center",
          targets: [0, 1, 2, 3, 4],
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
          data: "nroDocumento",
        },
        {
          data: "fechaFirma",
          render: function(data) {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          },
          width: "20%",
        },
        {
          data: "duracion",
          render: function(data) {
            return data && data != "0" ? data + " meses" : "Sin periodo";
          },
          width: "20%",
        },
        {
          data: "cantVehi",
          render: (data) => {
            return `${data} und.`
          },
          width: "5%"
        },
      ],
    });

    if (documentoId && !isNaN(documentoId)) {
      const detailDocument = await getDetailDocument(Number(documentoId));

      const fechaIni = convertirFecha(detailDocument.firma)
      const fechaFin = calcularFechaFin(fechaIni, detailDocument.duracion);
      const estado = obtenerEstado(fechaFin);

      // INPUTS DE DATOS
      $("#fec-fin-result").val(dayjs(fechaFin).format("DD/MM/YYYY"));
      $("#estado-result").val(estado);
      $("#tipo-result").val(detailDocument.tipoDocumento);
      $("#motivo-result").val(detailDocument.motivoDoc);
      $("#km-total-result").val(detailDocument.kmTotal);
      $("#km-adi-result").val(detailDocument.kmAdi);
      $("#descripcion-result").val(detailDocument.descripcion);

      // VEHICULOS POR TERRENOS
      $("#sup-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSup : 0);
      $("#sev-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSev : 0);
      $("#soc-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSoc : 0);
      $("#ciu-result").text(detailDocument.cantLea > 0 ? detailDocument.vehCiu : 0);

      // CANTIDAD LEASING
      $("#leasing-result").text(detailDocument.cantLea);

      $("#btn-document").addClass("flex");
      $("#btn-document").removeClass("hidden");

      // ABRIR EL PDF
      $("#btn-document").off("click").on("click", () => {
        window.open(detailDocument.archivoPdf, '_blank');
      })
    }

    if (nroDoc) {
      $("#crumb-active").text(`${nroDoc}`);
    }

    $("#listDocuments tbody").on("click", "tr", async function() {
      if (table.row(this).data()) {
        showSkeleton();

        $('tr').removeClass("selected-row");

        $(this).addClass("selected-row");

        const data = table.row(this).data();

        param.set("documentoId", data.id)
        param.set("nroDoc", data.nroDocumento)

        $("#crumb-active").text(`${data.nroDocumento}`);

        const nuevaURL = `${window.location.pathname}?${param.toString()}`;
        window.history.replaceState({}, "", nuevaURL);

        const detailDocument = await getDetailDocument(data.id);

        const fechaIni = convertirFecha(detailDocument.firma)
        const fechaFin = calcularFechaFin(fechaIni, detailDocument.duracion);
        const estado = obtenerEstado(fechaFin);

        // INPUTS DE DATOS
        $("#fec-fin-result").val(dayjs(fechaFin).format("DD/MM/YYYY"));
        $("#estado-result").val(estado);
        $("#tipo-result").val(detailDocument.tipoDocumento);
        $("#motivo-result").val(detailDocument.motivoDoc);
        $("#km-total-result").val(detailDocument.kmTotal);
        $("#km-adi-result").val(detailDocument.kmAdi);
        $("#descripcion-result").val(detailDocument.descripcion);

        // VEHICULOS POR TERRENOS
        $("#sup-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSup : 0);
        $("#sev-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSev : 0);
        $("#soc-result").text(detailDocument.cantLea > 0 ? detailDocument.vehSoc : 0);
        $("#ciu-result").text(detailDocument.cantLea > 0 ? detailDocument.vehCiu : 0);

        // CANTIDAD LEASING
        $("#leasing-result").text(detailDocument.cantLea);

        $("#btn-document").addClass("flex");
        $("#btn-document").removeClass("hidden");

        // ABRIR EL PDF
        // $("#btn-document").off("click").on("click", () => {
        //   window.open(detailDocument.archivoPdf, '_blank');
        // })

        hideSkeleton();
      }
    })

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })

    hideLoader();
  })

  $("#sup-modal").on("click", async () => {
    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SUPERFICIE");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSup" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">Placa</th>
            <th class="text-gray-500 !font-medium">Modelo</th>
            <th class="text-gray-500 !font-medium">Marca</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
            <th class="text-gray-500 !font-medium">Año</th>
            <th class="text-gray-500 !font-medium">Color</th>
            <th class="text-gray-500 !font-medium">Operación</th>
            <th class="text-gray-500 !font-medium">Fecha Fin</th>
            <th class="text-gray-500 !font-medium">Vence en</th>
            <th class="text-gray-500 !font-medium">Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVehSup").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas Superficie del documento ${documentoId}`,
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
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
          data: "modelo",
        },
        {
          data: "marca",
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
            if (data) {
              return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
            } else {
              return "--"
            }
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            if (data) {
              const fechaTsf = convertirFecha(data);
              const dias = obtenerDiasVencimiento(fechaTsf);
              if (dias > 0) {
                return `${dias} dias`
              } else if (dias < 0) {
                return `Hace ${Math.abs(dias)} dias`
              } else {
                return `Vence hoy`
              }
            } else {
              return "--"
            }
          }
        },
        {
          data: "nroLeasing"
        }
      ],
    })
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#sev-modal").on("click", async () => {
    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SEVERO");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSev" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">Placa</th>
            <th class="text-gray-500 !font-medium">Modelo</th>
            <th class="text-gray-500 !font-medium">Marca</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
            <th class="text-gray-500 !font-medium">Año</th>
            <th class="text-gray-500 !font-medium">Color</th>
            <th class="text-gray-500 !font-medium">Operación</th>
            <th class="text-gray-500 !font-medium">Fecha Fin</th>
            <th class="text-gray-500 !font-medium">Vence en</th>
            <th class="text-gray-500 !font-medium">Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVehSev").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas Servero del documento ${documentoId}`,
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
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
          data: "modelo",
        },
        {
          data: "marca",
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
            if (data) {
              return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
            } else {
              return "--"
            }
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            if (data) {
              const fechaTsf = convertirFecha(data);
              const dias = obtenerDiasVencimiento(fechaTsf);
              if (dias > 0) {
                return `${dias} dias`
              } else if (dias < 0) {
                return `Hace ${Math.abs(dias)} dias`
              } else {
                return `Vence hoy`
              }
            } else {
              return "--"
            }
          }
        },
        {
          data: "nroLeasing"
        }
      ],
    })
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#soc-modal").on("click", async () => {
    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SOCAVON");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSoc" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">Placa</th>
            <th class="text-gray-500 !font-medium">Modelo</th>
            <th class="text-gray-500 !font-medium">Marca</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
            <th class="text-gray-500 !font-medium">Año</th>
            <th class="text-gray-500 !font-medium">Color</th>
            <th class="text-gray-500 !font-medium">Operación</th>
            <th class="text-gray-500 !font-medium">Fecha Fin</th>
            <th class="text-gray-500 !font-medium">Vence en</th>
            <th class="text-gray-500 !font-medium">Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVehSoc").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas Socavón del documento ${documentoId}`,
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
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
          data: "modelo",
        },
        {
          data: "marca",
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
            if (data) {
              return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
            } else {
              return "--"
            }
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            if (data) {
              const fechaTsf = convertirFecha(data);
              const dias = obtenerDiasVencimiento(fechaTsf);
              if (dias > 0) {
                return `${dias} dias`
              } else if (dias < 0) {
                return `Hace ${Math.abs(dias)} dias`
              } else {
                return `Vence hoy`
              }
            } else {
              return "--"
            }
          }
        },
        {
          data: "nroLeasing"
        }
      ],
    })
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#ciu-modal").on("click", async () => {
    const perm = isPermission("ver_placas");

    if (!perm) {
      return;
    }

    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "CIUDAD");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehCiu" class="display">
        <thead>
          <tr>
            <th class="text-gray-500 !font-medium">Item</th>
            <th class="text-gray-500 !font-medium">Placa</th>
            <th class="text-gray-500 !font-medium">Modelo</th>
            <th class="text-gray-500 !font-medium">Marca</th>
            <th class="text-gray-500 !font-medium">Cantidad</th>
            <th class="text-gray-500 !font-medium">Año</th>
            <th class="text-gray-500 !font-medium">Color</th>
            <th class="text-gray-500 !font-medium">Operación</th>
            <th class="text-gray-500 !font-medium">Fecha Fin</th>
            <th class="text-gray-500 !font-medium">Vence en</th>
            <th class="text-gray-500 !font-medium">Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

    $("#listVehCiu").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: "300px",
      scrollCollapse: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas Ciudad del documento ${documentoId}`,
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
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
          data: "modelo",
        },
        {
          data: "marca",
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
            if (data) {
              return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
            } else {
              return "--"
            }
          }
        },
        {
          data: "fechaFin",
          render: function(data) {
            if (data) {
              const fechaTsf = convertirFecha(data);
              const dias = obtenerDiasVencimiento(fechaTsf);
              if (dias > 0) {
                return `${dias} dias`
              } else if (dias < 0) {
                return `Hace ${Math.abs(dias)} dias`
              } else {
                return `Vence hoy`
              }
            } else {
              return "--"
            }
          }
        },
        {
          data: "nroLeasing"
        }
      ],
    })
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-documents");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })

  $("#view-leasings").on("click", () => {
    const perm = isPermission("ver_leasing");

    if (!perm) {
      return;
    }

    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const documentoId = params.get("documentoId")
    const contratoId = params.get("contratoId")
    const nroDoc = params.get("nroDoc")

    if (!documentoId || !clienteId) return;

    window.location.href = `consultar_leasing_por_documento.php?documentoId=${documentoId}&clienteId=${clienteId}&contratoId=${contratoId}&nroDoc=${nroDoc}`;
  })
</script>

<?php
require './templates/footer.html';
?>