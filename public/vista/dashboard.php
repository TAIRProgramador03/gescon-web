<?php
require './templates/header.html';
?>
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- TOASTR CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSS DATATABLE -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css" />

<!-- JS DATATABLE -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
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

<!-- LUCID ICON -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<!-- MOTION -->
<script src="https://cdn.jsdelivr.net/npm/motion@10/dist/motion.min.js"></script>

<!-- CSS DE LA VISTA DASHBOARD -->
<style>
  <?php include '../css/views/dashboard.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
<div id="banner" class="w-full h-screen fixed top-0 left-0 z-[9999] bg-white flex flex-col justify-center items-center">
  <!-- <h3 class="!text-7xl !font-semibold !text-blue-600 uppercase">Gescon</h3> -->
  <h3 class="!text-7xl !font-semibold !text-blue-600 uppercase flex gap-1">
    <span class="animate-wave" style="animation-delay:0s">G</span>
    <span class="animate-wave" style="animation-delay:0.1s">e</span>
    <span class="animate-wave" style="animation-delay:0.2s">s</span>
    <span class="animate-wave" style="animation-delay:0.3s">c</span>
    <span class="animate-wave" style="animation-delay:0.4s">o</span>
    <span class="animate-wave" style="animation-delay:0.5s">n</span>
  </h3>
  <p class="m-0 font-medium text-gray-400 text-xl">Sistema Gestor de Contratos</p>
  <div class="flex-col gap-4 w-full flex items-center justify-center relative">
    <div class="w-28 h-28 border-8 text-blue-600 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-600 rounded-full"></div>
    <div class="gif-container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <img src="../img/carpeta.gif">
    </div>
  </div>
</div>

<div class="dashboard-container relative">
  <div class="loader-screen">
    <div class="loading-wave">
      <div class="loading-bar"></div>
      <div class="loading-bar"></div>
      <div class="loading-bar"></div>
      <div class="loading-bar"></div>
    </div>
  </div>
  <main class="dashboard-main">
    <section class="dashboard-section">
      <div class="dashboard-header">
        <h1>Dashboard</h1>
        <div class="cbo-client-container">
          <label for="">Cliente</label>
          <select id="cbo-client"></select>
        </div>
      </div>

      <div class="dashboard-cont-section">
        <div class="dashboard-item item-small">
          <div>
            <h3>Contratos</h3>
            <div class="data-value" id="con-Contra">0</div>
          </div>
          <img src="../img/icons/icon-contract.webp" alt="Contratos">
        </div>
        <div class="dashboard-item item-small">
          <div>
            <h3>Adendas</h3>
            <div class="data-value" id="con-Adenda">0</div>
          </div>
          <img src="../img/icons/icon-adenda.webp" alt="Adendas">
        </div>
        <div class="dashboard-item item-small">
          <div>
            <h3>Cartas</h3>
            <div class="data-value" id="con-Carta">0</div>
          </div>
          <img src="../img/icons/icon-carta.webp" alt="Cartas">
        </div>
        <div class="dashboard-item item-small">
          <div>
            <h3>Orden de compras</h3>
            <div class="data-value" id="con-OC">0</div>
          </div>
          <img src="../img/icons/icon-orden-de-compra.webp" alt="Orden de compras">
        </div>
      </div>

      <div class="dashboard-time-section">
        <div class="dashboard-item item-large">
          <h3>Linea de tiempo (Contrato - Leasing)</h3>
          <div id="data-value-comparation" class="data-value"></div>
          <div class="row-cbo-comparation">
            <!-- CONTRATOS -->
            <div class="flex flex-col w-full relative">
              <select id="cbo-contratos" name="contratos"></select>

              <label
                for="cbo-contratos"
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Contratos
              </label>
            </div>

            <!-- LEASINGS -->
            <div class="flex flex-col w-full relative">
              <select id="cbo-leasings" name="leasings"></select>

              <label
                for="cbo-leasings"
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Leasings
              </label>
            </div>
          </div>
          <canvas id="comparationChart" class="comparationChart !overflow-visible"></canvas>
        </div>

        <div class="dashboard-item item-large">
          <h3>Compra por modelo</h3>
          <div id="vehFleetDifference" class="data-value">0,00 PEN</div>
          <div class="filter-veh-fleet">
            <div class="flex flex-col w-full relative">
              <select id="cbo-models-gen" name="models"></select>

              <label
                for="cbo-models-gen"
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Modelos
              </label>
            </div>
            <div class="w-full flex justify-center items-center gap-3">
              <div class="flex flex-col w-full relative">
                <select id="cbo-from-year" name="years"></select>

                <label
                  for="cbo-from-year"
                  class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                  Desde
                </label>
              </div>
              <div class="flex flex-col w-full relative">
                <select id="cbo-to-year" name="years"></select>

                <label
                  for="cbo-to-year"
                  class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                  Hasta
                </label>
              </div>
            </div>
          </div>
          <div class="chart-veh-model-container">
            <canvas id="barModelYear" class="can-barra"></canvas>
          </div>
        </div>

        <!-- <div class="dashboard-item item-medium" style="overflow: hidden;">
          <h3>Top 3 Cliente</h3>
          <canvas id="salesChart" style="max-height: 300px;"></canvas>
        </div> -->
      </div>

      <div class="dashboard-item item-large table-leasings">
        <h3>Placas de Leasings</h3>
        <table id="listLeasings" class="display">
          <thead>
            <tr>
              <th class="!font-medium text-gray-500">Item</th>
              <th class="!font-medium text-gray-500">Placa</th>
              <th class="!font-medium text-gray-500">Modelo</th>
              <th class="!font-medium text-gray-500">Tipo</th>
              <th class="!font-medium text-gray-500">F. Acta Entrega.</th>
              <th class="!font-medium text-gray-500">F. Devolucion.</th>
              <th class="!font-medium text-gray-500">Años Contrato</th>
              <th class="!font-medium text-gray-500">Nro Leasing</th>
              <th class="!font-medium text-gray-500">F. Ini. Lea.</th>
              <th class="!font-medium text-gray-500">F. Fin Lea.</th>
              <th class="!font-medium text-gray-500">Años Leasing</th>
              <th class="!font-medium text-gray-500">Estado (Diferencia)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="dashboard-doughnut-section">
        <div class="dashboard-item item-large !bg-red-100 !border-red-600">
          <h3 class="!text-red-500">Vehiculos con leasings Vencidos</h3>
          <div id="data-value-veh-exp" class="data-value !text-red-800"></div>
          <div style="width: 100%; height: 220px;">
            <canvas id="donutLeasingA" class="can-barra"></canvas>
          </div>
        </div>

        <div class="dashboard-item item-large !bg-green-100 !border-green-600">
          <h3 class="!text-green-500">Vehiculos con leasings Por Vencer</h3>
          <div id="data-value-veh-to-exp" class="data-value !text-green-800"></div>
          <div style="width: 100%; height: 220px;">
            <canvas id="donutLeasingB" class="can-barra"></canvas>
          </div>
        </div>
      </div>

      <div class="dashboard-item item-large chart-vehicles-cli">
        <h3>Total vehiculos por clientes</h3>
        <div id="data-value-chart-veh" class="data-value"></div>
        <div class="data-chart">
          <div class="cbo-clients-multiple">
            <select id="cbo-clients-multiple" name="clients[]" multiple="multiple"></select>
          </div>
          <div class="chart-container">
            <canvas id="barVehicleLea"></canvas>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>

<div id="modal-leasing" data-route-permission="ver_dashboard">
  <div class="modal-container">
    <div class="modal-header">
      <i class="bi bi-info-circle"></i>
      <h2 id="modal-title">Detalles</h2>
    </div>
    <div class="modal-body" id="modal-body-info">

    </div>
    <div class="modal-footer">
      <button class="btn-error" id="btn-close">Cerrar</button>
    </div>
  </div>
</div>

<script src="../js/dashboard.js"></script>
<script>
  document.title = "Dashboard | Gescon";

  lucide.createIcons();
  // CHARGE SCREEN
  let onLoadWindow = 0;

  function showLoaderWindow() {
    onLoadWindow++;
    $('#banner').css('opacity', '1');
    $('#banner').css('z-index', '99999');

    $(".carousel-container").css('opacity', '1');
    $(".carousel-container").css('z-index', '99999');

    // $('.banner').show();
  }

  function hideLoaderWindow() {
    onLoadWindow--;
    if (onLoadWindow <= 0) {
      Motion.animate("#banner", {
        opacity: [1, 0],
      }, {
        duration: 0.45,
        easing: "ease-in"
      })


      // $('#banner').css('opacity', '0');
      setTimeout(() => {
        $('#banner').css('z-index', '-99999');
      }, 400)
    }
  }

  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $('.loader-screen').css('opacity', '1');
    $('.loader-screen').css('z-index', '99999');
  }

  function hideLoader() {
    activeRequests--;
    if (activeRequests <= 0) {
      Motion.animate(".loader-screen", {
        opacity: [1, 0],
      }, {
        duration: 0.45,
        easing: "ease-in"
      })

      // $('.loader-screen').css('opacity', '0');
      $('.loader-screen').css('z-index', '-99999');
    }
  }

  // CHARTS
  let vehFleetChart;
  let chartDoughnutLeaA;
  let chartDoughnutLeaB;
  let chartBarVehCli;
  let chartBarComparation;

  // TABLES
  let tableLea;

  const initChartComparation = (data) => {
    const ctx = $("#comparationChart");

    if (data.diferenciaDias) {
      if (data.diferenciaDias > 0) {
        $("#data-value-comparation").text(`Leasing vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else if (data.diferenciaDias < 0) {
        $("#data-value-comparation").text(`Contrato vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else {
        $("#data-value-comparation").text(`Vencen a la vez`)
      }
    } else {
      $("#data-value-comparation").text(`Sin resultados`)
    }

    chartBarComparation = new Chart(ctx, {
      type: 'line',
      data: {
        datasets: [{
            label: 'Contrato',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 3, // <--- Grosor de la línea
            borderCapStyle: 'round',
            fill: false,
            data: [{
              x: data.fechaIniCont,
              y: 60
            }, {
              x: data.fechaFinCont,
              y: 60
            }]
          },
          {
            label: 'Leasing',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 3, // <--- Grosor de la línea
            borderCapStyle: 'round',
            fill: false,
            data: [{
              x: data.fechaIniLea,
              y: 30
            }, {
              x: data.fechaFinLea,
              y: 30
            }],
          }
        ]
      },
      options: {
        responsive: true,
        interaction: {
          mode: 'nearest',
        },
        plugins: {
          title: {
            display: false,
            text: 'Rango de fechas Contratos - Leasings'
          },
          tooltip: false,
          datalabels: {
            formatter: (value) => dayjs(value.x).format("DD/MM/YYYY"),
            backgroundColor: "#2563eb",
            borderRadius: 6,
            color: "white",
            padding: 6,
            align: "top",
            anchor: "end",
            font: {
              weight: "bold"
            }
          }
        },
        scales: {
          x: {
            type: 'time',
            time: {
              tooltipFormat: 'dd/MM/yyyy'
            },
            display: true,
            title: {
              display: false,
              text: 'Fechas'
            },
            ticks: {
              autoSkip: false,
              maxRotation: 0,
              major: {
                enabled: true
              },
              font: function(context) {
                if (context.tick && context.tick.major) {
                  return {
                    weight: 'bold',
                  };
                }
              }
            }
          },
          y: {
            display: false,
            min: 0,
            max: 100,
            title: {
              display: true,
              text: 'value'
            }
          }
        },
        layout: {
          padding: {
            left: 40,
            right: 40
          }
        }
      },
      plugins: [ChartDataLabels]
    })
  }

  const initBarModelYear = async (data) => {

    const ctx = $("#barModelYear")

    const fullLabels = data.map(itm => itm.MODELO);
    const shortLabels = fullLabels.map(label => label.slice(0, 10) + "...");

    vehFleetChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: shortLabels,
        datasets: [{
          label: 'Modelos',
          data: data.map((cli) => cli.T_PRECIO_VEH),
          backgroundColor: data.map((cli) => {
            return 'rgba(54, 162, 235, 0.2)'
          }),
          borderColor: data.map((cli) => {
            return 'rgb(54, 162, 235)'
          }),
          borderWidth: 1,
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            callbacks: {
              title: function(context) {
                const index = context[0].dataIndex;
                return fullLabels[index]; // 👈 nombre completo
              }
            }
          },
          zoom: {
            pan: {
              enabled: true,
              mode: 'x'
            },
            zoom: {
              wheel: {
                enabled: true
              },
              pinch: {
                enabled: true
              },
              mode: 'x'
            }
          }
        }
      }
    })
  }

  const initDoughnutLeaA = async (data) => {
    const ctx = $("#donutLeasingA")

    $("#data-value-veh-exp").text(`${data.menor30Dias + data.entre30Y45Dias + data.entre45Y60Dias + data.entre60Y90Dias + data.mayor90Dias} vehiculos`)

    chartDoughnutLeaA = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          'Menor 30 dias',
          'Entre 30 y 45 dias',
          'Entre 45 y 60 dias',
          'Entre 60 y 90 dias',
          'Entre 90 y 120 dias'
        ],
        datasets: [{
          label: 'Vehiculos',
          data: [
            data.menor30Dias, data.entre30Y45Dias, data.entre45Y60Dias, data.entre60Y90Dias, data.mayor90Dias
          ],
          backgroundColor: [
            'rgb(255, 99, 99)',
            'rgb(255, 182, 99)',
            'rgb(193, 99, 255)',
            'rgb(99, 148, 255)',
            'rgb(104, 255, 99)',
          ],
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: 0
        },
        aspectRatio: 2.5,
        plugins: {
          legend: {
            position: 'right', // Cambia de 'top' a 'right'
            align: 'center' // Opcional: 'start', 'center' o 'end'
          }
        },
        onClick: (evento, elementosActivos) => {
          // Verificamos si se hizo clic en un segmento (y no en el espacio vacío)
          if (elementosActivos.length > 0) {
            const modal = document.getElementById("modal-leasing");
            modal.style.display = "flex";

            $("#modal-title").text("Vehiculos vencidos")

            Motion.animate(".modal-container", {
              opacity: [0, 1],
              scale: [0.7, 1.05, 1]
            }, {
              duration: 0.45,
              easing: "ease-out"
            })

            const indice = elementosActivos[0].index;

            // Obtenemos el label y el valor usando el índice
            const label = chartDoughnutLeaA.data.labels[indice];
            const valor = chartDoughnutLeaA.data.datasets[0].data[indice];

            $("#modal-body-info").append(`
              <table id="listVehExpires" class="display">
                <thead>
                  <tr>
                    <th class="!font-medium text-white bg-yellow-500">Item</th>
                    <th class="!font-medium text-white bg-yellow-500">Placa</th>
                    <th class="!font-medium text-white bg-yellow-500">Modelo</th>
                    <th class="!font-medium text-white bg-yellow-500">Marca</th>
                    <th class="!font-medium text-white bg-green-500">Cliente</th>
                    <th class="!font-medium text-white bg-green-500">Cliente Origen</th>
                    <th class="!font-medium text-white bg-green-500">Leasing</th>
                    <th class="!font-medium text-white bg-green-500">Fecha Fin</th>
                    <th class="!font-medium text-white bg-green-500">% de leasing</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  </tr>
                </tbody>
              </table>
            `);

            $("#listVehExpires").DataTable({
              language: {
                url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
              },
              dom: '<"superior"fB>rt<"inferior"i<"derecha-inferior"lp>>',
              buttons: [{
                extend: 'excelHtml5',
                text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Excel',
                className: 'btn-excel',
                filename: 'Reporte_Placas_Leasing_Vencidos_' + new Date().toLocaleDateString(),
                title: 'Lista de placas de los Leasings Vencidos',
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
                action: function(e, dt, button, config) {
                  var self = this;
                  var oldStart = dt.settings()._iDisplayStart;

                  // Mostrar un mensaje de "Procesando" manual
                  dt.buttons.info('Generando archivo', 'Por favor espere...', 3000);

                  dt.one('preXhr', function(e, s, data) {
                    data.start = 0;
                    data.length = 2147483647; // Tu número máximo para DB2

                    dt.one('preDraw', function(e, settings) {
                      // Ejecutar la exportación original
                      $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);

                      // IMPORTANTE: Decirle a DataTables que ya terminó el proceso visual
                      dt.processing(false);

                      // Restaurar paginación original
                      settings._iDisplayStart = oldStart;
                      setTimeout(function() {
                        dt.ajax.reload(null, false); // Recargar la vista original sin resetear paginado
                      }, 200);

                      return false; // Evitar renderizar miles de filas
                    });
                  });

                  dt.ajax.reload();
                }
              }],
              ordering: false,
              scrollY: '300px',
              scrollCollapse: true,
              serverSide: true, // Activa el procesamiento en servidor
              processing: true,
              ajax: async function(dataRender, callback, settings) {
                const paramsActualizados = new URLSearchParams(window.location.search);
                const paramClient = paramsActualizados.get("clienteId")

                try {
                  const search = dataRender.search.value;

                  // 2. Ejecutar tu Fetch con tus headers/includes personalizados
                  const res = await obtenerVehiculosVencidos(dataRender.draw, dataRender.start, dataRender.length, label, search, paramClient);

                  // 3. Mapear tu respuesta a lo que DataTables espera
                  callback({
                    draw: dataRender.draw,
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.data
                  });

                } catch (error) {
                  console.error("Error en fetch:", error);
                }
              },
              "columnDefs": [
                // Centrar contenido y cabecera en las columnas 0, 1 y 2
                {
                  "className": "dt-center",
                  "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                  data: "placa",
                },
                {
                  data: "modelo",
                },
                {
                  data: "marca",
                },
                {
                  data: "cliente"
                },
                {
                  data: "clienteAsoc"
                },
                {
                  data: "nroLeasing"
                },
                {
                  data: "fechaFin",
                  render: (data) => {
                    return dayjs(data).format("DD/MM/YYYY")
                  }
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
                }
              ],
            })
          } else {
            toastr.info("Debes seleccionar un segmento del grafico", "Aviso")
          }
        }
      }
    })
  }

  const initDoughnutLeaB = async (data) => {
    const ctx = $("#donutLeasingB")

    $("#data-value-veh-to-exp").text(`${data.menor30Dias + data.entre30Y45Dias + data.entre45Y60Dias + data.entre60Y90Dias + data.mayor90Dias} vehiculos`)

    chartDoughnutLeaB = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          'Menor 30 dias',
          'Entre 30 y 45 dias',
          'Entre 45 y 60 dias',
          'Entre 60 y 90 dias',
          'Entre 90 y 120 dias'
        ],
        datasets: [{
          label: 'Vehiculos',
          data: [
            data.menor30Dias, data.entre30Y45Dias, data.entre45Y60Dias, data.entre60Y90Dias, data.mayor90Dias
          ],
          backgroundColor: [
            'rgb(255, 99, 99)',
            'rgb(255, 182, 99)',
            'rgb(193, 99, 255)',
            'rgb(99, 148, 255)',
            'rgb(104, 255, 99)',
          ],
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: 0
        },
        aspectRatio: 2.5,
        plugins: {
          legend: {
            position: 'right', // Cambia de 'top' a 'right'
            align: 'center' // Opcional: 'start', 'center' o 'end'
          }
        },
        onClick: (evento, elementosActivos) => {
          // Verificamos si se hizo clic en un segmento (y no en el espacio vacío)
          if (elementosActivos.length > 0) {
            const modal = document.getElementById("modal-leasing");
            modal.style.display = "flex";

            $("#modal-title").text("Vehiculos por vencer")

            Motion.animate(".modal-container", {
              opacity: [0, 1],
              scale: [0.7, 1.05, 1]
            }, {
              duration: 0.45,
              easing: "ease-out"
            })

            const indice = elementosActivos[0].index;

            // Obtenemos el label y el valor usando el índice
            const label = chartDoughnutLeaB.data.labels[indice];
            const valor = chartDoughnutLeaB.data.datasets[0].data[indice];

            $("#modal-body-info").append(`
              <table id="listVehToExpires" class="display">
                <thead>
                  <tr>
                    <th class="!font-medium text-white bg-yellow-500">Item</th>
                    <th class="!font-medium text-white bg-yellow-500">Placa</th>
                    <th class="!font-medium text-white bg-yellow-500">Modelo</th>
                    <th class="!font-medium text-white bg-yellow-500">Marca</th>
                    <th class="!font-medium text-white bg-green-500">Cliente</th>
                    <th class="!font-medium text-white bg-green-500">Cliente Origen</th>
                    <th class="!font-medium text-white bg-green-500">Leasing</th>
                    <th class="!font-medium text-white bg-green-500">Fecha Fin</th>
                    <th class="!font-medium text-white bg-green-500">% de leasing</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  </tr>
                </tbody>
              </table>
            `);

            $("#listVehToExpires").DataTable({
              language: {
                url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
              },
              dom: '<"superior"fB>rt<"inferior"i<"derecha-inferior"lp>>',
              buttons: [{
                extend: 'excelHtml5',
                text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Excel',
                className: 'btn-excel',
                filename: 'Reporte_Placas_Leasing_Por_Vencer_' + new Date().toLocaleDateString(),
                title: 'Lista de placas de los Leasings por vencer',
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
                action: function(e, dt, button, config) {
                  var self = this;
                  var oldStart = dt.settings()._iDisplayStart;

                  // Mostrar un mensaje de "Procesando" manual
                  dt.buttons.info('Generando archivo', 'Por favor espere...', 3000);

                  dt.one('preXhr', function(e, s, data) {
                    data.start = 0;
                    data.length = 2147483647; // Tu número máximo para DB2

                    dt.one('preDraw', function(e, settings) {
                      // Ejecutar la exportación original
                      $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);

                      // IMPORTANTE: Decirle a DataTables que ya terminó el proceso visual
                      dt.processing(false);

                      // Restaurar paginación original
                      settings._iDisplayStart = oldStart;
                      setTimeout(function() {
                        dt.ajax.reload(null, false); // Recargar la vista original sin resetear paginado
                      }, 200);

                      return false; // Evitar renderizar miles de filas
                    });
                  });

                  dt.ajax.reload();
                }
              }],
              ordering: false,
              scrollY: '300px',
              scrollCollapse: true,
              serverSide: true, // Activa el procesamiento en servidor
              processing: true,
              ajax: async function(dataRender, callback, settings) {
                const paramsActualizados = new URLSearchParams(window.location.search);
                const paramClient = paramsActualizados.get("clienteId")

                try {
                  const search = dataRender.search.value;

                  // 2. Ejecutar tu Fetch con tus headers/includes personalizados
                  const res = await obtenerVehiculosPorVencer(dataRender.draw, dataRender.start, dataRender.length, label, search, paramClient);

                  // 3. Mapear tu respuesta a lo que DataTables espera
                  callback({
                    draw: dataRender.draw,
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.data
                  });

                } catch (error) {
                  console.error("Error en fetch:", error);
                }
              },
              "columnDefs": [
                // Centrar contenido y cabecera en las columnas 0, 1 y 2
                {
                  "className": "dt-center",
                  "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                  data: "placa",
                },
                {
                  data: "modelo",
                },
                {
                  data: "marca",
                },
                {
                  data: "cliente"
                },
                {
                  data: "clienteAsoc"
                },
                {
                  data: "nroLeasing"
                },
                {
                  data: "fechaFin",
                  render: (data) => {
                    return dayjs(data).format("DD/MM/YYYY")
                  }
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
                }
              ],
            })
          } else {
            toastr.info("Debes seleccionar un segmento del grafico", "Aviso")
          }
        }
      }
    })
  }

  const initBarVehicleLea = async (data) => {
    const ctx = $("#barVehicleLea")

    $("#data-value-chart-veh").text(`${data.reduce((acc, curr) => acc + curr.total, 0)} vehiculos`)

    chartBarVehCli = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.map((cli) => `${cli.cliente.substring(0, 14)}...`),
        datasets: [{
          label: 'Total Vehiculos',
          data: data.map((cli) => cli.total),
          backgroundColor: data.map((cli) => {
            if (cli.total < 15) {
              return 'rgba(255, 99, 132, 0.2)'
            } else if (cli.total < 30) {
              return 'rgba(235, 232, 54, 0.2)'
            } else if (cli.total > 30) {
              return 'rgba(54, 162, 235, 0.2)'
            }
          }),
          borderColor: data.map((cli) => {
            if (cli.total < 15) {
              return 'rgb(255, 99, 132)'
            } else if (cli.total > 15 && cli.total <= 30) {
              return 'rgb(232, 235, 54)'
            } else if (cli.total > 30) {
              return 'rgb(54, 162, 235)'
            }
          }),
          borderWidth: 1,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    })
  }

  document.addEventListener('DOMContentLoaded', async () => {
    showLoaderWindow();
    try {
      const params = new URLSearchParams(window.location.search)
      const clientId = params.get("clienteId");

      const quantityVehLea = await obtenerCantidadVehicle(clientId);
      const quatityVehCli = await obtenerTotalVehiculosPorCliente([]);

      const listModel = await obtenerModelosGenericos();
      let listYears = [];
      let totalPriceByModel = [];
      if (listModel.length > 0) {
        listYears = await obtenerAñosPorModelo(listModel[0].id)
        if (listYears.length > 0) {
          const listCost = await obtenerTotalCostoPorModelo(listModel[0].id, listYears[0])
          totalPriceByModel = listCost.LIST;
          $("#vehFleetDifference").text(`${listCost.TOTAL.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'PEN'
          })}`)
        }
      }

      const listContracts = await obtenerContratos(clientId);
      let listLeasings = [];
      if (listContracts.length > 0) {
        listLeasings = await obtenerLeasingsPorContrato(listContracts[0].ID)
      }

      const firstTenResult = quatityVehCli.slice(0, 10)

      // INITIALIZE FETCH
      cargarContContrato(clientId);

      // Initialize charts with placeholder data
      if (listContracts.length > 0 && listLeasings.length > 0) {
        const daysComparation = await obtenerDiasContratoLeasing(listContracts[0].ID, listLeasings[0].id)
        initChartComparation(daysComparation);
      } else {
        initChartComparation({
          "fechaIniCont": "",
          "fechaFinCont": "",
          "fechaIniLea": "",
          "fechaFinLea": "",
          "diferenciaDias": 0
        });
      }

      initBarModelYear(totalPriceByModel);
      initDoughnutLeaA(quantityVehLea.vencidos);
      initDoughnutLeaB(quantityVehLea.porVencer);
      initBarVehicleLea(firstTenResult);

      const client = await obtenerClientes();

      $("#cbo-client").select2({
        placeholder: "Seleccione un estado",
        allowClear: false, // Desactiva la "X"
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: [{
            id: 0,
            text: "TODOS"
          },
          ...client.map(cli => ({
            id: cli.IDCLI,
            text: cli.CLINOM
          }))
        ]
      })

      $("#cbo-models-gen").select2({
        placeholder: "Seleccione un modelo",
        allowClear: false, // Desactiva la "X"
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: listModel.map((mo) => ({
          id: mo.id,
          text: `${mo.description}`
        }))
      })

      $("#cbo-from-year").select2({
        placeholder: "Seleccione los años",
        allowClear: false, // Desactiva la "X",
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: listYears.map(year => ({
          id: year,
          text: `${year}`
        })),
      })

      $("#cbo-to-year").select2({
        placeholder: "Seleccione un año",
        allowClear: false, // Desactiva la "X",
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: listYears.filter(year => year >= Number($("#cbo-from-year").val())).map(year => ({
          id: year,
          text: `${year}`
        })),
      })

      $("#cbo-clients-multiple").select2({
        placeholder: "Seleccione sus clientes",
        allowClear: false, // Desactiva la "X",
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: quatityVehCli.map(cli => ({
          id: cli.id,
          text: `${cli.cliente} (${cli.total})`
        })),
      })

      $("#cbo-contratos").select2({
        placeholder: "Seleccione un contrato",
        allowClear: false,
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: listContracts.map(con => ({
          id: con.ID,
          text: con.DESCRIPCION
        }))
      })

      $("#cbo-leasings").select2({
        placeholder: "Seleccione un leasing",
        allowClear: false,
        width: '100%',
        language: {
          noResults: function() {
            return "No hay resultados disponibles"; // O puedes devolver un string HTML
          }
        },
        data: listLeasings.map(lea => ({
          id: lea.id,
          text: lea.nroLeasing
        }))
      })

      tableLea = $("#listLeasings").DataTable({
        language: {
          url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
        },
        dom: '<"superior"fB>rt<"inferior"i<"derecha-inferior"lp>>',
        buttons: [{
          extend: 'excelHtml5',
          text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
          titleAttr: 'Excel',
          className: 'btn-excel',
          filename: 'Reporte_Placas_' + new Date().toLocaleDateString(),
          title: 'Lista de placas de los Leasings',
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
          action: function(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()._iDisplayStart;

            // Mostrar un mensaje de "Procesando" manual
            dt.buttons.info('Generando archivo', 'Por favor espere...', 3000);

            dt.one('preXhr', function(e, s, data) {
              data.start = 0;
              data.length = 2147483647; // Tu número máximo para DB2

              dt.one('preDraw', function(e, settings) {
                // Ejecutar la exportación original
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);

                // IMPORTANTE: Decirle a DataTables que ya terminó el proceso visual
                dt.processing(false);

                // Restaurar paginación original
                settings._iDisplayStart = oldStart;
                setTimeout(function() {
                  dt.ajax.reload(null, false); // Recargar la vista original sin resetear paginado
                }, 200);

                return false; // Evitar renderizar miles de filas
              });
            });

            dt.ajax.reload();
          }
        }],
        ordering: false,
        scrollY: '438px',
        scrollX: true,
        scrollCollapse: true,
        serverSide: true, // Activa el procesamiento en servidor
        processing: true,
        ajax: async function(dataRender, callback, settings) {
          const paramsActualizados = new URLSearchParams(window.location.search);
          const paramClient = paramsActualizados.get("clienteId")

          try {
            const search = dataRender.search.value;

            // 2. Ejecutar tu Fetch con tus headers/includes personalizados
            const res = await obtenerLeasings(dataRender.draw, dataRender.start, dataRender.length, search, paramClient);

            // 3. Mapear tu respuesta a lo que DataTables espera
            callback({
              draw: dataRender.draw,
              recordsTotal: res.recordsTotal,
              recordsFiltered: res.recordsFiltered,
              data: res.data
            });

          } catch (error) {
            console.error("Error en fetch:", error);
          }
        },
        rowCallback: function(row, data) {
          if (data.diferenciaDias < 0) {
            $($(row).find("td")[11]).css("background-color", "#E60026").css("color", "#fff");
          } else if (data.diferenciaDias > 0) {
            $($(row).find("td")[11]).css("background-color", "#259e01").css("color", "#fff");
          } else {
            $($(row).find("td")[11]).css("background-color", "#006be6").css("color", "#fff");
          }
        },
        "columnDefs": [
          // Centrar contenido y cabecera en las columnas 0, 1 y 2
          {
            "className": "dt-center",
            "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
          }
        ],
        columns: [{
            data: "item",
            render: function(data, type, row, meta) {
              return meta.row + 1;
            },
            width: "52px",
          },
          {
            data: 'placa',
            width: "100px",
          },
          {
            data: 'modelo',
            width: "200px"
          },
          {
            data: 'tipoCont',
            render: (data) => {
              return data == "P" ? "Contrato" : "Adenda";
            },
            width: "100px"
          },
          {
            data: 'fechaIniActa',
            render: (data) => {
              return dayjs(data).format("DD/MM/YYYY")
            },
            width: "100px"
          },
          {
            data: 'fechaFinActa',
            render: (data) => {
              return dayjs(data).format("DD/MM/YYYY")
            },
            width: "100px"
          },
          {
            data: 'añosContrato',
            width: "100px"
          },
          {
            data: 'nroLeasing',
            width: "100px"
          },
          {
            data: 'fechaIniLea',
            render: (data) => {
              return dayjs(data).format("DD/MM/YYYY")
            },
            width: "100px"
          },
          {
            data: 'fechaFinLea',
            render: (data) => {
              return dayjs(data).format("DD/MM/YYYY")
            },
            width: "100px"
          },
          {
            data: 'añosLeasing',
            width: "100px"
          },
          {
            data: 'diferenciaDias',
            render: (data) => {
              if (data > 0) {
                return `Leasing vence antes (${Math.abs(data)} dias)`;
              } else if (data < 0) {
                return `Contrato vence antes (${Math.abs(data)} dias)`;
              } else {
                return `Vencen a la vez`;
              }
            },
            width: "200px"
          }
        ]
      })

      if (clientId) {
        $("#cbo-client").val(clientId).trigger("change");
      }

      if (listYears.length > 0) $('#cbo-years').val(listYears[0]).trigger("change");
      $('#cbo-clients-multiple').val(firstTenResult.map(cli => cli.id)).trigger("change");
      if (listContracts.length > 0) $("#cbo-contratos").val(listContracts[0].ID).trigger("change");
      if (listLeasings.length > 0) $("#cbo-leasings").val(listLeasings[0].id).trigger("change");
    } catch (err) {
      console.error(err);
      toastr.error(err.message, "Oops...")
    }


    hideLoaderWindow();
  });

  $("#cbo-client").on("select2:select", async () => {
    showLoader();

    const clientId = $("#cbo-client").val();

    const params = new URLSearchParams(window.location.search)

    let contratos;
    let leasings = [];
    $('#cbo-contratos').empty().trigger('change');
    $('#cbo-leasings').empty().trigger('change');

    if (clientId == 0) {
      params.delete("clienteId")
      contratos = await obtenerContratos();
      if (contratos.length > 0) {
        leasings = await obtenerLeasingsPorContrato(contratos[0].ID)
      }
    } else {
      params.set("clienteId", clientId)
      contratos = await obtenerContratos(clientId);
      if (contratos.length > 0) {
        leasings = await obtenerLeasingsPorContrato(contratos[0].ID)
      }
    }

    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    // DOUGNUT CHART UPDATE
    // const data = await obtenerFlotaVehicular(status != "T" ? status : undefined, clientId != 0 ? clientId : undefined);

    // $("#status-veh-fleet").val(0).trigger("change");

    // const difference = data.totalCosto - data.totalVenta;

    // $("#vehFleetDifference").text(`${difference.toLocaleString('es-ES', {
    //   style: 'currency',
    //   currency: 'PEN'
    // })}`)

    // vehFleetChart.data.datasets[0].data = [data.totalCosto, data.totalVenta];
    // vehFleetChart.update();

    // DOUGNUT CHART LEASINGS UPDATE
    const quantityVehLea = await obtenerCantidadVehicle(clientId != 0 ? clientId : undefined);
    const vencidos = quantityVehLea.vencidos;
    const porVencer = quantityVehLea.porVencer;

    $("#data-value-veh-exp").text(`${vencidos.menor30Dias + vencidos.entre30Y45Dias + vencidos.entre45Y60Dias + vencidos.entre60Y90Dias + vencidos.mayor90Dias} vehiculos`)
    $("#data-value-veh-to-exp").text(`${porVencer.menor30Dias + porVencer.entre30Y45Dias + porVencer.entre45Y60Dias + porVencer.entre60Y90Dias + porVencer.mayor90Dias} vehiculos`)

    chartDoughnutLeaA.data.datasets[0].data = [
      vencidos.menor30Dias, vencidos.entre30Y45Dias, vencidos.entre45Y60Dias, vencidos.entre60Y90Dias, vencidos.mayor90Dias
    ]

    chartDoughnutLeaB.data.datasets[0].data = [
      porVencer.menor30Dias, porVencer.entre30Y45Dias, porVencer.entre45Y60Dias, porVencer.entre60Y90Dias, porVencer.mayor90Dias
    ]

    chartDoughnutLeaA.update();
    chartDoughnutLeaB.update();

    // CONT UPDATE
    cargarContContrato(clientId != 0 ? clientId : undefined);

    // CONT TIME LINE UPDATE
    contratos.forEach(cont => {
      const data = {
        id: cont.ID,
        text: cont.DESCRIPCION
      };

      const newOption = new Option(data.text, data.id, false, false);
      $('#cbo-contratos').append(newOption).trigger('change');
    })

    leasings.forEach(lea => {
      const data = {
        id: lea.id,
        text: lea.nroLeasing
      };

      const newOption = new Option(data.text, data.id, false, false);
      $('#cbo-leasings').append(newOption).trigger('change');
    })

    const contractId = contratos[0] ? contratos[0].ID : null
    const leasingId = $('#cbo-leasings').val();

    if (contractId && leasingId) {
      const data = await obtenerDiasContratoLeasing(contractId, leasingId)

      if (data.diferenciaDias > 0) {
        $("#data-value-comparation").text(`Leasing vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else if (data.diferenciaDias < 0) {
        $("#data-value-comparation").text(`Contrato vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else {
        $("#data-value-comparation").text(`Vencen a la vez`)
      }

      chartBarComparation.data.datasets[0].data = [{
        x: data.fechaIniCont,
        y: 60
      }, {
        x: data.fechaFinCont,
        y: 60
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: data.fechaIniLea,
          y: 30
        },
        {
          x: data.fechaFinLea,
          y: 30
        }
      ]

    } else {
      $("#data-value-comparation").text(`Sin resultados`)
      chartBarComparation.data.datasets[0].data = [{
        x: "",
        y: 60
      }, {
        x: "",
        y: 60
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: "",
          y: 30
        },
        {
          x: "",
          y: 30
        }
      ]
    }

    chartBarComparation.update();

    // TABLE LEA
    tableLea.draw();

    setTimeout(() => {
      hideLoader();
    }, 2000)
  })

  $("#cbo-models-gen").on("select2:select", async () => {
    $('#cbo-from-year').empty().trigger('change');
    $('#cbo-to-year').empty().trigger('change');

    const modelId = $("#cbo-models-gen").val();

    const listYears = await obtenerAñosPorModelo(modelId)

    let data = [];

    if (listYears.length > 0) {
      data = await obtenerTotalCostoPorModelo(modelId, listYears[0], listYears[listYears.length - 1])
    }

    const fullLabels = data.LIST.map(itm => itm.MODELO);
    const shortLabels = fullLabels.map(label => label.slice(0, 10) + "...");

    listYears.forEach(year => {
      const newOption = new Option(year, year, false, false);

      $('#cbo-from-year').append(newOption).trigger('change');
    })

    $('#cbo-from-year').val(listYears[0]).trigger('change');

    listYears.forEach(year => {
      const newOption = new Option(year, year, false, false);

      $('#cbo-to-year').append(newOption).trigger('change');
    })

    $('#cbo-to-year').val(listYears[listYears.length - 1]).trigger('change');

    $("#vehFleetDifference").text(`${data.TOTAL.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'PEN'
          })}`)

    vehFleetChart.data.labels = shortLabels;
    vehFleetChart.data.datasets = [{
      label: 'Modelos',
      data: data.LIST.map((cli) => cli.T_PRECIO_VEH),
      fill: false,
      backgroundColor: data.LIST.map((cli) => {
        return 'rgba(54, 162, 235, 0.2)'
      }),
      borderColor: data.LIST.map((cli) => {
        return 'rgb(54, 162, 235)'
      }),
      borderWidth: 1,
    }]
    vehFleetChart.options.plugins = {
      tooltip: {
        callbacks: {
          title: function(context) {
            const index = context[0].dataIndex;
            return fullLabels[index];
          }
        }
      },
      zoom: {
        pan: {
          enabled: true,
          mode: 'x'
        },
        zoom: {
          wheel: {
            enabled: true
          },
          pinch: {
            enabled: true
          },
          mode: 'x'
        }
      }
    }
    vehFleetChart.update();
  })

  $("#cbo-from-year").on("select2:select", async () => {
    $('#cbo-to-year').empty().trigger('change');

    const modelId = $("#cbo-models-gen").val();
    const currentYear = $("#cbo-from-year").val();

    const listYears = await obtenerAñosPorModelo(modelId)

    const filterYear = listYears.filter(year => year >= Number(currentYear));

    filterYear.forEach(year => {
      const newOption = new Option(year, year, false, false);

      $('#cbo-to-year').append(newOption).trigger('change');
    })

    $('#cbo-to-year').val(filterYear[filterYear.length - 1]).trigger('change');

    const data = await obtenerTotalCostoPorModelo(modelId, currentYear, filterYear[filterYear.length - 1])

    const fullLabels = data.LIST.map(itm => itm.MODELO);
    const shortLabels = fullLabels.map(label => label.slice(0, 10) + "...");

    $("#vehFleetDifference").text(`${data.TOTAL.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'PEN'
          })}`)

    vehFleetChart.data.labels = shortLabels;
    vehFleetChart.data.datasets = [{
      label: 'Modelos',
      data: data.LIST.map((cli) => cli.T_PRECIO_VEH),
      fill: false,
      backgroundColor: data.LIST.map((cli) => {
        return 'rgba(54, 162, 235, 0.2)'
      }),
      borderColor: data.LIST.map((cli) => {
        return 'rgb(54, 162, 235)'
      }),
      borderWidth: 1,
    }]
    vehFleetChart.options.plugins = {
      tooltip: {
        callbacks: {
          title: function(context) {
            const index = context[0].dataIndex;
            return fullLabels[index];
          }
        }
      },
      zoom: {
        pan: {
          enabled: true,
          mode: 'x'
        },
        zoom: {
          wheel: {
            enabled: true
          },
          pinch: {
            enabled: true
          },
          mode: 'x'
        }
      }
    }
    vehFleetChart.update();
  })

  $("#cbo-to-year").on("select2:select", async () => {
    const modelId = $("#cbo-models-gen").val();
    const fromYear = $("#cbo-from-year").val();
    const currentYear = $("#cbo-to-year").val();

    const data = await obtenerTotalCostoPorModelo(modelId, fromYear, currentYear)

    const fullLabels = data.LIST.map(itm => itm.MODELO);
    const shortLabels = fullLabels.map(label => label.slice(0, 10) + "...");

    $("#vehFleetDifference").text(`${data.TOTAL.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'PEN'
          })}`)

    vehFleetChart.data.labels = shortLabels;
    vehFleetChart.data.datasets = [{
      label: 'Modelos',
      data: data.LIST.map((cli) => cli.T_PRECIO_VEH),
      fill: false,
      backgroundColor: data.LIST.map((cli) => {
        return 'rgba(54, 162, 235, 0.2)'
      }),
      borderColor: data.LIST.map((cli) => {
        return 'rgb(54, 162, 235)'
      }),
      borderWidth: 1,
    }]
    vehFleetChart.options.plugins = {
      tooltip: {
        callbacks: {
          title: function(context) {
            const index = context[0].dataIndex;
            return fullLabels[index];
          }
        }
      },
      zoom: {
        pan: {
          enabled: true,
          mode: 'x'
        },
        zoom: {
          wheel: {
            enabled: true
          },
          pinch: {
            enabled: true
          },
          mode: 'x'
        }
      }
    }
    vehFleetChart.update();
  })

  $("#cbo-clients-multiple").on("change", async () => {
    const value = $("#cbo-clients-multiple").val();

    const quantityVehCli = await obtenerTotalVehiculosPorCliente(value);

    $("#data-value-chart-veh").text(`${quantityVehCli.reduce((acc, curr) => acc + curr.total, 0)} vehiculos`)

    chartBarVehCli.data.labels = quantityVehCli.map((cli) => `${cli.cliente.substring(0, 14)}...`)
    chartBarVehCli.data.datasets[0].data = quantityVehCli.map((cli) => cli.total)
    chartBarVehCli.data.datasets[0].backgroundColor = quantityVehCli.map((cli) => {
      if (cli.total < 15) {
        return 'rgba(255, 99, 132, 0.2)'
      } else if (cli.total < 30) {
        return 'rgba(235, 232, 54, 0.2)'
      } else if (cli.total > 30) {
        return 'rgba(54, 162, 235, 0.2)'
      }
    })
    chartBarVehCli.data.datasets[0].borderColor = quantityVehCli.map((cli) => {
        if (cli.total < 15) {
          return 'rgb(255, 99, 132)'
        } else if (cli.total > 15 && cli.total <= 30) {
          return 'rgb(232, 235, 54)'
        } else if (cli.total > 30) {
          return 'rgb(54, 162, 235)'
        }
      }),
      chartBarVehCli.update();
  })

  $("#cbo-contratos").on("select2:select", async () => {
    const contractId = $("#cbo-contratos").val();

    $('#cbo-leasings').empty().trigger('change');

    const listLeasings = await obtenerLeasingsPorContrato(contractId)
    listLeasings.forEach(lea => {
      const data = {
        id: lea.id,
        text: lea.nroLeasing
      };

      const newOption = new Option(data.text, data.id, false, false);
      $('#cbo-leasings').append(newOption).trigger('change');
    })

    const leasingId = $('#cbo-leasings').val();

    if (leasingId) {
      const data = await obtenerDiasContratoLeasing(contractId, leasingId)

      if (data.diferenciaDias > 0) {
        $("#data-value-comparation").text(`Leasing vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else if (data.diferenciaDias < 0) {
        $("#data-value-comparation").text(`Contrato vence antes (${Math.abs(data.diferenciaDias)} dias)`)
      } else {
        $("#data-value-comparation").text(`Vencen a la vez`)
      }

      chartBarComparation.data.datasets[0].data = [{
        x: data.fechaIniCont,
        y: 60
      }, {
        x: data.fechaFinCont,
        y: 60
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: data.fechaIniLea,
          y: 30
        },
        {
          x: data.fechaFinLea,
          y: 30
        }
      ]

    } else {
      $("#data-value-comparation").text(`Sin resultados`)
      chartBarComparation.data.datasets[0].data = [{
        x: "",
        y: 60
      }, {
        x: "",
        y: 60
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: "",
          y: 30
        },
        {
          x: "",
          y: 30
        }
      ]
    }

    chartBarComparation.update();
  })

  $("#cbo-leasings").on("select2:select", async () => {
    const contractId = $("#cbo-contratos").val();
    const leasingId = $('#cbo-leasings').val();

    const data = await obtenerDiasContratoLeasing(contractId, leasingId)

    if (data.diferenciaDias > 0) {
      $("#data-value-comparation").text(`Leasing vence antes (${Math.abs(data.diferenciaDias)} dias)`)
    } else if (data.diferenciaDias < 0) {
      $("#data-value-comparation").text(`Contrato vence antes (${Math.abs(data.diferenciaDias)} dias)`)
    } else {
      $("#data-value-comparation").text(`Vencen a la vez`)
    }
    chartBarComparation.data.datasets[0].data = [{
      x: data.fechaIniCont,
      y: 60
    }, {
      x: data.fechaFinCont,
      y: 60
    }]

    chartBarComparation.data.datasets[1].data = [{
        x: data.fechaIniLea,
        y: 30
      },
      {
        x: data.fechaFinLea,
        y: 30
      }
    ]

    chartBarComparation.update();
  })

  $('#listLeasings').on('page.dt', function() {
    tableLea.table().container().getElementsByClassName('dt-scroll-body')[0].scrollTop = 0
  });

  $("#btn-close").on("click", async function() {
    const anim = Motion.animate(".modal-container", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-in"
    })

    await anim.finished;

    const modal = document.getElementById("modal-leasing");
    modal.style.display = "none";

    $("#modal-body-info").empty();
  })

  $(window).on('resize', function() {
    chartBarVehCli.resize(); // Fuerza a Chart.js a recalcular el tamaño
  });
</script>


<?php
require './templates/footer.html';
?>