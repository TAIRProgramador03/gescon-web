<?php
require '../templates/header.html';
?>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- CSS de Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- JS de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<!-- ESTILOS -->
<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/views/query_plate_traceability.css'; ?>
</style>

<div id="preloader-mini" class="w-full h-screen fixed top-0 left-0 z-[9999] bg-white flex flex-col justify-center items-center">
  <div class="flex-col gap-4 w-full flex items-center justify-center relative">
    <div class="w-28 h-28 border-8 text-blue-600 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-600 rounded-full"></div>
    <div class="gif-container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <img src="/public/img/carpeta.gif">
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
          Situación Actual
        </label>
      </div>
    </div>

    <div class="w-full overflow-visible">
      <table id="listAssign" class="display rounded-md">
        <thead>
          <tr>
            <th></th>
            <th class="bg-yellow-400 !text-white !font-medium">Item</th>
            <th class="bg-yellow-400 !text-white !font-medium">Placa</th>
            <th class="bg-yellow-400 !text-white !font-medium">Marca</th>
            <th class="bg-yellow-400 !text-white !font-medium">Modelo</th>
            <th class="bg-yellow-400 !text-white !font-medium">Año</th>
            <th class="bg-yellow-400 !text-white !font-medium">Color</th>
            <th class="bg-yellow-400 !text-white !font-medium">Terreno</th>
            <th class="bg-green-400 !text-white !font-medium">Leasing</th>
            <th class="bg-green-400 !text-white !font-medium">Fecha Inicio de leasing</th>
            <th class="bg-green-400 !text-white !font-medium">Fecha Fin de leasing</th>
            <th class="bg-blue-400 !text-white !font-medium">Cliente</th>
            <th class="bg-blue-400 !text-white !font-medium">Operacion</th>
            <th class="bg-blue-400 !text-white !font-medium">Contrato/Adenda</th>
            <th class="bg-blue-400 !text-white !font-medium">Fecha Firma de contrato</th>
            <th class="bg-blue-400 !text-white !font-medium">Plazo</th>
            <th class="bg-blue-400 !text-white !font-medium">Fecha Fin de contrato</th>
            <th class="bg-blue-400 !text-white !font-medium">Tarifa</th>
            <th class="bg-blue-400 !text-white !font-medium">Moneda</th>
            <th class="bg-taupe-600 text-white !font-medium">Fecha de Acta de Entrega</th>
            <th class="bg-taupe-600 text-white !font-medium">Fecha Devolucion</th>
            <th class="bg-taupe-600 text-white !font-medium">Condicion</th>
            <th class="bg-taupe-600 text-white !font-medium">% de contrato</th>
            <th class="bg-taupe-600 text-white !font-medium">Situación Actual</th>
            <th class="bg-taupe-600 text-white !font-medium">Acta</th>
            <th class="bg-taupe-600 text-white !font-medium">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- MODAL EDITAR PLACAS -->
<div id="modal-assign" class="w-full h-screen fixed top-0 left-0 flex justify-center items-center opacity-0 -z-[9990] overflow-hidden">
  <div class="modal-overlay w-full h-screen fixed top-0 left-0 bg-black/25 -z-10 overflow-hidden"></div>
  <div class="modal-container w-full max-w-lg max-h-[90%] bg-white rounded-md overflow-auto">
    <div class="w-full flex items-center gap-2 bg-yellow-700 text-white font-semibold p-2">
      <i class="bi bi-info-circle"></i>
      <h2 class="text-2xl">Actualizar placa</h2>
    </div>
    <div class="w-full flex flex-col gap-2 p-2">
      <!-- FECHA ENTREGA -->
      <div class="input flex flex-col w-full relative">
        <input
          id="fechaEntrega"
          name="fechaEntrega"
          type="text"
          placeholder="Ingrese una fecha"
          class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
        <label
          for="fechaEntrega"
          class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
          Fecha Entrega(*)
        </label>
      </div>

      <!-- FECHA DEVOLUCION -->
      <div class="input flex flex-col w-full relative">
        <input
          id="fechaDevolucion"
          name="fechaDevolucion"
          type="text"
          placeholder="Ingrese una fecha"
          class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
        <label
          for="fechaDevolucion"
          class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
          Fecha Devolución(*)
        </label>
      </div>

      <!-- TERRENO -->
      <div class="flex flex-col w-full relative">
        <select name="terreno" id="cbo-terreno-upd">
        </select>

        <label
          for="cbo-terreno-upd"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Tipo de terreno(*)
        </label>
      </div>

      <!-- CONDICION -->
      <div class="flex flex-col w-full relative">
        <select name="condicion" id="cbo-condicion-upd">
        </select>

        <label
          for="cbo-condicion-upd"
          class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
          Condicion(*)
        </label>
      </div>

      <!-- ACTA -->
      <div class="flex flex-col w-full relative">
        <label class="text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors z-[1]">Acta(*)</label>
        <div class="file-adjunta">
          <label class="file-upload tooltip-input" id="dropZone" data-tooltip="Arrastra o sube tu archivo PDF">
            <div id="uploadMessage" class="flex flex-col gap-1 justify-center items-center text-[#b2b2bb]">
              <i class="bi bi-cloud-upload-fill text-3xl"></i>
              <span>Haz clic o arrastra un archivo aquí</span>
            </div>
            <input type="file" id="fileInput" accept=".pdf">
            <div class="file-info" id="fileInfo">
              <img src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Icon">
              <span id="fileName"></span>
              <button class="view-file" id="viewFile">👁️</button>
              <button class="remove-file" id="removeFile">X</button>
            </div>
          </label>
        </div>
      </div>
    </div>
    <div class="w-full flex justify-end items-center gap-2 border-t border-t-gray-300 p-2">
      <button id="btn-save" class="px-3 py-2 font-medium flex justify-center items-center cursor-pointer bg-green-700 text-white hover:bg-green-600 rounded transition-colors">Guardar</button>
      <button id="btn-cancel" class="px-3 py-2 font-medium flex justify-center items-center cursor-pointer bg-slate-900 text-white hover:bg-slate-800 rounded transition-colors">Cancelar</button>
    </div>
  </div>
</div>

<!-- MODAL HISTORIAL DE MOVIMIENTOS -->
<div id="modal-history" class="w-full h-screen fixed top-0 left-0 flex justify-center items-center opacity-0 -z-[9990] overflow-hidden">
  <div class="modal-overlay-hist w-full h-screen fixed top-0 left-0 bg-black/25 -z-10 overflow-hidden"></div>
  <div class="modal-container-hist w-[80%] h-[90%] flex flex-col gap-3 bg-white rounded-md overflow-hidden relative px-4 py-5">
    <div class="w-full h-2 bg-yellow-400 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-1">
      <h3 class="text-2xl text-[#002141] font-semibold">Historial de movimientos</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Visualice todas las reasignaciones que se realizaron para este vehiculo.</p>
    </div>
    <div class="w-full h-full grid grid-cols-2 gap-3 overflow-hidden">
      <ul class="list-history w-full h-full flex flex-col gap-3 border border-gray-100 rounded-md p-3 overflow-auto">
      </ul>
      <div class="w-full h-full flex flex-col gap-3 border border-gray-100 rounded-md p-3 overflow-auto">
        <div class="w-full flex justify-between items-center">
          <h3 class="text-2xl text-[#002141] font-semibold">Información</h3>
          <p class="text-lg text-[#002141] font-semibold fecha-info"></p>
        </div>
        <div class="w-full flex flex-col gap-3">
          <div class="w-full flex flex-col gap-3 border border-gray-100 rounded-md px-4 py-2 relative overflow-hidden">
            <div class="w-2 h-full bg-red-400 absolute top-0 left-0"></div>
            <h3 class="text-lg text-[#002141] font-semibold">Anterior</h3>

            <div class="w-full grid grid-cols-3 gap-3 anterior-info">
              <p class="w-full flex flex-col gap-2">
                Operación:
                <span class="operacion-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Tarifa:
                <span class="tarifa-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Nro Contrato:
                <span class="nro-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Tipo:
                <span class="tipo-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Condicion:
                <span class="condicion-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Terreno:
                <span class="terreno-info text-sm text-gray-600">--</span>
              </p>
              <div class="w-full flex flex-col gap-2">
                Archivo:
                <div class="archivo-info text-sm text-gray-600">--</div>
              </div>
            </div>
          </div>
          <div class="w-full flex justify-center items-center"><i class="bi bi-arrow-down-circle-fill text-blue-600 text-2xl animate-bounce"></i></div>
          <div class="w-full flex flex-col gap-3 border border-gray-100 rounded-md px-4 py-2 relative overflow-hidden">
            <div class="w-2 h-full bg-green-400 absolute top-0 left-0"></div>
            <h3 class="text-lg text-[#002141] font-semibold">Nueva</h3>

            <div class="w-full grid grid-cols-3 gap-3 nuevo-info">
              <p class="w-full flex flex-col gap-2">
                Operación:
                <span class="operacion-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Tarifa:
                <span class="tarifa-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Nro Contrato:
                <span class="nro-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Tipo:
                <span class="tipo-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Condicion:
                <span class="condicion-info text-sm text-gray-600">--</span>
              </p>
              <p class="w-full flex flex-col gap-2">
                Terreno:
                <span class="terreno-info text-sm text-gray-600">--</span>
              </p>
              <div class="w-full flex flex-col gap-2">
                Archivo:
                <div class="archivo-info text-sm text-gray-600">--</div>
              </div>
            </div>
          </div>
          <!-- OBSERVACION -->
          <div class="input flex flex-col w-full relative -mt-2!">
            <textarea
              id="observacion"
              name="observacion"
              type="text"
              placeholder="Ingrese la observación"
              class="peer order-2 w-full h-24 resize-none border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" readonly></textarea>
            <label
              for="observacion"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
              Observación
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="tooltip-global" class="fixed z-[9999] opacity-0 pointer-events-none transition-opacity duration-200 flex flex-col justify-center items-center">
  <div class="tooltip-content px-2 py-1 text-xs text-white bg-blue-700 rounded-md shadow-lg max-w-[280px] text-center break-words"></div>
  <div class="tooltip-arrow w-2 h-2 bg-blue-700 rotate-45 mx-auto -mt-1!"></div>
</div>

<script type="module" src="/js/consulta_trazabilidad_placa.js"></script>
<script type="module">
  import {
    getAssigns,
    getClients,
    getContracts,
    verPdf,
    getLeasings,
    calcularPorcentaje,
    subirArchivo,
    updateAssign,
    clearFields,
    getHistory,
    getHistoryById,
    convertirFecha,
    generarExcel
  } from "/js/consulta_trazabilidad_placa.js";

  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  document.title = "Trazabilidad de placas | Gescon";

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

  let currentId;

  let dataAssign;

  let currentRow;

  let currentReasign = null;

  let fp = null;

  let fp2 = null;

  function transformType(value, object) {
    return object[value];
  }

  // DRAG AND DROP FILES

  const viewFileButton = document.getElementById('viewFile');
  const fileInput = document.getElementById('fileInput');
  const dropZone = document.getElementById('dropZone');
  const fileInfo = document.getElementById('fileInfo');
  const fileNameDisplay = document.getElementById('fileName');
  const uploadMessage = $('#uploadMessage');
  const removeFileButton = document.getElementById('removeFile');

  // Mostrar nombre del archivo al seleccionar
  fileInput.addEventListener('change', handleFile);

  // Eventos para drag and drop
  dropZone.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
  });

  dropZone.addEventListener('drop', (event) => {
    event.preventDefault();
    dropZone.classList.remove('dragover');

    const file = event.dataTransfer.files[0];
    if (file) {
      fileInput.files = event.dataTransfer.files; // Asignar archivo al input
      handleFile();
    }
  });

  function handleFile() {
    const file = fileInput.files[0];
    if (file) {
      uploadMessage.addClass("hidden"); // Muestra el mensaje inicial.
      uploadMessage.removeClass("flex"); // Muestra el mensaje inicial.
      fileInfo.style.display = 'flex'; // Mostrar el área con el archivo
      fileNameDisplay.textContent = truncateFileName(file.name); // Mostrar el nombre truncado del archivo
    }
  }

  function truncateFileName(name) {
    const maxLength = 25;
    if (name.length <= maxLength) return name;

    const fileExtension = name.slice(name.lastIndexOf('.'));
    const truncatedName = name.slice(0, maxLength - fileExtension.length - 3);
    return truncatedName + '...' + fileExtension;
  }

  // FUNCION PARA VER EL PDF
  $(document).on("click", ".btn-view-pdf", function() {
    const key = $(this).data("key");

    verPdf(key);
  });

  // FUNCION PARA VER HISTORIAL
  $(document).on("click", ".btn-view-history", async function() {
    const key = $(this).data("key");
    const history = await getHistory(key);

    $("#modal-history").removeClass("opacity-0 -z-[9990]").addClass("opacity-100 z-[9990]")

    animate(".modal-container-hist", {
      opacity: [0, 1],
      scale: [0.7, 1.05, 1]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })

    // AGREGAMOS LA CABECERA
    $(".list-history").append(`
      <li class="w-full border border-gray-100 rounded-md flex items-center gap-3 text-sm text-gray-400 font-medium p-2 text-center" data-idReassign="1">
        <div class="w-full max-w-[50px] flex justify-center items-center">
          <span>Item</span>
        </div>
        <span class="w-full">Fecha del cambio</span>
        <span class="w-full">Operacion anterior</span>
        <div class="w-full max-w-[15px] flex justify-center items-center">
        </div>
        <span class="w-full">Operacion nueva</span>
      </li>
    `)

    // AGREGAMOS LA INFORMACIÓN
    $(".list-history").append(history.length > 0 ? history.map((hst, i) => (
      `
      <li class="itm-reasign cursor-pointer w-full border border-gray-100 rounded-md flex items-center gap-3 text-sm text-gray-700 p-2 text-center hover:bg-blue-300 transition-colors" data-key="${hst.id}">
        <div class="w-full max-w-[50px] flex justify-center items-center">
          <span>${i + 1}</span>
        </div>
        <span class="w-full">${dayjs(convertirFecha(hst.fecha)).format("DD/MM/YYYY")}</span>
        <span class="w-full">${hst.opeAnterior}</span>
        <div class="w-full max-w-[15px] flex justify-center items-center">
          <i class="bi bi-arrow-right font-bold text-blue-600 text-lg"></i>
        </div>
        <span class="w-full">${hst.opeNueva}</span>
      </li>
      `
    )) : `
      <li class="w-full border border-gray-100 rounded-md flex items-center gap-3 text-sm text-gray-700 p-2 text-center">
        <span class="w-full text-center">No se encontraron registros</span>
      </li>
    `)
  });

  $(document).on("click", ".itm-reasign", async function() {
    const key = $(this).data("key");

    if (currentReasign && currentReasign == key) return;

    clearItmReasing();

    $(".itm-reasign").removeClass("bg-blue-300");
    $(this).addClass("bg-blue-300");

    currentReasign = key;

    const findAssing = await getHistoryById(key);

    $(".fecha-info").text(`(${dayjs(convertirFecha(findAssing.fecha)).format("DD/MM/YYYY")})`);
    $('textarea[name=observacion]').text(`${findAssing.observacion}`);

    $(".anterior-info").find(".operacion-info").text(findAssing.anterior.operacion)
    $(".anterior-info").find(".tarifa-info").text(findAssing.anterior.tarifa)
    $(".anterior-info").find(".nro-info").text(findAssing.anterior.contrato)
    $(".anterior-info").find(".tipo-info").text(findAssing.anterior.tipo == 'P' ? "Contrato" : "Documento")
    $(".anterior-info").find(".condicion-info").text(findAssing.anterior.condicion)
    $(".anterior-info").find(".terreno-info").text(findAssing.anterior.terreno)

    // MOSTRAR ARCHIVO ANTERIOR
    $(".anterior-info").find(".archivo-info").empty();
    $(".anterior-info").find(".archivo-info").append(findAssing.anterior.archivo ? `
                <button class="btn-view-pdf-anterior w-full flex justify-center items-center gap-1 bg-red-100 text-red-700 border border-red-700 rounded outline-none px-4 py-2 cursor-pointer" data-key="${findAssing.anterior.archivo}">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                  <span>Ver PDF</span>
                </button>
    ` : `<p class="text-red-500!">Sin acta</p>`);

    $(".nuevo-info").find(".operacion-info").text(findAssing.nuevo.operacion)
    $(".nuevo-info").find(".tarifa-info").text(findAssing.nuevo.tarifa)
    $(".nuevo-info").find(".nro-info").text(findAssing.nuevo.contrato)
    $(".nuevo-info").find(".tipo-info").text(findAssing.nuevo.tipo == 'P' ? "Contrato" : "Documento")
    $(".nuevo-info").find(".condicion-info").text(findAssing.nuevo.condicion);
    $(".nuevo-info").find(".terreno-info").text(findAssing.nuevo.terreno);

    // MOSTRAR ARCHIVO NUEVO
    $(".nuevo-info").find(".archivo-info").empty();
    $(".nuevo-info").find(".archivo-info").append(findAssing.nuevo.archivo ? `
                <button class="btn-view-pdf-nuevo w-full flex justify-center items-center gap-1 bg-red-100 text-red-700 border border-red-700 rounded outline-none px-4 py-2 cursor-pointer" data-key="${findAssing.nuevo.archivo}">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                  <span>Ver PDF</span>
                </button>
    ` : `<p class="text-red-500!">Sin acta</p>`);
  })

  $(document).on("click", ".btn-view-pdf-anterior", function() {
    const key = $(this).data("key");

    verPdf(key);
  });

  $(document).on("click", ".btn-view-pdf-nuevo", function() {
    const key = $(this).data("key");

    verPdf(key);
  });

  function clearItmReasing() {
    $(".fecha-info").empty();
    $('textarea[name=observacion]').empty();

    $(".anterior-info").find(".operacion-info").text("--")
    $(".anterior-info").find(".tarifa-info").text("--")
    $(".anterior-info").find(".nro-info").text("--")
    $(".anterior-info").find(".tipo-info").text("--")
    $(".anterior-info").find(".condicion-info").text("--")
    $(".anterior-info").find(".terreno-info").text("--")
    $(".anterior-info").find(".archivo-info").text("--")

    $(".nuevo-info").find(".operacion-info").text("--")
    $(".nuevo-info").find(".tarifa-info").text("--")
    $(".nuevo-info").find(".nro-info").text("--")
    $(".nuevo-info").find(".tipo-info").text("--")
    $(".nuevo-info").find(".condicion-info").text("--")
    $(".nuevo-info").find(".terreno-info").text("--")
    $(".nuevo-info").find(".archivo-info").text("--")
  }

  $(".modal-overlay-hist").on("click", async function() {
    const anim = animate(".modal-container-hist", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })

    await anim.finished;

    $("#modal-history").removeClass("opacity-100 z-[9990]").addClass("opacity-0 -z-[9990]");

    $(".list-history").empty();

    currentReasign = null;

    clearItmReasing();
  })

  document.addEventListener("DOMContentLoaded", async () => {
    showLoader();

    fileInfo.style.display = 'none'; // Asegúrate de que la información del archivo no aparezca.
    uploadMessage.addClass("flex"); // Muestra el mensaje inicial.
    uploadMessage.removeClass("hidden"); // Muestra el mensaje inicial.
    fileInput.value = ''; // Limpia el campo de archivo si existe algo previamente.

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
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        modifier: {
          selected: true
        },
        rows: function(idx, data, node) {
          const selected = table.rows({
            selected: true
          }).any();
          return selected ? $(node).hasClass('selected') : true;
        },
        action: async function(e, dt, button, config) {
          const selectedRows = dt.rows({
            selected: true
          }).data().toArray();

          const dataRow = selectedRows.length > 0 ?
            selectedRows :
            dt.rows({
              search: 'applied'
            }).data().toArray();

          await generarExcel(dataRow, "Reporte de Placas");
        }
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
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25]
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
          data: "marca",
          width: "80px"
        },
        {
          data: "modelo",
          width: "150px"
        },
        {
          data: "año"
        },
        {
          data: "color",
          width: "100px"
        },
        {
          data: "terreno",
          render: (data) => {
            return transformType(data, {
              0: "Superficie",
              1: "Socavón",
              2: "Ciudad",
              3: "Severo",
              4: "Pendiente"
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
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "fechaFin",
          render: (data) => {
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY")
          },
          width: "120px"
        },
        {
          data: "condicion",
          render: (data) => {
            return transformType(data, {
              0: "Titular",
              1: "Retén",
              2: "Logística",
              3: "Pendiente"
            })
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
                  <span class="numero-porcentaje ${colorText}">${result.toFixed(2)}%</span>
                </div>
              `
            }
          },
          width: "120px"
        },
        {
          data: null,
          render: (data, type, row) => {
            const dateFinish = dayjs(convertirFecha(row.fechaFin))
            const isGreater = dateFinish.isAfter(dayjs()); // VERIFICAMOS SI ESTA VENCIDO O NO

            const status = row.idOpeActual == 109 ? "Vendido" : row.idOpe != row.idOpeActual ? isGreater ? row.idCliCont == row.idCliOpe ? "Por Actualizar" : "Por Reasignar" : "Inactivo" : "Activo";
            const color = row.idOpeActual == 109 ? "bg-yellow-100 border-yellow-500 text-yellow-500" : row.idOpe != row.idOpeActual ? isGreater ? row.idCliCont == row.idCliOpe ? "bg-violet-100 border-violet-500 text-violet-500" : "bg-orange-100 border-orange-500 text-orange-500" : "bg-red-100 border-red-500 text-red-500" : "bg-green-100 border-green-500 text-green-500";

            return `<div class="w-full rounded font-medium px-2 py-1 border ${color}"><span>${status}</span></div>`
          },
          width: "120px"
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
        },
        {
          data: "idAssing",
          render: (data) => {
            if (data) {
              return `
              <div class="w-full flex justify-center items-center">
                <button class="btn-view-history w-full flex justify-center items-center gap-1 bg-blue-100 text-blue-700 border border-blue-700 rounded outline-none px-4 py-2 cursor-pointer" data-key="${data}">
                  <i class="bi bi-card-list"></i>
                  <span>Movimientos</span>
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
          id: 5,
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
        },
        {
          id: 4,
          text: "Pendiente"
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
          id: "PR",
          text: "Por Reasignar"
        },
        {
          id: "PA",
          text: "Por Actualizar"
        },
        {
          id: "V",
          text: "Vendidos"
        },
      ],
      width: "100%"
    });

    $("#cbo-terreno-upd").select2({
      placeholder: "Seleccione un terreno",
      allowClear: false,
      data: [{
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
        },
        {
          id: 4,
          text: "Pendiente"
        }
      ],
      width: "100%"
    })

    $("#cbo-condicion-upd").select2({
      placeholder: "Seleccione una condición",
      allowClear: false,
      data: [{
          id: 0,
          text: "Titular"
        },
        {
          id: 1,
          text: "Retén"
        },
        {
          id: 2,
          text: "Logística"
        },
        {
          id: 3,
          text: "Pendiente"
        }
      ],
      width: "100%"
    })

    fp = flatpickr("#fechaEntrega", {
      dateFormat: "d/m/Y",
      locale: "es",
      allowInput: true,
      clickOpens: true,
    });

    fp2 = flatpickr("#fechaDevolucion", {
      dateFormat: "d/m/Y",
      locale: "es",
      allowInput: true,
      clickOpens: true,
    });

    if (clienteId) $('#cbo-cliente').val(`${clienteId}`).trigger("change");

    if (contratoId) $('#cbo-contrato').val(`${contratoId}`).trigger("change");

    if (leasingId) $('#cbo-leasing').val(`${leasingId}`).trigger("change");

    if (tipoTerr) $('#cbo-terreno').val(`${tipoTerr}`).trigger("change");

    if (status) $('#cbo-estado').val(`${status}`).trigger("change");

    hideLoader();
  })

  const validInputDate = (e) => {
    let value = e.target.value.replace(/\D/g, ""); // solo números

    if (value.length >= 3 && value.length <= 4) {
      value = value.slice(0, 2) + "/" + value.slice(2);
    } else if (value.length >= 5) {
      value =
        value.slice(0, 2) + "/" + value.slice(2, 4) + "/" + value.slice(4, 8);
    }

    e.target.value = value;
  };

  document.getElementById("fechaEntrega").addEventListener("input", function(e) {
    validInputDate(e);
  });

  document.getElementById("fechaDevolucion").addEventListener("input", function(e) {
    validInputDate(e);
  });

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

    if (terrId >= 5) {
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

    const assings = await getAssigns(clienteId, contratoId, leasingId, terrId >= 5 ? null : terrId, status);

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

  $('#listAssign tbody').on('dblclick', 'tr', function() {
    // Get row data using the DataTables API
    const data = table.row(this).data();

    currentRow = table.row($(this).closest('tr'));

    currentId = data.idAssing;

    dataAssign = {
      fechaEntrega: convertirFecha(data.fechaIni),
      fechaDevolucion: convertirFecha(data.fechaFin),
      condicion: data.condicion,
      terreno: data.terreno,
      archivoPdf: data.archivoPdf
    }

    const dateInit = dayjs(convertirFecha(data.fechaIni));
    const dateEnd = dayjs(convertirFecha(data.fechaFin));

    $("#fechaEntrega").val(dateInit.format("DD/MM/YYYY"));
    $("#fechaDevolucion").val(dateEnd.format("DD/MM/YYYY"));
    $('#cbo-terreno-upd').val(`${data.terreno}`).trigger("change");
    $('#cbo-condicion-upd').val(`${data.condicion}`).trigger("change");


    const dateObj = dateInit.toDate();
    const dateObj2 = dateEnd.toDate();

    fp.jumpToDate(dateObj);
    fp.setDate(dateObj, true);

    fp2.jumpToDate(dateObj2);
    fp2.setDate(dateObj2, true);

    // if (data.terreno == "4") {
    //   $('#cbo-terreno-upd').prop("disabled", false)
    // } else {
    //   $('#cbo-terreno-upd').prop("disabled", true)
    // }

    if (data.condicion == "3") {
      $('#cbo-condicion-upd').prop("disabled", false)
    } else {
      $('#cbo-condicion-upd').prop("disabled", true)
    }

    if (data.archivoPdf == "") {
      $('#fileInput').prop("disabled", false);
      $("#uploadMessage").addClass("flex").removeClass("hidden");
      fileInfo.style.display = "none"
      $("#fileName").text("");
      removeFileButton.style.display = "flex";
      $("#viewFile").show();
    } else {
      $('#fileInput').prop("disabled", true);
      $("#uploadMessage").removeClass("flex").addClass("hidden");
      fileInfo.style.display = "flex"
      $("#fileName").text(data.archivoPdf.split("/")[1]);
      removeFileButton.style.display = "none";
      $("#viewFile").hide();
    }

    $("#modal-assign").addClass("opacity-100 z-[9999]").removeClass("opacity-0 -z-[9999]")

    animate(".modal-container", {
      opacity: [0, 1],
      scale: [0.75, 1.05, 1]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })
  });

  $("#btn-save").on("click", async function() {
    const fechaInicio = dayjs($('#fechaEntrega').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
    const fechaFin = dayjs($('#fechaDevolucion').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
    const terreno = $('#cbo-terreno-upd').val();
    const condicion = $('#cbo-condicion-upd').val();
    const file = fileInput.files[0];
    let archivoPdf = dataAssign.archivoPdf;

    if (file) {
      const uploadFile = await subirArchivo(fileInput.files[0]);
      archivoPdf = uploadFile.key;
    }

    const data = {
      id: currentId,
      fechaInicio,
      fechaFin,
      terreno,
      condicion,
      archivoPdf: archivoPdf == '' ? null : archivoPdf
    }

    await updateAssign(currentId, data);

    const rowData = currentRow.data();

    rowData.fechaIni = dayjs(fechaInicio).format("YYYYMMDD");
    rowData.fechaFin = dayjs(fechaFin).format("YYYYMMDD");
    rowData.terreno = terreno;
    rowData.condicion = condicion;
    rowData.archivoPdf = archivoPdf.replace(/^temp\//, "");

    currentRow.data(rowData).draw(false);
  })

  $("#btn-cancel").on("click", async function() {
    clearFields()
  })

  viewFileButton.addEventListener('click', () => {
    const file = fileInput.files[0];

    if (file && file.type === 'application/pdf') {
      const fileURL = URL.createObjectURL(file);
      window.open(fileURL, '_blank');
    }
  });

  removeFileButton.addEventListener('click', () => {
    fileInput.value = ''; // Limpiar input
    fileInfo.style.display = 'none'; // Ocultar el área del archivo
    uploadMessage.addClass("flex"); // Muestra el mensaje inicial.
    uploadMessage.removeClass("hidden"); // Muestra el mensaje inicial. // Mostrar mensaje de carga
  });


  const tooltip = document.getElementById("tooltip-global");
  const tooltipText = tooltip.querySelector(".tooltip-content");

  // INICIO VALORIZACION
  $(document).on("mouseenter", 'th[data-dt-column="19"]', function() {
    const rect = this.getBoundingClientRect();

    tooltipText.innerText = "Inicio de valorización";
    tooltip.style.opacity = 1;

    // 🔥 importante: esperar a que renderice
    requestAnimationFrame(() => {
      const tooltipWidth = tooltip.offsetWidth;
      const tooltipHeight = tooltip.offsetHeight;

      tooltip.style.top = (rect.top - tooltipHeight - 8) + "px";
      tooltip.style.left = (rect.left + rect.width / 2 - tooltipWidth / 2) + "px";
    });
  });

  $(document).on("mouseleave", 'th[data-dt-column="19"]', function() {
    tooltip.style.opacity = 0;
  });

  // OPERATIVIDAD
  $(document).on("mouseenter", 'th[data-dt-column="23"]', function() {
    const rect = this.getBoundingClientRect();

    tooltipText.innerHTML = `
      <div class="flex flex-col gap-2 text-justify!">
        <div><span class="font-medium uppercase">Activo:</span> Unidades operativas en el mismo cliente donde fue asignado inicialmente (GESCON / GESOPER).</div>
        <div><span class="font-medium uppercase">Inactivo:</span> Unidades que están operando en el mismo cliente con el contrato vencido (GESCON).</div>
        <div><span class="font-medium uppercase">Por Reasignar:</span> Unidades que se cambiaron de cliente y continuan pendientes por asignar (GESOPER/GESCON).</div>
        <div><span class="font-medium uppercase">Por Actualizar:</span> Unidades que se cambiaron de operación dentro del mismo cliente (GESOPER/GESCON).</div>
        <div><span class="font-medium uppercase">Vendido:</span> Unidad actualmente fuera de flota, Tair Vendidas (GESOPER).</div>
      </div>
    `;
    tooltip.style.opacity = 1;

    // 🔥 importante: esperar a que renderice
    requestAnimationFrame(() => {
      const tooltipWidth = tooltip.offsetWidth;
      const tooltipHeight = tooltip.offsetHeight;

      tooltip.style.top = (rect.top - tooltipHeight - 8) + "px";
      tooltip.style.left = (rect.left + rect.width / 2 - tooltipWidth / 2) + "px";
    });
  });

  $(document).on("mouseleave", 'th[data-dt-column="23"]', function() {
    tooltip.style.opacity = 0;
  });
</script>

<?php
require '../templates/footer.html';
?>