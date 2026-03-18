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

<!-- JS DATATABLE -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- CSS DE LA VISTA DASHBOARD -->
<style>
  <?php include '../css/views/dashboard.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
<div class="banner" id="banner">
  <div id="preloader">
    <div class="presentation">
      <div class="rotating-wheel"></div>
      <div class="small-white-bg"></div>
      <div class="logo-ta"></div>
    </div>
  </div>

  <div class="carousel-container">
    <div class="carousel">
      <img src="../img/COMBUSTIBLE.png" alt="Imagen 1">
      <img src="../img/CONTRATOS.png" alt="Imagen 2">
      <img src="../img/MANTENIMIENTO.png" alt="Imagen 3">
      <img src="../img/NEUMATICOS.png" alt="Imagen 4">
      <img src="../img/OPERACIONES.png" alt="Imagen 5">
      <img src="../img/LOGISTICA.png" alt="Imagen 6">
      <!-- Duplicamos las imágenes para el efecto infinito -->
      <img src="../img/COMBUSTIBLE.png" alt="Imagen 1">
      <img src="../img/CONTRATOS.png" alt="Imagen 2">
      <img src="../img/MANTENIMIENTO.png" alt="Imagen 3">
      <img src="../img/NEUMATICOS.png" alt="Imagen 4">
      <img src="../img/OPERACIONES.png" alt="Imagen 5">
      <img src="../img/LOGISTICA.png" alt="Imagen 6">
    </div>
  </div>

  <div class="content">
    <div class="author">
      <h3><em>GES 360 - Transformación Digital</em></h3>
      <p><b>TECNOLOGIA DE INFORMACION - GRUPO IBARCENA</b></p>
    </div>
  </div>
</div>

<div class="dashboard-container">
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

      <div class="dashboard-item item-large">
        <h3>Linea de tiempo (Contrato - Leasing)</h3>
        <div id="data-value-comparation" class="data-value"></div>
        <div class="row-cbo-comparation">
          <select name="contratos" id="cbo-contratos"></select>
          <select name="leasings" id="cbo-leasings"></select>
        </div>
        <canvas id="comparationChart" class="comparationChart"></canvas>
      </div>

      <div class="dashboard-item item-medium">
        <h3>Monto Proyectado</h3>
        <div id="vehFleetDifference" class="data-value"></div>
        <div class="filter-veh-fleet">
          <div class="row-filter">
            <select id="status-veh-fleet"></select>
          </div>
        </div>
        <canvas id="campaignDonut" class="can-barra"></canvas>
      </div>

      <div class="dashboard-item item-medium" style="overflow: hidden;">
        <h3>Top 3 Cliente</h3>
        <canvas id="salesChart" style="max-height: 300px;"></canvas>
      </div>

      <div class="dashboard-item item-large table-leasings">
        <h3>Placas de Leasings</h3>
        <table id="listLeasings" class="display">
          <thead>
            <tr>
              <th>Item</th>
              <th>Placa</th>
              <th>Modelo</th>
              <th>Nro Leasing</th>
              <th>Tipo</th>
              <th>F. Ini. Cont.</th>
              <th>F. Fin Cont.</th>
              <th>Años Contrato</th>
              <th>F. Ini. Lea.</th>
              <th>F. Fin Lea.</th>
              <th>Años Leasing</th>
              <th>Estado (Diferencia)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="dashboard-item item-large">
        <h3>Vehiculos con leasings Vencidos</h3>
        <div id="data-value-veh-exp" class="data-value"></div>
        <div style="width: 100%; height: 220px;">
          <canvas id="donutLeasingA" class="can-barra"></canvas>
        </div>
      </div>

      <div class="dashboard-item item-large">
        <h3>Vehiculos con leasings Por Vencer</h3>
        <div id="data-value-veh-to-exp" class="data-value"></div>
        <div style="width: 100%; height: 220px;">
          <canvas id="donutLeasingB" class="can-barra"></canvas>
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

<div id="modal-leasing">
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
  // window.onload = function() {
  //   setTimeout(() => {
  //     document.getElementById('banner').style.opacity = '0';
  //     setTimeout(() => {
  //       document.getElementById('banner').style.display = 'none';
  //     }, 1000); // Espera 1 segundo después de ocultar
  //   }, 4000); // Ocultar todo después de 2 segundos
  // };

  // CHARGE SCREEN
  let onLoadWindow = 0;

  function showLoaderWindow() {
    onLoadWindow++;
    $('.banner').css('opacity', '1');
    $('.banner').css('z-index', '99999');
    $('.banner').show();
  }

  function hideLoaderWindow() {
    onLoadWindow--;
    if (onLoadWindow <= 0) {
      setTimeout(() => {
        $('.banner').css('opacity', '0');
        $('.banner').css('z-index', '-99999');
        setTimeout(() => {
          $('.banner').hide();
        }, 200)
      }, 800)
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
      $('.loader-screen').css('opacity', '0');
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
              y: 50
            }, {
              x: data.fechaFinCont,
              y: 50
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
              y: 40
            }, {
              x: data.fechaFinLea,
              y: 40
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
          tooltip: {
            callbacks: {
              label: function(context) {
                const datasetLabel = context.dataset.label || '';
                return `${datasetLabel}`;
              }
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
        }
      },
    })
  }

  const initDoughnut = async (clientId) => {
    const data = await obtenerFlotaVehicular(undefined, clientId);

    const difference = data.totalCosto - data.totalVenta;

    $("#vehFleetDifference").text(`${difference.toLocaleString('es-ES', {
      style: 'currency',
      currency: 'PEN'
    })}`)

    const ctx = $("#campaignDonut")

    vehFleetChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          'T. Precio Costo',
          'T. Precio Venta'
        ],
        datasets: [{
          label: 'Costos',
          data: [data.totalCosto, data.totalVenta],
          backgroundColor: [
            'rgb(255, 226, 99)',
            'rgb(41, 207, 35)',
          ],
          hoverOffset: 4
        }]
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
          'Mayor 90 dias'
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
            const indice = elementosActivos[0].index;

            // Obtenemos el label y el valor usando el índice
            const label = chartDoughnutLeaA.data.labels[indice];
            const valor = chartDoughnutLeaA.data.datasets[0].data[indice];

            $("#modal-body-info").append(`
              <table id="listVehExpires" class="display">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Leasing</th>
                    <th>Cliente</th>
                    <th>Fecha Fin</th>
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
                url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
              },
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
                  data: "nroLeasing"
                },
                {
                  data: "cliente"
                },
                {
                  data: "fechaFin",
                  render: (data) => {
                    return dayjs(data).format("DD/MM/YYYY")
                  }
                }
              ],
            })

            const modal = document.getElementById("modal-leasing");
            modal.style.display = "flex";

            $("#modal-title").text("Vehiculos vencidos")
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
          'Mayor 90 dias'
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
            const indice = elementosActivos[0].index;

            // Obtenemos el label y el valor usando el índice
            const label = chartDoughnutLeaB.data.labels[indice];
            const valor = chartDoughnutLeaB.data.datasets[0].data[indice];

            $("#modal-body-info").append(`
              <table id="listVehToExpires" class="display">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Leasing</th>
                    <th>Cliente</th>
                    <th>Fecha Fin</th>
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
                url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
              },
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
                  data: "nroLeasing"
                },
                {
                  data: "cliente"
                },
                {
                  data: "fechaFin",
                  render: (data) => {
                    return dayjs(data).format("DD/MM/YYYY")
                  }
                }
              ],
            })

            const modal = document.getElementById("modal-leasing");
            modal.style.display = "flex";

            $("#modal-title").text("Vehiculos por vencer")
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
    const params = new URLSearchParams(window.location.search)
    const clientId = params.get("clienteId");

    const quantityVehLea = await obtenerCantidadVehicle(clientId);
    const quatityVehCli = await obtenerTotalVehiculosPorCliente([]);
    const listContracts = await obtenerContratos(clientId);
    let listLeasings = [];
    if (listContracts.length > 0) {
      listLeasings = await obtenerLeasingsPorContrato(listContracts[0].ID)
    }

    const firstTenResult = quatityVehCli.slice(0, 10)

    // INITIALIZE FETCH
    cargarContContrato(clientId);
    cargarContClient();

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

    await initDoughnut(clientId);
    initDoughnutLeaA(quantityVehLea.vencidos);
    initDoughnutLeaB(quantityVehLea.porVencer);
    initBarVehicleLea(firstTenResult);

    const client = await obtenerClientes();

    $("#cbo-client").select2({
      placeholder: "Seleccione un estado",
      allowClear: false, // Desactiva la "X"
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

    $("#status-veh-fleet").select2({
      placeholder: "Seleccione un estado",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 'T',
          text: "Seleccione un estado de contrato",
        },
        {
          id: 'A',
          text: "Activos",
        },
        {
          id: 'F',
          text: "Finalizados",
        },
      ]
    })

    $("#cbo-clients-multiple").select2({
      placeholder: "Seleccione sus clientes",
      allowClear: false, // Desactiva la "X",
      width: '100%',
      data: quatityVehCli.map(cli => ({
        id: cli.id,
        text: `${cli.cliente} (${cli.total} )`
      })),
    })

    $("#cbo-contratos").select2({
      placeholder: "Seleccione un contrato",
      allowClear: false,
      data: listContracts.map(con => ({
        id: con.ID,
        text: con.DESCRIPCION
      }))
    })

    $("#cbo-leasings").select2({
      placeholder: "Seleccione un leasing",
      allowClear: false,
      data: listLeasings.map(lea => ({
        id: lea.id,
        text: lea.nroLeasing
      }))
    })

    tableLea = $("#listLeasings").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
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
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: 'placa'
        },
        {
          data: 'modelo'
        },
        {
          data: 'nroLeasing'
        },
        {
          data: 'tipoCont'
        },
        {
          data: 'fechaIniCont',
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          }
        },
        {
          data: 'fechaFinCont',
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          }
        },
        {
          data: 'añosContrato'
        },
        {
          data: 'fechaIniLea',
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          }
        },
        {
          data: 'fechaFinLea',
          render: (data) => {
            return dayjs(data).format("DD/MM/YYYY")
          }
        },
        {
          data: 'añosLeasing'
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
          }
        }
      ]
    })

    if (clientId) {
      $("#cbo-client").val(clientId).trigger("change");
    }

    $('#cbo-clients-multiple').val(firstTenResult.map(cli => cli.id)).trigger("change");
    if (listContracts.length > 0) $("#cbo-contratos").val(listContracts[0].ID).trigger("change");
    if (listLeasings.length > 0) $("#cbo-leasings").val(listLeasings[0].id).trigger("change");


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
    const data = await obtenerFlotaVehicular(status != "T" ? status : undefined, clientId != 0 ? clientId : undefined);

    $("#status-veh-fleet").val(0).trigger("change");

    const difference = data.totalCosto - data.totalVenta;

    $("#vehFleetDifference").text(`${difference.toLocaleString('es-ES', {
      style: 'currency',
      currency: 'PEN'
    })}`)

    vehFleetChart.data.datasets[0].data = [data.totalCosto, data.totalVenta];
    vehFleetChart.update();

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
        y: 50
      }, {
        x: data.fechaFinCont,
        y: 50
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: data.fechaIniLea,
          y: 40
        },
        {
          x: data.fechaFinLea,
          y: 40
        }
      ]

    } else {
      $("#data-value-comparation").text(`Sin resultados`)
      chartBarComparation.data.datasets[0].data = [{
        x: "",
        y: 50
      }, {
        x: "",
        y: 50
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: "",
          y: 40
        },
        {
          x: "",
          y: 40
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

  $("#status-veh-fleet").on("select2:select", async () => {
    const status = $("#status-veh-fleet").val();

    const params = new URLSearchParams(window.location.search)
    const clientId = params.get("clienteId")

    const data = await obtenerFlotaVehicular(status != "T" ? status : undefined, clientId);

    const difference = data.totalCosto - data.totalVenta;

    $("#vehFleetDifference").text(`${difference.toLocaleString('es-ES', {
      style: 'currency',
      currency: 'PEN'
    })}`)

    vehFleetChart.data.datasets[0].data = [data.totalCosto, data.totalVenta];
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
        y: 50
      }, {
        x: data.fechaFinCont,
        y: 50
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: data.fechaIniLea,
          y: 40
        },
        {
          x: data.fechaFinLea,
          y: 40
        }
      ]

    } else {
      $("#data-value-comparation").text(`Sin resultados`)
      chartBarComparation.data.datasets[0].data = [{
        x: "",
        y: 50
      }, {
        x: "",
        y: 50
      }]

      chartBarComparation.data.datasets[1].data = [{
          x: "",
          y: 40
        },
        {
          x: "",
          y: 40
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
      y: 50
    }, {
      x: data.fechaFinCont,
      y: 50
    }]

    chartBarComparation.data.datasets[1].data = [{
        x: data.fechaIniLea,
        y: 40
      },
      {
        x: data.fechaFinLea,
        y: 40
      }
    ]

    chartBarComparation.update();
  })

  $('#listLeasings').on('page.dt', function() {
    tableLea.table().container().getElementsByClassName('dt-scroll-body')[0].scrollTop = 0
  });

  $("#btn-close").on("click", function() {
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