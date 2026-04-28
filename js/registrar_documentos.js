import { animate } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-top-right",
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

const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `http://${IP_LOCAL}:3000`,
    timeout: 3000,
  });
};

let instance;

let fileKey;

let isEdit = false;

let activeRequests = 0;

function showLoader() {
  activeRequests++;
  $("#preloader-mini").css("opacity", "1");
  $("#preloader-mini").css("z-index", "99999");
}

function hideLoader() {
  activeRequests--;
  if (activeRequests <= 0) {
    animate(
      "#preloader-mini",
      {
        opacity: [1, 0],
      },
      {
        duration: 0.45,
        easing: "ease-in",
      },
    );

    setTimeout(() => {
      // $('#preloader-mini').css('opacity', '0');
      $("#preloader-mini").css("z-index", "-99999");
    }, 400);
  }
}

document.addEventListener("DOMContentLoaded", async function () {
  showLoader();

  await cargarClientes();
  await cargarModelos();

  document.getElementById("btnClear").addEventListener("click", limpiarCampos);

  const checkbox = document.getElementById("especial");

  checkbox.addEventListener("change", function () {
    actualizarDuracionEstado();
  });

  $("#combo-cliente").select2({
    placeholder: "Seleccione el cliente",
    allowClear: false, // Desactiva la "X"
    width: "100%",
  });

  $("#combo-contrato").select2({
    placeholder: "Seleccione el contrato",
    allowClear: false, // Desactiva la "X"
    width: "100%",
  });

  $("#combo-raz").select2({
    placeholder: "Seleccione el tipo",
    allowClear: false, // Desactiva la "X"
    width: "100%",
  });

  $("#combo-motivo").select2({
    placeholder: "Seleccione el motivo",
    allowClear: false, // Desactiva la "X"
    width: "100%",
  });

  $("#tipoTerreno").select2({
    placeholder: "Seleccione el tipo",
    allowClear: false, // Desactiva la "X"
    width: "140px",
  });

  $("#tipoModelo").select2({
    placeholder: "Seleccione el modelo",
    allowClear: false, // Desactiva la "X"
    width: "100%",
  });

  $("#condicion").select2({
    placeholder: "Seleccione la condicion",
    allowClear: false, // Desactiva la "X"
    width: "120px",
  });

  flatpickr("#text-firma", {
    dateFormat: "d/m/Y",
    locale: "es",
    allowInput: true,
    clickOpens: true,
  });

  const params = new URLSearchParams(window.location.search);
  const isUpd = params.get("formUpd");
  const documentId = params.get("idDocumento");

  if (isUpd && isUpd == "true" && documentId) {
    // CARGAMOS TODA LA INFORMACIÓN
    await cargarDocumento(documentId);
  }

  hideLoader();
});

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

document.getElementById("text-firma").addEventListener("input", function (e) {
  validInputDate(e);
});

function actualizarDuracionEstado() {
  const duracionCeldas = document.querySelectorAll('input[name="duracion[]"]');
  const kmAdiCeldas = document.querySelectorAll('input[name="kmAdi[]"]');
  const checkbox = document.getElementById("especial"); // Reemplaza con el ID real del checkbox

  duracionCeldas.forEach(function (celda) {
    if (!checkbox.checked) {
      celda.value = "0"; // Establece el valor en 0 si el checkbox está desactivado
    }
    celda.disabled = !checkbox.checked;
  });

  kmAdiCeldas.forEach(function (celda) {
    if (!checkbox.checked) {
      celda.value = "0"; // Establece el valor en 0 si el checkbox está desactivado
    }
    celda.disabled = !checkbox.checked;
  });
}

function agregarFila(checkbox) {
  const tabla = document.getElementById("tabla-dinamica");
  const lastRow = tabla.querySelector("tbody tr:last-child");
  const lastRowIndex = Array.from(tabla.querySelectorAll("tbody tr")).indexOf(
    lastRow,
  );

  const nuevaFila = document.createElement("tr");

  nuevaFila.innerHTML = `
            <td><input type="text" name="item[]" value="${
              lastRowIndex + 2
            }" class="disabled:bg-gray-100 w-8 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" disabled></td>
            <td class="hidden"><input type="text" name="id[]" class="disabled:bg-gray-100 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" disabled></td>
            <td>
                <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" style="width: 100%;" data-tooltip="Selecciona el modelo">
                    <option value="">Seleccione un modelo</option>
                </select>
            </td>
            <td>
                <select name="tipo_terreno[]" class="cbo-form-cliente-deta terreno-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Superficie</option>
                    <option value="1">Socavon</option>
                    <option value="2">Ciudad</option>
                    <option value="3">Severo</option>
                </select>
            </td>
            <td><input type="text" name="tarifa[]" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Tarifa del contrato estipulado"></td>
            <td><input type="text" name="cpk[]" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Costo por kilometraje"></td>
            <td><input type="number" name="rm[]" class="no-negative w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="Recorrido mensual del vehiculo"></td>
            <td><input type="number" name="cantidad[]" class="no-negative w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="Cantidad de unidades"></td>
            <td><input type="text" min="0" name="kmAdi[]" class="disabled:bg-gray-100 w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" ${
              checkbox.checked ? "" : "disabled"
            } data-tooltip="$KM Adicional"></td>
            <td><input type="text" name="duracion[]" class="disabled:bg-gray-100 w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" ${
              checkbox.checked ? "" : "disabled"
            }  data-tooltip="Duracion contrato"></td>
            <td><input type="text" name="compra_veh[]" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
            <td><input type="text" name="precio_veh[]" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
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
              <button class="btn btn-error btn-remove-vehicle"><i class="bi bi-trash"></i></button>
            </td>
        `;

  // Agregar la nueva fila a la tabla
  tabla.querySelector("tbody").appendChild(nuevaFila);

  animate(
    nuevaFila,
    {
      opacity: [0, 1],
      transform: ["translateY(10px)", "translateY(0px)"],
      backgroundColor: ["#07E800", "#ffffff"],
    },
    {
      duration: 0.5,
      easing: "ease-out",
    },
  );

  actualizarDuracionEstado();

  cargarModelosFila(nuevaFila.querySelector(".modelo-select"));

  $(nuevaFila)
    .find(".modelo-select")
    .select2({
      placeholder: "Seleccione el modelo",
      allowClear: false,
      width: "120px",
    })
    .next(".select2-container")
    .css({
      "font-family": "Fredoka Variable, sans-serif",
      "font-size": "13px",
      "font-optical-sizing": "auto",
      "font-style": "normal",
      "font-weight": "400",
    });

  $(nuevaFila)
    .find(".terreno-select")
    .select2({
      placeholder: "Seleccione el terreno",
      allowClear: false,
      width: "120px",
    })
    .next(".select2-container")
    .css({
      "font-family": "Fredoka Variable, sans-serif",
      "font-size": "13px",
      "font-optical-sizing": "auto",
      "font-style": "normal",
    });

  $(nuevaFila)
    .find(".condicion-select")
    .select2({
      placeholder: "Seleccione la condicion",
      allowClear: false,
      width: "120px",
    })
    .next(".select2-container")
    .css({
      "font-family": "Fredoka Variable, sans-serif",
      "font-size": "13px",
      "font-optical-sizing": "auto",
      "font-style": "normal",
    });
}

async function cargarFilasDesdeLista(lista, checkbox) {
  const tabla = document.getElementById("tabla-dinamica");
  const tbody = tabla.querySelector("tbody");

  // 🔹 limpiar tabla si quieres (opcional)
  tbody.innerHTML = "";

  for (const [index, data] of lista.entries()) {
    const nuevaFila = document.createElement("tr");

    nuevaFila.innerHTML = `
      <td><input type="text" name="item[]" value="${index + 1}" class="disabled:bg-gray-100 w-8 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" disabled></td>

      <td class="hidden"><input type="text" name="id[]" class="disabled:bg-gray-100 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" value="${data.id}" disabled></td>

      <td>
        <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select">
          <option value="">Seleccione un modelo</option>
        </select>
      </td>

      <td>
        <select name="tipo_terreno[]" class="cbo-form-cliente-deta terreno-select">
          <option value="4">Seleccione el tipo</option>
          <option value="0">Superficie</option>
          <option value="1">Socavon</option>
          <option value="2">Ciudad</option>
          <option value="3">Severo</option>
        </select>
      </td>

      <td><input type="text" name="tarifa[]" value="${data.tarifa}" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
      <td><input type="text" name="cpk[]" value="${data.cpk}" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
      <td><input type="number" name="rm[]" value="${data.rm}" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
      <td><input type="number" name="cantidad[]" value="${data.cantidad}" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>

      <td>
        <input type="text" name="kmAdi[]" value="${data.kmAdicional}" class="disabled:bg-gray-100 w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" ${
          checkbox.checked ? "" : "disabled"
        }>
      </td>

      <td>
        <input type="text" name="duracion[]" value="${data.duracion}" class="disabled:bg-gray-100 w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" ${
          checkbox.checked ? "" : "disabled"
        }>
      </td>

      <td><input type="text" name="compra_veh[]" value="${data.compraVeh}" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>
      <td><input type="text" name="precio_veh[]" value="${data.precioVeh}" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input"></td>

      <td>
        <select name="condicion[]" class="cbo-form-cliente condicion-select">
          <option value="4">Seleccione el tipo</option>
          <option value="0">Titular</option>
          <option value="1">Retén</option>
          <option value="2">Logística</option>
          <option value="3">Pendiente</option>
        </select>
      </td>

      <td>
        <button class="btn btn-error btn-remove-vehicle">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    `;

    tbody.appendChild(nuevaFila);

    // 🔹 cargar modelos dinámicamente
    await cargarModelosFila(nuevaFila.querySelector(".modelo-select"));

    // 🔹 inicializar select2
    $(nuevaFila).find(".modelo-select").select2({ width: "120px" });
    $(nuevaFila).find(".terreno-select").select2({ width: "120px" });
    $(nuevaFila).find(".condicion-select").select2({ width: "120px" });

    // 🔥 setear valores después de inicializar
    if (data.modelo) {
      $(nuevaFila).find(".modelo-select").val(data.modelo).trigger("change");
    }

    if (data.tipoTerreno !== undefined) {
      $(nuevaFila)
        .find(".terreno-select")
        .val(data.tipoTerreno)
        .trigger("change");
    }

    if (data.condicion !== undefined) {
      $(nuevaFila)
        .find(".condicion-select")
        .val(data.condicion)
        .trigger("change");
    }
  }

  actualizarDuracionEstado();
}

$("#combo-cliente").on("select2:select", async function () {
  const idCli = $(this).val(); // Obtiene el ID del cliente seleccionado

  if (!idCli) {
    // Si no hay cliente seleccionado, limpia el combo de contratos
    document.getElementById("combo-contrato").innerHTML =
      '<option value="">Seleccione un contrato</option>';
    return;
  }

  await cargarContrato(idCli);
});

/**
 * AGREGA UNA NUEVA FILA A LA TABLA DE VEHICULOS
 */
$("#addVehicle").on("click", function () {
  const checkbox = document.getElementById("especial");

  agregarFila(checkbox);
});

$("#tabla-dinamica tbody").on("dblclick", "tr", function (e) {
  if ($(e.target).is("button, i, input, select, label")) return;

  const lastRow = $("#tabla-dinamica tbody tr:last")[0];

  if (this === lastRow) {
    const checkbox = document.getElementById("especial");
    agregarFila(checkbox);
  }
});

$("#tabla-dinamica").on("click", ".btn-remove-vehicle", function (e) {
  e.stopPropagation();

  $(this).closest("tr").remove();
});

$("#exportVehicle").on("click", function () {
  exportVehicle();
});

async function cargarClientes() {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) {
      throw new Error("Error en la solicitud");
    }

    const clientes = await response.json();
    const comboBox = document.querySelector('#combo-cliente[name="opciones"]');
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
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

async function cargarModelos() {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/modelos`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta del servidor
    if (!response.ok) {
      throw new Error("Error en la solicitud");
    }

    const modelos = await response.json();
    const comboBox = document.querySelector("#tipoModelo"); // Seleccionar correctamente el <select>
    comboBox.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un modelo"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox.appendChild(defaultOption);

    // Agregar las opciones de los modelos
    modelos.forEach((modelo) => {
      const option = document.createElement("option");
      option.value = modelo.ID; // ID del modelo
      option.textContent = modelo.MODELO; // Nombre del modelo
      comboBox.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar modelos:", error);
  }
}

async function cargarModelosFila(selectElement) {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/modelos`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta del servidor
    if (!response.ok) {
      throw new Error("Error en la solicitud");
    }

    const modelos = await response.json();
    selectElement.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Seleccione un modelo";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    selectElement.appendChild(defaultOption);

    // Agregar las opciones de los modelos
    modelos.forEach((modelo) => {
      const option = document.createElement("option");
      option.value = modelo.ID;
      option.textContent = modelo.MODELO;
      selectElement.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar modelos:", error);
  }
}

async function cargarContrato(idCli) {
  try {
    const IP_LOCAL = await obtenerConfig();

    // Realiza una solicitud al servidor para obtener los contratos del cliente
    const response = await fetch(
      `http://${IP_LOCAL}:3000/contratosNro?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const contratos = await response.json();

    // Verifica si hay contratos disponibles
    if (contratos.length === 0) {
      document.getElementById("combo-contrato").innerHTML =
        '<option value="">No hay contratos disponibles</option>';
      return;
    }

    // Llena el combo de contratos con los datos devueltos
    const contratoSelect = document.getElementById("combo-contrato");
    contratoSelect.innerHTML =
      '<option value="">Seleccione un contrato</option>'; // Limpia y añade la opción por defecto

    contratos.forEach((contrato) => {
      const option = document.createElement("option");
      option.value = contrato.ID; // Valor del contrato
      option.textContent = contrato.DESCRIPCION; // Descripción del contrato
      contratoSelect.appendChild(option);
    });
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    toastr.warning(
      "Error al obtener los contratos. Inténtelo de nuevo más tarde.",
      "Oops...",
    );
  }
}

async function cargarDocumento(id) {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get(`/obtenerDocumentoPorId/${id}`, {
      withCredentials: true,
    });

    const data = response.data;

    if (!data.nroDoc.startsWith("DPEN-")) {
      toastr.warning(
        "El documento no es temporal y no puede ser modificado",
        "Alerta",
      );
      isEdit = false;
      return;
    }

    isEdit = true;

    // TITULO DE FORMULARIO
    $("#title-form").text("Actualizar Documento");
    $("#desc-form").text(
      "Gestione la actualización de documentos temporales registrados para un contrato.",
    );

    // MOSTRAR BOTON ACTUALIZAR
    $("#grabarButton").removeClass("flex").addClass("hidden");
    $("#updateButton").removeClass("hidden").addClass("flex");

    // CBO CLIENTE
    $("#combo-cliente").val(data.idCliente).trigger("change");
    $("#combo-cliente").prop("disabled", true);

    //CBO CONTRATO
    await cargarContrato(data.idCliente);
    $("#combo-contrato").val(data.idPadre).trigger("change");
    $("#combo-contrato").prop("disabled", true);

    //CBO TIPO DOC
    $("#combo-raz").val(data.tipoDoc).trigger("change");

    //NRO DOC
    $("#text-nro-contra").val(data.nroDoc);

    //FEHCA FIRMA
    $("#text-firma").val(
      dayjs(convertirFecha(data.fechaFirma)).format("DD/MM/YYYY"),
    );

    //DURACION
    $("#text-dura").val(data.duracion);

    // CBO MOTIVO
    $("#combo-motivo").val(data.motivo).trigger("change");

    // KM ADICION
    $("#text-adic").val(data.kmAdicional);

    // KM TOTAL
    $("#text-bolsa").val(data.kmTotal);

    // TOTAL VEHICULOS
    $("#text-veh").val(data.cantidad);
    $("#text-sup").val(data.vehSup);
    $("#text-soc").val(data.vehSoc);
    $("#text-ciu").val(data.vehCiu);
    $("#text-sev").val(data.vehSev);

    // ARCHIVO
    fileKey = data.archivoPdf;
    const file = await obtenerArchivo(data.archivoPdf);
    if (file) {
      $("#uploadMessage").addClass("hidden").removeClass("flex"); // Ocultar mensaje de carga
      $("#fileInfo").css("display", "flex"); // Mostrar el área con el archivo
      $("#fileInput")[0].files = file.file;
      $("#fileName").text(file.name); // Mostrar el nombre truncado del archivo
    }

    // DOCUMENTO ESPECIAL
    $("#especial").prop("checked", data.tipoEsp);

    // DESCRIPCION
    $("#story").val(data.story);

    // CARGAR TABLA
    const checkbox = document.getElementById("especial");
    await cargarFilasDesdeLista(data.detalles, checkbox);
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

function showSpinner(element) {
  // Cambiar cursor al boton
  $(element).removeClass("cursor-pointer").addClass("cursor-progress");

  // Mostrar background
  $(element).find(".backgroud-spinner").addClass("w-full").removeClass("w-1/4");

  // Ocultar icono
  $(element).find(".icon-btn").addClass("hidden");

  // Mostrar spinner
  $(element).find(".spinner").removeClass("hidden");
  $(element).prop("disabled", true);
}

function hideSpinner(element) {
  // Cambiar cursor al boton
  $(element).addClass("cursor-pointer").removeClass("cursor-progress");

  // Ocultar background
  $(element).find(".backgroud-spinner").removeClass("w-full").addClass("w-1/4");

  // Ocultar spinner
  $(element).find(".spinner").addClass("hidden");
  $(element).prop("disabled", false);

  // Mostrar icono
  $(element).find(".icon-btn").removeClass("hidden");
}

async function guardarDocumento() {
  // Obtener valores de los campos del formulario
  let formData = {
    idCliente: document.querySelector("#combo-cliente").value,
    idContrato: document.querySelector("#combo-contrato").value,
    tipoContrato: document.querySelector("#combo-raz").value,
    nroContrato: textoAGuiones(
      document.querySelector("#text-nro-contra").value,
    ),
    vehiculo: document.querySelector("#text-veh").value,
    duracion: document.querySelector("#text-dura").value || "0",
    kmAdicional: document.querySelector("#text-adic").value || "0",
    kmTotal: document.querySelector("#text-bolsa").value || "0",
    vehSup: document.querySelector("#text-sup").value,
    vehSoc: document.querySelector("#text-soc").value,
    vehSev: document.querySelector("#text-sev").value,
    vehCiu: document.querySelector("#text-ciu").value,
    fechaFirma: dayjs(
      document.querySelector("#text-firma").value,
      "DD/MM/YYYY",
    ).format("YYYY-MM-DD"),
    Especial: document.querySelector("#especial").checked ? 1 : 0,
    motivo: document.querySelector("#combo-motivo").value,
    story: document.querySelector("#story").value,
  };

  if (formData.kmAdicional > 5) {
    toastr.info("El Km adicional no debe ser mayor a 5", "Aviso");
    return;
  }

  for (let i = 0; i < formData.vehiculo.length; i++) {
    if (formData.vehiculo[i] >= 10) {
      toastr.info(
        "La cantidad es inválido, solo debe contener números",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.duracion.length; i++) {
    if (formData.duracion[i] >= 10) {
      toastr.info(
        "La duración es inválido, solo debe contener números",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.kmTotal.length; i++) {
    if (formData.kmTotal[i] >= 10) {
      toastr.info(
        "El km total es inválido, solo debe contener números",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSup.length; i++) {
    if (formData.vehSup[i] >= 10) {
      toastr.info(
        "valor inválido, solo debe contener números enteros",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSoc.length; i++) {
    if (formData.vehSoc[i] >= 10) {
      toastr.info(
        "Valor inválido, solo debe contener números enteros",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSev.length; i++) {
    if (formData.vehSev[i] >= 10) {
      toastr.info(
        "Valor inválido, solo debe contener números enteros",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehCiu.length; i++) {
    if (formData.vehCiu[i] >= 10) {
      toastr.info(
        "valor inválido, solo debe contener números enteros",
        "Aviso",
      );
      return;
    }
  }

  if (
    Number(formData.vehiculo) !==
    Number(formData.vehCiu) +
      Number(formData.vehSev) +
      Number(formData.vehSoc) +
      Number(formData.vehSup)
  ) {
    toastr.info(
      "Total de vehiculos no coincide con la cantidad de vehiculos",
      "Aviso",
    );
    return;
  }

  // Validación de campos obligatorios
  if (!formData.idCliente || !formData.nroContrato || !formData.fechaFirma) {
    toastr.info("Por favor, completa todos los campos obligatorios.", "Aviso");
    return;
  }

  let socVe = 0;
  let supVe = 0;
  let sevVe = 0;
  let ciuVe = 0;
  let detalles = [];

  try {
    // Obtener detalles de contratos
    detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
      .map((fila, index) => {
        let idDet = fila.querySelector('input[name="id[]"]').value || null;
        let modelo = fila.querySelector('select[name="tipo_modelo[]"]').value;
        let tipoTerreno = fila.querySelector(
          'select[name="tipo_terreno[]"]',
        ).value;
        let condicion = fila.querySelector('select[name="condicion[]"]').value;
        let tarifa =
          Number(fila.querySelector('input[name="tarifa[]"]').value) || 0;
        let cpk = Number(fila.querySelector('input[name="cpk[]"]').value) || 0;
        let rm = Number(fila.querySelector('input[name="rm[]"]').value) || 0;
        let cantidad =
          Number(fila.querySelector('input[name="cantidad[]"]').value) || 0;
        let duracion =
          Number(fila.querySelector('input[name="duracion[]"]').value) || 0;
        let kmAdi =
          Number(fila.querySelector('input[name="kmAdi[]').value) || 0;
        let compraVeh =
          Number(fila.querySelector('input[name="compra_veh[]"]').value) || 0;
        let precioVeh =
          Number(fila.querySelector('input[name="precio_veh[]"]').value) || 0;

        // Validación y asignación de valores predeterminados
        tarifa = tarifa === "" ? 0 : tarifa;
        cpk = cpk === "" ? 0 : cpk;
        rm = rm === "" ? 0 : rm;
        cantidad = cantidad === "" ? 0 : cantidad;
        duracion = duracion === "" ? 0 : duracion;
        precioVeh = precioVeh === "" ? 0 : precioVeh;

        if (cpk > 5) {
          throw new Error("El CPK no debe ser mayor a 5");
        }

        if (!Number.isInteger(rm) || rm < 0) {
          throw new Error("RM inválido, solo debe contener números enteros");
        }
        if (!Number.isInteger(cantidad) || cantidad < 0) {
          throw new Error(
            "Cantidad inválida, solo debe contener números enteros",
          );
        }
        if (!Number.isInteger(duracion) || duracion < 0) {
          throw new Error(
            "Duración inválida, solo debe contener números enteros",
          );
        }

        if (tipoTerreno == 0) {
          supVe = supVe + cantidad;
        } else if (tipoTerreno == 1) {
          socVe = socVe + cantidad;
        } else if (tipoTerreno == 2) {
          ciuVe = ciuVe + cantidad;
        } else if (tipoTerreno == 3) {
          sevVe = sevVe + cantidad;
        }

        return modelo && tarifa != null && cantidad
          ? {
              idDet,
              secCon: index + 1,
              modelo,
              tipoTerreno,
              tarifa,
              cpk,
              rm,
              cantidad,
              duracion,
              kmAdicional: kmAdi,
              compraVeh,
              precioVeh,
              condicion,
            }
          : null;
      })
      .filter(Boolean);
  } catch (error) {
    //  Si hay un error, se muestra la notificación y se detiene todo
    toastr.warning(error.message, "Oops...");
    return;
  }

  if (formData.vehSup != supVe) {
    toastr.info("La cantidad de superficies no coinciden", "Aviso");
    return;
  }

  if (formData.vehSoc != socVe) {
    toastr.info("La cantidad de socavon no coinciden", "Aviso");
    return;
  }

  if (formData.vehSev != sevVe) {
    toastr.info("La cantidad de severo no coinciden", "Aviso");
    return;
  }

  if (formData.vehCiu != ciuVe) {
    toastr.info("La cantidad de ciudad no coinciden", "Aviso");
    return;
  }

  // Construcción del objeto final de datos
  const contratoData = { ...formData, detalles };

  async function registrar() {
    try {
      const uploadFile = await subirArchivo(fileInput.files[0]);

      const nombreArchivo = uploadFile.key;
      const data = { ...contratoData, archivoPdf: nombreArchivo };
      const IP_LOCAL = await obtenerConfig();
      const response = await fetch(
        `http://${IP_LOCAL}:3000/insertarDocumento`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        },
      );
      const result = await response.json();
      if (result.success) {
        toastr.success("Documento guardado exitosamente", "¡Excelente!");
        limpiarCampos();
      } else {
        toastr.warning(result.message, "Oops...");
      }
    } catch (error) {
      const mensaje =
        error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
      console.error("Error al enviar los datos:", error);
      toastr.warning(`Error al guardar: ${mensaje}`, "Oops...");
    }
  }

  async function actualizar(documentId) {
    try {
      let nameFile = fileInput.files[0].name;
      const isExist = await validarArchivo(nameFile);
      if (!isExist) {
        const uploadFile = await subirArchivo(fileInput.files[0]);
        nameFile = uploadFile.key;
      } else {
        nameFile = `documents/${nameFile}`;
      }

      const data = { ...contratoData, archivoPdf: nameFile };
      const IP_LOCAL = await obtenerConfig();
      const response = await fetch(
        `http://${IP_LOCAL}:3000/actualizarDocumento/${documentId}`,
        {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        },
      );
      const result = await response.json();
      if (result.success) {
        toastr.success("Documento guardado exitosamente", "¡Excelente!");
        limpiarCampos();
      } else {
        toastr.warning(result.message, "Oops...");
      }
    } catch (error) {
      const mensaje =
        error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
      console.error("Error al enviar los datos:", error);
      toastr.warning(`Error al guardar: ${mensaje}`, "Oops...");
    }
  }

  const params = new URLSearchParams(window.location.search);
  const isUpd = params.get("formUpd");
  const documentId = params.get("idDocumento");

  if (detalles.length == 0) {
    $("#alert-modal").css("display", "flex");

    $("#alert-modal .alert-container")
      .css("background-color", "#ffeab0")
      .css("border", "2px solid #ffbb00");

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

    $("#alert-modal .alert-container").html(
      `
        <h2>¡Sin modelos registrados!</h2>
        <p style="color: black !important">¿Estás seguro que deseas guardar un documento sin modelos?</p>
        <div class="btn-group">
          <button id="btn-save" class="btn btn-info">Si, guardar documento</button>
          <button id="btn-cancel" class="btn btn-dark">No, cancelar proceso</button>
        </div>
      `,
    );

    $("#alert-modal")
      .off("click", "#btn-save")
      .on("click", "#btn-save", async function () {
        if (isUpd && isUpd == "true" && documentId && isEdit) {
          await actualizar(documentId);
        } else {
          await registrar();
        }

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

        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    $("#alert-modal")
      .off("click", "#btn-cancel")
      .on("click", "#btn-cancel", async function () {
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

        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    return;
  }

  // CON TARIFA ALTA
  const tarifasAltas = [];
  const sinCondicion = [];

  detalles.forEach((det) => {
    if (det.condicion == "4") {
      sinCondicion.push(det.secCon);
    }

    const tarifaDet = det.tarifa;
    if (tarifaDet >= 100) {
      tarifasAltas.push(tarifaDet);
    }
  });

  if (sinCondicion.length > 0) {
    toastr.warning(
      `Debes de seleccionar una condición en los items ${sinCondicion.join(", ")}`,
    );

    return;
  }

  if (tarifasAltas.length > 0) {
    $("#alert-modal").css("display", "flex");

    $("#alert-modal .alert-container")
      .css("background-color", "#ffeab0")
      .css("border", "2px solid #ffbb00");

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

    $("#alert-modal .alert-container").html(
      `
        <h2>¡Tarifas excesivas!</h2>
        <p style="color: black !important">Hemos detectado que estas colocando <b>tarifas</b> mayor a dos cifras.</p>
        <p style="color: black !important">Tarifas observadas: ${tarifasAltas.join(", ")}</p>
        <p style="color: black !important">¿Estas seguro de continuar?</p>
        <div class="btn-group">
          <button id="btn-save" class="btn btn-info">Si, guardar documento</button>
          <button id="btn-cancel" class="btn btn-dark">No, cancelar proceso</button>
        </div>
      `,
    );

    $("#alert-modal")
      .off("click", "#btn-save")
      .on("click", "#btn-save", async function () {
        if (isUpd && isUpd == "true" && documentId && isEdit) {
          await actualizar(documentId);
        } else {
          await registrar();
        }

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

        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    $("#alert-modal")
      .off("click", "#btn-cancel")
      .on("click", "#btn-cancel", async function () {
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

        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    return;
  }

  // SIN TARIFA ALTA
  if (isUpd && isUpd == "true" && documentId && isEdit) {
    await actualizar(documentId);
  } else {
    await registrar();
  }
}

$("#grabarButton").on("click", async function () {
  showSpinner(this);

  await guardarDocumento();

  hideSpinner(this);
});

$("#updateButton").on("click", async function () {
  showSpinner(this);

  await guardarDocumento();

  hideSpinner(this);
});

async function obtenerArchivo(key) {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/previsualizarArchivo", {
      withCredentials: true,
      params: {
        key,
      },
    });

    const data = response.data;

    if (data.success) {
      const resFile = await axios.get(data.url, {
        responseType: "blob",
      });

      const blob = resFile.data;

      const name = data.url.split("/");
      const realName = name[name.length - 1].split("?");

      const file = new File([blob], realName[0], {
        type: blob.type,
      });

      const dt = new DataTransfer();
      dt.items.add(file);

      $("#fileInput")[0].files = dt.files;

      return {
        file: dt.files,
        name: file.name,
      };
    }
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
    return null;
  }
}

async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "documents");

  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
      method: "POST",
      enctype: "multipart/form-data",
      body: formData,
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (!result.success) {
      toastr.warning("Error al subir el archivo PDF", "Oops...");
    }

    return result;
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    toastr.warning("Ocurrió un error al subir el archivo", "Oops...");
  }
}

async function validarArchivo(nombreArchivo) {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(
      `http://${IP_LOCAL}:3000/validarArchivo?nombre=documents/${nombreArchivo.trim()}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const result = await response.json();

    return result.success;
  } catch (error) {
    console.error("Error al validar archivo PDF:", error);
    // toastr.warning(error.message, "Oops...");
    return false;
  }
}

function leerArchivoBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = () => reject("Error al leer el archivo");
    reader.readAsDataURL(file);
  });
}

async function exportVehicle() {
  let socVe = 0;
  let supVe = 0;
  let sevVe = 0;
  let ciuVe = 0;
  const detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
    .map((fila, index) => {
      let modelo = fila.querySelector('select[name="tipo_modelo[]"]');
      let modeloText = modelo.options[modelo.selectedIndex].text;

      let tipoTerreno = fila.querySelector('select[name="tipo_terreno[]"]');
      let tipoTerrenoText = tipoTerreno.options[tipoTerreno.selectedIndex].text;

      let condicion = fila.querySelector('select[name="condicion[]"]');
      let condicionText = condicion.options[condicion.selectedIndex].text;

      let tarifa =
        Number(fila.querySelector('input[name="tarifa[]"]').value) || 0;
      let cpk = Number(fila.querySelector('input[name="cpk[]"]').value) || 0;
      let rm = Number(fila.querySelector('input[name="rm[]"]').value) || 0;
      let cantidad =
        Number(fila.querySelector('input[name="cantidad[]"]').value) || 0;
      let duracion =
        Number(fila.querySelector('input[name="duracion[]"]').value) || 0;
      let kmAdi = Number(fila.querySelector('input[name="kmAdi[]').value) || 0;
      let compraVeh =
        Number(fila.querySelector('input[name="compra_veh[]"]').value) || 0;
      let precioVeh =
        Number(fila.querySelector('input[name="precio_veh[]"]').value) || 0;

      if (tipoTerreno == 0) {
        supVe = supVe + cantidad;
      } else if (tipoTerreno == 1) {
        socVe = socVe + cantidad;
      } else if (tipoTerreno == 2) {
        ciuVe = ciuVe + cantidad;
      } else if (tipoTerreno == 3) {
        sevVe = sevVe + cantidad;
      }

      return modelo && tarifa != null && cantidad
        ? {
            secCon: index + 1,
            modelo: modeloText,
            tipoTerreno: tipoTerrenoText,
            tarifa,
            cpk,
            rm,
            cantidad,
            duracion,
            kmAdicional: kmAdi,
            compraVeh,
            precioVeh,
            condicion: condicionText,
          }
        : null;
    })
    .filter(Boolean);

  if (detalles.length == 0) {
    toastr.info("No puedes exportar una tabla vacia", "Aviso");
    return;
  }

  const workbook = new ExcelJS.Workbook();
  const worksheet = workbook.addWorksheet("Modelos");

  worksheet.columns = [
    { header: "Item", key: "item", width: 8 },
    { header: "Modelo", key: "modelo", width: 35 },
    { header: "Tipo Terreno", key: "tipoTerreno", width: 15 },
    { header: "Tarifa", key: "tarifa", width: 15 },
    { header: "CPK", key: "cpk", width: 10 },
    { header: "RM", key: "rm", width: 10 },
    { header: "Cantidad", key: "cantidad", width: 12 },
    { header: "Duracion", key: "duracion", width: 12 },
    { header: "Km Adicional", key: "kmAdicional", width: 12 },
    { header: "Precio Compra", key: "compraVeh", width: 18 },
    { header: "Precio Venta", key: "precioVeh", width: 18 },
    { header: "Condicion", key: "condicion", width: 18 },
  ];

  worksheet.addRows(
    detalles.map((row, i) => ({
      item: i + 1,
      modelo: row.modelo,
      tipoTerreno: row.tipoTerreno,
      tarifa: row.tarifa,
      cpk: row.cpk,
      rm: row.rm,
      cantidad: row.cantidad,
      duracion: row.duracion,
      kmAdicional: row.kmAdicional,
      comprarVeh: row.compraVeh,
      precioVeh: row.precioVeh,
      condicion: row.condicion,
    })),
  );

  // estilo del header
  worksheet.getRow(1).eachCell((cell) => {
    cell.font = {
      bold: true,
      color: { argb: "FFFFFFFF" },
    };

    cell.fill = {
      type: "pattern",
      pattern: "solid",
      fgColor: { argb: "4472C4" },
    };

    cell.alignment = { horizontal: "center" };
  });

  // formato moneda
  // worksheet.getColumn("tarifa").numFmt = '"S/" #,##0.00';
  // worksheet.getColumn("compraVeh").numFmt = '"S/" #,##0.00';
  // worksheet.getColumn("precioVeh").numFmt = '"S/" #,##0.00';

  // crear tabla Excel real
  worksheet.addTable({
    name: "TablaVehiculos",
    ref: "A1",
    headerRow: true,
    style: {
      theme: "TableStyleMedium9",
      showRowStripes: true,
    },
    columns: [
      { name: "Item" },
      { name: "Modelo" },
      { name: "Tipo Terreno" },
      { name: "Tarifa" },
      { name: "CPK" },
      { name: "RM" },
      { name: "Cantidad" },
      { name: "Duracion" },
      { name: "Km Adicional" },
      { name: "Precio Compra" },
      { name: "Precio Venta" },
      { name: "Condicion" },
    ],
    rows: detalles.map((r, i) => [
      i + 1,
      r.modelo,
      r.tipoTerreno,
      r.tarifa,
      r.cpk,
      r.rm,
      r.cantidad,
      r.duracion,
      r.kmAdicional,
      r.compraVeh,
      r.precioVeh,
      r.condicion,
    ]),
  });

  const buffer = await workbook.xlsx.writeBuffer();

  const blob = new Blob([buffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  const url = URL.createObjectURL(blob);

  const a = document.createElement("a");
  a.href = url;
  a.download = "Modelos_vehiculos_export.xlsx";
  a.click();
}

function limpiarCampos() {
  // Limpiar los campos de texto (inputs)
  const params = new URLSearchParams(window.location.search);
  params.delete("formUpd");
  params.delete("idDocumento");

  const nuevaURL = `${window.location.pathname}?${params.toString()}`;
  window.history.replaceState({}, "", nuevaURL);

  $("#grabarButton").removeClass("hidden").addClass("flex");
  $("#updateButton").removeClass("flex").addClass("hidden");

  document.getElementById("text-nro-contra").value = "";
  document.getElementById("text-veh").value = "0";
  document.getElementById("text-firma").value = "";
  document.getElementById("text-dura").value = "";
  document.getElementById("text-adic").value = "";
  document.getElementById("text-bolsa").value = "";
  document.getElementById("text-sev").value = "0";
  document.getElementById("text-soc").value = "0";
  document.getElementById("text-sup").value = "0";
  document.getElementById("text-ciu").value = "0";
  document.getElementById("story").value = "";
  // Limpiar los valores de los divs (contenidos de texto)
  document.getElementById("fileInput").value = ""; // Esto limpia el archivo seleccionado
  document.getElementById("fileName").textContent = ""; // Esto limpia el nombre del archivo mostrado
  document.getElementById("fileInfo").style.display = "none"; // Oculta el área de información del archivo
  $("#uploadMessage").removeClass("hidden").addClass("flex");

  $("#combo-cliente").val(null).trigger("change");
  $("#combo-contrato").val(null).trigger("change");
  $("#combo-raz").val(null).trigger("change");
  $("#combo-motivo").val(null).trigger("change");
  $("#tipoTerreno").val(null).trigger("change");
  $("#modelo").val(null).trigger("change");
  $("#condicion").val(null).trigger("change");

  // Limpiar el checkbox
  document.getElementById("especial").checked = false;

  const tbody = document.getElementById("contratos-tbody");
  // Eliminar todo el contenido del tbody
  tbody.innerHTML = ` <tr>
                           <td><input type="text" name="item[]" class="disabled:bg-gray-100 w-8 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" value="1" disabled></td>
                           <td class="hidden"><input type="text" name="id[]" class="disabled:bg-gray-100 text-center outline-none text-gray-500 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px]" disabled></td>
                <td>
                  <select id="tipoModelo" name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" style="width: 100%;" data-tooltip="Selecciona el modelo">
                    <option value="">Seleccione un modelo</option>
                  </select>
                </td>
                <td>
                  <select id="tipoTerreno" name="tipo_terreno[]" class="cbo-form-cliente-deta terreno-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Superficie</option>
                    <option value="1">Socavon</option>
                    <option value="2">Ciudad</option>
                    <option value="3">Severo</option>
                  </select>
                </td>
                <td><input type="text" name="tarifa[]" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Tarifa del contrato estipulado"></td>
                <td><input type="text" name="cpk[]" class="w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Costo por kilometraje"></td>
                <td><input type="number" name="rm[]" class="no-negative w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="Recorrido mensual del vehiculo"></td>
                <td><input type="number" name="cantidad[]" class="no-negative w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="Cantidad de unidades"></td>
                <td><input type="text" min="0" name="kmAdi[]" class="disabled:bg-gray-100 w-14 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="$KM Adicional" disabled></td>
                <td><input type="text" name="duracion[]" class="disabled:bg-gray-100 text-center w-14 border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="0" data-tooltip="Duracion contrato" disabled></td>
                <td><input type="text" name="compra_veh[]" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
                <td><input type="text" name="precio_veh[]" class="w-18 text-center border-gray-300 px-[10px] py-[11px] text-xs bg-white border-2 rounded-[5px] focus:outline-none focus:border-blue-500 placeholder:text-black/25 tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
                <td>
                  <select id="condicion" name="condicion[]" class="cbo-form-cliente condicion-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione la condición">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Titular</option>
                    <option value="1">Retén</option>
                    <option value="2">Logística</option>
                    <option value="3">Pendiente</option>
                  </select>
                </td>
                <td>
                  <button class="btn btn-error btn-remove-vehicle"><i class="bi bi-trash"></i></button>
                </td>
                </tr>`;
  resetSelect("combo-cliente", "Seleccione un cliente");
  resetSelect("combo-contrato", "Seleccione un contrato");
  resetSelect("combo-motivo", "Seleccione un Motivo");
  resetSelect("combo-raz", "Seleccione un tipo");
  cargarModelos();
  $(document).ready(function () {
    $("#tipoTerreno").select2({
      placeholder: "Seleccione el tipo",
      allowClear: false, // Desactiva la "X"
      width: "120px",
    });

    $("#tipoModelo").select2({
      placeholder: "Seleccione el modelo",
      allowClear: false, // Desactiva la "X"
      width: "120px",
    });

    $("#condicion").select2({
      placeholder: "Seleccione la condicion",
      allowClear: false, // Desactiva la "X"
      width: "120px",
    });
  });
}

function resetSelect(idSelect, defaultText) {
  const select = document.getElementById(idSelect);
  if (select.options.length > 0) {
    select.selectedIndex = 0; // Selecciona la opción por defecto
    select.options[0].textContent = defaultText; // Actualiza el texto de la opción
  }
}

function limpiarSelect(idSelect) {
  const select = document.getElementById(idSelect);
  // Limpia todas las opciones dejando una inicial
  select.innerHTML = '<option value="">Seleccione una opción</option>';
}

function adicionaVeh() {
  window.location = "/gescon/vehiculos/adicionar_vehiculos";
}

function textoAGuiones(texto) {
  return texto.trim().replace(/\s+/g, "-").toUpperCase();
}

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}
