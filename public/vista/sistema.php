<?php
require './templates/header.html';
?>

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

<main class="w-full h-[calc(100dvh-64px)] flex justify-center items-center p-6">
  <figure class="w-full h-full flex flex-col gap-3">
    <h1 class="text-xl font-semibold">Bienvenido al <span class="text-blue-800">Sistema Gestor de Contratos</span></h1>
    <p class="text-gray-500">Seleccione una opción desde el panel izquierdo</p>
    <img src="../img/gescon.webp" alt="Gescon" class="w-full object-cover object-center rounded-xl border-gray-300">
  </figure>
</main>

<script>
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('banner').style.display = 'none';
    }, 2000);
  };
</script>

<?php
require './templates/footer.html';
?>