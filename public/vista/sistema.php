<?php
require './templates/header.html';
?>

<main class="w-full h-[calc(100dvh-64px)] flex justify-center items-center p-6">
  <figure class="w-full h-full flex flex-col gap-3">
    <h1 class="text-xl font-semibold">Bienvenido al <span class="text-blue-800">Sistema Gestor de Contratos</span></h1>
    <p class="text-gray-500">Seleccione una opción desde el panel izquierdo</p>
    <img src="../img/gescon.webp" alt="Gescon" class="w-full object-cover object-center rounded-xl border-gray-300">
  </figure>
</main>

<?php
require './templates/footer.html';
?>