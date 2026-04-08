toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-bottom-right",
  preventDuplicates: false,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};

let activeRequests = 0;

function showLoader() {
  activeRequests++;
  $("#preloader-mini").css("opacity", "1");
  $("#preloader-mini").css("z-index", "99999");
}

function hideLoader() {
  activeRequests--;
  if (activeRequests <= 0) {
    setTimeout(() => {
      $("#preloader-mini").css("opacity", "0");
      $("#preloader-mini").css("z-index", "-99999");
    }, 400);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  showLoader();

  const params = new URLSearchParams(window.location.search);
  const clientId = params.get("clienteId");

  document
    .getElementById("btnClear")
    .addEventListener("click", deshabilitarSelect);
  document
    .getElementById("grabarButton")
    .addEventListener("click", guardaAsignacion);

  const btnFlotaTotal = document.getElementById("btn-flota-total");

  $("#combo-box").select2({
    placeholder: "Seleccione el cliente",
    allowClear: false,
  });

  $("#combo-box-leasing").select2({
    placeholder: "Seleccione el leasing",
    allowClear: false,
  });

  $("#combo-box-asig").select2({
    placeholder: "Seleccione el cliente asignado",
    allowClear: false,
    width: "65%",
  });

  $("#combo-box").on("select2:select", function () {
    limpiarSelect("#combo-box-leasing");
  });
  // document
  //   .querySelector("#combo-box-leasing")
  //   .addEventListener("change", () => limpiarSelect("#combo-box"));
  cargarClientes();
  // cargarLeasing();

  const selectClientes = $("#combo-box");
  const selectLeasingAnonim = $("#combo-box-leasing");

  if (clientId) {
    cargarLeasingOfClient(clientId).then(() => {
      listaVehiculosAsignables(clientId);
    });
  }

  selectClientes.on("select2:select", async function () {
    const id = selectClientes.val();
    params.set("clienteId", id);
    const nuevaURL = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", nuevaURL);

    // deshabilitarSelect();
    // btnSelectLeasing.setAttribute("disabled", "disabled");

    cargarLeasingOfClient(id).then(() => {
      listaVehiculosAsignables(id);
    });
  });

  selectLeasingAnonim.on("select2:select", async function () {
    const id = selectClientes.val();
    await listaVehiculosAsignables(id);
  });

  cargarClientesAsig();
  const checkAll = document.getElementById("checkAll");
  checkAll?.addEventListener("change", function () {
    const checkboxes = document.querySelectorAll('input[name="item[]"]');
    checkboxes.forEach((cb) => (cb.checked = this.checked));
  });

  hideLoader();
});

document.addEventListener("change", function (e) {
  if (!e.target.classList.contains("acta")) return;

  const file = e.target.files[0];
  if (!file) return;

  const container = e.target.closest("td");
  const label = container.querySelector("label");

  const span = label.querySelector("span");
  const icon = label.querySelector("i");

  // cambiar texto
  span.textContent = file.name;

  // cambiar icono
  icon.className = "bi bi-check-circle";

  // cambiar color
  label.classList.remove("bg-blue-800");
  label.classList.add("bg-green-600");
});

// Operacciones para el formulario de asignacion de vehiculos

async function cargarClientes() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const clientes = await response.json();
    const comboBox = document.querySelector('#combo-box[name="opciones"]');
    comboBox.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un cliente"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    clientes.forEach((cliente) => {
      const option = document.createElement("option");
      option.value = cliente.IDCLI; // El ID del cliente
      option.textContent = cliente.CLINOM; // El nombre del cliente
      comboBox.appendChild(option);
    });

    const params = new URLSearchParams(window.location.search);
    const clientId = params.get("clienteId");
    if (clientId) {
      $("#combo-box").val(clientId).trigger("change");
    }
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

async function cargarLeasingOfClient(idCli) {
  try {
    const btnSelectLeasing = document.getElementById("combo-box-leasing");
    const response = await fetch(
      `http://${IP_LOCAL}:3000/leasingOfClient?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    ); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const leasing = await response.json();

    const comboBox2 = document.getElementById("combo-box-leasing");
    comboBox2.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un Leasing"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox2.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    leasing.forEach((leasing) => {
      const option = document.createElement("option");
      option.value = leasing.NRO_LEASING; // El ID del cliente
      option.textContent = leasing.NRO_LEASING; // El nombre del cliente
      comboBox2.appendChild(option);
    });

    if (leasing.length === 0) {
      console.log(comboBox2);
      comboBox2.setAttribute("disabled", "disabled");
    } else {
      const allOption = document.createElement("option");
      allOption.value = "all"; // Valor "all"
      allOption.textContent = "Todos"; // Texto visible
      allOption.selected = true;
      comboBox2.appendChild(allOption);

      comboBox2.removeAttribute("disabled");
    }
  } catch (error) {
    console.error("Error al cargar el leasing:", error);
  }
}

async function cargarLeasing() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/leasing`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const leasing = await response.json();
    const comboBox2 = document.querySelector(
      '#combo-box-leasing[name="opciones"]',
    );
    comboBox2.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un leasing"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox2.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    leasing.forEach((leasing) => {
      const option = document.createElement("option");
      option.value = leasing.ID; // El ID del cliente
      option.textContent = leasing.NRO_LEASING; // El nombre del cliente
      comboBox2.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar el leasing:", error);
  }
}

function limpiarSelect(selector) {
  $(selector).val(null).trigger("change");
}

async function listaVehiculosAsignables(clientId) {
  // let id = "";
  let idCli = clientId;
  if (!clientId) idCli = $("#combo-box").val();
  const idLea = $("#combo-box-leasing").val();

  console.log({ idCli, idLea });

  // if (idCli !== "" && idLea === "") {
  //   id = idCli;
  // } else if (idLea !== "" && idCli === "") {
  //   id = idLea;
  // } else {
  //   console.error("Error al cargar el leasing");
  //   return;
  // }

  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/consultaVehiculoLeasing?idCli=${idCli}&nroLeasing=${idLea}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const vehiLeasing = await response.json();

    if (!vehiLeasing.success || vehiLeasing.data.length === 0) {
      document.querySelector(".tabla-form-adi table tbody").innerHTML = `
                <tr>
                    <td colspan="12">No hay vehículos disponibles</td>
                </tr>
            `;
      return;
    }

    const tbody = document.querySelector(".tabla-form-adi table tbody");
    tbody.innerHTML = ""; // Limpia las filas existentes
    let contador = 0;
    vehiLeasing.data.forEach((vehi, index) => {
      const fileId = `acta_${index}`;

      const row = document.createElement("tr");
      row.innerHTML = `
                <td>${(contador =
                  contador +
                  1)} &nbsp;&nbsp;<input type="checkbox" name="item[]" value=""></td>
                <td><input type="text" name="codini[]" value="${
                  vehi.codini
                }" disabled></td>
                <td><input type="text" name="placa[]" value="${
                  vehi.placa
                }" disabled></td>
                <td><input type="text" name="marca[]" value="${
                  vehi.marca
                }" disabled></td>
                <td><input type="text" name="modelo[]" value="${
                  vehi.modelo
                }" disabled></td>
                <td><input type="text" name="leasing[]" value="${vehi.nro_leasing.trim()}" disabled></td>
                <td><input type="text" name="tarifa[]" value="" placeholder="0" class="text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
                <td><input type="date" name="fechaIni[]" value="" placeholder="dd/mm/aaaa" class="dte-ini text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
                <td><input type="date" name="fechaFin[]" value="" placeholder="dd/mm/aaaa" class="dte-fin text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
                <td><select name="operacion[]" class="combo-operacion cbo-form-cliente">
                    </select></td>
                <td><select name="contrato[]" class="combo-contrato cbo-form-cliente">
                    </select></td>
                <td class="overflow-hidden"><select name="tipo_terreno[]" class="combo-tip-terreno cbo-form-cliente">
                        <option value="4">Seleccione el tipo</option>
                        <option value="0">Superficie</option>
                        <option value="1">Socavon</option>
                        <option value="2">Ciudad</option>
                        <option value="3">Severo</option>
                    </select>
                </td>
                <td>
                  <select name="condicion[]" class="cbo-form-cliente condicion-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione la condición">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Titular</option>
                    <option value="1">Retén</option>
                    <option value="2">Logística</option>
                    <option value="3">Pendiente</option>
                  </select>
                </td>
                <td>
                  <div class="flex">
                    <label for="${fileId}" class="btn-upload w-full flex justify-center items-center gap-1 cursor-pointer bg-blue-800 !rounded-md !text-white px-3 py-2">
                      <i class="bi bi-file-earmark-arrow-up"></i>
                      <span>Subir archivo</span>
                    </label>
                    <input id="${fileId}" type="file" name="acta[]" class="acta hidden">
                  </div>
                </td>
            `;
      tbody.appendChild(row);

      $(row)
        .find(".combo-operacion")
        .select2({
          placeholder: "Seleccione la operacion",
          allowClear: false,
        })
        .next(".select2-container")
        .css({
          "font-family": "Fredoka Variable, sans-serif",
          "font-size": "13px",
          "font-optical-sizing": "auto",
          "font-style": "normal",
          "font-weight": "400",
        });

      $(row)
        .find(".combo-contrato")
        .select2({
          placeholder: "Seleccione el contrato",
          allowClear: false,
        })
        .next(".select2-container")
        .css({
          "font-family": "Fredoka Variable, sans-serif",
          "font-size": "13px",
          "font-optical-sizing": "auto",
          "font-style": "normal",
          "font-weight": "400",
        });

      $(row)
        .find(".combo-tip-terreno")
        .select2({
          placeholder: "Seleccione el terreno",
          allowClear: false,
        })
        .next(".select2-container")
        .css({
          "font-family": "Fredoka Variable, sans-serif",
          "font-size": "13px",
          "font-optical-sizing": "auto",
          "font-style": "normal",
          "font-weight": "400",
        });

      $(row)
        .find(".condicion-select")
        .select2({
          placeholder: "Seleccione condicion",
          allowClear: false,
        })
        .next(".select2-container")
        .css({
          "font-family": "Fredoka Variable, sans-serif",
          "font-size": "13px",
          "font-optical-sizing": "auto",
          "font-style": "normal",
          "font-weight": "400",
        });

      $(row)
        .find(".dte-ini")
        .each(function () {
          flatpickr(this, {
            dateFormat: "d/m/Y",
            locale: "es",
          });
        });

      $(row)
        .find(".dte-fin")
        .each(function () {
          flatpickr(this, {
            dateFormat: "d/m/Y",
            locale: "es",
          });
        });

      $("#combo-box-asig").prop("disabled", false);
      document.getElementById("checkAll").removeAttribute("disabled");
      document.getElementById("repeticion").removeAttribute("disabled");
    });
  } catch (error) {
    console.error("Error al enviar los datos:", error);
    toastr.warning("No se pudo cargar la lista de vehiculos", "Oops...");
  }
}

async function cargarClientesAsig() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const clientes = await response.json();
    const comboBox = document.querySelector('#combo-box-asig[name="opciones"]');
    comboBox.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un cliente"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    clientes.forEach((cliente) => {
      const option = document.createElement("option");
      option.value = cliente.IDCLI; // El ID del cliente
      option.textContent = cliente.CLINOM; // El nombre del cliente
      comboBox.appendChild(option);
    });
    cargarOperaciones();
    cargarContrato();
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

function deshabilitarSelect() {
  const params = new URLSearchParams(window.location.search);
  params.delete("clienteId");

  const nuevaURL = `${window.location.pathname}?${params.toString()}`;
  window.history.replaceState({}, "", nuevaURL);

  $("#combo-box-asig").prop("disabled", true);
  document.getElementById("checkAll").setAttribute("disabled", "true");
  document.getElementById("repeticion").setAttribute("disabled", "true");
  document.querySelector(".tabla-form-adi table tbody").innerHTML = `
        <tr>
            <td colspan="12">Seleccione un cliente para ver los vehiculos por asignar</td>
        </tr>
    `;

  $("#combo-box").val(null).trigger("change"); // Restablece el valor al predeterminado

  const comboBox2 = document.getElementById("combo-box-leasing");
  comboBox2.value = ""; // Restablece el valor al predeterminado

  $("#combo-box-asig").val(null).trigger("change"); // Restablece el valor al predeterminado

  document.getElementById("checkAll").checked = false;
  document.getElementById("repeticion").checked = false;

  comboBox2.innerHTML = "";

  const reloadOption = document.createElement("option");
  reloadOption.value = "";
  reloadOption.textContent = "Seleccione un Leasing";
  reloadOption.disabled = true;
  reloadOption.selected = true;
  comboBox2.appendChild(reloadOption);
  comboBox2.setAttribute("disabled", "disabled");
}

async function cargarOperaciones() {
  $("#combo-box-asig").on("select2:select", async function () {
    const idCli = this.value; // Obtiene el ID del cliente seleccionado

    if (!idCli) {
      // Si no hay cliente seleccionado, limpia todos los combos de operación en la tabla
      document.querySelectorAll(".combo-operacion").forEach((select) => {
        select.innerHTML = '<option value="">Seleccione una Operacion</option>';
      });
      return;
    }
    try {
      // Realiza una solicitud al servidor para obtener las operaciones asignadas al cliente
      const response = await fetch(
        `http://${IP_LOCAL}:3000/operacionesAsig?idCli=${idCli}`,
        {
          method: "GET",
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        },
      );
      const operaciones = await response.json();

      // Si no hay operaciones, limpiar todos los selects
      if (operaciones.length === 0) {
        document.querySelectorAll(".combo-operacion").forEach((select) => {
          select.innerHTML =
            '<option value="">No hay operaciones disponibles</option>';
        });
        return;
      }

      // Recorre todos los selects en las filas de la tabla y los llena con las operaciones disponibles
      document.querySelectorAll(".combo-operacion").forEach((select) => {
        select.innerHTML = '<option value="">Seleccione una operacion</option>'; // Opción por defecto
        operaciones.forEach((operacion) => {
          const option = document.createElement("option");
          option.value = operacion.ID; // Valor del contrato
          option.textContent = operacion.DESCRIPCION; // Descripción del contrato
          select.appendChild(option);
        });
      });
    } catch (error) {
      console.error("Error al obtener las operaciones:", error);
      alert("Error al obtener las operaciones. Inténtelo de nuevo más tarde.");
    }
  });
}

async function cargarContrato() {
  $("#combo-box-asig").on("select2:select", async function () {
    const idCli = this.value; // Obtiene el ID del cliente seleccionado

    if (!idCli) {
      // Si no hay cliente seleccionado, limpia todos los combos de operación en la tabla
      document.querySelectorAll(".combo-contrato").forEach((select) => {
        select.innerHTML = '<option value="">Seleccione un contrato</option>';
      });
      return;
    }
    try {
      // Realiza una solicitud al servidor para obtener las operaciones asignadas al cliente
      const response = await fetch(
        `http://${IP_LOCAL}:3000/contratosNroAdi?idCli=${idCli}`,
        {
          method: "GET",
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        },
      );
      const contratos = await response.json();

      // Si no hay operaciones, limpiar todos los selects
      if (contratos.length === 0) {
        document.querySelectorAll(".combo-contrato").forEach((select) => {
          select.innerHTML =
            '<option value="">No hay contratos disponibles</option>';
        });
        return;
      }

      // Recorre todos los selects en las filas de la tabla y los llena con las operaciones disponibles
      document.querySelectorAll(".combo-contrato").forEach((select) => {
        select.innerHTML = '<option value="">Seleccione un contrato</option>'; // Opción por defecto
        contratos.forEach((contrato) => {
          const option = document.createElement("option");
          option.value = contrato.ID; // Valor del contrato
          option.textContent = contrato.DESCRIPCION; // Descripción del contrato
          select.appendChild(option);
        });
      });
    } catch (error) {
      console.error("Error al obtener las operaciones:", error);
      alert("Error al obtener las operaciones. Inténtelo de nuevo más tarde.");
    }
  });
}

async function guardaAsignacion() {
  // Obtener valores de los campos del formulario
  let formData = {
    idCliente: $("#combo-box-asig").val(),
    valorRepe: document.getElementById("checkAll").checked,
  };

  // Validación de campos obligatorios
  if (!formData.idCliente) {
    toastr.info("Por favor, completa todos los campos obligatorios.", "Aviso");
    return;
  }

  const invalidDates = [];
  const tarifasAltas = [];

  // Filtrar solo los checkboxes seleccionados
  const detalles = Array.from(document.querySelectorAll("#asignacion-tbody tr"))
    .filter((fila) => fila.querySelector('input[name="item[]"]').checked) // Solo los seleccionados
    .map((fila, index) => {
      let idveh = fila.querySelector('input[name="codini[]"]').value;
      let numpla = fila.querySelector('input[name="placa[]"]').value;
      let marca = fila.querySelector('input[name="marca[]"]').value;
      let modelo = fila.querySelector('input[name="modelo[]"]').value;
      let tarifa = fila.querySelector('input[name="tarifa[]"]').value;
      let fechaIni = dayjs(
        fila.querySelector('input[name="fechaIni[]"]').value,
        "DD/MM/YYYY",
      ).format("YYYY-MM-DD");
      let fechaFin = dayjs(
        fila.querySelector('input[name="fechaFin[]"]').value,
        "DD/MM/YYYY",
      ).format("YYYY-MM-DD");
      let idOperacion = fila.querySelector('select[name="operacion[]"]').value; // Cambié de input a select
      let idContrato = fila.querySelector('select[name="contrato[]"]').value;
      let condicion = fila.querySelector('select[name="condicion[]"]').value;
      let leasing = fila.querySelector('input[name="leasing[]"]').value;
      let idTerreno = fila.querySelector('select[name="tipo_terreno[]"]').value;
      let file = fila.querySelector('input[name="acta[]"]').files[0];

      // Validación y asignación de valores predeterminados
      idveh = idveh === "" ? 0 : idveh;
      numpla = numpla === "" ? 0 : numpla;
      tarifa = tarifa === "" ? 0 : tarifa;

      if(condicion == '4') {
        toastr.info(`Debes de seleccionar una condición a la placa ${numpla}`, "Aviso");
        throw new Error(`Debes de seleccionar una condición a la placa ${numpla}`)
      }

      if (!fechaIni || !fechaFin) {
        console.log("Ambas fechas son obligatorias");
      } else {
        const fechaInicio = new Date(fechaIni);
        const fechaFinal = new Date(fechaFin);

        if (fechaFinal <= fechaInicio) {
          invalidDates.push(index + 1);
        }
      }

      if (tarifa >= 100) {
        tarifasAltas.push(tarifa);
      }

      return {
        secCon: index + 1,
        idveh,
        numpla,
        marca,
        modelo,
        tarifa,
        fechaIni,
        fechaFin,
        idOperacion,
        idContrato,
        leasing,
        idTerreno,
        condicion,
        archivoPdf: file,
      };
    });

  if (detalles.length === 0) {
    toastr.info("Debe seleccionar al menos un vehículo.", "Aviso");
    return;
  }

  if (invalidDates.length > 0) {
    const itmDate = invalidDates.join(", ");
    toastr.info(
      `La fecha de devolución debe ser mayor que la fecha de entrega. (Item: ${itmDate})`,
      "Aviso",
    );
    return;
  }

  if (tarifasAltas.length > 0) {
    $("#alert-modal").removeClass("hidden");
    $("#alert-modal").addClass("flex");

    $("#listTarifa").text(`Tarifas observadas: ${tarifasAltas.join(", ")}`)

    $("#btn-save")
      .off("click")
      .on("click", async function () {
        const validacionResult = await validarAsignacion(detalles);
        if (!validacionResult.success) {
          toastr.warning(
            validacionResult.mensaje || "Validación fallida",
            "Oops...",
          );
          return false;
        }

        const asignacionData = { ...formData, detalles };

        await registrar(asignacionData);

        $("#alert-modal").addClass("hidden");
        $("#alert-modal").removeClass("flex");
      });

    $("#btn-cancel")
      .off("click")
      .on("click", function () {
        $("#alert-modal").addClass("hidden");
        $("#alert-modal").removeClass("flex");
      });

    return;
  }

  const validacionResult = await validarAsignacion(detalles);
  if (!validacionResult.success) {
    toastr.warning(validacionResult.mensaje || "Validación fallida", "Oops...");
    return false;
  }

  const asignacionData = { ...formData, detalles };

  await registrar(asignacionData);
}

const registrar = async (asignacionData) => {
  // try {
  //   await Promise.all(
  //     asignacionData.detalles.map(async (detalle) => {
  //       if (!detalle.archivoPdf) return;
  //       const formData = new FormData();
  //       formData.append("archivoPdf", detalle.archivoPdf);
  //       formData.append("documentType", "acta");
  //       const res = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
  //         method: "POST",
  //         body: formData,
  //       });
  //       const data = await res.json();
  //       detalle.archivoPdf = data.key;
  //     }),
  //   );
  //   const response = await fetch(`http://${IP_LOCAL}:3000/insertaAsignacion`, {
  //     method: "POST",
  //     headers: { "Content-Type": "application/json" },
  //     body: JSON.stringify(asignacionData),
  //     credentials: "include", // Asegura que las cookies se envíen con la solicitud
  //   });
  //   const result = await response.json();
  //   if (result.success) {
  //     toastr.success("Asignación guardada exitosamente", "¡Éxito!");
  //     deshabilitarSelect();
  //   } else {
  //     toastr.warning(result.message, "Oops...");
  //   }
  // } catch (error) {
  //   const mensaje =
  //     error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
  //   console.error("Error al enviar los datos:", error);
  //   toastr.warning(`No se puedo procesar la asignación: ${mensaje}`, "Oops...");
  // }
};

const validarAsignacion = async (detalles) => {
  if (!detalles || detalles.length === 0) return { success: true };

  const validacionResponse = await fetch(
    `http://${IP_LOCAL}:3000/validaContratoCantidad`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ detalles }),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    },
  );

  const validacionResult = await validacionResponse.json();

  if (!validacionResult.success) {
    console.error("Error de validación:", validacionResult.mensaje);
    return { success: false, mensaje: validacionResult.mensaje };
  }

  return { success: true };
};
