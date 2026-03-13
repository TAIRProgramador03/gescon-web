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
  <!-- <header class="dashboard-header">
    <div class="search-bar">
      <input type="text" placeholder="Search">
      <button><i class="bi bi-search"></i></button>
    </div>
    <div class="user-info">
      <figure>
        <img src="../../public/img/tair.png" alt="Perfil">
      </figure>
      <span id="user-data"></span>
    </div>
  </header> -->
  <main class="dashboard-main">
    <section class="dashboard-section">
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
        <h3>Flota vehicular</h3>
        <div class="data-value">$48,352 revenue generated</div>
        <canvas id="campaignDonut" class="can-barra"></canvas>
      </div>

      <div class="dashboard-item item-medium" style="overflow: hidden;">
        <h3>Top 3 Cliente</h3>
        <canvas id="salesChart" style="max-height: 300px;"></canvas>
      </div>

      <div class="dashboard-item item-large tabla-formu">
        <h3>Leasing Vehicular</h3>
        <table id="listLeasing" class="display">
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

      <div class="dashboard-item item-large">
        <h3>Geography Based Traffic</h3>
        <div class="world-map">
          <!-- Placeholder for a world map SVG or image -->
          <img src="world-map-placeholder.png" alt="World Map">
        </div>
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

  const initDoughnut = () => {
    const ctx = $("#campaignDonut")

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          'Red',
          'Blue',
          'Yellow'
        ],
        datasets: [{
          label: 'My First Dataset',
          data: [300, 50, 100],
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
          ],
          hoverOffset: 4
        }]
      }
    })
  }

  document.addEventListener('DOMContentLoaded', async () => {
    // Initialize charts with placeholder data
    initLineChat();
    initDoughnut();

    const leasings = await cargarTablaconVehiculo();

    const table = $("#listLeasing").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
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

    table.search('').draw();
  });
</script>


<?php
require './templates/footer.html';
?>