<?php
require './templates/header.html';
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- CSS DATATABLE -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />

<!-- JS DATATABLE -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- TOASTR CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
  <?php include '../css/views/query_leasing.css' ?>
</style>

<div id="preloader-mini">
  <div class="gif-container">
    <img src="../img/carpeta.gif" alt="Cargando...">
  </div>
  <div class="welcome-message">
    <p>¡Cargando!.....</p>
  </div>
</div>

<main class="main-container">
  <div class="header">
    <h1>Administración de Leasings</h1>
  </div>

  <div class="container-info">
    <div class="container-table">
      <table id="listLeasing" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Nro Leasing</th>
            <th>Banco</th>
            <th>Cantidad</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Periodo</th>
            <th>Tipo</th>
            <th>Archivo</th>
          </tr>
        </thead>
        <tbody>
          <tr></tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Item</th>
            <th>Nro Leasing</th>
            <th>Banco</th>
            <th>Cantidad</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Periodo</th>
            <th>Tipo</th>
            <th>Archivo</th>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="container-filter">
      <h3>Segmentación</h3>
      <hr>
      <div class="row-filter">
        <label for="filter-bank">Bancos</label>
        <select id="filter-bank"></select>
      </div>
      <div id="row-client" class="row-filter filter-hidden">
        <label for="filter-client">Clientes</label>
        <select id="filter-client"></select>
      </div>
      <div id="row-contract" class="row-filter filter-hidden">
        <label for="filter-contract">Contratos</label>
        <select id="filter-contract"></select>
      </div>
      <div id="row-document" class="row-filter filter-hidden">
        <label for="filter-document">Documentos</label>
        <select id="filter-document"></select>
      </div>
    </div>
  </div>
</main>

<div id="modal-leasing">
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

<script src="../js/consulta_leasings.js"></script>
<script>
  let table;
  $(document).on("DOMContentLoaded", async () => {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);

    $("#filter-bank").select2({
      data: [{
          id: 0,
          text: "Seleccione un banco"
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
      ]
    });

    const clients = await getClients();

    $("#filter-client").select2({
      data: [{
          id: 0,
          text: "Seleccione un cliente"
        },
        ...clients.map(cli => ({
          id: cli.IDCLI,
          text: cli.CLINOM
        }))
      ]
    });

    $("#filter-contract").select2();
    $("#filter-document").select2();

    const params = new URLSearchParams(window.location.search)
    const bank = params.get("banco")
    const clientId = params.get("clienteId")
    const contractId = params.get("contratoId")
    const documentId = params.get("documentoId")

    let leasings;

    if (bank) {
      $("#filter-bank").val(bank).trigger("change");
      $("#row-client").removeClass("filter-hidden");

      if (clientId) {
        $("#filter-client").val(clientId).trigger("change")


        const contracts = await getContractsByClient(clientId);
        $('#filter-contract').append(new Option("Seleccione un contrato", 0, false, false)).trigger('change')

        contracts.forEach((cont) => {
          var newContract = {
            id: cont.ID,
            text: cont.DESCRIPCION
          };

          var option = new Option(newContract.text, newContract.id, false, false);
          $('#filter-contract').append(option).trigger('change');
        })

        $("#row-contract").removeClass("filter-hidden");

        if (contractId) {
          $("#filter-contract").val(contractId).trigger("change")

          const documents = await getDocumentsByContract(contractId, clientId);
          $('#filter-document').append(new Option("Seleccione un documento", 0, false, false)).trigger('change')

          documents.forEach((doc) => {
            var newDocument = {
              id: doc.id,
              text: doc.nroDocumento
            };

            var option = new Option(newDocument.text, newDocument.id, false, false);
            $('#filter-document').append(option).trigger('change');
          })

          $("#row-document").removeClass("filter-hidden");

          if (documentId) {
            $("#filter-document").val(documentId).trigger("change")

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
      leasings = await getLeasings();
    }

    table = $("#listLeasing").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      data: leasings,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "nroLeasing"
        },
        {
          data: "banco"
        },
        {
          data: "cantidad"
        },
        {
          data: "fechaIni",
          render: (data) => {
            if (data) {
              return convertirFecha(data.toString())
            } else {
              return "--";
            }
          }
        },
        {
          data: "fechaFin",
          render: (data) => {
            if (data) {
              return convertirFecha(data.toString())
            } else {
              return "--";
            }
          }
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
              return "--";
            }
          }
        },
        {
          data: "tipoCon"
        },
        {
          data: "archivoPdf",
          render: (data) => {
            return `
              <button class="btn-file" id="btn-file" onClick="verPdf('${data}')">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>Ver PDF</span>
              </button>
            `
          }
        },
      ],
    })

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })
  })

  $("#listLeasing tbody").on("click", "tr", async function(e) {
    const data = table.row(this).data();

    const vehicles = await getVehByLeasing(data.id);

    $("#modal-body-info").append(`
      <table id="listVeh" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Cantidad</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Fecha Fin</th>
            <th>Vence en</th>
            <th>Leasing</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Terreno</th>
            <th>Cantidad</th>
            <th>Año</th>
            <th>Color</th>
            <th>Operación</th>
            <th>Fecha Fin</th>
            <th>Vence en</th>
            <th>Leasing</th>
          </tr>
        </tfoot>
      </table>
    `);

    $("#listVeh").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      select: true,
      data: vehicles,
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
          data: "terreno",
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
              return convertirFecha(data.toString())
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
              if(dias > 0) {
                return `${dias} dias`
              } else if(dias < 0) {
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

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "flex";
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


      $("#row-client").removeClass("filter-hidden");
    } else {
      params.delete("banco")
      params.delete("clienteId")
      params.delete("contratoId")
      params.delete("documentoId")

      leasings = await getLeasings();

      $("#filter-client").val('0').trigger('change')

      $("#filter-contract").val('0').trigger('change')
      $("#filter-document").val('0').trigger('change')

      $("#row-client").addClass("filter-hidden");
      $("#row-contract").addClass("filter-hidden");
      $("#row-document").addClass("filter-hidden");
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

    if (clientId != 0) {
      params.set("clienteId", clientId)

      leasings = await getLeasings(bank, clientId);

      const contracts = await getContractsByClient(clientId);
      $('#filter-contract').empty();
      $('#filter-contract').append(new Option("Seleccione un contrato", 0, false, false)).trigger('change')

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
      $('#filter-document').append(new Option("Seleccione un documento", 0, false, false)).trigger('change')

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

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-leasing");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })
</script>

<?php
require './templates/footer.html';
?>