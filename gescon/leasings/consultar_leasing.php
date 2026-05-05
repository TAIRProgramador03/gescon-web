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

<!-- MOTION -->
<script src="https://cdn.jsdelivr.net/npm/motion@10/dist/motion.min.js"></script>

<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/views/query_leasing.css' ?>
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

<main class="main-container" data-route-permission="ver_leasing">
  <div class="container-info">
    <div class="container-table flex flex-col gap-4 px-9 py-7">
      <div class="w-full h-3 bg-cyan-700 absolute top-0 left-0"></div>
      <div class="w-full flex flex-col justify-center gap-2">
        <h3 id="title-form" class="text-5xl text-[#002141] font-semibold">Consulta de Leasing</h3>
        <p id="desc-form" class="!m-0 text-base font-normal text-gray-500">Visualice y consulte la información de los leasing registrados en el sistema.</p>
      </div>
      <div class="w-full grid grid-cols-4 gap-6">
        <div class="row-filter">
          <div class="flex flex-col w-full relative">
            <select id="filter-bank" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente"></select>

            <label
              for="filter-bank"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Bancos
            </label>
          </div>
        </div>
        <div id="row-client" class="row-filter">
          <div class="flex flex-col w-full relative">
            <select id="filter-client" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente"></select>

            <label
              for="filter-client"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Clientes
            </label>
          </div>
        </div>
        <div id="row-contract" class="row-filter filter-hidden">
          <div class="flex flex-col w-full relative">
            <select id="filter-contract" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente"></select>

            <label
              for="filter-contract"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Contratos
            </label>
          </div>
        </div>
        <div id="row-document" class="row-filter filter-hidden">
          <div class="flex flex-col w-full relative">
            <select id="filter-document" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente"></select>

            <label
              for="filter-document"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Documentos
            </label>
          </div>
        </div>
      </div>
      <table id="listLeasing" class="display">
        <thead>
          <tr>
            <th class="!font-medium text-gray-500">Item</th>
            <th class="!font-medium text-gray-500">Nro Leasing</th>
            <th class="!font-medium text-gray-500">Banco</th>
            <th class="!font-medium text-gray-500">Cantidad</th>
            <th class="!font-medium text-gray-500">Fecha Inicio</th>
            <th class="!font-medium text-gray-500">Fecha Fin</th>
            <th class="!font-medium text-gray-500">Periodo de gracia</th>
            <th class="!font-medium text-gray-500">Cliente</th>
            <th class="!font-medium text-gray-500">Cliente Origen</th>
            <th class="!font-medium text-gray-500">Contrato/Adenda</th>
            <th class="!font-medium text-gray-500">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr></tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<div id="modal-leasing">
  <div class="modal-container">
    <div class="modal-header text-white">
      <i class="bi bi-info-circle"></i>
      <h2 class="font-medium">Unidades del leasing</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<script src="/js/consulta_leasings.js"></script>
<script>
  document.title = "Consultar leasings | Gescon";

  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $('#preloader-mini').css('opacity', '1');
    $('#preloader-mini').css('z-index', '99999');
  }

  function hideLoader() {
    activeRequests--;
    if (activeRequests <= 0) {
      Motion.animate("#preloader-mini", {
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

  $(document).on("DOMContentLoaded", async () => {
    showLoader();

    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);

    $("#filter-bank").select2({
      allowClear: false,
      data: [{
          id: 0,
          text: "Todos"
        },
        {
          id: 1,
          text: "BANBIF"
        },
        {
          id: 2,
          text: "BBVA"
        },
        {
          id: 3,
          text: "BCP"
        },
        {
          id: 4,
          text: "HSBC"
        },
        {
          id: 5,
          text: "INTERBANK"
        },
        {
          id: 6,
          text: "SCOTIABANK"
        },
        {
          id: 7,
          text: "TAIR"
        },
        {
          id: 8,
          text: "SANTANDER"
        },
      ],
      width: "100%"
    });

    const clients = await getClients();

    $("#filter-client").select2({
      allowClear: false,
      data: [{
          id: 0,
          text: "Todos"
        },
        ...clients.map(cli => ({
          id: cli.IDCLI,
          text: cli.CLINOM
        }))
      ],
      width: "100%"
    });

    $("#filter-contract").select2({
      allowClear: false,
      width: "100%"
    });
    $("#filter-document").select2({
      allowClear: false,
      width: "100%"
    });

    const params = new URLSearchParams(window.location.search);

    const bank = params.get("banco");
    const clientId = params.get("clienteId");
    const contractId = params.get("contratoId");
    const documentId = params.get("documentoId");

    let leasings;

    if (bank) {
      $("#filter-bank").val(bank).trigger("change");
    }

    if (clientId) {
      $("#filter-client").val(clientId).trigger("change");

      const contracts = await getContractsByClient(clientId);

      $("#filter-contract")
        .empty()
        .append(new Option("Todos", 0, false, false));

      contracts.forEach((cont) => {
        $("#filter-contract").append(
          new Option(cont.DESCRIPCION, cont.ID, false, false)
        );
      });

      $("#filter-contract").trigger("change");
      $("#row-contract").removeClass("filter-hidden");

      if (contractId) {
        $("#filter-contract").val(contractId).trigger("change");

        const documents = await getDocumentsByContract(contractId, clientId);

        $("#filter-document")
          .empty()
          .append(new Option("Todos", 0, false, false));

        documents.forEach((doc) => {
          $("#filter-document").append(
            new Option(doc.nroDocumento, doc.id, false, false)
          );
        });

        $("#filter-document").trigger("change");
        $("#row-document").removeClass("filter-hidden");

        if (documentId) {
          $("#filter-document").val(documentId).trigger("change");
        }
      }
    }

    if (documentId) {
      leasings = await getLeasings(bank, clientId, documentId, "H");
    } else if (contractId) {
      leasings = await getLeasings(bank, clientId, contractId, "P");
    } else {
      leasings = await getLeasings(bank, clientId);
    }

    table = $("#listLeasing").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollX: true,
      scrollY: "500px",
      scrollCollapse: true,
      dom: '<"superior"fB>rt<"inferior"i<"derecha-inferior"lp>>',
      buttons: [{
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: 'Excel',
        className: 'btn-excel',
        action: async function(e, dt, button, config) {
          const dataRow = dt.rows({
            search: 'applied'
          }).data().toArray();
          await generarExcel(dataRow, "Reporte de Leasings");
        }
      }],
      data: leasings,
      "columnDefs": [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          "className": "dt-center",
          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        }
      ],
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "70px",
        },
        {
          data: "nroLeasing",
          width: "150px",
        },
        {
          data: "banco",
          width: "100px",
        },
        {
          data: "cantidad",
          render: (data) => {
            return `${data} und.`
          },
          width: "90px",
        },
        {
          data: "fechaIni",
          render: (data, type) => {
            if (!data) return type === 'sort' ? 0 : "Sin fecha";

            if (type === 'sort' || type === 'type') {
              return dayjs(convertirFecha(data.toString())).format("YYYYMMDD");
            }

            return dayjs(convertirFecha(data.toString())).format("DD/MM/YYYY");
          },
          width: "120px",
        },
        {
          data: "fechaFin",
          render: (data, type) => {
            if (!data) return type === 'sort' ? 0 : "Sin fecha";

            if (type === 'sort' || type === 'type') {
              return dayjs(convertirFecha(data.toString())).format("YYYYMMDD");
            }

            return dayjs(convertirFecha(data.toString())).format("DD/MM/YYYY");
          },
          width: "120px",
        },
        {
          data: "perGracia",
          render: (data) => {
            if (data) {
              if (data > 0) {
                return `${data} meses`
              } else {
                return `Sin periodo`
              };
            } else {
              return "Sin periodo";
            }
          },
          width: "150px",
        },
        {
          data: "cliente",
          width: "180px",
        },
        {
          data: "clienteOrigen",
          render: (data, type, row) => {
            return data == "" ? row.cliente : data;
          },
          width: "180px",
        },
        {
          data: "nroContrato",
          width: "180px",
        },
        {
          data: "archivoPdf",
          render: (data, type, row) => {
            return `
              <div class="w-full flex justify-center items-center gap-2">
                <button class="btn-view" data-permissions="ver_placas" onClick="verFlota('${row.id}')">
                  <i class="bi bi-car-front-fill"></i>
                  <span>Ver Flota</span>
                </button>
                <button class="btn-file" onClick="verPdf('${data}')">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                  <span>Ver PDF</span>
                </button>
              </div>
            `
          },
          width: "200px",
        },
      ],
    })

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })

    table.on("draw.dt", function() {
      aplicarPermisos();
    });

    hideLoader();
  })

  $("#filter-bank").on("select2:select", async () => {
    const bank = $("#filter-bank").val();

    const params = new URLSearchParams(window.location.search)
    const clientId = params.get("clienteId");
    const contractId = params.get("contratoId");
    const documentId = params.get("documentoId")

    let leasings;

    if (bank != 0) {
      params.set("banco", bank)

      if (clientId) {
        if (contractId) {
          if (documentId) {
            leasings = await getLeasings(bank, clientId, documentId, 'H');
          } else {
            leasings = await getLeasings(bank, clientId, contractId, 'P');
          }
        } else {
          leasings = await getLeasings(bank, clientId);
        }
      } else {
        leasings = await getLeasings(bank);
      }
    } else {
      params.delete("banco")

      if (clientId) {
        if (contractId) {
          if (documentId) {
            leasings = await getLeasings(undefined, clientId, documentId, 'H');
          } else {
            leasings = await getLeasings(undefined, clientId, contractId, 'P');
          }
        } else {
          leasings = await getLeasings(undefined, clientId);
        }
      } else {
        leasings = await getLeasings();
      }
    }

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    table.clear();
    table.rows.add(leasings);
    table.draw();
  })

  $("#filter-client").on("select2:select", async () => {
    const clientId = $("#filter-client").val();
    const params = new URLSearchParams(window.location.search)
    const bank = params.get("banco")

    let leasings;

    console.log(clientId);

    if (clientId != 0) {
      params.set("clienteId", clientId)

      console.log("SI HAY CLIENTE");

      leasings = await getLeasings(bank, clientId);

      const contracts = await getContractsByClient(clientId);
      $('#filter-contract').empty();
      $('#filter-contract').append(new Option("Todos", 0, false, false)).trigger('change')

      contracts.forEach((cont) => {
        var newContract = {
          id: cont.ID,
          text: cont.DESCRIPCION
        };

        var option = new Option(newContract.text, newContract.id, false, false);
        $('#filter-contract').append(option).trigger('change');
      })

      $("#row-contract").removeClass("filter-hidden");
    } else {
      params.delete("clienteId")

      leasings = await getLeasings(bank);

      $("#filter-contract").val('0').trigger('change')
      $("#filter-document").val('0').trigger('change')

      $("#row-contract").addClass("filter-hidden");
    }

    console.log(leasings);

    params.delete("contratoId")
    params.delete("documentoId")

    $("#row-document").addClass("filter-hidden");

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    table.clear();
    table.rows.add(leasings);
    table.draw();
  })

  $("#filter-contract").on("select2:select", async () => {
    const contractId = $("#filter-contract").val();
    const params = new URLSearchParams(window.location.search)
    const bank = params.get("banco")
    const clientId = params.get("clienteId")

    let leasings;

    if (contractId != 0) {
      params.set("contratoId", contractId)

      leasings = await getLeasings(bank, clientId, contractId, 'P');

      const documents = await getDocumentsByContract(contractId, clientId);
      $('#filter-document').empty();
      $('#filter-document').append(new Option("Todos", 0, false, false)).trigger('change')

      documents.forEach((doc) => {
        var newDocument = {
          id: doc.id,
          text: doc.nroDocumento
        };

        var option = new Option(newDocument.text, newDocument.id, false, false);
        $('#filter-document').append(option).trigger('change');
      })

      $("#row-document").removeClass("filter-hidden");
    } else {
      params.delete("contratoId")
      params.delete("documentoId")

      leasings = await getLeasings(bank, clientId);

      $("#filter-document").val('0').trigger('change')

      $("#row-document").addClass("filter-hidden");
    }

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    table.clear();
    table.rows.add(leasings);
    table.draw();
  })

  $("#filter-document").on("select2:select", async () => {
    const documentId = $("#filter-document").val();
    const params = new URLSearchParams(window.location.search)
    const bank = params.get("banco")
    const clientId = params.get("clienteId")
    const contractId = params.get("contratoId")

    let leasings;

    if (documentId != 0) {
      params.set("documentoId", documentId)

      leasings = await getLeasings(bank, clientId, documentId, 'H');
    } else {
      params.delete("documentoId")

      leasings = await getLeasings(bank, clientId, contractId, 'P');
    }

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    table.clear();
    table.rows.add(leasings);
    table.draw();
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
require '../templates/footer.html';
?>