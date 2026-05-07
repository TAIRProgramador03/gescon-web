<?php
require '../templates/header.html';
?>

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/views/reassign_vehicle.css'; ?>
</style>

<div id="preloader-mini" class="absolute inset-0 z-[9999] bg-white flex flex-col justify-center items-center">
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

<main class="w-full h-[calc(100vh-64px)] flex gap-4 relative overflow-auto" data-route-permission="insertar_reasignacion">

  <div class="w-full h-fit bg-white flex flex-col gap-3 px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-orange-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Reasignar vehiculos</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione los cambios de asignación de vehículos.</p>
    </div>
    <div class="w-full grid grid-cols-3 gap-5">
      <div class="w-full flex flex-col gap-3 col-span-2 border border-gray-100 rounded-lg p-3">
        <!-- FILTROS -->
        <div class="w-full flex items-center gap-3">
          <div class="flex flex-col w-full relative -mt-2!">
            <select id="cbo-clientes" name="clientes"></select>
            <label
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Cliente
            </label>
          </div>

          <div class="flex flex-col w-full relative -mt-2!">
            <select id="cbo-operaciones" name="operaciones"></select>
            <label
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Operación Actual
            </label>
          </div>
        </div>

        <!-- TABLA -->
        <table id="listVehicles">
          <thead>
            <tr>
              <th></th>
              <th class="!font-medium text-gray-500">Placa</th>
              <th class="!font-medium text-gray-500">Fecha Ref.</th>
              <th class="!font-medium text-white bg-red-500">Operación Actual</th>
              <th class="!font-medium text-white bg-green-500">Operación a traspasar</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="w-full flex flex-col gap-3 border border-gray-100 rounded-lg p-3">
        <h3 class="text-2xl text-[#002141] font-semibold">Traspasar vehiculos</h3>
        <div class="w-full h-full flex flex-col justify-start items-center gap-3">
          <!-- OPERACIÓN A TRASLADAR -->
          <div class="input flex flex-col w-full relative -mt-2!">
            <input
              id="operacion"
              name="operacion"
              type="text"
              placeholder="Seleccione una de la tabla"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 disabled:bg-gray-100" disabled />
            <label
              for="firma"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:bg-gray-100">
              Operación a traspasar
            </label>
          </div>

          <!-- CONTRATO -->
          <div class="flex flex-col w-full relative -mt-2!">
            <select id="cbo-contratos" name="contratos" disabled></select>
            <label
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Contratos (*)
            </label>
          </div>

          <div class="w-full grid grid-cols-3 gap-3">
            <!-- TARIFA -->
            <div class="input flex flex-col w-full relative -mt-2!">
              <input
                id="tarifa"
                name="tarida"
                type="text"
                placeholder="Ingrese una tarifa"
                class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" disabled />
              <label
                for="tarifa"
                class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
                Tarifa (*)
              </label>
            </div>

            <!-- CONDICION -->
            <div class="flex flex-col w-full relative -mt-2!">
              <select id="cbo-condicion" name="condiciones" disabled></select>
              <label
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Condicion (*)
              </label>
            </div>

            <!-- TERRENO -->
            <div class="flex flex-col w-full relative -mt-2!">
              <select id="cbo-terreno" name="terreno" disabled></select>
              <label
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Terreno (*)
              </label>
            </div>
          </div>

          <!-- FECHA -->
          <div class="input flex flex-col w-full relative -mt-2!">
            <input
              id="fechaReasignacion"
              name="fechaReasignacion"
              type="text"
              placeholder="Ingrese una fecha"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" disabled />
            <label
              for="fechaReasignacion"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
              Fecha Reasignación(*)
            </label>
          </div>

          <div class="w-full grid-cols-2 gap-3 hidden inputs-plate">
            <!-- PLAZO -->
            <div class="input flex flex-col w-full relative -mt-2!">
              <input
                id="plazo"
                name="plazo"
                type="number"
                placeholder="Ingrese una plazo"
                class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" disabled />
              <label
                for="plazo"
                class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
                Plazo (Meses)(*)
              </label>
            </div>

            <!-- FECHA FIN -->
            <div class="input flex flex-col w-full relative -mt-2!">
              <input
                id="fechaFin"
                name="fechaFin"
                type="text"
                placeholder="Ingrese una fecha"
                class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" disabled />
              <label
                for="fechaFin"
                class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
                Fecha Fin(*)
              </label>
            </div>
          </div>

          <!-- OBSERVACION -->
          <div class="input flex flex-col w-full relative -mt-2!">
            <textarea
              id="observacion"
              name="observacion"
              type="text"
              placeholder="Ingrese la observación"
              class="peer order-2 w-full h-24 resize-none border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" disabled></textarea>
            <label
              for="observacion"
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500 peer-disabled:text-[#eee]">
              Observación (Opcional)
            </label>
          </div>

          <!-- ARCHIVO -->
          <div id="contenedorArchivo" class="w-full h-[180px] rounded-lg border-2 border-dashed border-gray-300 relative mt-2!">
            <label
              for="acta"
              class="text-gray-500 text-xs font-semibold absolute -top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
              Acta (Opcional)
            </label>
            <div class="w-full h-full flex justify-center items-center relative overflow-hidden">
              <!-- SUBA EL ARCHIVO -->
              <div class="contenedor-por-subir w-full flex flex-col justify-center items-center text-gray-400">
                <i class="bi bi-cloud-arrow-up text-3xl"></i>
                <span class="text-sm">Arraste o suba un archivo</span>
              </div>

              <!-- DESPUES DE SUBIRLO -->
              <div class="contenedor-subido w-full hidden flex-col justify-center items-center gap-2 px-2">
                <div class="w-full flex justify-center items-center gap-1 text-blue-500">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                  <span id="nombreArchivo" class="text-sm line-clamp-1">Nombre-de-archivo.pdf</span>
                </div>
                <div class="w-full flex justify-center items-center gap-2">
                  <button class="bg-green-100 text-green-700 px-2 py-1 w-fit rounded-md border border-green-700 cursor-pointer hover:bg-green-300 transition-colors outline-none"><i class="bi bi-eye-fill"></i></button>

                  <button class="bg-red-100 text-red-700 px-2 py-1 w-fit rounded-md border border-red-700 cursor-pointer hover:bg-red-300 transition-colors outline-none"><i class="bi bi-x"></i></button>
                </div>
              </div>

              <!-- INPUT -->
              <label id="labelActa" for="acta" class="w-full h-full flex cursor-pointer absolute top-0 left-0"></label>
              <input id="acta" type="file" class="hidden" accept=".pdf" disabled>
            </div>
          </div>

          <button id="btn-guardar" class="w-full px-3 py-2 rounded-md cursor-pointer flex justify-center items-center gap-2 bg-green-500 text-white hover:bg-green-700 transition-colors disabled:bg-gray-500 disabled:cursor-not-allowed" disabled>
            Guardar
            <div
              class="spinner hidden w-4 h-4 border-2 border-t-blue-500 border-gray-300 rounded-full animate-spin"></div>
          </button>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- MODAL PDF -->
<div class="modal-pdf fixed w-full h-screen top-0 left-0 flex justify-center items-center opacity-0 -z-[9990]">
  <div class="fixed w-full h-screen top-0 left-0 bg-black/25 container-overlay"></div>
  <div class="w-[80%] h-[650px] container-pdf">
    <iframe id="modalPdfViewer" width="100%" height="100%"></iframe>
  </div>
</div>

<script type="module">
  import {
    getVehiclesPending,
    getVehiclesNoPending,
    getClients,
    getOperations,
    getContractId,
    getDocumentId,
    uploadFileS3,
    saveOperation,
    validInputDate,
    convertirFecha,
    manejarArchivo,
    getContracts
  } from "/js/reasigna_vehiculo.js"

  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  document.title = "Reasignar vehiculos | Gescon";

  let activeRequests = 0;

  function showLoader({
    animated = false
  } = {}) {
    activeRequests++;

    document.body.style.overflow = "hidden";

    if (animated) {
      // aparece con animación
      $('#preloader-mini').css('z-index', '99999');

      animate("#preloader-mini", {
        opacity: [0, 1],
      }, {
        duration: 0.4,
        easing: "ease-out"
      });

    } else {
      // aparece instantáneo
      $('#preloader-mini').css({
        opacity: '1',
        zIndex: '99999'
      });
    }
  }

  function hideLoader({
    animated = true
  } = {}) {
    activeRequests = Math.max(0, activeRequests - 1);

    if (activeRequests === 0) {
      if (animated) {
        animate("#preloader-mini", {
          opacity: [1, 0],
        }, {
          duration: 0.45,
          easing: "ease-in"
        });

        setTimeout(() => {
          $('#preloader-mini').css('z-index', '-99999');

          document.body.style.overflow = "";

        }, 400);

      } else {
        // ocultar instantáneo
        $('#preloader-mini').css({
          opacity: '0',
          zIndex: '-99999'
        });
      }
    }
  }

  let table;
  let fp;
  let fpInit;
  let fpFinish;
  let selectedBeforeOperation = null;
  let selectedOperation = null;
  let selectedOperationName = null;
  let archivoActual = null;
  let archivoFila = null;

  document.addEventListener("DOMContentLoaded", async function() {
    showLoader();

    const listClients = await getClients();

    const listOperations = await getOperations();

    const listVehicle = await getVehiclesPending();

    const listOpeTable = listOperations.filter(op =>
      listVehicle.some(veh => veh.idOpeAsign == op.ID)
    );

    $("#cbo-clientes").select2({
      placeholder: "Seleccione un cliente",
      allowClear: false,
      language: {
        noResults: function() {
          return "No hay resultados disponibles";
        }
      },
      data: listClients.map(cli => ({
        id: cli.IDCLI,
        text: cli.CLINOM
      })),
      width: "100%"
    });

    $("#cbo-operaciones").select2({
      placeholder: "Seleccione una operación",
      allowClear: false,
      language: {
        noResults: function() {
          return "No hay resultados disponibles";
        }
      },
      data: listOpeTable.map(ope => ({
        id: ope.ID,
        text: ope.DESCRIPCION
      })),
      width: "100%"
    });

    $("#cbo-contratos").select2({
      placeholder: "Seleccione una contrato",
      allowClear: false,
      language: {
        noResults: function() {
          return "No hay resultados disponibles";
        }
      },
      data: [],
      width: "100%"
    })

    $("#cbo-condicion").select2({
      placeholder: "Seleccione una condición",
      allowClear: false,
      language: {
        noResults: function() {
          return "No hay resultados disponibles";
        }
      },
      data: [{
        id: "0",
        text: "Titular"
      }, {
        id: "1",
        text: "Retén"
      }, {
        id: "2",
        text: "Logística"
      }, {
        id: "3",
        text: "Pendiente"
      }],
      width: "100%"
    })

    $("#cbo-terreno").select2({
      placeholder: "Seleccione un terreno",
      allowClear: false,
      language: {
        noResults: function() {
          return "No hay resultados disponibles";
        }
      },
      data: [{
        id: "0",
        text: "Superficie"
      }, {
        id: "1",
        text: "Socavón"
      }, {
        id: "2",
        text: "Ciudad"
      }, {
        id: "3",
        text: "Severo"
      }, {
        id: "4",
        text: "Pendiente"
      }],
      width: "100%"
    })

    table = $("#listVehicles").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      // paging: false,
      lengthChange: false,
      pageLength: 100,
      emptyTable: "No hay vehículos disponibles",
      dom: '<"superior flex justify-between items-center"<"left flex items-center gap-2"f<"checkbox-view">><"leyendas">>rt<"inferior"i<"derecha-inferior"lp>>',
      scrollCollapse: true,
      scrollX: true,
      scrollY: 400,
      initComplete: function() {
        $(".leyendas").html(`
          <div class="w-full flex justify-center items-center gap-4">
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-red-400 rounded-sm"></span>
              <p class="text-xs !m-0">Desde</p>
            </div>
            <i class="bi bi-arrow-right text-blue-600"></i>
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-green-400 rounded-sm"></span>
              <p class="text-xs !m-0">Hasta</p>
            </div>
          </div>
        `);

        $(".checkbox-view").html(`
            <label class="relative inline-flex items-center cursor-pointer">
              <input class="check-table sr-only peer" type="checkbox" />
              <div
                class="w-10 h-6 rounded-full bg-blue-500 peer-checked:bg-green-500 transition-all duration-500 after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-4 after:w-4 after:flex after:items-center after:justify-center after:transition-all after:duration-500 peer-checked:after:translate-x-4 after:shadow-md after:text-xs"
              ></div>
              <span class="ml-1! text-sm font-medium text-gray-900 after:content-['Reasignación'] peer-checked:after:content-['Actualización']"></span>
            </label>
          `)

        $("#listVehicles thead th:first-child").html("");

        this.api().columns.adjust();
      },
      data: listVehicle,
      order: [
        [1, "asc"]
      ],
      select: {
        style: "single",
        selector: "td:first-child",
      },
      columnDefs: [{
          orderable: false,
          render: DataTable.render.select({
            header: false
          }),
          targets: 0,
        },
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          className: "dt-center",
          targets: [0, 1, 2, 3, 4],
        },
      ],
      columns: [{
          data: null, // CHECKBOX
          defaultContent: "",
        },
        {
          data: "placa",
          width: "15%"
        },
        {
          data: "fechaRef",
          render: (data, type) => {
            if (type === 'sort' || type === 'type') {
              return dayjs(convertirFecha(data)).format("YYYYMMDD");
            }
            return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
          },
          width: "15%"
        },
        {
          data: "opeAsign",
          width: "30%"
        },
        {
          data: "opeActual",
          width: "30%"
        },
      ],
    })

    $("#cbo-clientes").val(null).trigger("change");
    $("#cbo-operaciones").val(null).trigger("change");
    $("#cbo-contratos").val(null).trigger("change");
    $("#cbo-condicion").val(null).trigger("change");
    $("#cbo-terreno").val(null).trigger("change");

    fp = flatpickr("#fechaReasignacion", {
      dateFormat: "d/m/Y",
      locale: "es",
      allowInput: true,
      clickOpens: true,
    });

    fpFinish = flatpickr("#fechaFin", {
      dateFormat: "d/m/Y",
      locale: "es",
      allowInput: true,
      clickOpens: true,
    });

    $("thead .dt-select-checkbox").remove();

    table.on("select", async function(e, dt, type, indexes) {
      if (type === "row") {
        const row = table.row(indexes[0]);
        const data = row.data();

        const listContracts = await getContracts(data.idClienteOpe);

        const optList = listContracts.filter(cont => cont.ID != data.idContrato).map(cont => ({
          id: cont.ID,
          text: cont.DESCRIPCION
        }));

        $("#cbo-contratos").empty();

        $("#cbo-contratos").append(new Option(data.nroContrato, data.idContrato, false, false));

        optList.forEach(item => {
          const option = new Option(item.text, item.id, false, false);
          $("#cbo-contratos").append(option);
        });

        selectedBeforeOperation = data.idOpeAsign;
        selectedOperation = data.idOpeActual;
        selectedOperationName = data.opeActual;

        // VALOR DE CONTRATO ACTUAL
        $("#operacion").val(selectedOperationName);
        $("#cbo-contratos").val(data.idContrato).trigger("change");
        $("#cbo-condicion").val(data.condicion).trigger("change");
        $("#cbo-terreno").val(data.terreno).trigger("change");
        $("#tarifa").val(data.tarifa);

        const isChecked = $(".check-table").prop("checked")

        // CARGAR LOS CAMPOS EXTRAS DEL MODO CAMBIO
        if (isChecked) {
          const dateInit = dayjs(convertirFecha(data.fechaFin)).add(1, "day")
          const timeLimit = Number(data.plazoContrato);

          $("#fechaReasignacion").val(dateInit.format("DD/MM/YYYY"))

          fp.setDate(dateInit.format("DD/MM/YYYY"), true);
          fp.jumpToDate(dateInit.toDate());

          $("#plazo").val(timeLimit);

          const dateFinish = dayjs(convertirFecha(data.fechaFin)).add(timeLimit, "month");

          $("#fechaFin").val(dateFinish.format("DD/MM/YYYY"))
          fpFinish.setDate(dateFinish.format("DD/MM/YYYY"), true);
          fpFinish.jumpToDate(dateFinish.toDate());
        }

        // FIJAMOS LA FECHA EN LA MINIMA
        const minDate = dayjs(convertirFecha(data.fechaRef))
        if (!isChecked) {
          if (minDate) {
            const dateObj = minDate.toDate();

            fp.set("minDate", minDate.format("DD/MM/YYYY"));

            fp.jumpToDate(dateObj);
          }
        }


        // HABILITAMOS LOS CAMPOS
        $("#acta").prop("disabled", false)
        $("#fechaReasignacion").prop("disabled", false)
        $("#fechaFin").prop("disabled", false)
        $("#plazo").prop("disabled", false)
        $("#cbo-contratos").prop("disabled", false)
        $("#cbo-condicion").prop("disabled", false)
        $("#cbo-terreno").prop("disabled", false)
        $("#tarifa").prop("disabled", false)
        $("#btn-guardar").prop("disabled", false)
        $("#observacion").prop("disabled", false)
      }
    });

    table.on("deselect", function() {
      const allSelecteds = table.rows({
        selected: true
      }).data().toArray();

      if (allSelecteds.length === 0) {
        selectedBeforeOperation = null;
        selectedOperation = null;
        selectedOperationName = null;

        $("#cbo-contratos").empty();

        $("#operacion").val(null);
        $("#cbo-contratos").val(null).trigger("change")
        $("#cbo-condicion").val(null).trigger("change")
        $("#cbo-terreno").val(null).trigger("change")
        $("#tarifa").val(null);
        $("#plazo").val(null);
        fp.clear();
        fp.set("minDate", null);
        fpFinish.clear();
        fpFinish.set("minDate", null);

        archivoActual = null;

        // LIMPIAR ARCHIVO

        // limpiar input
        $("#acta").val("");
        $("#observacion").val(null)

        // volver a estado inicial
        $("#nombreArchivo").text("");

        // Mostrar el icono de nube
        $("#contenedorArchivo .contenedor-por-subir")
          .removeClass("hidden")
          .addClass("flex");

        // Ocultar el nombre y botones
        $("#contenedorArchivo .contenedor-subido")
          .addClass("hidden").removeClass("flex");

        // Habilitar el label de acta
        $("#labelActa").removeClass("hidden").addClass("flex")

        // DESHABILITAR CAMPOS
        $("#acta").prop("disabled", true)
        $("#fechaReasignacion").prop("disabled", true)
        $("#fechaFin").prop("disabled", true)
        $("#plazo").prop("disabled", true)
        $("#cbo-contratos").prop("disabled", true)
        $("#cbo-condicion").prop("disabled", true)
        $("#cbo-terreno").prop("disabled", true)
        $("#tarifa").prop("disabled", true)
        $("#btn-guardar").prop("disabled", true)
        $("#observacion").prop("disabled", true)
      }
    });

    hideLoader();
  })

  $("#listVehicles thead").on("click", "th:first-child", function(e) {
    e.stopPropagation();
  });

  $("#listVehicles thead").on("click", "th:first-child", function(e) {
    e.stopPropagation();
  });

  document.getElementById("fechaReasignacion").addEventListener("input", function(e) {
    validInputDate(e);
  });

  document.getElementById("fechaFin").addEventListener("input", function(e) {
    validInputDate(e);
  });

  $(document).on("click", ".check-table", async function() {
    showLoader({
      animated: true
    });

    $("#cbo-clientes").val(null).trigger("change");
    $("#cbo-operaciones").val(null).trigger("change");

    if ($(this).prop("checked")) {
      $(".inputs-plate").removeClass("hidden").addClass("grid");
      $("#contenedorArchivo").addClass("hidden").removeClass("block")
      $('label[for="fechaReasignacion"]').text("Fecha Inicio(*)")

      const listVehicle = await getVehiclesNoPending();

      table.clear();
      table.rows.add(listVehicle);
      table.draw();
    } else {
      $(".inputs-plate").addClass("hidden").removeClass("grid");
      $("#contenedorArchivo").removeClass("hidden").addClass("block")
      $('label[for="fechaReasignacion"]').text("Fecha Reasignación(*)")

      const listVehicle = await getVehiclesPending();

      table.clear();
      table.rows.add(listVehicle);
      table.draw();
    }

    clearFields();

    hideLoader();
  })

  $("#cbo-clientes").on("select2:select", async function() {
    showLoader({
      animated: true
    });

    const isChecked = $(".check-table").prop("checked")
    const idCli = $(this).val();

    const listOperations = await getOperations(idCli);
    let listVehicles = [];

    if (isChecked) {
      listVehicles = await getVehiclesNoPending(idCli)
    } else {
      listVehicles = await getVehiclesPending(idCli)
    }

    const listOpeTable = listOperations.filter(op =>
      listVehicles.some(veh => veh.idOpeAsign == op.ID)
    );

    const $operaciones = $("#cbo-operaciones");
    $operaciones.empty();

    $operaciones.append(new Option("", "", true, true));

    listOpeTable.forEach(op => {
      const option = new Option(op.DESCRIPCION, op.ID, false, false);
      $operaciones.append(option);
    });

    $operaciones.trigger("change");

    table.clear();
    table.rows.add(listVehicles);
    table.draw();

    clearFields();

    hideLoader();
  })

  $("#cbo-operaciones").on("select2:select", async function() {
    showLoader({
      animated: true
    })

    const isChecked = $(".check-table").prop("checked")
    const idOpe = $(this).val();
    const idCli = $("#cbo-clientes").val()

    let listVehicles = [];

    if (isChecked) {
      listVehicles = await getVehiclesNoPending(idCli, idOpe);
    } else {
      listVehicles = await getVehiclesPending(idCli, idOpe);
    }

    table.clear();
    table.rows.add(listVehicles);
    table.draw();

    clearFields();

    hideLoader();
  })

  $("#cbo-contratos").on("select2:select", async function() {
    const isChecked = $(".check-table").prop("checked")
    const contractId = $(this).val();

    if (isChecked) {
      let contract = null;
      const id = contractId.split("_")[1]
      const type = contractId.split("_")[0]

      if (type == "P") {
        contract = await getContractId(id);
      } else if (type == "H") {
        contract = await getDocumentId(id);
      }

      // REALIZA EL CALCULO DE LA FECHA FINAL
      const dateInit = dayjs($("#fechaReasignacion").val(), "DD/MM/YYYY")
      const timeLimit = Number(contract.duracion);

      $("#plazo").val(timeLimit);

      const dateFinish = dateInit.add(timeLimit, "month").subtract(1, "day");

      $("#fechaFin").val(dateFinish.format("DD/MM/YYYY"))
      fpFinish.setDate(dateFinish.format("DD/MM/YYYY"), true);
      fpFinish.jumpToDate(dateFinish.toDate());
    }
  })

  $("#fechaReasignacion").on("input", async function() {
    const isChecked = $(".check-table").prop("checked")
    const dateInit = dayjs($(this).val(), "DD/MM/YYYY")

    if (isChecked) {
      // REALIZA EL CALCULO DE LA FECHA FINAL
      const timeLimit = Number($("#plazo").val());

      const dateFinish = dateInit.add(timeLimit, "month").subtract(1, "day");

      $("#fechaFin").val(dateFinish.format("DD/MM/YYYY"))
      fpFinish.setDate(dateFinish.format("DD/MM/YYYY"), true);
      fpFinish.jumpToDate(dateFinish.toDate());
    }
  })

  $("#plazo").on("input", async function() {
    const isChecked = $(".check-table").prop("checked")
    const timeLimit = Number($(this).val());

    if (isChecked) {
      // REALIZA EL CALCULO DE LA FECHA FINAL
      const dateInit = dayjs($("#fechaReasignacion").val(), "DD/MM/YYYY")

      const dateFinish = dateInit.add(timeLimit, "month").subtract(1, "day");

      $("#fechaFin").val(dateFinish.format("DD/MM/YYYY"))
      fpFinish.setDate(dateFinish.format("DD/MM/YYYY"), true);
      fpFinish.jumpToDate(dateFinish.toDate());
    }
  })

  // DRAG AND DROP
  const $dropZone = $("#contenedorArchivo");
  const $input = $("#acta");

  $dropZone.on("dragover", function(e) {
    e.preventDefault();
    e.stopPropagation();

    if ($input.prop("disabled")) return;

    $(this).addClass("border-blue-400 bg-blue-50");
  });

  $dropZone.on("dragleave", function(e) {
    e.preventDefault();
    e.stopPropagation();

    $(this).removeClass("border-blue-400 bg-blue-50");
  });

  $dropZone.on("drop", function(e) {
    e.preventDefault();
    e.stopPropagation();

    $(this).removeClass("border-blue-400 bg-blue-50");

    if ($input.prop("disabled")) return;

    const files = e.originalEvent.dataTransfer.files;

    const getFile = manejarArchivo(files[0]);

    archivoActual = getFile;
  });

  $input.on("change", function() {
    const file = this.files[0];

    const getFile = manejarArchivo(file);

    archivoActual = getFile;
  });

  $("#contenedorArchivo").on("click", ".bi-x", function() {
    archivoActual = null;

    // limpiar input
    $("#acta").val("");

    // volver a estado inicial
    $("#nombreArchivo").text("");

    // Mostrar el icono de nube
    $("#contenedorArchivo .contenedor-por-subir")
      .removeClass("hidden")
      .addClass("flex");

    // Ocultar el nombre y botones
    $("#contenedorArchivo .contenedor-subido")
      .addClass("hidden").removeClass("flex");

    // Habilitar el label de acta
    $("#labelActa").removeClass("hidden").addClass("flex")
  });

  $("#contenedorArchivo").on("click", ".bi-eye-fill", function() {
    if (!archivoActual) {
      toastr.warning("No hay archivo para visualizar", "Oops...");
      return;
    }

    const url = URL.createObjectURL(archivoActual);

    $("#modalPdfViewer").attr("src", url);

    // mostrar modal
    $(".modal-pdf").removeClass("opacity-0 -z-[9990]").addClass("opacity-100 z-[9990]");
    animate(".container-pdf", {
      opacity: [0, 1],
      scale: [0.7, 1.05, 1]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })
  });

  $(".container-overlay").on("click", async function() {
    const anim = animate(".container-pdf", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })

    await anim.finished;

    $(".modal-pdf").removeClass("opacity-100 z-[9990]").addClass("opacity-0 -z-[9990]");
  })

  $("#tarifa").on("input", function() {
    let value = $(this).val();

    // eliminar todo lo que no sea número o punto
    value = value.replace(/[^0-9.]/g, "");

    // evitar más de un punto
    const parts = value.split(".");
    if (parts.length > 2) {
      value = parts[0] + "." + parts.slice(1).join("");
    }

    $(this).val(value);
  });

  // GUARDAR
  function showSpinner(element) {
    $(element).find(".spinner").removeClass("hidden")
    $(element).prop("disabled", true)
  }

  function hideSpinner(element) {
    $(element).find(".spinner").addClass("hidden")
    $(element).prop("disabled", false)
  }

  $("#btn-guardar").on("click", async function() {
    showSpinner(this);

    const row = table.row({
      selected: true
    });
    const rowData = row.data();

    if (!rowData) {
      toastr.info("Debe seleccionar un vehículo", "Aviso");
      hideSpinner(this);
      return;
    }

    // CAMPOS - REASIGNACION TIPICA
    const idAssign = rowData.idAsign;
    const date = $("#fechaReasignacion").val(); // SE REUTILIZA PAR AMBOS CASOS (FECHA REASIGNACION | FECHA INICIO)
    const contract = $("#cbo-contratos").val();
    const condition = $("#cbo-condicion").val();
    const terrain = $("#cbo-terreno").val();
    const observation = $("#observacion").val();
    const tariff = $("#tarifa").val();
    const file = $("#acta")[0].files[0];

    // CAMPOS EXTRAS - REASIGNACION POCO COMÚN
    const timeLine = $("#plazo").val();
    const dateFinish = $("#fechaFin").val();
    const isChecked = $(".check-table").prop("checked")


    if (isChecked) {
      if (!date || !tariff || !contract || !condition || !terrain || !timeLine || !dateFinish) {
        hideSpinner(this);
        toastr.info("Debes completar todos los campos", "Aviso");
        return;
      }

      const validDate = dayjs(date, "DD/MM/YYYY").add(Number(timeLine), 'month').isSame(dayjs(dateFinish, "DD/MM/YYYY"));

      if (!validDate) {
        hideSpinner(this);
        toastr.info("El calculo de la fecha fin no es el correcto", "Aviso");
        return;
      }
    } else {
      if (!date || !tariff || !contract || !condition || !terrain) {
        hideSpinner(this);
        toastr.info("Debes completar todos los campos", "Aviso");
        return;
      }
    }

    let key = null;

    if (file !== undefined) {
      const uploadFile = await uploadFileS3(file);
      key = uploadFile.key;
    }

    const data = {
      beforeOperation: selectedBeforeOperation,
      operation: selectedOperation,
      contract,
      condition,
      terrain,
      tariff,
      date: dayjs(date, "DD/MM/YYYY").format("YYYY-MM-DD"),
      dateFinish: dateFinish ? dayjs(dateFinish, "DD/MM/YYYY").format("YYYY-MM-DD") : null,
      timeLine: timeLine != "" ? timeLine : null,
      observation,
      file: key,
      isChecked,
    };

    const result = await saveOperation(idAssign, data);

    if (result.success) {
      if(isChecked) {
        row.deselect();
      } else {
        row.remove().draw(false);
      }
      clearFields();
      toastr.success(result.message, "¡Éxito!");
    }

    // console.log(data);

    // setTimeout(() => {
    //   clearFields();
    //   toastr.success("Guardo con exito", "¡Éxito!");

    //   hideSpinner(this);
    // }, 1500)

    hideSpinner(this);
  });

  function clearFields() {
    selectedBeforeOperation = null;
    selectedOperation = null;
    selectedOperationName = null;

    $("#operacion").val(null)
    $("#fechaReasignacion").val(null)
    $("#fechaFin").val(null)
    $("#plazo").val(null)
    $("#cbo-contratos").val(null).trigger("change")
    $("#cbo-condicion").val(null).trigger("change")
    $("#cbo-terreno").val(null).trigger("change")
    $("#tarifa").val(null)
    $("#observacion").val(null)
    fp.clear();
    fp.set("minDate", null);

    archivoActual = null;

    // limpiar input
    $("#acta").val("");

    // volver a estado inicial
    $("#nombreArchivo").text("");

    // Mostrar el icono de nube
    $("#contenedorArchivo .contenedor-por-subir")
      .removeClass("hidden")
      .addClass("flex");

    // Ocultar el nombre y botones
    $("#contenedorArchivo .contenedor-subido")
      .addClass("hidden").removeClass("flex");

    // Habilitar el label de acta
    $("#labelActa").removeClass("hidden").addClass("flex")

    $("#acta").prop("disabled", true)
    $("#fechaReasignacion").prop("disabled", true)
    $("#fechaFin").prop("disabled", true)
    $("#plazo").prop("disabled", true)
    $("#cbo-contratos").prop("disabled", true)
    $("#cbo-condicion").prop("disabled", true)
    $("#cbo-terreno").prop("disabled", true)
    $("#tarifa").prop("disabled", true)
    $("#btn-guardar").prop("disabled", true)
    $("#observacion").prop("disabled", true)
  }
</script>

<?php
require '../templates/footer.html';
?>