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

<!-- ESTILOS -->
<style>
  <?php include '../../css/views/register_user.css'; ?>
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

<main class="w-full flex flex-col gap-4" data-route-permission="insertar_usuarios">
  <div class="w-full bg-white flex flex-col gap-3 px-9 py-7 rounded-md border border-gray-300 relative overflow-hidden">
    <div class="w-full h-3 bg-violet-800 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Registrar Usuario</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione el registro de un nuevo usuario al sistema.</p>
    </div>

    <!-- NUEVO USUARIO -->
    <div class="w-full flex flex-col gap-4">
      <form id="form-new-user" class="w-full flex flex-col gap-3">
        <div class="w-full grid grid-cols-6 gap-3">
          <div class="input flex flex-col w-full relative col-span-2">
            <input
              name="usuario"
              type="text"
              placeholder="Ingrese un nombre de usuario"
              required
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
            <label
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
              Usuario
            </label>
          </div>

          <div class="input flex flex-col w-full relative col-span-2">
            <input
              name="codemp"
              type="text"
              required
              placeholder="Ingrese el codigo del empleado"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
            <label
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
              Codigo Empleado
            </label>
          </div>

          <div class="input flex flex-col w-full relative col-span-2">
            <input
              name="clave"
              type="password"
              required
              placeholder="Ingrese una clave"
              class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
            <label
              class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
              Contraseña
            </label>
            <button
              type="button"
              class="btn-view-pass absolute z-10 top-[calc(50%+8px)] right-2 -translate-y-1/2 cursor-pointer text-gray-600 peer-focus:text-blue-500">
              <i class="bi bi-eye-fill"></i>
            </button>
          </div>

          <div class="flex flex-col w-full relative col-span-3">
            <select id="cbo-roles" name="rol"></select>
            <label
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Rol
            </label>
          </div>

          <div class="flex flex-col gap-2 col-span-3">
            <div class="flex flex-col w-full relative">
              <select id="cbo-perfiles" name="perfil" disabled></select>
              <label
                class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                Perfil GesOper
              </label>
            </div>
            <div class="flex items-center gap-2">
              <input type="checkbox" name="inGesoper" id="inGesoper" class="!accent-blue-500 size-4 outline-none">
              <label for="inGesoper" class="text-sm text-gray-700">Agregar al GesOper</label>
            </div>
          </div>
        </div>
        <div class="w-full flex justify-end items-center gap-3">
          <button type="submit" class="w-fit cursor-pointer px-3 py-2 rounded flex justify-center items-center gap-1 bg-green-700 text-white hover:bg-green-500 transition-colors">Registrar</button>
        </div>
      </form>
    </div>

    <div class="w-full bg-gray-100 h-[1px]"></div>

    <!-- NUEVO DESDE GESOPER -->
    <div class="w-ull flex flex-col gap-2">
      <div class="w-full flex flex-col justify-center gap-2">
        <h2 class="text-2xl text-[#002141] font-semibold">Usuarios de Gesoper</h2>
        <p class="!m-0 text-base font-normal text-gray-500">Gestione el registro de un nuevo usuario al sistema desde GesOper.</p>
      </div>
      <div id="listNewUsers" class="w-full grid grid-cols-2 gap-3">
        <!-- AQUI NUEVOS FORMULARIOS POR USUARIO ENCONTRADO -->
      </div>
    </div>
  </div>
</main>

<script type="module" src="../../js/registrar_usuarios.js"></script>
<script type="module">
  import {
    getNewUsers,
    getRoles,
    getRolesGesOper,
    registerUser
  } from '../../js/registrar_usuarios.js'

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

  $(document).ready(async function() {
    showLoader();

    const listRoles = await getRoles();
    const listRolesGesoper = await getRolesGesOper();

    $("#cbo-roles").select2({
      placeholder: "Seleccione un rol",
      allowClear: false,
      width: "100%",
      data: listRoles.map(role => ({
        id: role.id,
        text: role.name
      }))
    })

    $("#cbo-perfiles").select2({
      placeholder: "Seleccione un perfil",
      allowClear: false,
      width: "100%",
      data: listRolesGesoper.map(role => ({
        id: role.id,
        text: role.name
      }))
    })

    $("#cbo-roles").val(null).trigger("change");
    $("#cbo-perfiles").val(null).trigger("change");

    const listNewUsers = await getNewUsers();
    const divNewUsers = $("#listNewUsers")

    if (listNewUsers.length > 0) {
      divNewUsers.append(`
        ${listNewUsers.map(user => `
          <form class="form w-full flex flex-col gap-3 p-4 border border-gray-200 rounded-md" data-form="${user.id}">
            <h3 class="text-[#002141] font-medium">Usuario: ${user.usuario}</h3>
            <div class="w-full flex flex-col gap-2">
              <div class="input flex flex-col w-full relative">
                <input
                  name="usuario[]"
                  type="text"
                  value="${user.usuario}"
                  required
                  class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 disabled:bg-gray-50"
                  disabled />
                <label
                  class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
                  Usuario
                </label>
              </div>

              <div class="input flex flex-col w-full relative">
                <input
                  name="codemp[]"
                  type="text"
                  value="${user.codEmp}"
                  required
                  class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 disabled:bg-gray-50"
                  disabled />
                <label
                  class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
                  Codigo Empleado
                </label>
              </div>

              <div class="flex flex-col w-full relative">
                <select name="roles[]" class="cbo-roles" data-rol="${user.rolId}"></select>
                <label
                  class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                  Rol / Perfil
                </label>
              </div>

              <div class="input flex flex-col w-full relative">
                <input
                  name="clave[]"
                  type="password"
                  required
                  placeholder="Ingrese una clave"
                  class="peer order-2 w-full border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25" />
                <label
                  class="order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors peer-focus:text-blue-500">
                  Contraseña
                </label>
                <button
                  type="button"
                  class="btn-view-pass absolute z-10 top-[calc(50%+8px)] right-2 -translate-y-1/2 cursor-pointer text-gray-600 peer-focus:text-blue-500">
                  <i class="bi bi-eye-fill"></i>
                </button>
              </div>
            </div>
            <button type="submit" class="w-fit cursor-pointer px-3 py-2 rounded flex justify-center items-center gap-1 bg-green-700 text-white hover:bg-green-500 transition-colors">Registrar</button>
          </form>
        `).join("")}
      `)

      $(".cbo-roles").each(function() {
        const rol = $(this).data("rol");

        $(this).select2({
          placeholder: "Seleccione un rol",
          width: "100%",
          data: listRoles.map(role => ({
            id: role.id,
            text: role.name
          }))
        });

        if (rol) {
          $(this).val(rol).trigger("change");
        }
      });
    } else {
      divNewUsers.append(`
        <h3>No hay usuarios pendientes</h3>
      `)
    }

    hideLoader();
  })

  $(document).on("submit", ".form", async function(e) {
    e.preventDefault();

    const $form = $(this);
    const formEl = $form[0];

    const userId = $form.data("form");

    const usuario = $form.find('input[name="usuario[]"]').val();
    const codemp = $form.find('input[name="codemp[]"]').val();
    const rol = $form.find('select[name="roles[]"]').val();
    const clave = $form.find('input[name="clave[]"]').val();

    if (!rol) {
      toastr.info(`Debe seleccionar un rol en el usuario ${usuario}`, "Aviso");
      return;
    }

    if (!clave) {
      toastr.info(`Debe ingresar una contraseña en el usuario ${usuario}`, "Aviso");
      return;
    }

    const data = {
      usuario,
      codemp,
      rol: Number(rol),
      clave,
      perfil: 0,
      inGesoper: false
    }

    console.log(data);

    await registerUser(data);

    await animate(
      formEl, {
        opacity: [1, 0],
        scale: [1, 0.5]
      }, {
        duration: 0.4,
        easing: "ease-in-out"
      }
    ).finished;

    formEl.remove();

    if ($("#listNewUsers .form").length === 0) {
      // último form
      $("#listNewUsers").append("<h3>No hay usuarios pendientes</h3>");
    }
  });

  $(document).on("submit", "#form-new-user", async function(e) {
    e.preventDefault();

    const $form = $(this);

    const usuario = $form.find('input[name="usuario"]').val();
    const codemp = $form.find('input[name="codemp"]').val();
    const rol = $form.find('select[name="rol"]').val();
    const clave = $form.find('input[name="clave"]').val();
    const perfil = $form.find('select[name="perfil"]').val();
    const inGesoper = $form.find('input[name="inGesoper"]').prop("checked");

    if (!usuario) {
      toastr.info(`Debe ingresar un nombre de usuario`, "Aviso");
      return;
    }

    if (!codemp) {
      toastr.info(`Debe ingresar un codigo de empleado`, "Aviso");
      return;
    }

    if (!rol) {
      toastr.info(`Debe seleccionar un rol`, "Aviso");
      return;
    }

    if (!clave) {
      toastr.info(`Debe ingresar una contraseña`, "Aviso");
      return;
    }

    if (inGesoper) {
      if (!perfil) {
        toastr.info(`Debe seleccionar un perfil para el gesoper`, "Aviso");
        return;
      }
    }

    const data = {
      usuario,
      codemp,
      rol: Number(rol),
      clave,
      perfil: Number(perfil),
      inGesoper
    }

    console.log(data);

    await registerUser(data);
  })

  $(document).on("click", ".btn-view-pass", function() {
    const $btn = $(this);

    const $input = $btn.closest(".input").find("input[name^='clave']");

    const isPassword = $input.attr("type") === "password";

    $input.attr("type", isPassword ? "text" : "password");

    $btn.find("i")
      .toggleClass("bi-eye-fill", !isPassword)
      .toggleClass("bi-eye-slash-fill", isPassword);
  });

  $("#inGesoper").on("click", function() {
    $("#cbo-perfiles").prop("disabled", !this.checked);

    if (!this.checked) {
      $("#cbo-perfiles").val(null).trigger("change");
    }
  })
</script>

<?php
require '../templates/footer.html';
?>