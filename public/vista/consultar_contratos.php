<?php
require './templates/header.html';
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

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- TOASTR CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSS DE LA VISTA CONSULTAR CONTRATOS -->
<style>
  <?php include '../css/views/query_contract.css'; ?>
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

<main class="main-query">
  <div class="contenedor">
    <div class="form-col-1 contenedor-col-1 relative px-9 py-7 overflow-hidden">
      <div class="w-full h-3 bg-blue-700 absolute top-0 left-0"></div>
      <div class="w-full flex flex-col justify-center gap-2">
        <h3 class="text-5xl text-[#002141] font-semibold">Administración de contratos</h3>
        <p class="!m-0 text-base font-normal text-gray-500">Visualice y consulte la información de los contratos registrados en el sistema.</p>
      </div>
      <div class="tabla-form flex flex-col gap-3">
        <div class="cbo-row">
          <div class="flex flex-col w-full relative">
            <select id="combo-box" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente">
            </select>

            <label
              for="combo-cliente"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Seleccione el cliente
            </label>
          </div>
          <div class="flex flex-col w-full relative">
            <select id="combo-contrato" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato">
            </select>

            <label
              for="combo-cliente"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Seleccione el Contrato
            </label>
          </div>
        </div>
        <table id="listContracts" class="display">
          <thead>
            <tr>
              <th class="text-gray-500 !font-medium">Item</th>
              <th class="text-gray-500 !font-medium">N° contrato</th>
              <th class="text-gray-500 !font-medium">Fecha Firma</th>
              <th class="text-gray-500 !font-medium">Periodo</th>
              <th class="text-gray-500 !font-medium">Cant total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="input flex flex-col w-full relative">
        <textarea
          id="story" name="story"
          type="text"
          placeholder="Vacío"
          class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 h-24 text-sm resize-none" disabled></textarea>
        <label
          for="contrato"
          class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
          Descripción
        </label>
      </div>
      <div class="salio-form"> <!--text-form-col-->
        <button
          type="button"
          id="btnNewDoc"
          class="cursor-pointer bg-cyan-800 text-center w-full rounded-2xl h-16 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
          <div
            class="bg-cyan-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
            <i class="bi bi-file-earmark-plus-fill"></i>
          </div>
          <p class="translate-x-4 !m-0 !text-white text-base font-medium">Nuevo doc.</p>
        </button>
        <button
          type="button"
          id="btnNewLea"
          class="cursor-pointer bg-green-800 text-center w-full rounded-2xl h-16 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
          <div
            class="bg-green-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
            <i class="bi bi-file-earmark-arrow-up-fill"></i>
          </div>
          <p class="translate-x-4 !m-0 !text-white text-base font-medium">Nuevo lea.</p>
        </button>
        <button
          type="button"
          id="btnClear"
          class="cursor-pointer bg-yellow-700 text-center w-full rounded-2xl h-16 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
          <div
            class="bg-yellow-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
            <i class="bi bi-stars"></i>
          </div>
          <p class="translate-x-4 !m-0 !text-white text-base font-medium">Limpiar</p>
        </button>
      </div>
    </div>
    <div class="form-col-2 contenedor-col-2 relative px-9 py-7 overflow-hidden">
      <div class="w-full h-3 bg-blue-700 absolute top-0 left-0"></div>
      <div class="w-full">
        <h3 class="text-2xl text-[#002141] font-semibold">Resumen</h3>
      </div>
      <div id="skeleton-contract" class="w-[250px] hidden flex-col gap-5 items-center">
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
        </div>
        <div class="w-full">
          <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
        </div>
        <div class="w-full flex gap-2">
          <div class="w-1/3 h-[47px] bg-slate-400 rounded animate-pulse"></div>
          <div class="w-full grid grid-cols-4 gap-1">
            <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
            <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
            <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
            <div class="w-full h-[47px] bg-slate-400 rounded animate-pulse"></div>
          </div>
        </div>
        <div class="w-full grid grid-cols-2 gap-2">
          <div class="w-full h-[152px] bg-slate-400 rounded animate-pulse"></div>
          <div class="w-full h-[152px] bg-slate-400 rounded animate-pulse"></div>
        </div>
        <div class="w-full grid grid-cols-2 gap-2">
          <div class="w-full h-[152px] bg-slate-400 rounded animate-pulse"></div>
          <div class="w-full h-[152px] bg-slate-400 rounded animate-pulse"></div>
        </div>
      </div>
      <div id="data-contract" class="flex flex-col gap-5">
        <div class="text-form-col">
          <label for="combo-box">Estado:</label>
          <input id="text-estado" name="estado" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="text-form-col">
          <label for="combo-box">Fecha Ini:</label>
          <input id="text-inicio" name="inicio" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="text-form-col">
          <label for="combo-box">Fecha Fin:</label>
          <input id="text-fin" name="fin" type="text" class="px-[10px] py-[11px] rounded-[5px] border-2 border-gray-300 bg-gray-50 text-gray-600" value="--" disabled>
        </div>
        <div class="text-form-col">
          <label for="combo-box tp-form">Tipo Terreno:</label>
          <div class="cuadradro">
            <div id="view-sev" class="card terreno-form">
              <div class="tdh nom-tp">Sev.</div>

              <div class="tdh" id="txt-sev">0</div>
            </div>
            <div id="view-soc" class="card terreno-form">
              <div class="tdh nom-tp">Soc.</div>

              <div class="tdh" id="txt-soc">0</div>
            </div>
            <div id="view-sup" class="card terreno-form">
              <div class="tdh nom-tp">Sup.</div>

              <div class="tdh" id="txt-sup">0</div>
            </div>
            <div id="view-ciu" class="card terreno-form">
              <div class="tdh nom-tp">Ciu.</div>

              <div class="tdh" id="txt-ciu">0</div>
            </div>
          </div>
        </div>
        <div class="text-form-col">
          <div class="cuadradro-form">
            <div class="card terreno-form doc-form" id="href-query-doc">
              <div class="tda tti-form nom-tp">N° Documentos</div>

              <div class="tda can-form"><i class="fa fa fa-sheet-plastic" style="color: #1e3a8a;"></i><span id="txt-aso">0</span></div>
            </div>
            <div class="card terreno-form doc-form" id="href-query-lea">
              <div class="tda tti-form nom-tp">N° leasing</div>

              <div class="tda can-form"><i class="fa fa fa-book" style="color: #1e3a8a;"></i><span id="txt-leas">0</span></div>
            </div>
            <div class="card terreno-form doc-form" id="href-query-veh">
              <div class="tda tti-form nom-tp">Veh. Activos</div>

              <div class="tda can-form"><i class="fa-solid fa-car" style="color: #1e3a8a;"></i><span id="txt-vehic">0</span></div>
            </div>
            <div class="card terreno-form doc-form" id="href-query-assign">
              <div class="tda tti-form nom-tp" id="cab-href-query-assign">Veh. Asignados</div>

              <div class="tda can-form"><i class="fa-solid fa-check" style="color: #1e3a8a;"></i><span id="txt-assign">0</span></div>
            </div>
          </div>
        </div>
        <div class="button-action-col">
          <button
            type="button"
            id="btn-edit-con"
            class="cursor-pointer bg-blue-800 text-center w-full rounded-2xl h-16 relative text-xl hidden justify-center items-center font-semibold border-4 border-white group">
            <div
              class="bg-blue-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
              <i class="bi bi-pencil-fill"></i>
            </div>
            <p class="translate-x-4 !m-0 !text-white text-base font-medium">Editar contrato</p>
          </button>
          <button
            id="btn-assign"
            type="button"
            class="cursor-pointer bg-red-800 text-center w-full rounded-2xl h-16 relative text-xl hidden justify-center items-center font-semibold border-4 border-white group btn-assign">
            <span class="count-veh-alert"></span>
            <div
              class="bg-red-950 text-white rounded-xl h-14 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
              <i class="bi bi-car-front-fill"></i>
            </div>
            <p class="translate-x-4 !m-0 !text-white text-base font-medium">Pendientes</p>
          </button>

        </div>
      </div>
    </div>
  </div>
</main>

<div id="modal-documents">
  <div class="modal-container">
    <div class="modal-header">
      <i class="bi bi-info-circle"></i>
      <h2>Detalles</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<div id="alert-modal">
  <div class="alert-bg"></div>
  <div class="alert-container">
  </div>
</div>

<script src="../js/consulta_contratos.js"></script>
<script type="module">
  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $('#preloader-mini').css('opacity', '1');
    $('#preloader-mini').css('z-index', '99999');
  }

  function hideLoader() {
    activeRequests--;
    if (activeRequests <= 0) {
      setTimeout(() => {
        $('#preloader-mini').css('opacity', '0');
        $('#preloader-mini').css('z-index', '-99999');
      }, 400)
    }
  }

  let activeSkeleton = 0;

  function showSkeleton() {
    activeSkeleton++;
    $('#skeleton-contract').addClass("flex");
    $('#skeleton-contract').removeClass("hidden");

    $('#data-contract').addClass("hidden");
    $('#data-contract').removeClass("flex");
  }

  function hideSkeleton() {
    activeSkeleton--;
    if (activeSkeleton <= 0) {
      setTimeout(() => {
        $('#skeleton-contract').addClass("hidden");
        $('#skeleton-contract').removeClass("flex");

        $('#data-contract').addClass("flex");
        $('#data-contract').removeClass("hidden");
      }, 400)
    }
  }

  // window.onload = function() {
  //   setTimeout(() => {
  //     document.body.classList.add('loaded');
  //     document.getElementById('preloader-mini').style.display = 'none';
  //   }, 2000);
  // };

  let table;

  $(document).on('DOMContentLoaded', async function() {
    showLoader();

    await cargarClientes();
    document.getElementById("btnClear").addEventListener("click", limpiarCampos);

    const params = new URLSearchParams(window.location.search);
    const idClient = params.get("clienteId");
    const idContract = params.get("contratoId");

    table = $("#listContracts").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // ordering: false,
      searching: false,
      scrollY: "500px",
      scrollCollapse: true,
      dom: 'rt<"inferior"i<"derecha-inferior"lp>>',
      data: [],
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4]
        }
      ],
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "DESCRIPCION",
          render: function(data) {
            return `${data}`;
          },
        },
        {
          data: "FECHACREA",
          render: function(data) {
            if (data) {
              return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
            } else {
              return `--`
            }
          },
        },
        {
          data: "DURACION",
          render: function(data) {
            return `${data} meses`;
          },
        },
        {
          data: "TOTVEH",
          render: function(data) {
            return `${data} und.`;
          },
        },
      ],
    });

    $("#combo-box").select2({
      placeholder: "Seleccione un cliente",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    $("#combo-contrato").select2({
      placeholder: "Seleccione un contrato",
      allowClear: false, // Desactiva la "X"
      width: "100%"
    });

    if (idClient) {
      $("#combo-box").val(`${idClient}`).trigger("change");

      const contracts = await getContracts(idClient);

      await cargarContrato(idClient);

      const vehPending = await getPendingVeh(idClient);

      if (vehPending.data && vehPending.data.length > 0) {
        setTimeout(() => {
          $("#alert-modal").css("display", "flex");

          $("#alert-modal .alert-container").css("background-color", "#ffeab0").css("border", "2px solid #ffbb00")

          $("#alert-modal .alert-container").html(
            `
              <h2>¡Aviso de unidades pendientes!</h2>
              <p style="color: black !important">El sistema ha detectado que este cliente cuenta con vehiculos sin asignar. Le sugerimos asignarlos para evitar irregularidades</p>
              <p style="color: black !important">¿Deseas asignarlos ahora?</p>
              <div class="btn-group">
                <button class="btn btn-info btn-assign">Si, quiero asignarlos</button>
                <button id="btn-close-alert" class="btn btn-dark">Ignorar alerta</button>
              </div>
            `
          )
        }, 2000)

        $("#btn-assign").removeClass("hidden");
        $("#btn-assign").addClass("flex");
        $(".count-veh-alert").text(vehPending.data.length)
      } else {
        $("#btn-assign").removeClass("flex");
        $("#btn-assign").addClass("hidden");
      }

      table.clear();
      table.rows.add(contracts);
      table.draw();

      if (idContract) {
        await cargarDatosContrato(idClient, idContract);
        $("#btn-edit-con").addClass("flex");
        $("#btn-edit-con").removeClass("hidden");
      } else {
        await cargarDatosContrato(idClient);
        $("#btn-edit-con").addClass("hidden");
        $("#btn-edit-con").removeClass("flex");
      }
    }

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })


    hideLoader();
  });

  $("#alert-modal .alert-bg").on("click", () => {
    const modal = document.getElementById("alert-modal");
    modal.style.display = "none";

    $("#alert-modal .alert-container").empty();
  })

  $(document).on("click", ".btn-assign", () => {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")

    if (!clienteId) return;

    window.location.href = `adicionar_vehiculos.php?clienteId=${clienteId}`;
  })

  $(document).on("click", "#btn-close-alert", () => {
    const modal = document.getElementById("alert-modal");
    modal.style.display = "none";

    $("#alert-modal .alert-container").empty();
  })

  $("#combo-box").on("select2:select", async function(e) {
    showLoader();

    limpia();

    const params = new URLSearchParams(window.location.search);
    params.set("clienteId", e.params.data.id);
    params.delete("contratoId")

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    await cargarContrato(e.params.data.id);

    await cargarDatosContrato(e.params.data.id);

    const contracts = await getContracts(e.params.data.id);

    const vehPending = await getPendingVeh(e.params.data.id);

    if (vehPending.data && vehPending.data.length > 0) {
      $("#alert-modal").css("display", "flex");

      $("#alert-modal .alert-container").css("background-color", "#ffeab0").css("border", "2px solid #ffbb00")

      $("#alert-modal .alert-container").html(
        `
          <h2>¡Aviso de unidades pendientes!</h2>
          <p style="color: black !important">El sistema ha detectado que este cliente cuenta con vehiculos sin asignar. Le sugerimos asignarlos para evitar irregularidades</p>
          <p style="color: black !important">¿Deseas asignarlos ahora?</p>
          <div class="btn-group">
            <button class="btn btn-info btn-assign">Si, quiero asignarlos</button>
            <button id="btn-close-alert" class="btn btn-dark">Ignorar alerta</button>
          </div>
        `
      )

      $("#btn-assign").removeClass("hidden");
      $("#btn-assign").addClass("flex");
      $(".count-veh-alert").text(vehPending.data.length)
    } else {
      $("#btn-assign").addClass("hidden");
      $("#btn-assign").removeClass("flex");
    }

    $("#btn-edit-con").addClass("hidden");
    $("#btn-edit-con").removeClass("flex");

    table.clear();
    table.rows.add(contracts);
    table.draw();

    hideLoader();
  });

  $("#combo-contrato").on("select2:select", async function(e) {
    const params = new URLSearchParams(window.location.search);
    params.delete("contratoId");
    window.history.replaceState({}, "", `${window.location.pathname}?${params}`);

    const contracts = await cargarTablacontrato(e.params.data.id)

    table.clear();
    table.rows.add(contracts);
    table.draw();;
  })

  $("#listContracts tbody")
    .on("click", "tr", async function(e) {
      showSkeleton();

      $('tr').removeClass("selected-row");

      $(this).addClass("selected-row");

      const data = table.row(this).data();

      const contratoId = data.ID;

      const params = new URLSearchParams(window.location.search);
      params.set("contratoId", contratoId);

      const clienteId = params.get("clienteId");

      if (!clienteId) return;

      const nuevaURL = `${window.location.pathname}?${params.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      // Realizar la solicitud AJAX al backend para obtener los detalles del contrato
      try {
        const response = await fetch(
          `http://${IP_LOCAL}:3000/contratoDetalle?contratoId=${contratoId}&clienteId=${clienteId}`, {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          },
        );
        const data = await response.json();

        if (!data.success) {
          console.error("Error al obtener los detalles del contrato");
          return;
        }

        // Asignar valores a los campos de entrada con los datos obtenidos
        const fechaFirma = data.data.fechaFirma; // Se espera en formato yyyymmdd

        // Convertir fecha firma a formato yyyy-mm-dd
        const fechaInicio = convertirFecha(fechaFirma);
        document.getElementById("text-inicio").value = dayjs(fechaInicio).format("DD/MM/YYYY"); // Asignar FECHA_FIRMA

        // Calcular fecha de fin
        const fechaFin = calcularFechaFin(fechaInicio, data.data.duracion);
        document.getElementById("text-fin").value = dayjs(fechaFin).format("DD/MM/YYYY"); // Asignar fecha de fin

        const estado = obtenerEstado(fechaFin);
        document.getElementById("text-estado").value = estado; // Asignar DESCRIPCION
        // Establecer el estado según la fecha actual y la fecha de fin
        document.getElementById("story").value = data.data.descripcion; // Asignar estado

        // Aquí asignamos los valores de los vehículos a los campos correspondientes
        document.getElementById("txt-sev").textContent =
          data.data.vehiculoSev || "0";
        document.getElementById("txt-soc").textContent =
          data.data.vehiculoSoc || "0";
        document.getElementById("txt-sup").textContent =
          data.data.vehiculoSup || "0";
        document.getElementById("txt-ciu").textContent =
          data.data.vehiculoCiu || "0";
        document.getElementById("txt-aso").textContent =
          data.data.cantidadDocumentos || "0"; // Asignar texto al div
        document.getElementById("txt-leas").textContent =
          data.data.cantidadLeasing || "0"; // Asignar texto al div
        document.getElementById("txt-vehic").textContent =
          data.data.cantidadVehiculos || "0";
        document.getElementById("txt-assign").textContent =
          data.data.cantidadAsignados || "0";

        $("#btn-edit-con").addClass("flex")
        $("#btn-edit-con").removeClass("hidden")

      } catch (error) {
        console.error("Error al obtener los datos del contrato:", error);
      }

      hideSkeleton();
    });


  function registrarContrato() {

  };

  $("#btnNewDoc").on("click", function() {
    window.location = 'registrar_documentos.php';
  });

  $("#btnNewLea").on("click", function() {
    window.location = 'registrar_leasing.php';
  });

  function registrarDocumento() {
    window.location = 'registrar_documentos.php';
  };

  function queryDocument() {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const contratoId = params.get("contratoId")

    if (!contratoId || !clienteId) return;

    window.location.href = `consultar_documento_por_contrato.php?contratoId=${contratoId}&clienteId=${clienteId}`;
  }

  function queryLeasing() {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const contratoId = params.get("contratoId")

    if (!contratoId || !clienteId) return;

    window.location.href = `consultar_leasing_por_contrato.php?contratoId=${contratoId}&clienteId=${clienteId}`;
  }

  function queryVehicles() {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const contratoId = params.get("contratoId")

    if (!contratoId || !clienteId) return;

    window.location.href = `consultar_total_vehiculos.php?contratoId=${contratoId}&clienteId=${clienteId}`;
  }

  function queryAssign() {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const contratoId = params.get("contratoId")

    if (!clienteId) return;

    window.location.href = `consultar_asignaciones_por_contrato.php?clienteId=${clienteId}${contratoId ? `&contratoId=${contratoId}` : ""}`;
  }

  $("#href-query-doc").on("click", () => {
    queryDocument()
  })

  $("#href-query-lea").on("click", () => {
    queryLeasing()
  })

  $("#href-query-veh").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const clientId = param.get("clienteId")
    const contratoId = param.get("contratoId")

    if (!clientId) {
      toastr.info("Debes de seleccionar un cliente en la tabla", "Aviso")
      return;
    }

    const vehicles = await getAssignVehActive(clientId, contratoId, "A");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVeh" class="display">
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
    `);

    $("#listVeh").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clientId}`,
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
      scrollY: '300px',
      scrollCollapse: true,
      data: vehicles,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
        }
      ],
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
    })

    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#href-query-assign").on("click", () => {
    queryAssign()
  })

  $("#btn-edit-con").on("click", () => {
    const params = new URLSearchParams(window.location.search);
    const contratoId = params.get("contratoId")

    if (!contratoId) return;

    window.location.href = `registrar_contratos.php?formUpd=true&contratoId=${contratoId}`;
  })

  // OPCION PARA VER VEHICULOS POR TERRENO

  // SEVERO
  $("#view-sev").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const clientId = param.get("clienteId")
    const contratoId = param.get("contratoId")

    if (!clientId) {
      toastr.info("Debes de seleccionar un cliente en la tabla", "Aviso")
      return;
    }

    const vehicles = await getAssignVehActive(clientId, contratoId, null, 3);

    if (!Array.isArray(vehicles)) return;

    if (vehicles.length == 0) {
      toastr.info("No se encontraron registros del tipo de vehiculo Severo", "Aviso")
      return;
    }

    $("#modal-body-info").append(`
      <table id="listVehSev" class="display">
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
    `);

    $("#listVehSev").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clientId}`,
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
      scrollY: '300px',
      scrollCollapse: true,
      data: vehicles,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
        }
      ],
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
    })

    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  // SOCAVON
  $("#view-soc").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const clientId = param.get("clienteId")
    const contratoId = param.get("contratoId")

    if (!clientId) {
      toastr.info("Debes de seleccionar un cliente en la tabla", "Aviso")
      return;
    }

    const vehicles = await getAssignVehActive(clientId, contratoId, null, 1);

    if (!Array.isArray(vehicles)) return;

    if (vehicles.length == 0) {
      toastr.info("No se encontraron registros del tipo de vehiculo Socavón", "Aviso")
      return;
    }

    $("#modal-body-info").append(`
      <table id="listVehSoc" class="display">
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
    `);

    $("#listVehSoc").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clientId}`,
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
      scrollY: '300px',
      scrollCollapse: true,
      data: vehicles,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
        }
      ],
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
    })

    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  // SUPERFICIE
  $("#view-sup").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const clientId = param.get("clienteId")
    const contratoId = param.get("contratoId")

    if (!clientId) {
      toastr.info("Debes de seleccionar un cliente en la tabla", "Aviso")
      return;
    }

    const vehicles = await getAssignVehActive(clientId, contratoId, null, 0);

    if (!Array.isArray(vehicles)) return;

    if (vehicles.length == 0) {
      toastr.info("No se encontraron registros del tipo de vehiculo Superficie", "Aviso")
      return;
    }

    $("#modal-body-info").append(`
      <table id="listVehSup" class="display">
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
    `);

    $("#listVehSup").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clientId}`,
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
      scrollY: '300px',
      scrollCollapse: true,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
        }
      ],
      data: vehicles,
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
    })

    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  // CIUDAD
  $("#view-ciu").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const clientId = param.get("clienteId")
    const contratoId = param.get("contratoId")

    if (!clientId) {
      toastr.info("Debes de seleccionar un cliente en la tabla", "Aviso")
      return;
    }

    const vehicles = await getAssignVehActive(clientId, contratoId, null, 2);

    if (!Array.isArray(vehicles)) return;

    if (vehicles.length == 0) {
      toastr.info("No se encontraron registros del tipo de vehiculo Ciudad", "Aviso")
      return;
    }

    $("#modal-body-info").append(`
      <table id="listVehCiu" class="display">
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
    `);

    $("#listVehCiu").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // fixedHeader: true,
      dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        extend: 'excelHtml5',
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        filename: 'Placas_Asignadas_' + new Date().toLocaleDateString(),
        title: `Lista de placas del cliente ${clientId}`,
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
      scrollY: '300px',
      scrollCollapse: true,
      data: vehicles,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
        }
      ],
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
    })

    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-documents");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>