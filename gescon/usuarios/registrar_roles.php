<?php
require '../templates/header.html';
?>

<!-- TOASTR JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!--BOOTSTRAP CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


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
    <a id="crumb-second" href="consultar_roles" class="px-3 py-1 flex justify-center items-center gap-1 rounded-md text-blue-800 hover:bg-blue-800 hover:text-white transition-colors">
      Roles
    </a>
    <span>/</span>
    <a id="crumb-active" class="px-3 py-1 flex justify-center items-center bg-blue-800 text-white rounded-md">
      Registrar
    </a>
  </div>

  <div class="w-full bg-white px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-violet-800 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Registrar Rol</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione el registro de un nuevo rol al sistema.</p>
    </div>

    <div class="w-full grid grid-cols-2 gap-3">
      <div class="w-full flex flex-col gap-3">
        <!-- NOMBRE -->
        <div class="input flex flex-col w-full relative col-span-2">
          <input
            name="name"
            type="text"
            placeholder="Ingrese un nombre"
            required
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
          <label
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Nombre
          </label>
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="input flex flex-col w-full relative col-span-2">
          <input
            name="descripcion"
            type="text"
            placeholder="Ingrese una descripción"
            class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
          <label
            class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
            Descripción
          </label>
        </div>

        <button id="btn-save" class="w-fit cursor-pointer px-3 py-2 rounded flex justify-center items-center gap-1 bg-green-700 text-white hover:bg-green-500 transition-colors">Registrar</button>
      </div>

      <div class="w-full flex flex-col gap-3 max-h-[420px] p-4 border border-gray-300 rounded-md overflow-auto">
        <h2 class="text-2xl font-semibold text-[#002141]">Permisos</h2>
        <div id="listPermissions" class="w-full flex flex-col gap-3">
          <!-- AQUI VAN LOS PERMISOS CARGADOS -->
        </div>
      </div>
    </div>
  </div>
</main>

<script type="module" src="/js/registrar_roles.js"></script>
<script type="module">
  import {
    getPermissions,
    convertTitle,
    registerRole
  } from '/js/registrar_roles.js'

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

  const selectedPermissions = new Set();

  $(document).ready(async function() {
    showLoader();

    const listPermissions = await getPermissions();

    const groupedPermissions = listPermissions.reduce((acc, perm) => {
      const [accion, modulo] = perm.name.split("_");

      if (!acc[modulo]) {
        acc[modulo] = [];
      }

      acc[modulo].push({
        ...perm,
        accion
      });

      return acc;
    }, {});

    $("#listPermissions").append(Object.entries(groupedPermissions).map(([modulo, permisos]) => `
      <div class="w-full border border-gray-200 rounded-md p-4 flex flex-col gap-3">
        
        <!-- 🔥 Título del módulo -->
        <h3 class="text-md font-semibold text-gray-800">
          ${convertTitle(modulo)}
        </h3>

        <!-- 🔽 Permisos -->
        ${permisos.map(perm => `
          <div class="w-full flex justify-between items-center">
            <span class="text-sm text-gray-600 font-medium">
              ${convertTitle(perm.name)}
            </span>

            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input 
                class="sr-only peer permission-checkbox" 
                type="checkbox" 
                data-id="${perm.id}"
              >

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 bg-red-300 
                peer-checked:bg-blue-300
                peer-focus:ring-2 peer-focus:ring-blue-500
                
                after:content-['No'] after:absolute after:rounded-[50%] 
                after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
                after:flex after:justify-center after:items-center  
                after:text-red-800 after:font-bold
                
                peer-checked:after:translate-x-6 
                peer-checked:after:content-['Si'] 
                peer-checked:after:text-sky-800">
              </div>
            </label>
          </div>
        `).join("")}

      </div>
    `).join(""))

    hideLoader();
  })

  $(document).on("change", ".permission-checkbox", function() {
    const id = Number($(this).data("id"));

    if (this.checked) {
      selectedPermissions.add(id);
    } else {
      selectedPermissions.delete(id);
    }
  });

  $("#btn-save").on("click", async function() {

    const name = $('input[name="name"]').val();
    const description = $('input[name="descripcion"]').val();

    if(!name) {
      toastr.info("Debe de ingresar un nombre", "Aviso")
    }

    const data = {
      name,
      description,
      permissions: [...selectedPermissions]
    }

    await registerRole(data);
  })
</script>

<?php
require '../templates/footer.html';
?>