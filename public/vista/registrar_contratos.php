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

<!-- TOASTR -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- END TOASTR -->

<!-- ESTILOS -->
<style>
  <?php include '../css/views/register_contract.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
<div id="preloader-mini">
  <div class="gif-container">
    <img src="../img/carpeta.gif" alt="Cargando...">
  </div>
  <div class="welcome-message">
    <p>¡Cargando!.....</p>
  </div>
</div>

<main class="main-register">
  <!-- <div id="notification" class="hidden"></div> -->
  <div class="w-full bg-white border border-gray-300 rounded-xl shadow-md flex flex-col justify-center !p-3">
    <h3 id="title-form" class="text-3xl text-[#002141] font-semibold">Registrar Contrato</h3>
    <p class="!m-0 text-sm font-normal text-gray-500">Crear un nuevo contrato para un cliente</p>
  </div>

  <div class="contenedor border border-gray-300">
    <div class="form-registrar">
      <div class="form-cliente-cbo px-5">
        <!-- <div class="cbo-registrar">
          <label for="combo-cliente">Razon Social(*):</label>
          <select id="combo-cliente" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente">
            <option value="">Seleccione un cliente</option>
          </select>
        </div> -->
        <div class="flex flex-col w-full relative">
          <select id="combo-cliente" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente">
            <option value="">Seleccione un cliente</option>
          </select>

          <!-- El label DEBE estar después del select en el HTML -->
          <label
            for="combo-cliente"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Razon Social(*)
          </label>
        </div>
      </div>
      <!--<div id="tooltip"></div>-->
      <div class="form-one px-5">

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

        <!-- CANTIDAD VEHICULOS -->
        <div class="input flex flex-col w-full relative">
          <input
            id="vehiculos"
            name="Vehiculos"
            type="number"
            placeholder="Ingrese una cantidad de vehiculos"
            value="0"
            data-tooltip="Cantidad de vehiculos contratados"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="vehiculos"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Cant. de Vehiculos(*)
          </label>
        </div>

        <!-- FECHA FIRMA -->
        <div class="input flex flex-col w-full relative">
          <input
            id="firma"
            name="Firma"
            type="text"
            placeholder="Ingrese una fehca"
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
            type="text"
            placeholder="CLIENTE-MM-AAAA-0001"
            data-tooltip="Duracion del contrato en meses"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="duracion"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Duracion (Meses)(*)
          </label>
        </div>
        <!-- <div class="form-cliente">
          <label for="combo-box">N° de Contrato(*):</label>
          <input id="contrato" name="Contrato" type="text" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" data-tooltip="El número del contrato debe ser un correlativo (CLIENTE-MM-AAAA-0001)">
        </div> -->
        <!-- <div class="form-cliente">
          <label for="combo-box">Cant. Vehiculos(*):</label>
          <input id="vehiculos" name="Vehiculos" type="number" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" value="0" data-tooltip="Cantidad de vehiculos contratados">
        </div> -->
      </div>
      <div class="form-two px-5">
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

        <!-- <div class="form-cliente custom-date">
          <label for="combo-box">Fecha Firma(*):</label>
          <input id="firma" name="Firma" type="text" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm dta tooltip-input" data-tooltip="Fecha de la firma del contrato">
        </div> -->
        <!-- <div class="form-cliente">
          <label for="combo-box">Duracion (Meses):</label>
          <input id="duracion" name="Duracion" type="text" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" data-tooltip="Duracion del contrato en meses">
        </div> -->
      </div>
      <div class="form-three px-5">
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


        <!-- <div class="form-cliente">
          <label for="combo-box">Tipo Moneda(*):</label>
          <select id="combo-moneda" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Tipo de moneda soles o dolares">
            <option value="">Seleccione una moneda</option>
            <option value="0">Soles</option>
            <option value="1">Dolares</option>
          </select>
        </div> -->
        <!-- <div class="form-cliente">
          <label for="combo-box">Rubro de empresa:</label>
          <select id="combo-tipo" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el rubro del cliente">
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
        </div> -->
      </div>
      <div class="form-four px-5">
        <!-- VEH SUP -->
        <div class="input flex flex-col w-full relative">
          <input
            id="sup" 
            name="Sup" 
            type="number"
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Superficie"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
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
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Socavón"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
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
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Ciudad"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
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
            placeholder="Ingrese cantidad"
            value="0"
            data-tooltip="Cantidad de vehículos en Severo"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="sev"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            # Veh. Sev(*)
          </label>
        </div>
        <!-- <div class="form-cliente">
          <label for="combo-box">$ KM Adicional:</label>
          <input id="adicional" name="Adicional" type="text" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" data-tooltip="Tarifa por km adicional de recorrido 0.000">
        </div> -->
        <!-- <div class="form-cliente">
          <label for="combo-box">Bolsa KM Total:</label>
          <input id="bolsa" name="Bolsa" type="text" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" data-tooltip="Km total a recorrer por unidad">
        </div> -->
      </div>
      <div class="form-five">
        <!-- <div class="form-cliente">
          <label for="combo-box"># Veh. Sup(*):</label>
          <input id="sup" name="Sup" type="number" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input " value="0" data-tooltip="Cantidad de vehículos en Superficie">
        </div>
        <div class="form-cliente">
          <label for="combo-box"># Veh. Soc(*):</label>
          <input id="soc" name="Soc" type="number" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Socavon">
        </div>
      </div>
      <div class="form-six">
        <div class="form-cliente">
          <label for="combo-box"># Veh. Ciu(*):</label>
          <input id="ciu" name="Ciu" type="number" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Ciudad">
        </div>
        <div class="form-cliente">
          <label for="combo-box"># Veh. Sev(*):</label>
          <input id="sev" name="Sev" type="number" class="w-[60%] px-1 py-2 border border-gray-300 rounded focus:outline-1 focus:outline-blue-500 focus:shadow-sm tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Severo">
        </div> -->
      </div>
      <div class="form-six px-5">
        <div class="form-cliente adjunto-pdf h-48">
          <label for="combo-box">Adjuntar pdf:</label>
          <div class="file-adjunta">
            <label class="file-upload tooltip-input !h-36" id="dropZone" data-tooltip="Arrastra o seleccione un archivo en pdf">
              <span id="uploadMessage">Haz clic o arrastra un archivo aquí</span>
              <input type="file" id="fileInput" accept=".pdf" data-tooltip="Arrastra o seleccione un archivo en pdf">
              <div class="file-info" id="fileInfo">
                <img src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Icon">
                <span id="fileName"></span>
                <button class="view-file" id="viewFile">👁️</button>
                <button class="remove-file" id="removeFile">X</button>
              </div>
            </label>
          </div>
        </div>
        <div class="form-cliente form-especial">
          <label for="combo-box">Contrato Especial:</label>
          <input id="especial" name="especial" type="checkbox" class="check-form-contrato tooltip-input" data-tooltip="Contrato especial, Cuando un contrato tiene varios periodos de finalización.">
        </div>
      </div>
      <!--agregar una columna mas-->
      <div class="form-seven">
        <div class="tabla-form">
          <div class="tabla-add-vehicle flex gap-3">
            <button id="addVehicle" class="btn bg-blue-600 text-white">
              <span>Agregar vehiculo</span>
              <span>
                <i class="bi bi-car-front"></i>
                <i class="bi bi-plus"></i>
              </span>
            </button>
            <button id="exportVehicle" class="btn bg-green-600 text-white">
              <span>Exportar</span>
              <i class="bi bi-file-earmark-excel"></i>
            </button>
          </div>
          <table id="tabla-dinamica" class="w-full">
            <thead>
              <tr>
                <th>Item</th>
                <th>Modelo</th>
                <th>Tipo terreno</th>
                <th>Tarifa</th>
                <th>CPK</th>
                <th>RM</th>
                <th>Cantidad</th>
                <th>Duracion</th>
                <th>Compra Veh. ($)</th>
                <th>Venta Veh. ($)</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody id="contratos-tbody" class="table-detalle">

            </tbody>
          </table>
        </div>
      </div>
      <!--agregar una columna mas-->
      <div class="form-cliente-cbo">
        <div class="cbo-registrar">
          <label for="combo-box">Descripcion:</label>
          <textarea id="story" name="story" rows="4" placeholder="" class="area-campo tooltip-input border border-gray-300 rounded-sm focus:outline-1 focus:outline-blue-500 focus:shadow-sm" data-tooltip="Ingrese aqui algun comentario adicional"></textarea>
        </div>
      </div>
      <div class="form-cliente-cbo">
        <div class="cbo-registrar body">
          <button class="clear-action" id="btnClear">
            <div>
              <div class="broom"></div>
              <div class="trash">
                <div class="trash-top">
                  <svg viewBox="0 0 24 27">
                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                  </svg>
                </div>
                <div class="paper-clear"></div>
              </div>
            </div>
            Limpiar
          </button>
          <button class="continue-application" id="grabarButton">
            <div>
              <div class="pencil"></div>
              <div class="folder">
                <div class="top">
                  <svg viewBox="0 0 24 27">
                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                  </svg>
                </div>
                <div class="paper"></div>
              </div>
            </div>
            Grabar
          </button>
          <button class="btn-update" id="actualizarButton">
            <div>
              <div class="pencil"></div>
              <div class="folder">
                <div class="top">
                  <svg viewBox="0 0 24 27">
                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                  </svg>
                </div>
                <div class="paper"></div>
              </div>
            </div>
            Actualizar
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
  const uploadMessage = document.getElementById('uploadMessage');
  const removeFileButton = document.getElementById('removeFile');

  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
    fileInfo.style.display = 'none'; // Asegúrate de que la información del archivo no aparezca.
    uploadMessage.style.display = 'block'; // Muestra el mensaje inicial.
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

  // Mostrar archivo y cambiar el contenido visual
  function handleFile() {
    const file = fileInput.files[0];
    if (file) {
      uploadMessage.style.display = 'none'; // Ocultar mensaje de carga
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
    uploadMessage.style.display = 'block'; // Mostrar mensaje de carga
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
      allowClear: false // Desactiva la "X"
    });

    $("#combo-moneda").select2({
      placeholder: "Seleccione una moneda",
      allowClear: false // Desactiva la "X"
    });

    $("#combo-tipo").select2({
      placeholder: "Seleccione un tipo",
      allowClear: false // Desactiva la "X"
    });

    $("#tipoModelo").select2({
      placeholder: "Seleccione el modelo",
      allowClear: false // Desactiva la "X"
    });

    $("#tipoTerreno").select2({
      placeholder: "Seleccione el terreno",
      allowClear: false // Desactiva la "X"
    });
  });

  flatpickr("#firma", {
    dateFormat: "d/m/Y"
  });
</script>
<script type="module" src="../js/registrar_contratos.js"></script>


<?php
require './templates/footer.html';
?>