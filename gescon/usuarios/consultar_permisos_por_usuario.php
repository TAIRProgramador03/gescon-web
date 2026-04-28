<?php
require '../templates/header.html';
?>

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

<main class="w-full flex flex-col gap-4" data-route-permission="ver_usuarios">
  <div class="w-full flex gap-2 items-center p-2 rounded-xl border border-gray-300 bg-white">
    <a id="crumb-first" href="consultar_usuarios" class="px-3 py-1 flex justify-center items-center gap-1 rounded-md text-blue-800 hover:bg-blue-800 hover:text-white transition-colors">
      <i class="bi bi-person-fill"></i>
      Usuarios
    </a>
    <span>/</span>
    <a id="crumb-active" class="px-3 py-1 flex justify-center items-center bg-blue-800 text-white rounded-md">
      Permisos
    </a>
  </div>

  <div class="w-full flex flex-col gap-4 bg-white px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-violet-800 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Visualizar permisos</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Verifique la cantidad de permisos asignados a un usuario especifico.</p>
    </div>

    <div class="w-full grid grid-cols-1 gap-4">
      <!-- DASHBOARD -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-gray-500 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Dashboard</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Visualizar dashboard</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_dashboard" name="ver_dashboard" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>

      <!-- CONTRATOS -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-blue-800 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Contratos</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Consultar contratos</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_contratos" name="ver_contratos" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Registrar contratos</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_contratos" name="insertar_contratos" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Modificar contratos temp.</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="editar_contratos" name="editar_contratos" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>

      <!-- DOCUMENTOS -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-taupe-800 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Documentos</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Consultar documentos</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_documentos" name="ver_documentos" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Registrar documentos</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_documentos" name="insertar_documentos" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Modificar documentos temp.</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer permission-checkbox" type="checkbox" id="editar_documentos" name="editar_documentos" data-id="14" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>

      <!-- LEASINGS -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-cyan-800 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Leasings</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Consultar leasings</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_leasing" name="ver_leasing" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Registrar lesaings</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_leasing" name="insertar_leasing" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>

      <!-- PLACAS -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-orange-800 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Placas</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Consultar placas</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_placas" name="ver_placas" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Asignar placas</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_asignacion" name="insertar_asignacion" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Reasignar placas</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_reasignacion" name="insertar_reasignacion" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>

      <!-- AUTORIZACION -->
      <div class="w-full flex flex-col gap-3 px-3 py-3 rounded border border-gray-300 relative overflow-hidden">
        <div class="w-full h-1 bg-violet-800 absolute top-0 left-0"></div>
        <h4 class="text-xl text-[#002141] font-semibold">Autorización</h4>
        <ul class="list-none flex flex-col gap-3">
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Consultar usuarios</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="ver_usuarios" name="ver_usuarios" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Registrar usuarios</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="insertar_usuarios" name="insertar_usuarios" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
          <li class="w-full flex justify-between items-center">
            <span class="text-medium text-gray-500">Administrar roles</span>
            <label class="relative inline-flex w-fit items-center cursor-pointer">
              <input class="sr-only peer" type="checkbox" id="administrar_roles" name="administrar_roles" disabled>

              <div class="peer rounded-4xl outline-none duration-100 after:duration-500 w-16 h-10 
              bg-red-300 
              peer-checked:bg-blue-300
              peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
              
              after:content-['No'] after:absolute after:outline-none after:rounded-[50%] 
              after:h-8 after:w-8 after:bg-white after:top-1 after:left-1 
              after:flex after:justify-center after:items-center  
              after:text-red-800 after:font-bold
              
              peer-checked:after:translate-x-6 
              peer-checked:after:content-['Si'] 
              peer-checked:after:text-sky-800
              peer-checked:after:border-white">
              </div>
            </label>
          </li>
        </ul>
      </div>
    </div>
  </div>
</main>

<script type="module" src="/js/consulta_permisos_por_usuario.js"></script>

<script type="module">
  import {
    getPermissions
  } from "/js/consulta_permisos_por_usuario.js"

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

    const params = new URLSearchParams(window.location.search);
    const userId = params.get("usuarioId");

    if (!userId) {
      toastr.warning("No se detecto ningun parametro del usuario", "Oops...")
      return;
    }

    const permissions = await getPermissions(userId)

    $("#ver_dashboard").prop("checked", permissions.includes("ver_dashboard"))
    $("#ver_contratos").prop("checked", permissions.includes("ver_contratos"))
    $("#ver_documentos").prop("checked", permissions.includes("ver_documentos"))
    $("#ver_leasing").prop("checked", permissions.includes("ver_leasing"))
    $("#ver_placas").prop("checked", permissions.includes("ver_placas"))
    $("#ver_usuarios").prop("checked", permissions.includes("ver_usuarios"))
    $("#insertar_contratos").prop("checked", permissions.includes("insertar_contratos"))
    $("#insertar_documentos").prop("checked", permissions.includes("insertar_documentos"))
    $("#insertar_leasing").prop("checked", permissions.includes("insertar_leasing"))
    $("#insertar_asignacion").prop("checked", permissions.includes("insertar_asignacion"))
    $("#insertar_reasignacion").prop("checked", permissions.includes("insertar_reasignacion"))
    $("#insertar_usuarios").prop("checked", permissions.includes("insertar_usuarios"))
    $("#administrar_roles").prop("checked", permissions.includes("administrar_roles"))
    $("#editar_contratos").prop("checked", permissions.includes("editar_contratos"))
    $("#editar_documentos").prop("checked", permissions.includes("editar_documentos"))

    hideLoader();
  })
</script>

<?php
require '../templates/footer.html';
?>