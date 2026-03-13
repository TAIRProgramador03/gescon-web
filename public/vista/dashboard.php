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

<!-- CSS DE LA VISTA DASHBOARD -->
<style>
    <?php include '../css/views/dashboard.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
<div class="banner" id="banner">
    <!--<div class="slider" style="--quantity: 7">
            <div class="item" style="--position: 1"><img src="../img/GES_COMBUSTIBLE.png" alt=""></div>
            <div class="item" style="--position: 2"><img src="../img/GES_CONTRATOS.png" alt=""></div>
            <div class="item" style="--position: 3"><img src="../img/GES_LOGISTICA.png" alt=""></div>
            <div class="item" style="--position: 4"><img src="../img/GES_MANTENIMIENTO.png" alt=""></div>
            <div class="item" style="--position: 5"><img src="../img/GES_NEUMATICOS.png" alt=""></div>
            <div class="item" style="--position: 6"><img src="../img/GES_OPERACIONES.png" alt=""></div>
            <div class="item" style="--position: 7"><img src="../img/GES_RRHH.png" alt=""></div>
        </div>-->

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
    <header class="dashboard-header">
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <button><i class="bi bi-search"></i></button>
        </div>
        <div class="header-icons">
            <span>...</span>
        </div>
    </header>
    <main class="dashboard-main">
        <section class="dashboard-section">
            <div class="dashboard-item item-small">
                <h3>Contratos <i class="fa-solid fa-file-contract"></i></h3>
                <div class="data-value" id="con-Contra">0</div>
                <div class="data-change" id="por-Contra"></div>
            </div>
            <div class="dashboard-item item-small">
                <h3>Adendas <i class="fa-solid fa-file-invoice"></i></h3>
                <div class="data-value" id="con-Adenda">0</div>
                <div class="data-change" id="por-Adenda"></div>
            </div>
            <div class="dashboard-item item-small">
                <h3>Cartas <i class="fa-solid fa-file-signature"></i></h3>
                <div class="data-value" id="con-Carta">0</div>
                <div class="data-change" id="por-Carta"></div>
            </div>
            <div class="dashboard-item item-small">
                <h3>Orden de compras <i class="fa-solid fa-file-lines"></i></h3>
                <div class="data-value" id="con-OC">0</div>
                <div class="data-change" id="por-OC"></div>
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
                <table>
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

<!-- SCRIPTS DE LA VISTA -->
<script src="https://cdn.jsdelivr.net/npm/motion@latest/dist/motion.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js" integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    window.onload = function() {
        setTimeout(() => {
            document.getElementById('banner').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('banner').style.display = 'none';
            }, 1000); // Espera 1 segundo después de ocultar
        }, 4000); // Ocultar todo después de 2 segundos
    };


    // script.js
    document.addEventListener('DOMContentLoaded', () => {
        // Placeholder data for Revenue Chart
        const revenueData = {
            labels: ['Plane', 'Helicopter', 'Boat', 'Train', 'Subway', 'Bus', 'Car', 'Moto', 'Bicycle', 'Skateboard', 'Others'],
            data: [250, 300, 280, 400, 350, 520, 480, 300, 250, 400, 350]
        };

        // Placeholder data for Campaign Donut Chart
        const campaignData = {
            labels: ['Revenue', 'Expenditures'],
            data: [70, 30] // Example: 70% revenue, 30% expenditures
        };


        // Function to create a basic line chart (placeholder)
        function createBasicLineChart(canvasId, data) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');

            // Simplified line chart drawing (replace with actual chart implementation)
            ctx.fillStyle = '#64748b';
            ctx.fillRect(0, 2, canvas.width, canvas.height);
            ctx.fillStyle = '#fff';
            ctx.font = '16px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('Line Chart Placeholder', canvas.width / 2, canvas.height / 2);
        }

        function createBasicDonutChart(canvasId, data) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');

            // Calculate total value
            const totalValue = data.data.reduce((acc, val) => acc + val, 0);

            let startAngle = -0.5 * Math.PI; // Start from the top
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) * 0.8; // Adjust radius for better fit

            const colors = ['#a5b4fc', '#00f1ed']; // Example colors

            data.data.forEach((value, index) => {
                const fraction = value / totalValue;
                const angle = 2 * Math.PI * fraction;

                // Draw the arc/slice
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, startAngle, startAngle + angle, false);
                ctx.lineTo(centerX, centerY); // Close the path
                ctx.closePath();

                // Set fill color
                ctx.fillStyle = colors[index % colors.length];
                ctx.fill();

                startAngle += angle;
            });

            // Add a hole in the middle to make it a donut chart
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius * 0.5, 0, 2 * Math.PI, false);
            ctx.fillStyle = '#475569'; // Background color
            ctx.fill();
        }

        // Initialize charts with placeholder data
        createBasicLineChart('revenueChart', revenueData);
        createBasicDonutChart('campaignDonut', campaignData);
        /*createBasicBarChart('salesChart', salesData);*/
    });
</script>
<script type="module" src="../js/dashboard.js"></script>


<?php
require './templates/footer.html';
?>