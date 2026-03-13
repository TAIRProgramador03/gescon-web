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

<!-- CSS DE LA VISTA CONSULTAR CONTRATOS -->
<style>
  <?php include '../css/views/query_contract.css'; ?>
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
<main>
  <div class="contenedor">
    <div class="form-col-1 contenedor-col-1">
      <div class="tittle-form-col">
        <h3>Administracion de Contratos</h3>
      </div>
      <div class="cbo-form-col">
        <label for="combo-box">Seleccione el Cliente:</label>
        <select id="combo-box" name="opciones" class="cbo-form-cliente"></select>
      </div>
      <div class="cbo-form-col">
        <label for="combo-contrato">Seleccione el Contrato:</label>
        <select id="combo-contrato" name="opciones" class="cbo-form-cliente"></select>
      </div>
      <div class="tabla-form">
        <table>
          <thead>
            <tr>
              <th>Item</th>
              <th>N° contrato</th>
              <th>Fecha Firma</th>
              <th>Periodo</th>
              <th>Cant total</th>
            </tr>
          </thead>
          <tbody id="contratos-tbody">
            <tr>
              <td colspan="5">Seleccione un cliente para ver los contratos</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="cbo-form-col">
        <label for="combo-box area-text">Descripcion:</label>
        <textarea id="story" name="story" rows="2" cols="70" style="resize: none;" placeholder="" disabled></textarea>
      </div>
      <div class="salio-form"> <!--text-form-col-->
        <button class="add-action" onclick="registrarContrato()">
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
          Nuevo Doc.
        </button>
        <button class="continue-application" onclick="registrarDocumento()">
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
          Doc. Asoc.
        </button>
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
      </div>
    </div>
    <div class="form-col-2 contenedor-col-2">
      <div class="tittle-form-col">
        <h3>Resumen de Contrato</h3>
      </div>
      <div class="text-form-col">
        <label for="combo-box">Estado:</label>
        <input id="text-estado" name="estado" type="text" class="resumen-form-contrato" disabled>
      </div>
      <div class="text-form-col">
        <label for="combo-box">Fecha Ini:</label>
        <input id="text-inicio" name="inicio" type="text" class="resumen-form-contrato" disabled>
      </div>
      <div class="text-form-col">
        <label for="combo-box">Fecha Fin:</label>
        <input id="text-fin" name="fin" type="text" class="resumen-form-contrato" disabled>
      </div>
      <div class="text-form-col">
        <label for="combo-box tp-form">Tipo Terreno:</label>
        <div class="cuadradro">
          <div id="view-sev" class="card terreno-form">
            <div class="tdh nom-tp">Sev.</div>
            <hr>
            <div class="tdh" id="txt-sev">0</div>
          </div>
          <div id="view-soc" class="card terreno-form">
            <div class="tdh nom-tp">Soc.</div>
            <hr>
            <div class="tdh" id="txt-soc">0</div>
          </div>
          <div id="view-sup" class="card terreno-form">
            <div class="tdh nom-tp">Sup.</div>
            <hr>
            <div class="tdh" id="txt-sup">0</div>
          </div>
          <div id="view-ciu" class="card terreno-form">
            <div class="tdh nom-tp">Ciu.</div>
            <hr>
            <div class="tdh" id="txt-ciu">0</div>
          </div>
        </div>
      </div>
      <div class="text-form-col">
        <div class="cuadradro-form">
          <div class="card terreno-form doc-form" id="href-query-doc">
            <div class="tda tti-form nom-tp">N° Documentos</div>
            <hr>
            <div class="tda can-form"><i class="fa fa fa-sheet-plastic" style="color: #0e2e67;"></i><span id="txt-aso">0</span></div>
          </div>
          <div class="card terreno-form doc-form" id="href-query-lea">
            <div class="tda tti-form nom-tp">N° leasing</div>
            <hr>
            <div class="tda can-form"><i class="fa fa fa-book" style="color: #0e2e67;"></i><span id="txt-leas">0</span></div>
          </div>
          <div class="card terreno-form doc-form" id="href-query-veh">
            <div class="tda tti-form nom-tp">Veh. Detallados</div>
            <hr>
            <div class="tda can-form"><i class="fa fa-cars" style="color: #0e2e67;"></i><span id="txt-vehic">0</span></div>
          </div>
          <div class="card terreno-form doc-form" id="href-query-assign">
            <div class="tda tti-form nom-tp">Veh. Asignados</div>
            <hr>
            <div class="tda can-form"><i class="fa-solid fa-check" style="color: #0e2e67;"></i><span id="txt-assign">0</span></div>
          </div>
        </div>
      </div>
      <div class="text-form-col">
        <button class="continue-pen" disabled>
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
          Pendientes
        </button>
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

<script src="../js/consulta_contratos.js"></script>
<script type="module">
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
  };


  function registrarContrato() {
    window.location = 'registrar_contratos.php';
  };

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

    if (!contratoId || !clienteId) return;

    window.location.href = `consultar_asignaciones_por_contrato.php?contratoId=${contratoId}&clienteId=${clienteId}`;
  }

  $("#href-query-doc").on("click", () => {
    queryDocument()
  })

  $("#href-query-lea").on("click", () => {
    queryLeasing()
  })

  $("#href-query-veh").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const contratoId = param.get("contratoId")

    if (!contratoId) {
      toastr.info("Debes de seleccionar un contrato en la tabla", "Aviso")
      return;
    }

    const vehicles = await getVehByContract(contratoId);

    if (!Array.isArray(vehicles)) return;

    $("#modal-body-info").append(`
      <table id="listVeh" class="display">
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

    $("#listVeh").DataTable({
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

  $("#href-query-assign").on("click", () => {
    queryAssign()
  })

  // OPCION PARA VER VEHICULOS POR TERRENO

  // SEVERO
  $("#view-sev").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const contratoId = param.get("contratoId")

    if (!contratoId) {
      toastr.info("Debes de seleccionar un contrato en la tabla", "Aviso")
      return;
    }

    const vehicles = await getVehByContract(contratoId, "SEVERO");

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

  // SOCAVON
  $("#view-soc").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const contratoId = param.get("contratoId")

    if (!contratoId) {
      toastr.info("Debes de seleccionar un contrato en la tabla", "Aviso")
      return;
    }

    const vehicles = await getVehByContract(contratoId, "SOCAVON");

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

  // SUPERFICIE
  $("#view-sup").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const contratoId = param.get("contratoId")

    if (!contratoId) {
      toastr.info("Debes de seleccionar un contrato en la tabla", "Aviso")
      return;
    }

    const vehicles = await getVehByContract(contratoId, "SUPERFICIE");

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

  // CIUDAD
  $("#view-ciu").on("click", async () => {
    const param = new URLSearchParams(window.location.search)
    const contratoId = param.get("contratoId")

    if (!contratoId) {
      toastr.info("Debes de seleccionar un contrato en la tabla", "Aviso")
      return;
    }

    const vehicles = await getVehByContract(contratoId, "CIUDAD");

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
</script>

<?php
require './templates/footer.html';
?>