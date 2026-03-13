<?php
require './templates/header.html';
?>

<style>
  <?php include '../css/views/query_documents_by_contract.css'; ?>
</style>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

<div id="preloader-mini">
  <div class="gif-container">
    <img src="../img/carpeta.gif" alt="Cargando...">
  </div>
  <div class="welcome-message">
    <p>¡Cargando!.....</p>
  </div>
</div>

<main class="main-query-doc">
  <div class="header-title">
    <h1>Documentos de contrato</h1>
    <p>Nro de contrato consultado: <span id="parametroPintado"></span></p>
  </div>

  <div class="container-data">
    <div class="column-table">
      <table id="listDocuments" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>N° Documento</th>
            <th>Fecha Firma</th>
            <th>Duracion</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Item</th>
            <th>N° Documento</th>
            <th>Fecha Firma</th>
            <th>Duracion</th>
            <th>Cantidad</th>
          </tr>
        </tfoot>
      </table>
      <div class="item-result">
        <label for="descripcion-result">Descripción</label>
        <textarea id="descripcion-result" readonly></textarea>
      </div>
    </div>

    <div class="result-search">
      <h3>Resumen</h3>
      <hr />
      <div class="item-result">
        <label for="fec-fin-result">Fecha Fin</label>
        <input id="fec-fin-result" readonly>
      </div>
      <div class="item-result">
        <label for="estado-result">Estado</label>
        <input id="estado-result" readonly>
      </div>
      <div class="item-result">
        <label for="tipo-result">Tipo de Doc.</label>
        <input id="tipo-result" readonly>
      </div>
      <div class="item-result">
        <label for="motivo-result">Motivo</label>
        <input id="motivo-result" readonly>
      </div>
      <div class="item-result">
        <label for="km-total-result">Km Total</label>
        <input id="km-total-result" readonly>
      </div>
      <div class="item-result">
        <label for="km-adi-result">Km Adicional</label>
        <input id="km-adi-result" readonly>
      </div>
      <div>
        <ul>
          <li id="sup-modal">
            <span>Sup</span>
            <p id="sup-result">0</p>
          </li>
          <li id="sev-modal">
            <span>Sev</span>
            <p id="sev-result">0</p>
          </li>
          <li id="soc-modal">
            <span>Soc</span>
            <p id="soc-result">0</p>
          </li>
          <li id="ciu-modal">
            <span>Ciu</span>
            <p id="ciu-result">0</p>
          </li>
        </ul>
      </div>
      <div id="view-leasings" class="leasing-result">
        <span>N° Leasings</span>
        <div class="card-lea">
          <i class="fa fa fa-book" style="color: #0e2e67;"></i>
          <p id="leasing-result">0</p>
        </div>
      </div>
      <button class="btn-success" id="btn-document">
        Ver documento
        <i class="bi bi-file-earmark-arrow-down-fill"></i>
      </button>
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

<script src="../js/consulta_documentos_por_contrato.js"></script>
<script type="module">
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
  };

  document.addEventListener("DOMContentLoaded", async () => {
    const param = new URLSearchParams(window.location.search);
    const clienteId = param.get("clienteId");
    const contratoId = param.get("contratoId");
    const documentoId = param.get("documentoId")

    if (!contratoId || !clienteId) alert("No se encontraron los parametros necesarios")

    const textSpan = document.getElementById("parametroPintado");
    textSpan.innerHTML = contratoId;

    const documents = await getDocuments(contratoId, clienteId);

    const table = $("#listDocuments").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      select: true,
      data: documents,
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
            return convertirFecha(data);
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
      $("#fec-fin-result").val(fechaFin);
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

      // ABRIR EL PDF
      $("#btn-document").off("click").on("click", () => {
        window.open(detailDocument.archivoPdf, '_blank');
      })
    }

    $("#listDocuments tbody").on("click", "tr", async function() {
      $('tr').removeClass("selected-row");

      $(this).addClass("selected-row");

      const data = table.row(this).data();

      param.set("documentoId", data.id)

      const nuevaURL = `${window.location.pathname}?${param.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      const detailDocument = await getDetailDocument(data.id);

      const fechaIni = convertirFecha(detailDocument.firma)
      const fechaFin = calcularFechaFin(fechaIni, detailDocument.duracion);
      const estado = obtenerEstado(fechaFin);

      // INPUTS DE DATOS
      $("#fec-fin-result").val(fechaFin);
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

      // ABRIR EL PDF
      $("#btn-document").off("click").on("click", () => {
        window.open(detailDocument.archivoPdf, '_blank');
      })
    })

    table.on("page.dt", () => {
      $('tr').removeClass("selected-row");
    })
  })

  $("#sup-modal").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SUPERFICIE");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSup" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
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

    $("#listVehSup").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
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
              return convertirFecha(data);
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
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#sev-modal").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SEVERO");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSev" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
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

    $("#listVehSev").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
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
              return convertirFecha(data);
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
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#soc-modal").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "SOCAVON");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehSoc" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
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

    $("#listVehSoc").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
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
              return convertirFecha(data);
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
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#ciu-modal").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const documentoId = param.get("documentoId")

    if (!documentoId) return;

    const vehicles = await getVehByDocument(documentoId, "CIUDAD");

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVehCiu" class="display">
        <thead>
          <tr>
            <th>Item</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
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

    $("#listVehCiu").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
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
              return convertirFecha(data);
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
    const modal = document.getElementById("modal-documents");
    modal.style.display = "flex";
  })

  $("#btn-close").on("click", function() {
    const modal = document.getElementById("modal-documents");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })

  $("#view-leasings").on("click", () => {
    const params = new URLSearchParams(window.location.search);
    const clienteId = params.get("clienteId")
    const documentoId = params.get("documentoId")

    if (!documentoId || !clienteId) return;

    window.location.href = `consultar_leasing_por_documento.php?documentoId=${documentoId}&clienteId=${clienteId}`;
  })
</script>

<?php
require './templates/footer.html';
?>