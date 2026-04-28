<?php
require '../templates/header.html';
?>

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
<link rel="stylesheet" href="https://cdn.datatables.net/select/3.1.3/css/select.dataTables.css" />

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
<script src="https://cdn.datatables.net/select/3.1.3/js/dataTables.select.js"></script>
<script src="https://cdn.datatables.net/select/3.1.3/js/select.dataTables.js"></script>

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

<!-- CSS DE LA VISTA ADICIONAR VEHICULOS -->
<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/views/add_vehicle.css'; ?>
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

<main class="main-register" data-route-permission="insertar_asignacion">
  <div class="contenedor border border-gray-300 px-9 py-7 relative overflow-hidden">
    <div class="w-full h-3 bg-yellow-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Asignar unidades</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione la transferencia de vehículos entre clientes, seleccionando el destino al cual serán asignados.</p>
    </div>
    <div class="body-adiciona">
      <div class="w-full grid grid-cols-2 place-content-center gap-4 pt-6 pb-4">
        <!-- CLIENTE CBO -->
        <div class="flex flex-col w-full relative">
          <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes">
            <option value="">Seleccione un cliente</option>
          </select>

          <label
            for="combo-box"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Cliente Origen(*)
          </label>
        </div>

        <!-- LEASING CBO -->
        <div class="flex flex-col w-full relative">
          <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
            <option value="" disabled selected>Seleccione un Leasing</option>
          </select>

          <label
            for="combo-box-leasing"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            N° De Leasing
          </label>
        </div>
      </div>
      <table id="listAssign" class="display">
        <thead>
          <tr>
            <th class="bg-yellow-700 !text-white !font-medium"></th>
            <th class="bg-yellow-700 !text-white !font-medium">Item</th>
            <th class="bg-yellow-700 !text-white !font-medium">ID</th>
            <th class="bg-yellow-700 !text-white !font-medium">Placa</th>
            <th class="bg-yellow-700 !text-white !font-medium">Marca</th>
            <th class="bg-yellow-700 !text-white !font-medium">Modelo</th>
            <th class="bg-yellow-700 !text-white !font-medium">Leasing</th>
            <th class="bg-yellow-700 !text-white !font-medium">Tarifa</th>
            <th class="bg-yellow-700 !text-white !font-medium">Fecha de Entrega</th>
            <th class="bg-yellow-700 !text-white !font-medium">Fecha Devolucion</th>
            <th class="bg-yellow-700 !text-white !font-medium">Operacion</th>
            <th class="bg-yellow-700 !text-white !font-medium">Contrato / Documento</th>
            <th class="bg-yellow-700 !text-white !font-medium">Terreno</th>
            <th class="bg-yellow-700 !text-white !font-medium">Condicion</th>
            <th class="bg-yellow-700 !text-white !font-medium">Acta</th>
          </tr>
        </thead>
        <tbody id="asignacion-tbody">
        </tbody>
      </table>
      <div class="modal-footer">
        <div class="cbo-form-adiciona">
          <!-- ASIGNAR CBO -->
          <div class="flex flex-col w-full relative">
            <select id="combo-box-asig" name="opciones" class="cbo-form-leasing" disabled></select>

            <label
              for="combo-box-asig"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Asignar Cliente Destino(*)
            </label>
          </div>
          <div class="w-full flex gap-3 justify-end items-center">
            <div class="flex justify-center items-center gap-1">
              <input class="check-xtodo" type="checkbox" id="repeticion" disabled>
              <label for="repeticion" repeticion"">Repetir</label>
            </div>
            <button
              type="button"
              id="grabarButton"
              class="cursor-pointer bg-green-700 text-center w-1/3 rounded-2xl h-12 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
              <div
                class="backgroud-spinner bg-green-950 text-white rounded-xl h-10 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
                <i class="bi bi-floppy-fill icon-btn"></i>
                <div
                  class="spinner hidden w-4 h-4 border-2 border-t-blue-500 border-gray-300 rounded-full animate-spin"></div>
              </div>
              <p class="translate-x-4 !m-0 !text-white text-base font-medium">Grabar</p>
            </button>
            <button
              type="button"
              id="btnClear"
              class="cursor-pointer bg-yellow-700 text-center w-1/3 rounded-2xl h-12 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
              <div
                class="bg-yellow-950 text-white rounded-xl h-10 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
                <i class="bi bi-stars"></i>
              </div>
              <p class="translate-x-4 !m-0 !text-white text-base font-medium">Limpiar</p>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- ALERTA MODAL -->
<div id="alert-modal" class="fixed w-full h-dvh top-0 left-0 hidden justify-center items-center z-[9990]">
  <div class="fixed top-0 left-0 w-full h-full bg-black/25 z-[9991]"></div>
  <div class="alert-container w-[30%] max-w-[90%] bg-[#ffeab0] rounded-xl border-2 border-[#ffbb00] flex flex-col gap-3 p-5 z-[9999]">
    <h3 class="font-medium text-[#e0a501] text-xl">¡Tarifas excesivas!</h3>
    <p>Hemos detectado que estas colocando <b>tarifas</b> mayor a dos cifras.</p>
    <p id="listTarifa"></p>
    <p>¿Estas seguro de continuar?</p>
    <div class="flex items-center gap-1">
      <button id="btn-save" class="px-4 py-2 text-white outline-none border-none rounded-lg text-sm bg-blue-700 hover:bg-blue-500 transition-colors cursor-pointer">Si, guardar asignación</button>
      <button id="btn-cancel" class="px-4 py-2 text-white outline-none border-none rounded-lg text-sm bg-zinc-900 hover:bg-zinc-700 transition-colors cursor-pointer">No, cancelar proceso</button>
    </div>
  </div>
</div>

<!-- SCRIPTS DE LA VISTA -->

<script type="module" src="/js/adiciona_vehiculo.js"></script>

<script type="module">
  import {
    deshabilitarSelect,
    guardaAsignacion,
    limpiarSelect,
    cargarClientes,
    cargarLeasingOfClient,
    listaVehiculosAsignables,
    cargarClientesAsig
  } from '/js/adiciona_vehiculo.js';

  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  document.title = "Asignar vehiculos | Gescon";

  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $("#preloader-mini").css("opacity", "1");
    $("#preloader-mini").css("z-index", "99999");
  }

  function hideLoader() {
    activeRequests--;
    if (activeRequests <= 0) {
      animate(
        "#preloader-mini", {
          opacity: [1, 0],
        }, {
          duration: 0.45,
          easing: "ease-in",
        },
      );

      setTimeout(() => {
        // $("#preloader-mini").css("opacity", "0");
        $("#preloader-mini").css("z-index", "-99999");
      }, 400);
    }
  }

  function showSpinner(element) {
    // Cambiar cursor al boton
    $(element).removeClass("cursor-pointer").addClass("cursor-progress");

    // Mostrar background
    $(element).find(".backgroud-spinner").addClass("w-full").removeClass("w-1/4");

    // Ocultar icono
    $(element).find(".icon-btn").addClass("hidden");

    // Mostrar spinner
    $(element).find(".spinner").removeClass("hidden");
    $(element).prop("disabled", true);
  }

  function hideSpinner(element) {
    // Cambiar cursor al boton
    $(element).addClass("cursor-pointer").removeClass("cursor-progress");

    // Ocultar background
    $(element).find(".backgroud-spinner").removeClass("w-full").addClass("w-1/4");

    // Ocultar spinner
    $(element).find(".spinner").addClass("hidden");
    $(element).prop("disabled", false);

    // Mostrar icono
    $(element).find(".icon-btn").removeClass("hidden");
  }

  document.addEventListener("DOMContentLoaded", () => {
    showLoader();

    const params = new URLSearchParams(window.location.search);
    const clientId = params.get("clienteId");

    document
      .getElementById("btnClear")
      .addEventListener("click", deshabilitarSelect);

    const btnFlotaTotal = document.getElementById("btn-flota-total");

    $("#combo-box").select2({
      placeholder: "Seleccione el cliente",
      allowClear: false,
    });

    $("#combo-box-leasing").select2({
      placeholder: "Seleccione el leasing",
      allowClear: false,
    });

    $("#combo-box-asig").select2({
      placeholder: "Seleccione el cliente asignado",
      allowClear: false,
      width: "65%",
    });

    $("#combo-box").on("select2:select", function() {
      limpiarSelect("#combo-box-leasing");
    });

    cargarClientes();

    const selectClientes = $("#combo-box");
    const selectLeasingAnonim = $("#combo-box-leasing");

    if (clientId) {
      cargarLeasingOfClient(clientId).then(() => {
        listaVehiculosAsignables(clientId);
      });
    } else {
      listaVehiculosAsignables(null);
    }

    selectClientes.on("select2:select", async function() {
      const id = selectClientes.val();
      params.set("clienteId", id);
      const nuevaURL = `${window.location.pathname}?${params.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      cargarLeasingOfClient(id).then(() => {
        listaVehiculosAsignables(id);
      });
    });

    selectLeasingAnonim.on("select2:select", async function() {
      const id = selectClientes.val();
      await listaVehiculosAsignables(id);
    });

    cargarClientesAsig();

    hideLoader();
  });

  document.addEventListener("change", function(e) {
    if (!e.target.classList.contains("acta")) return;

    const file = e.target.files[0];
    if (!file) return;

    const container = e.target.closest("td");
    const label = container.querySelector("label");

    const span = label.querySelector("span");
    const icon = label.querySelector("i");

    // cambiar texto
    span.textContent = file.name;

    // cambiar icono
    icon.className = "bi bi-check-circle";

    // cambiar color
    label.classList.remove("bg-blue-800");
    label.classList.add("bg-green-600");
  });

  $("#grabarButton").on("click", async function() {
    showSpinner(this);

    await guardaAsignacion();

    hideSpinner(this);
  });


  $("#listAssign tbody").on("change", ".acta", function() {
    const input = this;
    const container = $(this).closest("div");
    const btnRemove = container.find(".remove-file");

    if (input.files && input.files.length > 0) {
      btnRemove.removeClass("hidden").addClass("flex");
    } else {
      const label = container.find("label");
      const span = label.find("span");
      const icon = label.find("i");

      // 🔹 limpiar input file
      input.value = "";

      // 🔹 restaurar texto
      span.text("Subir archivo");

      // 🔹 restaurar icono
      icon.attr("class", "bi bi-file-earmark-arrow-up");

      // 🔹 restaurar color
      label.removeClass("bg-green-600").addClass("bg-blue-800");

      // 🔹 ocultar botón remove
      $(this).addClass("hidden").removeClass("flex");

      btnRemove.addClass("hidden").removeClass("flex");
    }
  });

  $("#listAssign tbody").on("click", ".remove-file", function() {
    const container = $(this).closest("div");
    const input = container.find(".acta")[0];

    const label = container.find("label");
    const span = label.find("span");
    const icon = label.find("i");

    // 🔹 limpiar input file
    input.value = "";

    // 🔹 restaurar texto
    span.text("Subir archivo");

    // 🔹 restaurar icono
    icon.attr("class", "bi bi-file-earmark-arrow-up");

    // 🔹 restaurar color
    label.removeClass("bg-green-600").addClass("bg-blue-800");

    // 🔹 ocultar botón remove
    $(this).addClass("hidden").removeClass("flex");
  });
</script>

<?php
require '../templates/footer.html';
?>