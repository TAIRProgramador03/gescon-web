const instance = axios.create({
  baseURL: `http://${IP_LOCAL}:3000`,
  timeout: 3000,
});

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

/**
 * Inicializa la página cargando clientes, modelos y configurando los eventos de los botones
 */
document.addEventListener("DOMContentLoaded", async () => {
  const params = new URLSearchParams(window.location.search);
  const isUpd = params.get("formUpd");
  const contractId = params.get("contratoId");

  if (isUpd && isUpd === "true" && contractId) {
    const findContract = await cargarContrato(contractId);

    if (findContract) {
      const isEdit = validNroContract(findContract.nroContrato);
      if (isEdit === "TEMP") {
        $("#title-form").text("Actualizar contrato");
        $(".btn-update").show();
        $(".clear-action").hide();
        $(".continue-application").hide();
        $("#combo-cliente").prop("disabled", true);
        await cargarCampos(findContract);
      } else {
        toastr.warning(
          "El contrato solicitado no tiene permitido su modificación.",
          "¡Alto!",
        );
        cargarClientes();
        cargarModelos();
      }
    } else {
      cargarClientes();
      cargarModelos();
    }
  } else {
    cargarClientes();
    cargarModelos();
  }

  document.getElementById("btnClear").addEventListener("click", limpiarCampos);
  document
    .getElementById("grabarButton")
    .addEventListener("click", guardarContrato);
  document
    .getElementById("actualizarButton")
    .addEventListener("click", guardarContrato);
});

/**
 * Habilita o deshabilita el campo de duración según el estado del checkbox "especial"
 */
document.addEventListener("DOMContentLoaded", function () {
  const checkbox = document.getElementById("especial");

  checkbox.addEventListener("change", function () {
    actualizarDuracionEstado();
  });

  /**
   * AGREGA UNA NUEVA FILA A LA TABLA DE VEHICULOS
   */
  $("#addVehicle").on("click", function (e) {
    cargarFilasRegistrar(checkbox);
  });
});

$("#tabla-dinamica").on("click", ".btn-remove-vehicle", function () {
  $(this).closest("tr").remove();
});

$("#exportVehicle").on("click", function () {
  exportVehicle();
});

function actualizarDuracionEstado() {
  const duracionCeldas = document.querySelectorAll('input[name="duracion[]"]');
  const checkbox = document.getElementById("especial"); // Reemplaza con el ID real del checkbox

  duracionCeldas.forEach(function (celda) {
    if (!checkbox.checked) {
      celda.value = "0"; // Establece el valor en 0 si el checkbox está desactivado
    }
    celda.disabled = !checkbox.checked;
  });
}

function cargarFilasRegistrar(checkbox) {
  const tabla = document.getElementById("tabla-dinamica");
  const lastRow = tabla.querySelector("tbody tr:last-child");
  const lastRowIndex = Array.from(tabla.querySelectorAll("tbody tr")).indexOf(
    lastRow,
  );

  const nuevaFila = document.createElement("tr");
  nuevaFila.innerHTML = `
            <td><input type="text" name="item[]" value="${
              lastRowIndex + 2
            }" disabled></td>
            <td style="display: none;"><input type="text" name="iddet[]" class="tooltip-input" value=0"></td>
            <td>
                <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" style="width: 100%;" data-tooltip="Selecciona el modelo">
                    <option value="">Seleccione un modelo</option>
                </select>
            </td>
            <td>
                <select name="tipo_terreno[]" class="cbo-form-cliente terreno-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Superficie</option>
                    <option value="1">Socavon</option>
                    <option value="2">Ciudad</option>
                    <option value="3">Severo</option>
                </select>
            </td>
            <td><input type="text" name="tarifa[]" class="tooltip-input" value="" data-tooltip="Tarifa del contrato estipulado"></td>
            <td><input type="text" name="cpk[]" class="tooltip-input" value="" data-tooltip="Costo por kilometraje"></td>
            <td><input type="number" name="rm[]" class="tooltip-input" value="0" data-tooltip="Recorrido mensual del vehiculo"></td>
            <td><input type="number" name="cantidad[]" class="tooltip-input" value="0" data-tooltip="Cantidad de unidades"></td>
            <td><input type="text" name="duracion[]" class="tooltip-input"  value="0" ${
              checkbox.checked ? "" : "disabled"
            } data-tooltip="Duracion contrato"></td>
            <td><input type="text" name="compra_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
            <td><input type="text" name="precio_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
            <td>
              <button class="btn btn-error btn-remove-vehicle"><i class="bi bi-trash"></i></button>
            </td>
        `;

  tabla.querySelector("tbody").appendChild(nuevaFila);
  actualizarDuracionEstado();

  // Llenar el select de modelos en la nueva fila
  cargarModelosFila(nuevaFila.querySelector(".modelo-select"));

  $(nuevaFila)
    .find(".modelo-select")
    .select2({
      placeholder: "Seleccione el modelo",
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

  $(nuevaFila)
    .find(".terreno-select")
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
    });
}

function cargarFilas(data, modelos) {
  const tabla = document.getElementById("tabla-dinamica");
  const checkbox = document.getElementById("especial");

  const lastRow = tabla.querySelector("tbody tr:last-child");
  const lastRowIndex = Array.from(tabla.querySelectorAll("tbody tr")).indexOf(
    lastRow,
  );

  const nuevaFila = document.createElement("tr");
  nuevaFila.innerHTML = `
            <td><input type="text" name="item[]" value="${
              lastRowIndex + 2
            }" disabled></td>
            <td style="display: none;"><input type="text" name="iddet[]" class="tooltip-input" value="${data.id}"></td>
            <td>
                <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" style="width: 100%;" data-tooltip="Selecciona el modelo">
                    <option value="">Seleccione un modelo</option>
                </select>
            </td>
            <td>
                <select name="tipo_terreno[]" class="cbo-form-cliente terreno-select tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                    <option value="4">Seleccione el tipo</option>
                    <option value="0">Superficie</option>
                    <option value="1">Socavon</option>
                    <option value="2">Ciudad</option>
                    <option value="3">Severo</option>
                </select>
            </td>
            <td><input type="text" name="tarifa[]" class="tooltip-input" value="${data.tarifa}" data-tooltip="Tarifa del contrato estipulado"></td>
            <td><input type="text" name="cpk[]" class="tooltip-input" value="${data.cpk}" data-tooltip="Costo por kilometraje"></td>
            <td><input type="number" name="rm[]" class="tooltip-input" value="${data.rm}" data-tooltip="Recorrido mensual del vehiculo"></td>
            <td><input type="number" name="cantidad[]" class="tooltip-input" value="${data.cantidad}" data-tooltip="Cantidad de unidades"></td>
            <td><input type="text" name="duracion[]" class="tooltip-input"  value="${data.duracion}" ${
              checkbox.checked ? "" : "disabled"
            } data-tooltip="Duracion contrato"></td>
            <td><input type="text" name="compra_veh[]" class="tooltip-input" value="${data.compraVeh}" data-tooltip="Precio promedio de la compra del vehiculo"></td>
            <td><input type="text" name="precio_veh[]" class="tooltip-input" value="${data.precioVeh}" data-tooltip="Precio promedio de la venta del vehiculo"></td>
            <td>
              <button class="btn btn-error btn-remove-vehicle"><i class="bi bi-trash"></i></button>
            </td>
        `;

  tabla.querySelector("tbody").appendChild(nuevaFila);
  actualizarDuracionEstado();

  $(nuevaFila)
    .find(".modelo-select")
    .select2({
      placeholder: "Seleccione el modelo",
      allowClear: false,
      data: modelos.map((mod) => ({
        id: mod.ID,
        text: mod.MODELO,
      })),
      pagination: {
        more: true,
      },
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
    })
    .next(".select2-container")
    .css({
      "font-family": "Fredoka Variable, sans-serif",
      "font-size": "13px",
      "font-optical-sizing": "auto",
      "font-style": "normal",
    });

  // Llenar el select de modelos en la nueva fila
  $(nuevaFila).find(".modelo-select").val(data.modelo).trigger("change");

  $(nuevaFila).find(".terreno-select").val(data.tipoTerreno).trigger("change");
}

async function cargarContrato(id) {
  try {
    const response = await instance.get(`/contratoPorId/${id}`, {
      withCredentials: true,
    });

    const result = response.data;

    if (response.status !== 200) {
      console.error(result.message);
      toastr.error(result.message, "Oops...");
      return;
    }

    return result;
  } catch (error) {
    console.error(error);
    toastr.error(error.response.data.message, "Oops...");
  }
}

async function cargarCampos(data) {
  cargarClientes(data.idCliente);

  $('input[name="Contrato"]').val(data.nroContrato);
  $('input[name="Vehiculos"]').val(data.cantVehiculos);
  $('input[name="Firma"]').val(dayjs(convertirFecha(data.fechaFirma)).format("DD/MM/YYYY"));
  $('input[name="Duracion"]').val(data.duracion);
  $("#combo-moneda").val(data.tipoMoneda).trigger("change");
  $("#combo-tipo").val(data.tipoCliente).trigger("change");
  $('input[name="Adicional"]').val(data.kmAdicional);
  $('input[name="Bolsa"]').val(data.kmTotal);
  $('input[name="Sup"]').val(data.vehSup);
  $('input[name="Soc"]').val(data.vehSoc);
  $('input[name="Ciu"]').val(data.vehCiu);
  $('input[name="Sev"]').val(data.vehSev);
  $('input[name="especial"]').prop(
    "checked",
    data.contratoEspecial ? true : false,
  );
  $('textarea[name="story"]').val(data.story);

  cargarCampoPDF(data.archivoPdf);

  // cargarModelos();
  const modelos = await obtenerTodosModelos();

  data.detalles.forEach((row) => {
    cargarFilas(row, modelos);
  });
}

async function cargarCampoPDF(url) {
  try {
    const response = await axios.get(url, {
      withCredentials: true,
      responseType: "blob",
    });

    const blob = response.data;

    const name = url.split("/");

    const file = new File([blob], name[name.length - 1], {
      type: blob.type,
    });

    const dt = new DataTransfer();
    dt.items.add(file);

    $("#fileInput")[0].files = dt.files;

    if (file) {
      $("#uploadMessage").hide(); // Ocultar mensaje de carga
      $("#fileInfo").css("display", "flex"); // Mostrar el área con el archivo
      $("#fileName").text(truncateFileName(file.name)); // Mostrar el nombre truncado del archivo
    }
  } catch (error) {
    console.error(error);
    toastr.error(error, "Oops...");
  }
}

async function cargarClientes(id) {
  try {
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

    if (id) {
      comboBox.value = id;
    }
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

async function cargarModelos() {
  try {
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

async function obtenerTodosModelos() {
  const response = await fetch(`http://${IP_LOCAL}:3000/modelos`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  }); // Ruta del servidor
  if (!response.ok) {
    throw new Error("Error en la solicitud");
  }

  const modelos = await response.json();

  return modelos;
}

async function cargarModelosFila(selectElement) {
  try {
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

async function guardarContrato() {
  let formData = {
    idCliente: document.querySelector("#combo-cliente").value,
    nroContrato: textoAGuiones(document.querySelector("#contrato").value),
    cantVehiculos: document.querySelector("#vehiculos").value,
    fechaFirma: dayjs(document.querySelector("#firma").value, 'DD/MM/YYYY').format("YYYY-MM-DD"),
    duracion: document.querySelector("#duracion").value.trim() || "0",
    kmAdicional: document.querySelector("#adicional").value.trim() || "0",
    kmTotal: document.querySelector("#bolsa").value.trim() || "0",
    vehSup: document.querySelector("#sup").value,
    vehSoc: document.querySelector("#soc").value,
    vehSev: document.querySelector("#sev").value,
    vehCiu: document.querySelector("#ciu").value,
    tipoMoneda: document.querySelector("#combo-moneda").value || "0",
    tipoCliente: document.querySelector("#combo-tipo").value || "0",
    contratoEspecial: document.querySelector("#especial").checked ? 1 : 0,
    story: document.querySelector("#story").value,
  };

  if (formData.kmAdicional > 5) {
    toastr.info("El Km adicional no debe ser mayor a 5", "Atención");
    return;
  } else {
    console.log("valido carnal");
  }

  for (let i = 0; i < formData.cantVehiculos.length; i++) {
    if (formData.cantVehiculos[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "La cantidad es no válida, solo debe contener números",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.duracion.length; i++) {
    if (formData.duracion[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "La duración es no válido, solo debe contener números",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.kmTotal.length; i++) {
    if (formData.kmTotal[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "El km total es no válido, solo debe contener números",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSup.length; i++) {
    if (formData.vehSup[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "Valor no válido, solo debe contener números enteros.",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSoc.length; i++) {
    if (formData.vehSoc[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "Valor no válido, solo debe contener números enteros.",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSev.length; i++) {
    if (formData.vehSev[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "Valor no válido, solo debe contener números enteros.",
        "Atención",
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehCiu.length; i++) {
    if (formData.vehCiu[i] < 10) {
      console.log("Todo conforme.");
    } else {
      toastr.info(
        "Valor no válido, solo debe contener números enteros",
        "Atención",
      );
      return;
    }
  }

  if (
    Number(formData.cantVehiculos) ===
    Number(formData.vehCiu) +
      Number(formData.vehSev) +
      Number(formData.vehSoc) +
      Number(formData.vehSup)
  ) {
    console.log("Conforme Dr. Fili");
  } else {
    toastr.info(
      "Total de vehiculos no coincide con la cantidad de vehiculos",
      "Atención",
    );
    return;
  }

  // Validación de campos obligatorios
  if (
    !formData.idCliente ||
    !formData.nroContrato ||
    !formData.cantVehiculos ||
    !formData.fechaFirma ||
    !formData.tipoMoneda ||
    !formData.vehSup ||
    !formData.vehSoc ||
    !formData.vehSev ||
    !formData.vehCiu
  ) {
    toastr.info(
      "Por favor, completa todos los campos obligatorios.",
      "Atención",
    );
    return;
  }

  let socVe = 0;
  let supVe = 0;
  let sevVe = 0;
  let ciuVe = 0;
  let detalles = [];
  // Obtener detalles de contratos
  try {
    detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
      .map((fila, index) => {
        let idDet = fila.querySelector('input[name="iddet[]"]').value;
        let modelo = fila.querySelector('select[name="tipo_modelo[]"]').value;
        let tipoTerreno = fila.querySelector(
          'select[name="tipo_terreno[]"]',
        ).value;
        let tarifa =
          Number(fila.querySelector('input[name="tarifa[]"]').value) || 0;
        let cpk = Number(fila.querySelector('input[name="cpk[]"]').value) || 0;
        let rm = Number(fila.querySelector('input[name="rm[]"]').value) || 0;
        let cantidad =
          Number(fila.querySelector('input[name="cantidad[]"]').value) || 0;
        let duracion =
          Number(fila.querySelector('input[name="duracion[]"]').value) || 0;
        let compraVeh =
          Number(fila.querySelector('input[name="compra_veh[]"]').value) || 0;
        let precioVeh =
          Number(fila.querySelector('input[name="precio_veh[]"]').value) || 0;

        // 🚨 Si algún valor no cumple, se lanza un error y se detiene todo
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

        if (cpk > 5) {
          throw new Error("El CPK no debe ser mayor a 5");
        } else {
          console.log("valido carnal");
        }

        return modelo && tarifa != null && cantidad
          ? {
              idDet: Number(idDet),
              secCon: index + 1,
              modelo,
              tipoTerreno,
              tarifa,
              cpk,
              rm,
              cantidad,
              duracion,
              compraVeh,
              precioVeh,
            }
          : null;
      })
      .filter(Boolean);

    console.log("Datos procesados correctamente:", detalles);
  } catch (error) {
    //  Si hay un error, se muestra la notificación y se detiene todo
    toastr.warning(error.message, "¡Oops...!");
    return;
  }

  if (formData.vehSup != supVe) {
    toastr.info("La cantidad de superficies no coinciden", "Atención");
    return;
  }

  if (formData.vehSoc != socVe) {
    toastr.info("La cantidad de socavon no coinciden", "Atención");
    return;
  }

  if (formData.vehSev != sevVe) {
    toastr.info("La cantidad de severo no coinciden", "Atención");
    return;
  }

  if (formData.vehCiu != ciuVe) {
    toastr.info("La cantidad de ciudad no coinciden", "Atención");
    return;
  }

  // Obtener archivo adjunto si existe
  const nombreArchivo = fileInput.files[0].name;

  if (nombreArchivo) {
    const yaExiste = await validarArchivo(nombreArchivo); // Solo el nombre, ya es string
    if (!yaExiste) {
      await subirArchivo(fileInput.files[0]); // Aquí mandas el archivo como tal (tipo File)
    } else {
      console.warn("El archivo ya existe, no se sube.");
      toastr.warning("El archivo PDF ya existe en el servidor", "Atención");
      return;
    }
  }

  // Construcción del objeto final de datos
  const contratoData = { ...formData, detalles, archivoPdf: nombreArchivo };

  const params = new URLSearchParams(window.location.search);
  const isUpd = params.get("formUpd");
  const contractId = params.get("contratoId");

  async function registrar() {
    console.log(contratoData);
    // try {
    //   const response = await fetch(`http://${IP_LOCAL}:3000/insertarContrato`, {
    //     method: "POST",
    //     headers: { "Content-Type": "application/json" },
    //     body: JSON.stringify(contratoData),
    //     credentials: "include", // Asegura que las cookies se envíen con la solicitud
    //   });
    //   const result = await response.json();
    //   if (result.success) {
    //     toastr.success("Contrato guardado exitosamente", "¡Exitó!");
    //     await subirArchivo(fileInput.files[0]);
    //     limpiarCampos();
    //   } else {
    //     toastr.warning(result.message, "¡Alto!");
    //   }
    // } catch (error) {
    //   const mensaje =
    //     error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    //   console.error("Error al enviar los datos:", error);
    //   toastr.warning(`Ocurrio algo: ${mensaje}`, "Oops...");
    // }
  }

  async function actualizar(contractId) {
    console.log(contratoData);
    // try {
    //   const response = await fetch(
    //     `http://${IP_LOCAL}:3000/actualizarContrato/${contractId}`,
    //     {
    //       method: "PUT",
    //       headers: { "Content-Type": "application/json" },
    //       body: JSON.stringify(contratoData),
    //       credentials: "include", // Asegura que las cookies se envíen con la solicitud
    //     },
    //   );
    //   const result = await response.json();
    //   if (result.success) {
    //     toastr.success("Contrato actualizado exitosamente", "¡Exitó!");
    //     await subirArchivo(fileInput.files[0]);
    //     limpiarCampos();
    //   } else {
    //     toastr.warning(result.message, "¡Alto!");
    //   }
    // } catch (error) {
    //   const mensaje =
    //     error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    //   console.error("Error al enviar los datos:", error);
    //   toastr.warning(`Ocurrio algo: ${mensaje}`, "Oops...");
    // }
  }

  // CON TARIFA ALTA
  const tarifasAltas = [];

  detalles.forEach((det) => {
    const tarifaDet = det.tarifa;
    if (tarifaDet >= 100) {
      tarifasAltas.push(tarifaDet);
    }
  });

  if (tarifasAltas.length > 0) {
    $("#alert-modal").css("display", "flex");

    $("#alert-modal .alert-container")
      .css("background-color", "#ffeab0")
      .css("border", "2px solid #ffbb00");

    $("#alert-modal .alert-container").html(
      `
        <h2>¡Tarifas excesivas!</h2>
        <p style="color: black !important">Hemos detectado que estas colocando <b>tarifas</b> mayor a dos cifras.</p>
        <p style="color: black !important">Tarifas observadas: ${tarifasAltas.join(", ")}</p>
        <p style="color: black !important">¿Estas seguro de continuar?</p>
        <div class="btn-group">
          <button id="btn-save" class="btn btn-info">Si, guardar contrato</button>
          <button id="btn-cancel" class="btn btn-dark">No, cancelar proceso</button>
        </div>
      `,
    );

    $("#alert-modal")
      .off("click", "#btn-save")
      .on("click", "#btn-save", async function () {
        if (isUpd && isUpd === "true" && contractId) {
          const isEdit = validNroContract(contratoData.nroContrato);
          if (isEdit === "TEMP") {
            await actualizar(contractId);
          } else {
            await registrar();
          }
        } else {
          await registrar();
        }

        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    $("#alert-modal")
      .off("click", "#btn-cancel")
      .on("click", "#btn-cancel", function () {
        const modal = document.getElementById("alert-modal");
        modal.style.display = "none";

        $("#alert-modal .alert-container").empty();
      });

    return;
  }

  // SIN TARIFA ALTA
  if (isUpd && isUpd === "true" && contractId) {
    const isEdit = validNroContract(contratoData.nroContrato);
    if (isEdit === "TEMP") {
      await actualizar(contractId);
    } else {
      await registrar();
    }
  } else {
    await registrar();
  }
}

async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "contracts");

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
      enctype: "multipart/form-data",
      method: "POST",
      body: formData,
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (!result.success) {
      toastr.warning(result.message, "Oops...");
    }
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    toastr.warning(error.message, "Oops...");
  }
}

async function validarArchivo(nombreArchivo) {
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/validarArchivo?nombre=${nombreArchivo}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const result = await response.json();

    if (result.existe) {
      toastr.info("El archivo PDF ya existe en el servidor", "Aviso");
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error("Error al validar archivo PDF:", error);
    toastr.warning(error.message, "Oops...");
    return false;
  }
}

// Leer archivo en base64
function leerArchivoBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.onerror = () => reject("Error al leer el archivo");
    reader.readAsDataURL(file);
  });
}

// function mostrarNotificacion(mensaje, color) {
//   const notification = document.getElementById("notification");
//   notification.textContent = mensaje;
//   notification.style.backgroundColor = color || "#d4edda"; // Verde suave por defecto
//   notification.classList.add("show");

//   // Mostrar la notificación con el efecto
//   setTimeout(() => {
//     notification.classList.remove("show");
//   }, 3000);
// }

async function exportVehicle() {
  let socVe = 0;
  let supVe = 0;
  let sevVe = 0;
  let ciuVe = 0;
  const detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
    .map((fila, index) => {
      let idDet = fila.querySelector('input[name="iddet[]"]').value;

      let modelo = fila.querySelector('select[name="tipo_modelo[]"]');
      let modeloText = modelo.options[modelo.selectedIndex].text;

      let tipoTerreno = fila.querySelector(
        'select[name="tipo_terreno[]"]',
      );
      let tipoTerrenoText = tipoTerreno.options[tipoTerreno.selectedIndex].text;

      let tarifa =
        Number(fila.querySelector('input[name="tarifa[]"]').value) || 0;
      let cpk = Number(fila.querySelector('input[name="cpk[]"]').value) || 0;
      let rm = Number(fila.querySelector('input[name="rm[]"]').value) || 0;
      let cantidad =
        Number(fila.querySelector('input[name="cantidad[]"]').value) || 0;
      let duracion =
        Number(fila.querySelector('input[name="duracion[]"]').value) || 0;
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
            idDet: Number(idDet),
            secCon: index + 1,
            modelo: modeloText,
            tipoTerreno: tipoTerrenoText,
            tarifa,
            cpk,
            rm,
            cantidad,
            duracion,
            compraVeh,
            precioVeh,
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
    { header: "Precio Compra", key: "compraVeh", width: 18 },
    { header: "Precio Venta", key: "precioVeh", width: 18 },
  ];

  worksheet.addRows(detalles.map((row, i) => ({
    item: i + 1,
    modelo: row.modelo,
    tipoTerreno: row.tipoTerreno,
    tarifa: row.tarifa,
    cpk: row.cpk,
    rm: row.rm,
    cantidad: row.cantidad,
    duracion: row.duracion,
    comprarVeh: row.compraVeh,
    precioVeh: row.precioVeh
  })));

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
      { name: "Precio Compra" },
      { name: "Precio Venta" },
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
      r.compraVeh,
      r.precioVeh,
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
  const params = new URLSearchParams(window.location.search);
  params.delete("formUpd");
  params.delete("contratoId");

  const nuevaURL = `${window.location.pathname}?${params.toString()}`;
  window.history.replaceState({}, "", nuevaURL);

  $("#title-form").text("Registrar contrato");
  $(".btn-update").hide();
  $(".clear-action").show();
  $(".continue-application").show();

  // Limpiar los campos de texto (inputs)
  console.log("Función limpiarCampos ejecutada");
  document.getElementById("contrato").value = "";
  document.getElementById("vehiculos").value = "";
  document.getElementById("firma").value = "";
  document.getElementById("duracion").value = "";
  document.getElementById("adicional").value = "";
  document.getElementById("bolsa").value = "";
  document.getElementById("sev").value = "0";
  document.getElementById("soc").value = "0";
  document.getElementById("sup").value = "0";
  document.getElementById("ciu").value = "0";
  document.getElementById("story").value = "";
  // Limpiar los valores de los divs (contenidos de texto)
  document.getElementById("fileInput").value = ""; // Esto limpia el archivo seleccionado
  document.getElementById("fileName").textContent = ""; // Esto limpia el nombre del archivo mostrado
  document.getElementById("fileInfo").style.display = "none"; // Oculta el área de información del archivo
  const uploadMessage = document.getElementById("uploadMessage");
  uploadMessage.textContent = "Haz clic o arrastra un archivo aquí"; // Restablece el mensaje
  uploadMessage.style.display = "block";
  // Limpiar el checkbox
  document.getElementById("especial").checked = false;

  $("#combo-cliente").prop("disabled", false);
  $("#combo-cliente").val(null).trigger("change");
  $("#combo-moneda").val(null).trigger("change");
  $("#combo-tipo").val(null).trigger("change");

  const tbody = document.getElementById("contratos-tbody");
  // Eliminar todo el contenido del tbody
  // tbody.innerHTML = ` <tr>
  //                           <td><input type="text" name="item[]" value="1" disabled></td>
  //                           <td>
  //                               <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" id="tipoModelo" style="width: 100%;" data-tooltip="Seleccione el modelo">
  //                                   <option value="">Seleccione un modelo</option>
  //                               </select>
  //                           </td>
  //                           <td>
  //                               <select name="tipo_terreno[]" class="cbo-form-cliente terreno-select tooltip-input" id="tipoTerreno" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
  //                                   <option value="4">Seleccione el tipo</option>
  //                                   <option value="0">Superficie</option>
  //                                   <option value="1">Socavon</option>
  //                                   <option value="2">Ciudad</option>
  //                                   <option value="3">Severo</option>
  //                               </select>
  //                           </td>
  //                           <td><input type="text" name="tarifa[]" class="tooltip-input" value="" data-tooltip="Tarifa del contrato estipulado"></td>
  //                           <td><input type="text" name="cpk[]" class="tooltip-input" value="" data-tooltip="Costo por kilometraje"></td>
  //                           <td><input type="number" name="rm[]" class="tooltip-input" value="0" data-tooltip="Recorrido mensual del vehiculo"></td>
  //                           <td><input type="number" name="cantidad[]" class="tooltip-input" value="0" data-tooltip="Cantidad de unidades"></td>
  //                           <td><input type="text" name="duracion[]" class="tooltip-input" value="0" data-tooltip="Duracion contrato" disabled></td>
  //                           <td><input type="text" name="compra_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
  //                           <td><input type="text" name="precio_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
  //                           <td>
  //                             <button class="btn btn-error btn-remove-vehicle"><i class="bi bi-trash"></i></button>
  //                           </td>
  //                       </td>`;

  tbody.innerHTML = ``;
  resetSelect("combo-cliente", "Seleccione un cliente");
  resetSelect("combo-tipo", "Seleccione un tipo");
  resetSelect("combo-moneda", "Seleccione una moneda");
  cargarModelos();
  $(document).ready(function () {
    $("#tipoModelo").select2({
      placeholder: "Seleccione el tipo",
      allowClear: false, // Desactiva la "X"
    });

    $("#tipoTerreno").select2({
      placeholder: "Seleccione el terreno",
      allowClear: false, // Desactiva la "X"
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

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

function truncateFileName(name) {
  const maxLength = 25;
  if (name.length <= maxLength) return name;

  const fileExtension = name.slice(name.lastIndexOf("."));
  const truncatedName = name.slice(0, maxLength - fileExtension.length - 3);
  return truncatedName + "..." + fileExtension;
}

function validNroContract(nro) {
  const chars = nro.split("-");
  return chars[0];
}

function textoAGuiones(texto) {
  return texto.trim().replace(/\s+/g, "-").toUpperCase();
}
