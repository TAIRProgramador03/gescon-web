<?php
require './templates/header.html';
?>

<!-- MOTION -->
<script src="https://cdn.jsdelivr.net/npm/motion@10/dist/motion.min.js"></script>

<!-- CSS DE LA VISTA DASHBOARD -->
<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/css/views/dashboard.css'; ?>
</style>

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
      <img src="/public/img/carpeta.gif">
    </div>
  </div>
</div>

<main class="w-full h-[calc(100dvh-64px)] flex justify-center items-center p-6">
  <div class="w-full h-full flex flex-col gap-3 overflow-hidden">
    <h1 class="text-xl font-semibold">Bienvenido al <span class="text-blue-800">Sistema Gestor de Contratos</span></h1>
    <p class="text-gray-500">Seleccione una opción desde el panel izquierdo</p>
    <figure class="w-full h-full flex rounded-xl overflow-hidden">
      <img src="/public/img/gescon.webp" alt="Gescon" class="w-full object-cover object-center border-gray-300">
    </figure>
  </div>
</main>

<div id="alert-modal">
  <div class="alert-bg"></div>
  <div class="alert-container">
  </div>
</div>

<script>
  document.title = "Bienvenido a Gescon";

  // CHARGE SCREEN
  let onLoadWindow = 0;

  function showLoaderWindow() {
    onLoadWindow++;
    $('#banner').css('opacity', '1');
    $('#banner').css('z-index', '99999');

    $(".carousel-container").css('opacity', '1');
    $(".carousel-container").css('z-index', '99999');

    // $('.banner').show();
  }

  function hideLoaderWindow() {
    onLoadWindow--;
    if (onLoadWindow <= 0) {
      Motion.animate("#banner", {
        opacity: [1, 0],
      }, {
        duration: 0.45,
        easing: "ease-in"
      })


      // $('#banner').css('opacity', '0');
      setTimeout(() => {
        $('#banner').css('z-index', '-99999');
      }, 400)
    }
  }

  const obtenerInstancia = async () => {
    const IP_LOCAL = await obtenerConfig();
    return axios.create({
      baseURL: `http://${IP_LOCAL}:3000`,
      timeout: 3000,
    });
  };

  let instance;

  async function obtenerVehiculosReasignacion() {
    try {
      instance = await obtenerInstancia();
      const response = await instance.get("/vehiculosPendientesReasginar", {
        withCredentials: true,
      });

      return response.data;
    } catch (error) {
      console.error(error.response.data);
      toastr.warning(error.response.data.message, "Oops...");
    }
  }

  function isPermission(permission) {
    const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

    return permissions.includes(permission);
  }

  window.onload = async function() {
    showLoaderWindow();

    const listVehiclesPending = await obtenerVehiculosReasignacion();

    if (listVehiclesPending.length > 0) {
      const perm = isPermission('insertar_reasignacion')
      if (perm) {
        Motion.animate(".alert-container", {
          opacity: [0, 1],
          scale: [0.7, 1.05, 1]
        }, {
          duration: 0.45,
          easing: "ease-out"
        });

        $("#alert-modal").css("display", "flex");

        $("#alert-modal .alert-container").css("background-color", "#ffeab0").css("border", "2px solid #ffbb00")

        $("#alert-modal .alert-container").html(
          `
              <h2>¡Aviso de unidades pendientes!</h2>
              <p style="color: black !important">El sistema ha detectado que se cuenta con <b>${listVehiclesPending.length}</b> vehiculo(s) que han sido traspasados a otras operaciones.</p>
              <p style="color: black !important">¿Deseas reasignarlos ahora?</p>
              <div class="btn-group">
                <a href="/gescon/vehiculos/reasignar_vehiculos" class="btn btn-info btn-assign">Si, quiero reasignarlos</a>
                <button id="btn-close-alert" class="btn btn-dark">Ignorar alerta</button>
              </div>
            `
        )
      }
    }

    hideLoaderWindow();
  };

  $(document).on("click", "#btn-close-alert", async () => {
    const anim = Motion.animate(".alert-container", {
      opacity: [1, 0],
      scale: [1, 1.05, 0.7]
    }, {
      duration: 0.45,
      easing: "ease-in"
    });

    await anim.finished;

    const modal = document.getElementById("alert-modal");
    modal.style.display = "none";

    $("#alert-modal .alert-container").empty();
  })
</script>

<?php
require './templates/footer.html';
?>