<?php
require '../templates/header.html';
?>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- ESTILOS -->
<style>
  <?php include '../../css/views/query_roles.css'; ?>
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

<main class="w-full flex flex-col gap-4" data-route-permission="administrar_roles">
  <div class="w-full flex gap-2 items-center p-2 rounded-xl border border-gray-300 bg-white">
    <a id="crumb-first" href="consultar_usuarios" class="px-3 py-1 flex justify-center items-center gap-1 rounded-md text-blue-800 hover:bg-blue-800 hover:text-white transition-colors">
      <i class="bi bi-person-fill"></i>
      Usuarios
    </a>
    <span>/</span>
    <a id="crumb-active" class="px-3 py-1 flex justify-center items-center bg-blue-800 text-white rounded-md">
      Roles
    </a>
  </div>

  <div class="w-full bg-white px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-violet-800 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Administración de Roles</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Visualice y gestione la información de los roles registrados en el sistema de forma clara y organizada.</p>
    </div>

    <table id="listRoles" class="display rounded-md">
      <thead>
        <tr>
          <th class="text-gray-400 !font-medium">Item</th>
          <th class="text-gray-400 !font-medium">Nombre</th>
          <th class="text-gray-400 !font-medium">Descripción</th>
          <th class="text-gray-400 !font-medium">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        </tr>
      </tbody>
    </table>
  </div>
</main>

<script type="module" src="../../js/consulta_rol.js"></script>

<script type="module">
  import {
    getTableRoles
  } from "../../js/consulta_rol.js"

  import {
    animate
  } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

  let activeRequests = 0;

  function showLoader() {
    activeRequests++;
    $('#preloader-mini').css('opacity', '1');
    $('#preloader-mini').css('z-index', '99999');
  }

  function hideLoader() {
    activeRequests = Math.max(0, activeRequests - 1);
    if (activeRequests === 0) {
      animate("#preloader-mini", {
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

  $(document).ready(async function() {
    showLoader();

    table = await getTableRoles()

    hideLoader();
  })
</script>

<?php
require '../templates/footer.html';
?>