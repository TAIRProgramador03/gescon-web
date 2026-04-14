<?php
require '../templates/header.html';
?>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- ESTILOS -->
<style>
  <?php include '../../css/views/query_user.css'; ?>
</style>

<div id="preloader-mini" class="w-full h-screen fixed top-0 left-0 z-[9999] bg-white flex flex-col justify-center items-center">
  <div class="flex-col gap-4 w-full flex items-center justify-center relative">
    <div class="w-28 h-28 border-8 text-blue-600 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-600 rounded-full"></div>
    <div class="gif-container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <img src="../../img/carpeta.gif">
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

<main class="w-full flex flex-col gap-4" data-route-permission="ver_usuarios">
  <div class="w-full bg-white px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-violet-800 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Administración de Usuarios</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Visualice y gestione la información de los usuarios registrados en el sistema de forma clara y organizada.</p>
    </div>

    <table id="listUsers" class="display rounded-md">
      <thead>
        <tr>
          <th class="text-gray-400 !font-medium">Item</th>
          <th class="text-gray-400 !font-medium">Usuario</th>
          <th class="text-gray-400 !font-medium">Codigo Empleado</th>
          <th class="text-gray-400 !font-medium">Rol</th>
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

<div id="modal-upd" class="fixed w-full h-screen top-0 left-0 flex justify-center items-center opacity-0 -z-50">
  <div class="modal-overlay fixed top-0 left-0 w-full h-screen bg-black/25 -z-10"></div>
  <div class="modal-container w-full max-w-xs bg-white rounded-lg border-gray-300 flex flex-col gap-2 px-4 py-3">
    <h2 class="text-2xl font-semibold">Actualizar rol</h2>
    <div class="flex flex-col w-full relative">
      <select id="cbo-roles" name="opciones">
      </select>

      <label
        for="cbo-roles"
        class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
        Rol(*)
      </label>
    </div>
    <div class="w-full flex justify-center items-center gap-2 pt-2">
      <button id="btn-save" class="w-full px-4 py-2 flex justify-center items-center gap-1 rounded cursor-pointer font-medium bg-green-100 border border-green-800 text-green-800 hover:bg-green-800 hover:text-white transition-colors">
        <i class="bi bi-floppy-fill"></i>
        <span>Guardar</span>
      </button>
      <button id="btn-cancel" class="w-full px-4 py-2 flex justify-center items-center gap-1 rounded cursor-pointer font-medium bg-red-100 border border-red-800 text-red-800 hover:bg-red-800 hover:text-white transition-colors">
        <i class="bi bi-x"></i>
        <span>Cancelar</span>
      </button>
    </div>
  </div>
</div>

<script type="module" src="../../js/consulta_usuario.js"></script>

<script type="module">
  import {
    getTableUsers,
    getRoles,
    getUserById,
    updateRoleUser
  } from "../../js/consulta_usuario.js"

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
  let currentId = 0;

  $(document).ready(async function() {
    showLoader();

    table = await getTableUsers()

    const roles = await getRoles();

    $("#cbo-roles").select2({
      placeholder: "Seleccione un estado",
      allowClear: false, // Desactiva la "X",
      data: roles.map(role => ({
        id: role.id,
        text: role.name
      }))
    })

    hideLoader();
  })

  $(document).on("click", ".open-modal", async function() {
    const id = $(this).data("id");

    currentId = Number(id);

    const findUser = await getUserById(id);

    $("#cbo-roles").val(`${findUser.idRol}`).trigger("change");

    animate(".modal-container", {
      opacity: [0, 1],
      scale: [0.7, 1.05, 1]
    }, {
      duration: 0.45,
      easing: "ease-out"
    })

    $("#modal-upd")
      .removeClass("opacity-0 -z-50")
      .addClass("opacity-100 z-50");
  })

  $("#btn-save").on("click", async function() {
    const idRol = Number($("#cbo-roles").val());

    await updateRoleUser(currentId, idRol);

    const rowIndex = table.rows().indexes().toArray().find(index => {
      return table.row(index).data().id === currentId;
    });

    if (rowIndex !== undefined) {
      const rowData = table.row(rowIndex).data();

      rowData.rol.name = $("#cbo-roles option:selected").text();

      table.row(rowIndex).data(rowData).draw(false);
    }
    
    const anim = animate(".modal-container", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-in"
    })

    await anim.finished;

    $("#modal-upd")
      .removeClass("opacity-100 z-50")
      .addClass("opacity-0 -z-50");
  })

  $("#btn-cancel").on("click", async function() {
    const anim = animate(".modal-container", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-in"
    })

    await anim.finished;

    $("#modal-upd")
      .removeClass("opacity-100 z-50")
      .addClass("opacity-0 -z-50");
  });
</script>

<?php
require '../templates/footer.html';
?>