<?php
require './templates/header.html';
?>
<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<!-- jQuery (Necesario) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- CSS de Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- JS de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<!-- TOASTR -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- END TOASTR -->

<!-- ESTILOS -->
<style>
  <?php include '../css/views/register_contract.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
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

<main class="main-register" data-route-permission="insertar_contratos">
  <div class="contenedor border border-gray-300 px-9 py-7 relative overflow-hidden">
    <div class="w-full h-3 bg-blue-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 id="title-form" class="text-5xl text-[#002141] font-semibold">Registrar Contrato</h3>
      <p id="desc-form" class="!m-0 text-base font-normal text-gray-500">Gestione el registro de un nuevo contrato vinculado a un cliente.</p>
    </div>
    <div class="form-registrar flex flex-col gap-2">
      <div class="form-one">
        <!-- CLIENTE -->
        <div class="flex flex-col w-full relative">
          <select id="combo-cliente" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente">
            <option value="">Seleccione un cliente</option>
          </select>

          <label
            for="combo-cliente"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Razón Social(*)
          </label>
        </div>

        <!-- NRO CONTRATO -->
        <div class="input flex flex-col w-full relative">
          <input
            id="contrato"
            name="Contrato"
            type="text"
            placeholder="CLIENTE-MM-AAAA-0001"
            data-tooltip="El número del contrato debe ser un correlativo (CLIENTE-MM-AAAA-0001)"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="contrato"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            N° de Contrato(*)
          </label>
        </div>

        <!-- FECHA FIRMA -->
        <div class="input flex flex-col w-full relative">
          <input
            id="firma"
            name="Firma"
            type="text"
            placeholder="Ingrese una fecha"
            data-tooltip="Fecha de la firma del contrato"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="firma"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Fecha Firma(*)
          </label>
        </div>

        <!-- DURACION -->
        <div class="input flex flex-col w-full relative">
          <input
            id="duracion"
            name="Duracion"
            type="number"
            placeholder="Ingrese la duración"
            data-tooltip="Duracion del contrato en meses"
            class="no-negative peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="duracion"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Duracion (Meses)(*)
          </label>
        </div>

        <!-- TIPO MONEDA -->
        <div class="flex flex-col w-full relative">
          <select id="combo-moneda" name="opciones" class="tooltip-input">
            <option value="">Seleccione una moneda</option>
            <option value="0">Soles</option>
            <option value="1">Dólares</option>
          </select>

          <label
            for="combo-moneda"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Tipo Moneda(*)
          </label>
        </div>

        <!-- RUBRO DE EMPRESA -->
        <div class="flex flex-col w-full relative">
          <select id="combo-tipo" name="opciones" class="tooltip-input" data-tooltip="Selecciona el rubro del cliente">
            <option value="">Seleccione un tipo</option>
            <option value="1">AVICOLA</option>
            <option value="2">CONTRATISTA MINERA</option>
            <option value="3">ENERGIA</option>
            <option value="4">GOBIERNO</option>
            <option value="5">INMOBILIARIA</option>
            <option value="6">MINERIA</option>
            <option value="7">PESQUERA</option>
            <option value="8">SEGURIDAD</option>
            <option value="9">TELEFONIA</option>
            <option value="10">TRANSPORTES</option>
            <option value="11">OTROS</option>
          </select>

          <label
            for="combo-tipo"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Rubro de empresa
          </label>
        </div>
      </div>
      <div class="form-two">
        <!-- KM ADICIONAL -->
        <div class="input flex flex-col w-full relative">
          <input
            id="adicional"
            name="Adicional"
            type="text"
            placeholder="Ingrese el km adicional"
            value="0"
            data-tooltip="Tarifa por km adicional de recorrido 0.000"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="adicional"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            $ KM Adicional(*)
          </label>
        </div>

        <!-- BOLSA KM TOTAL -->
        <div class="input flex flex-col w-full relative">
          <input
            id="bolsa"
            name="Bolsa"
            type="text"
            placeholder="Ingrese el km total"
            value="0"
            data-tooltip="Km total a recorrer por unidad"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="bolsa"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Bolsa KM Total(*)
          </label>
        </div>

        <!-- CANTIDAD VEHICULOS -->
        <div class="input flex flex-col w-full relative">
          <input
            id="vehiculos"
            name="Vehiculos"
            type="number"
            min="0"
            placeholder="Ingrese la cantidad de vehiculos"
            value="0"
            data-tooltip="Cantidad de vehiculos contratados"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input no-negative" />
          <label
            for="vehiculos"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Cant. de Vehiculos(*)
          </label>
        </div>

        <!-- VEH SUP -->
        <div class="input flex flex-col w-full relative">
          <input
            id="sup"
            name="Sup"
            type="number"
            min="0"
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Superficie"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input no-negative" />
          <label
            for="sup"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            # Veh. Sup(*)
          </label>
        </div>

        <!-- VEH SOC -->
        <div class="input flex flex-col w-full relative">
          <input
            id="soc"
            name="Soc"
            type="number"
            min="0"
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Socavón"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input no-negative" />
          <label
            for="soc"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            # Veh. Soc(*)
          </label>
        </div>

        <!-- VEH CIU -->
        <div class="input flex flex-col w-full relative">
          <input
            id="ciu"
            name="Ciu"
            type="number"
            min="0"
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Ciudad"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input no-negative" />
          <label
            for="ciu"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            # Veh. Ciu(*)
          </label>
        </div>

        <!-- VEH SEV -->
        <div class="input flex flex-col w-full relative">
          <input
            id="sev"
            name="Sev"
            type="number"
            min="0"
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Severo"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input no-negative" />
          <label
            for="sev"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            # Veh. Sev(*)
          </label>
        </div>
      </div>
      <div class="form-six">
        <!-- SUBIR ARCHIVO -->
        <div class="flex flex-col w-full relative">
          <label class="text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors z-[1]">Adjunta archivo(*)</label>
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

      <!--agregar una columna mas-->
      <div class="form-seven">
        <div class="tabla-form">
          <div class="tabla-add-vehicle w-full flex justify-between items-end">
            <div class="flex gap-3 items-center">
              <button id="addVehicle" class="btn bg-blue-600 text-white h-fit">
                <span>Agregar modelo</span>
                <span>
                  <i class="bi bi-car-front"></i>
                  <i class="bi bi-plus"></i>
                </span>
              </button>
              <button id="exportVehicle" class="btn bg-green-600 text-white h-fit">
                <span>Exportar</span>
                <i class="bi bi-file-earmark-excel"></i>
              </button>
            </div>

            <!-- CONTRATO ESPECIAL -->
            <div class="flex flex-col justify-end items-end gap-2">
              <label for="combo-box" class="text-gray-500 text-xs font-semibold">Contrato Especial</label>
              <!-- <input id="especial" name="especial" type="checkbox" class="check-form-contrato tooltip-input" data-tooltip="Contrato especial, Cuando un contrato tiene varios periodos de finalización."> -->
              <label class="relative inline-flex w-fit items-center cursor-pointer">
                <input class="sr-only peer" value="" type="checkbox" id="especial" name="especial">
                <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
                </div>
              </label>
            </div>
          </div>
          <div class="max-h-[400px] overflow-y-auto">
            <table id="tabla-dinamica" class="w-full border-collapse">
              <thead>
                <tr>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Item</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Modelo</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Tipo terreno</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Tarifa</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">CPK</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">RM</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Cantidad</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">$ KM Adi.</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Duracion</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Compra Veh. ($)</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Venta Veh. ($)</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Condición</th>
                  <th class="sticky top-0 bg-white z-20 border px-2 py-2">Accion</th>
                </tr>
              </thead>
              <tbody id="contratos-tbody" class="table-detalle">
                <!-- filas dinámicas -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--agregar una columna mas-->

      <div class="form-cliente-cbo">
        <!-- <div class="cbo-registrar">
          <label for="combo-box">Descripcion:</label>
          <textarea id="story" name="story" rows="4" placeholder="" class="area-campo tooltip-input border border-gray-300 rounded-sm focus:outline-1 focus:outline-blue-500 focus:shadow-sm" data-tooltip="Ingrese aqui algun comentario adicional"></textarea>
        </div> -->

        <div class="input flex flex-col w-full relative">
          <textarea
            id="story"
            name="story"
            placeholder="Escribe una descripción"
            data-tooltip="Ingrese aqui algun comentario adicional"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] h-24 text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></textarea>
          <label
            for="contrato"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Descripción
          </label>
        </div>
      </div>
      <div class="form-cliente-cbo">
        <div class="cbo-registrar body">
          <button
            type="button"
            id="btnClear"
            class="cursor-pointer bg-yellow-700 text-center w-1/4 rounded-2xl h-16 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
            <div
              class="bg-yellow-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
              <i class="bi bi-stars"></i>
            </div>
            <p class="translate-x-4 !m-0 !text-white text-base font-medium">Limpiar</p>
          </button>
          <button
            type="button"
            id="grabarButton"
            class="cursor-pointer bg-green-700 text-center w-1/4 rounded-2xl h-16 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
            <div
              class="bg-green-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
              <i class="bi bi-floppy-fill"></i>
            </div>
            <p class="translate-x-4 !m-0 !text-white text-base font-medium">Registrar</p>
          </button>
          <button
            type="button"
            id="actualizarButton"
            class="cursor-pointer bg-blue-700 text-center w-1/4 rounded-2xl h-16 relative text-xl hidden justify-center items-center font-semibold border-4 border-white group">
            <div
              class="bg-blue-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
              <i class="bi bi-pencil-fill"></i>
            </div>
            <p class="translate-x-4 !m-0 !text-white text-base font-medium">Actualizar</p>
          </button>
        </div>
      </div>
    </div>
  </div>
</main>

<div id="pdfModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" id="closeModal">&times;</span>
    <iframe id="modalPdfViewer" width="100%" height="600px"></iframe>
  </div>
</div>

<div id="alert-modal">
  <div class="alert-bg"></div>
  <div class="alert-container">
  </div>
</div>

<!-- SCRIPTS -->
<script type="module">
  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  document.title = "Registrar Contrato | Gescon";

  document.addEventListener("DOMContentLoaded", function() {
    const tooltip = document.createElement("div");

    tooltip.style.position = "fixed";
    tooltip.style.background = "black";
    tooltip.style.color = "white";
    tooltip.style.padding = "5px 10px";
    tooltip.style.borderRadius = "5px";
    tooltip.style.fontSize = "12px";
    tooltip.style.display = "none";
    tooltip.style.opacity = "0";
    tooltip.style.transition = "opacity 0.2s ease-in-out";
    tooltip.style.zIndex = "1000";
    tooltip.style.whiteSpace = "nowrap";
    document.body.appendChild(tooltip);

    document.addEventListener("mouseenter", function(event) {
      if (!event.target || !event.target.classList) return; // Evita error en `null`
      if (event.target.classList.contains("tooltip-input")) {
        const tooltipText = event.target.getAttribute("data-tooltip");
        if (!tooltipText) return;

        tooltip.textContent = tooltipText;
        tooltip.style.display = "block";
        tooltip.style.opacity = "1";
      }
    }, true);

    document.addEventListener("mousemove", function(event) {
      if (!event.target || !event.target.classList) return; // Evita error en `null`
      if (event.target.classList.contains("tooltip-input")) {
        let x = event.clientX + 10;
        let y = event.clientY + 10;

        if (x + tooltip.offsetWidth > window.innerWidth) {
          x = event.clientX - tooltip.offsetWidth - 10;
        }
        if (y + tooltip.offsetHeight > window.innerHeight) {
          y = event.clientY - tooltip.offsetHeight - 10;
        }

        tooltip.style.left = `${x}px`;
        tooltip.style.top = `${y}px`;
      }
    });

    document.addEventListener("mouseleave", function(event) {
      if (!event.target || !event.target.classList) return; // Evita error en `null`
      if (event.target.classList.contains("tooltip-input")) {
        tooltip.style.opacity = "0";
        setTimeout(() => {
          tooltip.style.display = "none";
        }, 200);
      }
    }, true);
  });

  const fileInput = document.getElementById('fileInput');
  const dropZone = document.getElementById('dropZone');
  const fileInfo = document.getElementById('fileInfo');
  const fileNameDisplay = document.getElementById('fileName');
  const uploadMessage = $('#uploadMessage');
  const removeFileButton = document.getElementById('removeFile');

  window.onload = function() {
    // setTimeout(() => {
    //   document.body.classList.add('loaded');
    //   document.getElementById('preloader-mini').style.display = 'none';
    // }, 2000);

    fileInfo.style.display = 'none'; // Asegúrate de que la información del archivo no aparezca.
    uploadMessage.addClass("flex"); // Muestra el mensaje inicial.
    uploadMessage.removeClass("hidden"); // Muestra el mensaje inicial.
    fileInput.value = ''; // Limpia el campo de archivo si existe algo previamente.
  };

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

  // INPUTS NUMBER NO NEGATIVE
  const inputsNumber = document.querySelectorAll('.no-negative');

  inputsNumber.forEach(input => {

    const check = () => {
      if (!input.validity.valid) input.value = 0;
      if (+input.value < 0) input.value = 0;
    };

    input.addEventListener('input', check);
    input.addEventListener('blur', check);

  });

  document.addEventListener("input", function(e) {

    if (!e.target.classList.contains("no-negative")) return;

    const input = e.target;

    if (!input.validity.valid) input.value = 0;
    if (+input.value < 0) input.value = 0;

  });

  document.addEventListener("blur", function(e) {

    if (!e.target.classList.contains("no-negative")) return;

    const input = e.target;

    if (!input.validity.valid) input.value = 0;
    if (+input.value < 0) input.value = 0;

  }, true);

  // Mostrar archivo y cambiar el contenido visual
  function handleFile() {
    const file = fileInput.files[0];
    if (file) {
      uploadMessage.addClass("hidden"); // Muestra el mensaje inicial.
      uploadMessage.removeClass("flex"); // Muestra el mensaje inicial.
      fileInfo.style.display = 'flex'; // Mostrar el área con el archivo
      fileNameDisplay.textContent = truncateFileName(file.name); // Mostrar el nombre truncado del archivo
    }
  }

  const viewFileButton = document.getElementById('viewFile');
  const pdfModal = document.getElementById('pdfModal');
  const modalPdfViewer = document.getElementById('modalPdfViewer');
  const closeModal = document.getElementById('closeModal');

  // Evento para abrir el modal con vista previa
  viewFileButton.addEventListener('click', () => {
    const file = fileInput.files[0];
    if (file && file.type === 'application/pdf') {
      const fileURL = URL.createObjectURL(file);
      modalPdfViewer.src = fileURL;
      pdfModal.style.display = 'block';
    }
  });

  // Cerrar modal
  closeModal.addEventListener('click', () => {
    pdfModal.style.display = 'none';
    modalPdfViewer.src = '';
  });

  // Cerrar modal al hacer clic fuera del contenido
  window.addEventListener('click', (event) => {
    if (event.target === pdfModal) {
      pdfModal.style.display = 'none';
      modalPdfViewer.src = '';
    }
  });



  // Función para truncar el nombre del archivo
  function truncateFileName(name) {
    const maxLength = 25;
    if (name.length <= maxLength) return name;

    const fileExtension = name.slice(name.lastIndexOf('.'));
    const truncatedName = name.slice(0, maxLength - fileExtension.length - 3);
    return truncatedName + '...' + fileExtension;
  }

  // Eliminar archivo seleccionado
  removeFileButton.addEventListener('click', () => {
    fileInput.value = ''; // Limpiar input
    fileInfo.style.display = 'none'; // Ocultar el área del archivo
    uploadMessage.addClass("flex"); // Muestra el mensaje inicial.
    uploadMessage.removeClass("hidden"); // Muestra el mensaje inicial. // Mostrar mensaje de carga
    pdfPreview.src = '';
    pdfPreviewContainer.style.display = 'none';
  });

  /*$(document).ready(function() {
      $("#tipoTerreno").select2({
          placeholder: "Seleccione el tipo",
          allowClear: false // Desactiva la "X"
      });
  });*/

  $(document).ready(function() {
    $("#combo-cliente").select2({
      placeholder: "Seleccione un cliente",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    $("#combo-moneda").select2({
      placeholder: "Seleccione una moneda",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    $("#combo-tipo").select2({
      placeholder: "Seleccione un tipo",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    $("#tipoModelo").select2({
      placeholder: "Seleccione el modelo",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    $("#tipoTerreno").select2({
      placeholder: "Seleccione el terreno",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });
  });

  flatpickr("#firma", {
    dateFormat: "d/m/Y",
    locale: "es",
    allowInput: true,
    clickOpens: true,
  });

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

  document.getElementById("firma").addEventListener("input", function(e) {
    validInputDate(e);
  });
</script>
<script type="module" src="../js/registrar_contratos.js"></script>


<?php
require './templates/footer.html';
?>