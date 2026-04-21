import { animate } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

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

let tableAssign = null;

// Operacciones para el formulario de asignacion de vehiculos
const validInputDate = (e) => {
  let value = e.target.value.replace(/\D/g, ""); // solo números

  if (value.length >= 3 && value.length <= 4) {
    value = value.slice(0, 2) + "/" + value.slice(2);
  } else if (value.length >= 5) {
    value =
      value.slice(0, 2) + "/" + value.slice(2, 4) + "/" + value.slice(4, 8);
  }

  e.target.value = value;
};

export async function cargarClientes() {
  try {
    const IP_LOCAL = await obtenerConfig();

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

export async function cargarLeasingOfClient(idCli) {
  try {
    const btnSelectLeasing = document.getElementById("combo-box-leasing");

    const IP_LOCAL = await obtenerConfig();

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
    const IP_LOCAL = await obtenerConfig();

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

export function limpiarSelect(selector) {
  $(selector).val(null).trigger("change");
}

export async function listaVehiculosAsignables(clientId) {
  // let id = "";
  let idCli = clientId;
  if (!clientId) idCli = $("#combo-box").val();
  const idLea = $("#combo-box-leasing").val();

  try {
    let vehiLeasing = { data: null };

    if (idCli) {
      const IP_LOCAL = await obtenerConfig();

      const response = await fetch(
        `http://${IP_LOCAL}:3000/consultaVehiculoLeasing?idCli=${idCli}&nroLeasing=${idLea}`,
        {
          method: "GET",
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        },
      );

      vehiLeasing = await response.json();
    }

    const data = Array.isArray(vehiLeasing.data) ? vehiLeasing.data : [];

    if ($.fn.DataTable.isDataTable("#listAssign")) {
      tableAssign.clear();
      tableAssign.rows.add(data);
      tableAssign.draw();
    } else {
      tableAssign = $("#listAssign").DataTable({
        language: {
          url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
        },
        paging: false,
        info: false, // "Mostrando 1 a 100..."
        lengthChange: false,
        emptyTable: "No hay vehículos disponibles",
        fixedHeader: true,
        dom: '<"superior"f>rt<"inferior"i<"derecha-inferior"lp>>',
        scrollCollapse: true,
        scrollX: true,
        scrollY: 550,
        initComplete: function () {
          this.api().columns.adjust();
        },
        data,
        order: [[1, "asc"]],
        select: {
          style: "multi",
          selector: "td:first-child",
        },
        columnDefs: [
          {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0,
          },
          // Centrar contenido y cabecera en las columnas 0, 1 y 2
          {
            className: "dt-center",
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
          },
        ],
        columns: [
          {
            data: null, // CHECKBOX
            defaultContent: "",
          },
          {
            data: "item",
            render: function (data, type, row, meta) {
              return meta.row + 1;
            },
            width: "15px",
          },
          {
            data: "codini",
            render: (data) => {
              return `<input type="text" name="codini[]" value="${
                data
              }" disabled>`;
            },
            visible: false,
          },
          {
            data: "placa",
            render: (data, type) => {
              if (type === "filter" || type === "sort") {
                return data;
              }

              return `<input type="text" name="placa[]" value="${data}" class="w-full text-center" disabled>`;
            },
            width: "50px",
          },
          {
            data: "marca",
            render: (data, type) => {
              if (type === "filter" || type === "sort") {
                return data;
              }

              return `<input type="text" name="marca[]" value="${
                data
              }" class="w-full text-center" disabled>`;
            },
            width: "50px",
          },
          {
            data: "modelo",
            render: (data, type) => {
              if (type === "filter" || type === "sort") {
                return data;
              }

              return `<input type="text" name="modelo[]" value="${
                data
              }" class="w-full text-center" disabled>`;
            },
            width: "150px",
          },
          {
            data: "nro_leasing",
            render: (data, type) => {
              if (type === "filter" || type === "sort") {
                return data;
              }

              return `<input type="text" name="leasing[]" value="${data.trim()}" class="w-full text-center" disabled>`;
            },
            width: "130px",
          },
          {
            data: null, // TARIFA
            render: () => {
              return `<input type="text" name="tarifa[]" value="" placeholder="0" class="w-12 !text-black text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input">`;
            },
            width: "20px",
          },
          {
            data: null, // FECHA ENTREGA
            render: () => {
              return `<input type="date" name="fechaIni[]" value="" placeholder="dd/mm/aaaa" class="dte-ini w-28 !text-black text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input">`;
            },
            width: "100px",
          },
          {
            data: null, // FECHA DEVOLUCION
            render: () => {
              return `<input type="date" name="fechaFin[]" value="" placeholder="dd/mm/aaaa" class="dte-fin w-28 !text-black text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input">`;
            },
            width: "100px",
          },
          {
            data: null, // OPERACION
            render: () => {
              return `<select name="operacion[]" class="combo-operacion cbo-form-cliente"></select>`;
            },
            width: "200px",
          },
          {
            data: null, // CONTRATO
            render: () => {
              return `<select name="contrato[]" class="combo-contrato cbo-form-cliente"></select>`;
            },
            width: "200px",
          },
          {
            data: null, // TERRENO
            render: () => {
              return `<select name="tipo_terreno[]" class="combo-tip-terreno cbo-form-cliente">
                        <option value="5">Seleccione el tipo</option>
                        <option value="0">Superficie</option>
                        <option value="1">Socavon</option>
                        <option value="2">Ciudad</option>
                        <option value="3">Severo</option>
                        <option value="4">Pendiente</option>
                    </select>`;
            },
            width: "130px",
          },
          {
            data: null, // CONDICION
            render: () => {
              return `
              <select name="condicion[]" class="cbo-form-cliente condicion-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione la condición">
                <option value="4">Seleccione el tipo</option>
                <option value="0">Titular</option>
                <option value="1">Retén</option>
                <option value="2">Logística</option>
                <option value="3">Pendiente</option>
              </select>
            `;
            },
            width: "130px",
          },
          {
            data: null, // ACTA
            render: (data, type, row, meta) => {
              return `
              <div class="flex items-center gap-1">
                <label for="acta_${row.codini}" class="btn-upload w-full flex justify-center items-center gap-1 cursor-pointer bg-blue-800 !rounded-md !text-white px-3 py-2">
                  <i class="bi bi-file-earmark-arrow-up"></i>
                  <span class="line-clamp-2">Subir archivo</span>
                </label>
                <input id="acta_${row.codini}" type="file" name="acta[]" class="acta hidden" accept="application/pdf">
                <button id="remove-file-${row.codini}" class="remove-file cursor-pointer p-2 hidden justify-center items-center bg-red-100 border border-red-700 text-red-700 rounded-sm"><i class="bi bi-x"></i></button>
              </div>
            `;
            },
            width: "150px",
          },
        ],
        drawCallback: function () {
          this.api().columns.adjust();
          
          $(".combo-operacion").select2({
            placeholder: "Seleccione la operacion",
            width: "100%",
            language: {
              noResults: function () {
                return "No hay resultados disponibles"; // O puedes devolver un string HTML
              },
            },
          });

          $(".combo-contrato").select2({
            placeholder: "Seleccione el contrato",
            width: "100%",
            language: {
              noResults: function () {
                return "No hay resultados disponibles"; // O puedes devolver un string HTML
              },
            },
          });

          $(".combo-tip-terreno").select2({
            placeholder: "Seleccione el terreno",
            width: "100%",
          });

          $(".condicion-select").select2({
            placeholder: "Seleccione condicion",
            width: "100%",
          });

          $(".dte-ini, .dte-fin").each(function () {
            if (!this._flatpickr) {
              flatpickr(this, {
                dateFormat: "d/m/Y",
                locale: "es",
                allowInput: true,
                clickOpens: true,
                onChange: function (selectedDates, dateStr, instance) {
                  validInputDate({
                    target: instance.input,
                  });
                },
              });
            }
          });
        },
      });

      setTimeout(() => {
        tableAssign.columns.adjust().draw();
      }, 100);
    }

    if (data.length > 0) {
      $("#combo-box-asig").prop("disabled", false).val(null).trigger("change");
      document.getElementById("repeticion").removeAttribute("disabled");
    } else {
      $("#combo-box-asig").prop("disabled", true).val(null).trigger("change");
      document.getElementById("repeticion").setAttribute("disabled", "true");
    }
  } catch (error) {
    console.error("Error al enviar los datos:", error);
    toastr.warning("No se pudo cargar la lista de vehiculos", "Oops...");
  }
}

$(document).on("input", ".dte-ini, .dte-fin", function (e) {
  validInputDate(e);
});

export async function cargarClientesAsig() {
  try {
    const IP_LOCAL = await obtenerConfig();

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

export function deshabilitarSelect() {
  const params = new URLSearchParams(window.location.search);
  params.delete("clienteId");

  const nuevaURL = `${window.location.pathname}?${params.toString()}`;
  window.history.replaceState({}, "", nuevaURL);

  $("#combo-box-asig").prop("disabled", true);
  document.getElementById("repeticion").setAttribute("disabled", "true");

  if (tableAssign) {
    tableAssign.clear().draw();
  }

  $("#combo-box").val(null).trigger("change"); // Restablece el valor al predeterminado

  const comboBox2 = document.getElementById("combo-box-leasing");
  comboBox2.value = ""; // Restablece el valor al predeterminado

  $("#combo-box-asig").val(null).trigger("change"); // Restablece el valor al predeterminado

  // document.getElementById("checkAll").checked = false;
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
      const IP_LOCAL = await obtenerConfig();

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
      toastr.warning(
        "Error al obtener las operaciones. Inténtelo de nuevo más tarde.",
        "Oops...",
      );
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
      const IP_LOCAL = await obtenerConfig();

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
      toastr.warning(
        "Error al obtener las operaciones. Inténtelo de nuevo más tarde.",
        "Oops...",
      );
    }
  });
}

export async function guardaAsignacion() {
  // Obtener valores de los campos del formulario
  let formData = {
    idCliente: $("#combo-box-asig").val(),
    valorRepe: document.getElementById("repeticion").checked,
  };

  // Validación de campos obligatorios
  if (!formData.idCliente) {
    toastr.info("Por favor, completa todos los campos obligatorios.", "Aviso");
    return;
  }

  const invalidDates = [];
  const tarifasAltas = [];

  // Filtrar solo los checkboxes seleccionados
  const detalles = [];

  let contador = 1;

  tableAssign.rows({ selected: true }).every(function (index) {
    const data = this.data(); // ✅ datos originales
    const node = this.node(); // ✅ DOM real
    const $fila = $(node);

    let idveh = data.codini; // 🔥 AQUÍ el cambio importante
    let numpla = $fila.find('input[name="placa[]"]').val();
    let marca = $fila.find('input[name="marca[]"]').val();
    let modelo = $fila.find('input[name="modelo[]"]').val();
    let tarifa = $fila.find('input[name="tarifa[]"]').val();

    let fechaIni = dayjs(
      $fila.find('input[name="fechaIni[]"]').val(),
      "DD/MM/YYYY",
    ).format("YYYY-MM-DD");

    let fechaFin = dayjs(
      $fila.find('input[name="fechaFin[]"]').val(),
      "DD/MM/YYYY",
    ).format("YYYY-MM-DD");

    let idOperacion = $fila.find('select[name="operacion[]"]').val();
    let idContrato = $fila.find('select[name="contrato[]"]').val();
    let condicion = $fila.find('select[name="condicion[]"]').val();
    let leasing = $fila.find('input[name="leasing[]"]').val();
    let idTerreno = $fila.find('select[name="tipo_terreno[]"]').val();
    let file = $fila.find('input[name="acta[]"]')[0]?.files[0];

    // Defaults
    idveh = idveh === "" ? 0 : idveh;
    numpla = numpla === "" ? 0 : numpla;
    tarifa = tarifa === "" ? 0 : tarifa;

    if (condicion == "4") {
      toastr.info(
        `Debes de seleccionar una condición a la placa ${numpla}`,
        "Aviso",
      );
      throw new Error(`Condición inválida en placa ${numpla}`);
    }

    if (fechaIni && fechaFin) {
      const fechaInicio = new Date(fechaIni);
      const fechaFinal = new Date(fechaFin);

      if (fechaFinal <= fechaInicio) {
        invalidDates.push(index + 1);
      }
    }

    if (tarifa >= 100) {
      tarifasAltas.push(tarifa);
    }

    detalles.push({
      secCon: contador,
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
    });

    contador++;
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
    animate(
      ".alert-container",
      {
        opacity: [0, 1],
        scale: [0.7, 1.05, 1],
      },
      {
        duration: 0.45,
        easing: "ease-out",
      },
    );

    $("#alert-modal").removeClass("hidden");
    $("#alert-modal").addClass("flex");

    $("#listTarifa").text(`Tarifas observadas: ${tarifasAltas.join(", ")}`);

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

        const anim = animate(
          ".alert-container",
          {
            opacity: [1, 0],
            scale: [1, 1.05, 0.7],
          },
          {
            duration: 0.45,
            easing: "ease-in",
          },
        );

        await anim.finished;

        $("#alert-modal").addClass("hidden");
        $("#alert-modal").removeClass("flex");
      });

    $("#btn-cancel")
      .off("click")
      .on("click", async function () {
        const anim = animate(
          ".alert-container",
          {
            opacity: [1, 0],
            scale: [1, 1.05, 0.7],
          },
          {
            duration: 0.45,
            easing: "ease-in",
          },
        );

        await anim.finished;

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

  console.log(asignacionData);

  await registrar(asignacionData);
}

const registrar = async (asignacionData) => {
  try {
    const IP_LOCAL = await obtenerConfig();
    await Promise.all(
      asignacionData.detalles.map(async (detalle) => {
        if (!detalle.archivoPdf) {
          detalle.archivoPdf = null;
          return;
        }
        const formData = new FormData();
        formData.append("archivoPdf", detalle.archivoPdf);
        formData.append("documentType", "acta");
        const res = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
          method: "POST",
          body: formData,
        });
        const data = await res.json();
        detalle.archivoPdf = data.key;
      }),
    );
    const response = await fetch(`http://${IP_LOCAL}:3000/insertaAsignacion`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(asignacionData),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });
    const result = await response.json();
    if (result.success) {
      toastr.success("Asignación guardada exitosamente", "¡Éxito!");
      deshabilitarSelect();
    } else {
      toastr.warning(result.message, "Oops...");
    }
  } catch (error) {
    const mensaje =
      error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    console.error("Error al enviar los datos:", error);
    toastr.warning(`No se puedo procesar la asignación: ${mensaje}`, "Oops...");
  }
};

const validarAsignacion = async (detalles) => {
  if (!detalles || detalles.length === 0) return { success: true };

  const IP_LOCAL = await obtenerConfig();

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
