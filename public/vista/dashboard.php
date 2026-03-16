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
    <!--<h2 data-content="TECNOLOGIA DE INFORMACION DEL GRUPO IBARCENA">
                TECNOLOGIA DE INFORMACION DEL GRUPO IBARCENA
            </h2>
            <h1 data-content="WEB SYS">
                WEB SYS
            </h1>
            <div class="author">
                <h2>GES 360</h2>
                <p><b>Web System</b></p>
                <p>
                  Developed by the IT area, by Fili
                </p>
            </div>-->
    <div class="author">
      <h3><em>GES 360 - Transformación Digital</em></h3>
      <p><b>TECNOLOGIA DE INFORMACION - GRUPO IBARCENA</b></p>
      <!--<p>
                  Developed by the IT area, by Fili and Erix
                </p>-->
    </div>
  </div>
</div>

<div class="dashboard-container">
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
          <img src="../img/icons/icon-contract.webp" alt="Adendas">
        </div>
        <div class="dashboard-item item-small">
          <div>
            <h3>Cartas</h3>
            <div class="data-value" id="con-Carta">0</div>
          </div>
          <img src="../img/icons/icon-contract.webp" alt="Cartas">
        </div>
        <div class="dashboard-item item-small">
          <div>
            <h3>Orden de compras</h3>
            <div class="data-value" id="con-OC">0</div>
          </div>
          <img src="../img/icons/icon-contract.webp" alt="Orden de compras">
        </div>
      </div>

      <div class="dashboard-item item-large">
        <h3>Resumen mensual</h3>
        <div class="data-value">$59,342.32</div>
        <canvas id="revenueChart" class="revenueChart"></canvas>
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

      <div class="dashboard-item item-large tabla-formu">
        <h3>Leasing Vehicular</h3>
        <table id="listVehicle" class="display">
          <thead>
            <tr>
              <th>Item</th>
              <th>Modelo</th>
              <th>Precio</th>
            </tr>
          </thead>
          <tbody id="vehiculos-tbody">
            <tr>
              <td colspan="3">No hay Vehiculos</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="dashboard-item item-large table-leasings">
        <h3>Placas de Leasings</h3>
        <table id="listLeasings" class="display">
          <thead>
            <tr>
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
              <th>Diferencia Dias</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

<script src="../js/dashboard.js"></script>
<script>
  window.onload = function() {
    setTimeout(() => {
      document.getElementById('banner').style.opacity = '0';
      setTimeout(() => {
        document.getElementById('banner').style.display = 'none';
      }, 1000); // Espera 1 segundo después de ocultar
    }, 4000); // Ocultar todo después de 2 segundos
  };

  let vehFleetChart;
  let tableLea;

  const initLineChat = () => {
    const ctx = $("#revenueChart");

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Enero", "Febrero", "Marzo"],
        datasets: [{
          type: "line",
          label: 'My First Dataset',
          data: [65, 59, 80],
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
        }]
      }
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

  document.addEventListener('DOMContentLoaded', async () => {
    const params = new URLSearchParams(window.location.search)
    const clientId = params.get("clienteId")

    // INITIALIZE FETCH
    cargarContContrato(clientId);
    cargarContClient();
    cargarTablaconVehiculo();

    // Initialize charts with placeholder data
    initLineChat();
    await initDoughnut(clientId);

    const leasings = await cargarTablaconVehiculo();
    const client = await obtenerClientes();

    $("#cbo-client").select2({
      placeholder: "Seleccione un estado",
      allowClear: false, // Desactiva la "X"
      data: [{
          id: 0,
          text: "Seleccione un cliente"
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

    const table = $("#listVehicle").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: '200px',
      scrollCollapse: true,
      data: leasings,
      columns: [{
          data: "item",
          render: function(data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "MODELO",
        },
        {
          data: "PRECIO_VEH",
        },
      ],
    })

    tableLea = $("#listLeasings").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      scrollY: '200px',
      scrollCollapse: true,
      serverSide: true, // Activa el procesamiento en servidor
      processing: true,
      ajax: async function(dataRender, callback, settings) {
        const paramsActualizados = new URLSearchParams(window.location.search);
        const paramClient = paramsActualizados.get("clienteId")

        try {
          // 2. Ejecutar tu Fetch con tus headers/includes personalizados
          const res = await obtenerLeasings(dataRender.draw, dataRender.start, dataRender.length, paramClient);

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
      columns: [
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
          data: 'fechaIniCont'
        },
        {
          data: 'fechaFinCont'
        },
        {
          data: 'añosContrato'
        },
        {
          data: 'fechaIniLea'
        },
        {
          data: 'fechaFinLea'
        },
        {
          data: 'añosLeasing'
        },
        {
          data: 'diferenciaDias'
        }
      ]
    })

    if (clientId) {
      $("#cbo-client").val(clientId).trigger("change");
    }
  });

  $("#cbo-client").on("select2:select", async () => {
    const clientId = $("#cbo-client").val();

    const params = new URLSearchParams(window.location.search)

    if (clientId == 0) {
      params.delete("clienteId")
    } else {
      params.set("clienteId", clientId)
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


    // CONT UPDATE
    cargarContContrato(clientId != 0 ? clientId : undefined);

    // TABLE LEA
    tableLea.draw();
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
</script>


<?php
require './templates/footer.html';
?>