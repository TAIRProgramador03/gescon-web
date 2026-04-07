<?php
require './templates/header.html';
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

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
  <?php include '../css/views/register_leasing.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
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

<main class="main-register">
  <div class="contenedor h-fit border rounded-xl border-gray-300 px-9 py-7 relative overflow-hidden">
    <div class="w-full h-3 bg-cyan-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Registrar Leasing</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione el registro de un nuevo leasing para el cliente seleccionado.</p>
    </div>
    <div class="form-cuerpo flex flex-col gap-6">

      <!-- FILA 1 -->
      <div class="w-full grid grid-cols-3 items-start gap-4">
        <div class="w-full flex items-end gap-2">
          <div class="flex flex-col w-full relative">
            <input
              id="inputClienteSeleccionado"
              type="text"
              placeholder="Seleccione el cliente"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs text-black bg-white border-2 rounded-[5px] focus:outline-none placeholder:text-black/25 tooltip-input"
              readonly />
            <label
              for="inputClienteSeleccionado"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Cliente(*)
            </label>
            <button id="openModalCli" class="absolute right-0 bottom-0 px-[14px] text-xs py-[11px] bg-cyan-600/10 border-2 border-cyan-600 text-cyan-600 rounded-sm outline-none cursor-pointer hover:bg-cyan-600 hover:text-white transition-colors tooltip-input" data-tooltip="Busque el cliente">
              <i class="bi bi-search"></i>
            </button>
          </div>

        </div>
        <div class="input flex flex-col w-full relative">
          <input
            id="NroLeasing"
            name="NroLeasing"
            type="text"
            placeholder="Ingrese el numero de leasing"
            data-tooltip="Numero del leasing"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="NroLeasing"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            N° de Leasing(*)
          </label>
        </div>
        <div class="w-full flex flex-col gap-1">
          <div class="flex flex-col w-full relative">
            <input
              id="inputClienteAsociado"
              type="text"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs text-black bg-white border-2 rounded-[5px] focus:outline-none placeholder:text-black/25 tooltip-input"
              readonly />
            <label
              for="inputClienteAsociado"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Cliente Asociado
            </label>
            <button id="openModalCliAsoc" class="absolute right-0 bottom-0 px-[14px] text-xs py-[11px] bg-cyan-600/10 border-2 border-cyan-600 text-cyan-600 rounded-sm outline-none cursor-pointer hover:bg-cyan-600 hover:text-white transition-colors disabled:bg-gray-400/10 disabled:text-gray-300 disabled:border-gray-300" disabled>
              <i class="bi bi-search"></i>
            </button>
          </div>
          <div class="flex items-center gap-1">
            <input type="checkbox" name="" id="useAssociatedClient">
            <label for="useAssociatedClient" class="text-sm text-gray-800 font-medium">Asignar cliente asociado</label>
          </div>
        </div>
      </div>

      <!-- FILA 2 -->
      <div class="w-full grid grid-cols-2 items-start gap-4">
        <div class="flex flex-col w-full relative">
          <select id="combo-box-asig" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato">
            <option value="">Seleccione un contrato</option>
          </select>

          <label
            for="combo-box-asig"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Contrato(*)
          </label>
        </div>

        <div class="flex flex-col w-full relative">
          <select id="banco" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el banco">
            <option value="">Seleccione un banco</option>
            <option value="1">BANBIF</option>
            <option value="2">BBVA</option>
            <option value="3">BCP</option>
            <option value="4">HSBC</option>
            <option value="5">INTERBANK</option>
            <option value="6">SCOTIABANK</option>
            <option value="7">TAIR</option>
            <option value="8">SANTANDER</option>
          </select>

          <label
            for="banco"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Banco(*)
          </label>
        </div>
      </div>

      <!-- FILA 3 -->
      <div class="w-full grid grid-cols-4 items-start gap-4">
        <div class="input flex flex-col w-full relative">
          <input
            id="fechaIni"
            type="date"
            placeholder="dd/mm/aaaa"
            data-tooltip="Fecha inicio del leasing"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="fechaIni"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Fecha Inicio(*)
          </label>
        </div>
        <div class="input flex flex-col w-full relative">
          <input
            id="fechaFin"
            type="date"
            placeholder="dd/mm/aaaa"
            data-tooltip="Fecha fin del leasing"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="fechaFin"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Fecha Fin(*)
          </label>
        </div>
        <div class="input flex flex-col w-full relative">
          <input
            id="periGracia"
            type="number"
            min="0"
            value="0"
            placeholder="Ingrese el periodo de gracia"
            data-tooltip="Periodo de gracia en meses"
            class="no-negative peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="periGracia"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Periodo de Gracia(*)
          </label>
        </div>
        <div class="input flex flex-col w-full relative">
          <input
            id="cantVehi"
            type="number"
            min="0"
            value="0"
            placeholder="Ingrese la cantidad de vehiculos"
            data-tooltip="Cantidad de unidades adquiridas"
            class="no-negative peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" />
          <label
            for="cantVehi"
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Cantidad de Vehiculos(*)
          </label>
        </div>
      </div>

      <!-- FILA 4 -->
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

      <!-- <div class="leasing-adenda">
                <label for="combo-box">Contratos</label>
                <select id="combo-box-asig" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato" style="text-align: center;">
                    <option value="">Seleccione un contrato</option>
                </select>
            </div> -->
      <!-- <div class="leasing-adenda">
                <label>Banco</label>
                <select id="banco" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el banco" style="text-align: center;">
                    <option value="">Seleccione un banco</option>
                    <option value="1">BANBIF</option>
                    <option value="2">BBVA</option>
                    <option value="3">BCP</option>
                    <option value="4">HSBC</option>
                    <option value="5">INTERBANK</option>
                    <option value="6">SCOTIABANK</option>
                    <option value="7">TAIR</option>
                    <option value="8">SANTANDER</option>
                </select>
            </div> -->
      <!-- <div class="leasing-adenda">
        <label>Cant. Vehiculos</label>
        <input type="text" placeholder="" id="cantVehi" class="tooltip-input" data-tooltip="Cantidad de unidades adquiridas">
      </div> -->
      <!-- <div class="leasing-adenda">
                <label>Fecha Inicio</label>
                <input type="date" placeholder="" id="fechaIni" class="tooltip-input" data-tooltip="Fecha inicio del leasing">
            </div>
            <div class="leasing-adenda">
                <label>Fecha Fin</label>
                <input type="date" placeholder="" id="fechaFin" class="tooltip-input" data-tooltip="Fecha fin del leasing">
            </div> -->
      <!-- <div class="leasing-adenda">
                <label>Periodo de Gracia</label>
                <input type="text" placeholder="" id="periGracia" class="tooltip-input" data-tooltip="Periodo de gracia en meses">
            </div> -->
      <div class="flex flex-col gap-3">
        <div class="w-full flex justify-end items-center">
          <button id="openModal" class="btn-vehi cart-dos tooltip-input" data-tooltip="Selecciona las unidades adquiridas"> <strong><i class="fa-solid fa-plus"></i> Vehiculos </strong><img src="../img/car-wash.png" alt="Freepik" width="30" height="30" style="position: relative; top: 01px;"></button>
        </div>
        <div class="tabla-form">
          <table id="tablaSeleccionados">
            <thead>
              <tr>
                <th>Item</th>
                <th>ID</th>
                <th>Modelo</th>
                <th>Tipo terreno</th>
                <th>Placa</th>
                <th>Codini</th>
                <th>Cantidad</th>
              </tr>
            </thead>
            <tbody id="contratos-tbody" class="table-detalle">
            </tbody>
          </table>
        </div>
      </div>
      <div class="butto-form">
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

          </div>
      </div>
    </div>

    <div id="myModalCli" class="modal">
      <div class="main">
        <!-- Header del modal -->
        <div class="modal-header header-cliente">
          <h3>Listado de clientes</h3>
          <span class="closeCli">&times;</span> <!-- Botón de cerrar -->
        </div>

        <!-- Body del modal -->
        <div class="modal-body">
          <div class="buscador" style="padding: 10px 25px; color: #000000;">
            <label for="buscadorTabla">Buscar Cliente:</label>
            <input type="text" id="buscadorTabla" placeholder="Ingrese un término...">
          </div>
          <div class="form-seven">
            <div class="tabla-form-cli">
              <table>
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>RUC</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>ID</th>
                    <th>Abrev.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="6">Seleccione un cliente para ver los contratos</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Footer del modal -->
        <div class="modal-footer">
          <!--<button class="btn-acepta" id="btnAceptar">Aceptar</button>
                <button class="btn-cancelar" id="btnCancelar">Cancelar</button>-->
        </div>
      </div>
    </div>

    <div id="myModalCliAsoc" class="modal">
      <div class="main">
        <!-- Header del modal -->
        <div class="modal-header header-cliente">
          <h3>Listado de clientes Asociados</h3>
          <span class="closeCliAsoc">&times;</span> <!-- Botón de cerrar -->
        </div>

        <!-- Body del modal -->
        <div class="modal-body">
          <div class="buscador" style="padding: 10px 25px; color: #000000;">
            <label for="buscadorTabla">Buscar Cliente:</label>
            <input type="text" id="buscadorTablaAsoc" placeholder="Ingrese un término...">
          </div>
          <div class="form-seven">
            <div class="tabla-form-cli-asoc">
              <table>
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>RUC</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>ID</th>
                    <th>Abrev.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="6">Seleccione un cliente para ver los contratos</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Footer del modal -->
        <div class="modal-footer">
          <!--<button class="btn-acepta" id="btnAceptar">Aceptar</button>
                <button class="btn-cancelar" id="btnCancelar">Cancelar</button>-->
        </div>
      </div>
    </div>

    <div id="myModal" class="modal">
      <!-- Contenido de la ventana modal -->
      <div class="main">
        <!-- Header del modal -->
        <div class="modal-header header-vehiculo">
          <h3>Listado de Vehiculos</h3>
          <span class="close">&times;</span> <!-- Botón de cerrar -->
        </div>

        <!-- Body del modal -->
        <div class="modal-body">
          <div class="buscador" style="padding: 10px 25px; color: #000;">
            <label for="buscadorTabla">Buscar Vehiculo:</label>
            <input type="text" id="buscadorTablaVehi" placeholder="Ingrese un término...">
          </div>
          <div class="form-seven">
            <div class="tabla-form-vehi">
              <table>
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Codini</th>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Generico</th>
                    <th>Tipo Terreno</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="7">Seleccione un vehiculo para ver los contratos</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Footer del modal -->
        <div class="modal-footer">
          <!--<button class="btn-acepta" id="btnVehiculo">Aceptar</button>
                <button class="btn-cancelar">Cancelar</button>-->
        </div>
      </div>
    </div>

    <div id="pdfModal" class="modal-pdf">
      <div class="modal-content-pdf">
        <span class="close-modal-pdf" id="closeModal">&times;</span>
        <iframe id="modalPdfViewer" width="100%" height="500px"></iframe>
      </div>
    </div>
</main>

<!-- SCRIPTS -->
<script>
  function asignacionVehicular() {
    window.location = 'adicionar_vehiculos.php';
  };
</script>
<script type="module">
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

  const inputs = document.querySelectorAll(".tooltip-input");
  const tooltip = document.createElement("div");

  tooltip.style.position = "fixed"; // Se mueve con el cursor
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

  inputs.forEach(input => {
    input.addEventListener("mouseenter", function(event) {
      const tooltipText = input.getAttribute("data-tooltip");
      if (!tooltipText) return;

      tooltip.textContent = tooltipText;
      tooltip.style.display = "block";
      tooltip.style.opacity = "1";
    });

    input.addEventListener("mousemove", function(event) {
      let x = event.clientX + 10; // 10px de margen a la derecha del cursor
      let y = event.clientY + 10; // 10px abajo del cursor

      // Evitar que el tooltip se salga de la pantalla
      if (x + tooltip.offsetWidth > window.innerWidth) {
        x = event.clientX - tooltip.offsetWidth - 10; // Lo mueve a la izquierda si no cabe
      }
      if (y + tooltip.offsetHeight > window.innerHeight) {
        y = event.clientY - tooltip.offsetHeight - 10; // Lo sube si no cabe abajo
      }

      tooltip.style.left = `${x}px`;
      tooltip.style.top = `${y}px`;
    });

    input.addEventListener("mouseleave", function() {
      tooltip.style.opacity = "0";
      setTimeout(() => {
        tooltip.style.display = "none";
      }, 200);
    });
  });

  /* window.onload = function() {
      setTimeout(() => {
          document.body.classList.add('loaded');
          document.getElementById('preloader').style.display = 'none';
      }, 2000); 
  };*/

  const modal = document.getElementById("myModal");
  const btn = document.getElementById("openModal");
  const span = document.getElementsByClassName("close")[0];

  // Abrir la ventana modal al hacer clic en el botón
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // Cerrar la ventana modal al hacer clic en la "x"
  span.onclick = function() {
    modal.style.display = "none";
  }

  // Cerrar la ventana modal al hacer clic fuera de ella
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  const modalCli = document.getElementById("myModalCli");
  const modalCliAsoc = document.getElementById("myModalCliAsoc");
  const btnCli = document.getElementById("openModalCli");
  const btnCliAsoc = document.getElementById("openModalCliAsoc");
  const spanCli = document.getElementsByClassName("closeCli")[0];
  const spanCliAsoc = document.getElementsByClassName("closeCliAsoc")[0];

  // Abrir la ventana modal al hacer clic en el botón
  btnCli.onclick = function() {
    modalCli.style.display = "block";
  }

  btnCliAsoc.onclick = function() {
    modalCliAsoc.style.display = "block";
  }

  // Cerrar la ventana modal al hacer clic en la "x"
  spanCli.onclick = function() {
    modalCli.style.display = "none";
  }

  spanCliAsoc.onclick = function() {
    modalCliAsoc.style.display = "none";
  }

  // Cerrar la ventana modal al hacer clic fuera de ella
  window.onclick = function(event) {
    if (event.target == modalCli) {
      modalCli.style.display = "none";
    }
  }

  const fileInput = document.getElementById('fileInput');
  const dropZone = document.getElementById('dropZone');
  const fileInfo = document.getElementById('fileInfo');
  const fileNameDisplay = document.getElementById('fileName');
  const uploadMessage = $('#uploadMessage');
  const removeFileButton = document.getElementById('removeFile');

  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
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
  });
</script>
<script type="module" src="../js/registrar_leasing.js"></script>

<?php
require './templates/footer.html';
?>