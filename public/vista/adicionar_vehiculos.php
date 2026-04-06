<?php
require './templates/header.html';
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- CSS de Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- JS de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<!-- TOASTR -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- END TOASTR -->

<!-- CSS DE LA VISTA ADICIONAR VEHICULOS -->
<style>
  <?php include '../css/views/add_vehicle.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->
<div id="preloader-mini" class="w-full h-screen fixed top-0 left-0 z-[9999] bg-white flex flex-col justify-center items-center">
  <div class="flex-col gap-4 w-full flex items-center justify-center relative">
    <div class="w-28 h-28 border-8 text-blue-600 text-4xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-600 rounded-full"></div>
    <div class="gif-container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <img src="../img/carpeta.gif">
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

<main class="main-register">
  <div class="contenedor border border-gray-300 px-9 py-7 relative overflow-hidden">
    <div class="w-full h-3 bg-yellow-700 absolute top-0 left-0"></div>
    <div class="w-full flex flex-col justify-center gap-2">
      <h3 class="text-5xl text-[#002141] font-semibold">Asignar unidades</h3>
      <p class="!m-0 text-base font-normal text-gray-500">Gestione la transferencia de vehículos entre clientes, seleccionando el destino al cual serán asignados.</p>
    </div>
    <div class="body-adiciona">
      <!-- <div class="cbo-form-dig">
                <div class="w-full grid grid-cols-2 place-content-center gap-3 pb-3">
                    <div class="flex flex-col w-full relative">
                        <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes">
                            <option value="">Seleccione un cliente</option>
                        </select>

                        <label
                            for="combo-box"
                            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                            Cliente(*)
                        </label>
                    </div>
                    <div class="flex flex-col w-full relative">
                        <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
                            <option value="" disabled selected>Seleccione un Leasing</option>
                        </select>

                        <label
                            for="combo-box-leasing"
                            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
                            N° De Leasing
                        </label>
                    </div>

                    <div class="cbo-clau-te">
                        <label for="combo-box-cliente">Cliente:</label>
                        <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes"></select>
                    </div>
                    <div class="cbo-clau-te">
                        <label for="combo-box-leasing">N° De Leasing:</label>
                        <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
                            <option value="" disabled selected>Seleccione un Leasing</option>
                        </select>
                    </div>
                </div>
                <div class="cbo-form-adiciona">
                    onclick="listaVehiculosAsignables()"
                    <button id="btn-flota-total" class="btn-flota-adi" >Flota Total</button>
                </div>
            </div> -->
      <div class="w-full grid grid-cols-2 place-content-center gap-4 pt-6 pb-4">
        <!-- CLIENTE CBO -->
        <div class="flex flex-col w-full relative">
          <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes">
            <option value="">Seleccione un cliente</option>
          </select>

          <label
            for="combo-box"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            Cliente Origen(*)
          </label>
        </div>

        <!-- LEASING CBO -->
        <div class="flex flex-col w-full relative">
          <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
            <option value="" disabled selected>Seleccione un Leasing</option>
          </select>

          <label
            for="combo-box-leasing"
            class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
            N° De Leasing
          </label>
        </div>

        <!-- <div class="cbo-clau-te">
                        <label for="combo-box-cliente">Cliente:</label>
                        <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes"></select>
                    </div> -->
        <!-- <div class="cbo-clau-te">
                        <label for="combo-box-leasing">N° De Leasing:</label>
                        <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
                            <option value="" disabled selected>Seleccione un Leasing</option>
                        </select>
                    </div> -->
      </div>
      <div class="tabla-form-adi">
        <table>
          <thead>
            <tr>
              <th><input class="check-xtodo" type="checkbox" id="checkAll" disabled> Select</th>
              <th>ID</th>
              <th>Placa</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Leasing</th>
              <th>Tarifa</th>
              <th>Fecha de Entrega</th>
              <th>Fecha Devolucion</th>
              <th>Operacion</th>
              <th>Contrato</th>
              <th>Terreno</th>
              <th>Acta</th>
            </tr>
          </thead>
          <tbody id="asignacion-tbody">
            <tr>
              <td colspan="12">Seleccione un cliente para ver los vehiculos por asignar</td>
            </tr>
          </tbody>
          <!--<tbody id="contratos-tbody" class="table-detalle">
                            </tbody>-->
        </table>
      </div>
      <div class="modal-footer">
        <div class="cbo-form-adiciona">
          <!-- ASIGNAR CBO -->
          <div class="flex flex-col w-full relative">
            <select id="combo-box-asig" name="opciones" class="cbo-form-leasing" disabled></select>

            <label
              for="combo-box-asig"
              class="label-select z-[1] order-1 text-gray-500 text-xs font-semibold relative top-2 ml-[7px] px-[3px] bg-white w-fit transition-colors">
              Asignar Cliente Destino(*)
            </label>
          </div>
          <!-- <div class="w-full flex gap-3">
                        <label for="combo-box-asig">Asignar Cliente:</label>
                        <select id="combo-box-asig" name="opciones" class="cbo-form-leasing" disabled></select>
                    </div> -->
          <div class="w-full flex gap-3 justify-end items-center">
            <div class="flex justify-center items-center gap-1">
              <input class="check-xtodo" type="checkbox" id="repeticion" disabled>
              <label for="id=" repeticion"">Repetir</label>
            </div>
            <!-- <button class="px-5 py-2 bg-green-600 outline-none rounded-sm hover:bg-green-700 transition-colors text-white cursor-pointer" id="grabarButton">Grabar</button> -->
            <button
              type="button"
              id="grabarButton"
              class="cursor-pointer bg-green-700 text-center w-1/3 rounded-2xl h-12 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
              <div
                class="bg-green-950 text-white rounded-xl h-10 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
                <i class="bi bi-floppy-fill"></i>
              </div>
              <p class="translate-x-4 !m-0 !text-white text-base font-medium">Grabar</p>
            </button>
            <!-- <button class="px-5 py-2 bg-yellow-700 outline-none rounded-sm hover:bg-yellow-600 transition-colors text-white cursor-pointer" id="btnClear">Limpiar</button> -->
            <button
              type="button"
              id="btnClear"
              class="cursor-pointer bg-yellow-700 text-center w-1/3 rounded-2xl h-12 relative text-xl flex justify-center items-center font-semibold border-4 border-white group">
              <div
                class="bg-yellow-950 text-white rounded-xl h-10 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
                <i class="bi bi-stars"></i>
              </div>
              <p class="translate-x-4 !m-0 !text-white text-base font-medium">Limpiar</p>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- ALERTA MODAL -->
<div id="alert-modal" class="fixed w-full h-dvh top-0 left-0 hidden justify-center items-center z-[9990]">
  <div class="fixed top-0 left-0 w-full h-full bg-black/25 z-[9991]"></div>
  <div class="w-[30%] max-w-[90%] bg-[#ffeab0] rounded-xl border-2 border-[#ffbb00] p-5 z-[9999]">
    <h3 class="font-medium text-[#e0a501] text-xl">¡Tarifas excesivas!</h3>
    <p>Hemos detectado que estas colocando <b>tarifas</b> mayor a dos cifras.</p>
    <p id="listTarifa"></p>
    <p>¿Estas seguro de continuar?</p>
    <div class="flex items-center gap-1">
      <button id="btn-save" class="px-4 py-2 text-white outline-none border-none rounded-lg text-sm bg-blue-700 hover:bg-blue-500 transition-colors cursor-pointer">Si, guardar asignación</button>
      <button id="btn-cancel" class="px-4 py-2 text-white outline-none border-none rounded-lg text-sm bg-zinc-900 hover:bg-zinc-700 transition-colors cursor-pointer">No, cancelar proceso</button>
    </div>
  </div>
</div>

<!-- SCRIPTS DE LA VISTA -->

<script type="module">
  window.onload = function() {
    setTimeout(() => {
      document.body.classList.add('loaded');
      document.getElementById('preloader-mini').style.display = 'none';
    }, 2000);
  };
</script>
<script type="module" src="../js/adiciona_vehiculo.js"></script>

<?php
require './templates/footer.html';
?>