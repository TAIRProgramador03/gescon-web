// const IP_LOCAL = 'localhost';

document.addEventListener("DOMContentLoaded", () => {
  cargarClientes();
  cargarModelos();
  document.getElementById("btnClear").addEventListener("click", limpiarCampos);
  document.getElementById("btnAddVeh").addEventListener("click", adicionaVeh);
  document
    .getElementById("grabarButton")
    .addEventListener("click", guardarDocumento);
});

document.addEventListener("DOMContentLoaded", function () {
  const checkbox = document.getElementById("especial");
  const tabla = document.getElementById("tabla-dinamica");

  checkbox.addEventListener("change", function () {
    actualizarDuracionEstado();
  });

  /*function actualizarDuracionEstado() {
        const duracionCeldas = document.querySelectorAll('input[name="duracion[]"]');
        duracionCeldas.forEach(function(celda) {
            celda.disabled = !checkbox.checked;
        });
    }*/
  function actualizarDuracionEstado() {
    const duracionCeldas = document.querySelectorAll(
      'input[name="duracion[]"]'
    );
    const checkbox = document.getElementById("especial"); // Reemplaza con el ID real del checkbox

    duracionCeldas.forEach(function (celda) {
      if (!checkbox.checked) {
        celda.value = "0"; // Establece el valor en 0 si el checkbox está desactivado
      }
      celda.disabled = !checkbox.checked;
    });
  }

  function agregarFila() {
    const lastRow = tabla.querySelector("tbody tr:last-child");
    const lastRowIndex = Array.from(tabla.querySelectorAll("tbody tr")).indexOf(
      lastRow
    );

    const nuevaFila = document.createElement("tr");

    nuevaFila.innerHTML = `
            <td><input type="text" name="item[]" value="${
              lastRowIndex + 2
            }" disabled></td>
            <td>
                <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" style="width: 100%;" data-tooltip="Selecciona el modelo">
                    <option value="">Seleccione un modelo</option>
                </select>
            </td>
            <td>
                <select name="tipo_terreno[]" class="cbo-form-cliente-deta tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
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
            <td><input type="text" name="duracion[]" class="tooltip-input" value="0" ${
              checkbox.checked ? "" : "disabled"
            }  data-tooltip="Duracion contrato"></td>
            <td><input type="text" name="compra_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
            <td><input type="text" name="precio_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
        `;

    // Agregar la nueva fila a la tabla
    tabla.querySelector("tbody").appendChild(nuevaFila);
    actualizarDuracionEstado();

    cargarModelosFila(nuevaFila.querySelector(".modelo-select"));

    $(nuevaFila)
      .find(".modelo-select")
      .select2({
        placeholder: "Seleccione el tipo",
        allowClear: false,
      })
      .next(".select2-container")
      .css({
        "font-family": "Montserrat, serif",
        "font-size": "13px",
        "font-optical-sizing": "auto",
        "font-style": "normal",
        color: "black",
      });
  }

  tabla.addEventListener("click", function (e) {
    // Verifica si se hace clic en la última fila
    if (
      e.target.closest("tr") &&
      e.target.closest("tr") === tabla.querySelector("tbody tr:last-child")
    ) {
      agregarFila();
    }
  });
});

async function cargarClientes() {
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
    cargarContrato();
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

async function cargarContrato() {
  document
    .getElementById("combo-cliente")
    .addEventListener("change", async function () {
      const idCli = this.value; // Obtiene el ID del cliente seleccionado

      if (!idCli) {
        // Si no hay cliente seleccionado, limpia el combo de contratos
        document.getElementById("combo-contrato").innerHTML =
          '<option value="">Seleccione un contrato</option>';
        return;
      }
      try {
        // Realiza una solicitud al servidor para obtener los contratos del cliente
        const response = await fetch(
          `http://${IP_LOCAL}:3000/contratosNro?idCli=${idCli}`,
          {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          }
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
        alert("Error al obtener los contratos. Inténtelo de nuevo más tarde.");
      }
    });
}

async function guardarDocumento() {
  // Obtener valores de los campos del formulario
  let formData = {
    idCliente: document.querySelector("#combo-cliente").value,
    idContrato: document.querySelector("#combo-contrato").value,
    tipoContrato: document.querySelector("#combo-raz").value,
    nroContrato: document.querySelector("#text-nro-contra").value,
    vehiculo: document.querySelector("#text-veh").value,
    duracion: document.querySelector("#text-dura").value || "0",
    kmAdicional: document.querySelector("#text-adic").value || "0",
    kmTotal: document.querySelector("#text-bolsa").value || "0",
    vehSup: document.querySelector("#text-sup").value,
    vehSoc: document.querySelector("#text-soc").value,
    vehSev: document.querySelector("#text-sev").value,
    vehCiu: document.querySelector("#text-ciu").value,
    fechaFirma: document.querySelector("#text-firma").value,
    Especial: document.querySelector("#especial").checked ? 1 : 0,
    motivo: document.querySelector("#combo-motivo").value,
    story: document.querySelector("#story").value,
  };

  if (formData.kmAdicional > 5) {
    mostrarNotificacion("El Km adicional no debe ser mayor a 5", "#C70039");
    return;
  } else {
    console.log("valido carnal");
  }

  for (let i = 0; i < formData.vehiculo.length; i++) {
    if (formData.vehiculo[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "La cantidad es inválido, solo debe contener números",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.duracion.length; i++) {
    if (formData.duracion[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "La duración es inválido, solo debe contener números",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.kmTotal.length; i++) {
    if (formData.kmTotal[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "el km total es inválido, solo debe contener números",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSup.length; i++) {
    if (formData.vehSup[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "valor inválido, solo debe contener números enteros",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSoc.length; i++) {
    if (formData.vehSoc[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "valor inválido, solo debe contener números enteros",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehSev.length; i++) {
    if (formData.vehSev[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "valor inválido, solo debe contener números enteros",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.vehCiu.length; i++) {
    if (formData.vehCiu[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "valor inválido, solo debe contener números enteros",
        "#C70039"
      );
      return;
    }
  }

  if (
    Number(formData.vehiculo) ===
    Number(formData.vehCiu) +
      Number(formData.vehSev) +
      Number(formData.vehSoc) +
      Number(formData.vehSup)
  ) {
    console.log("Conforme Dr. Fili");
  } else {
    mostrarNotificacion(
      "Total de vehiculos no coincide con la cantidad de vehiculos",
      "#C70039"
    );
    return;
  }

  // Validación de campos obligatorios
  if (!formData.idCliente || !formData.nroContrato || !formData.fechaFirma) {
    mostrarNotificacion(
      "Por favor, completa todos los campos obligatorios.",
      "#C70039"
    );
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
        let modelo = fila.querySelector('select[name="tipo_modelo[]"]').value;
        let tipoTerreno = fila.querySelector(
          'select[name="tipo_terreno[]"]'
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

        // Validación y asignación de valores predeterminados
        tarifa = tarifa === "" ? 0 : tarifa;
        cpk = cpk === "" ? 0 : cpk;
        rm = rm === "" ? 0 : rm;
        cantidad = cantidad === "" ? 0 : cantidad;
        duracion = duracion === "" ? 0 : duracion;
        precioVeh = precioVeh === "" ? 0 : precioVeh;

        if (cpk > 5) {
          throw new Error("El CPK no debe ser mayor a 5");
        } else {
          console.log("valido carnal");
        }

        if (!Number.isInteger(rm) || rm < 0) {
          throw new Error("RM inválido, solo debe contener números enteros");
        }
        if (!Number.isInteger(cantidad) || cantidad < 0) {
          throw new Error(
            "Cantidad inválida, solo debe contener números enteros"
          );
        }
        if (!Number.isInteger(duracion) || duracion < 0) {
          throw new Error(
            "Duración inválida, solo debe contener números enteros"
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

        return modelo && tarifa && cantidad
          ? {
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
    mostrarNotificacion(error.message, "#C70039");
    return;
  }

  if (formData.vehSup != supVe) {
    mostrarNotificacion("la cantidad de superficies no coinciden", "#C70039");
    return;
  }

  if (formData.vehSoc != socVe) {
    mostrarNotificacion("la cantidad de socavon no coinciden", "#C70039");
    return;
  }

  if (formData.vehSev != sevVe) {
    mostrarNotificacion("la cantidad de severo no coinciden", "#C70039");
    return;
  }

  if (formData.vehCiu != ciuVe) {
    mostrarNotificacion("la cantidad de ciudad no coinciden", "#C70039");
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
      mostrarNotificacion("El archivo PDF ya existe en el servidor", "#C70039");
      return;
    }
  }

  // Construcción del objeto final de datos
  const contratoData = { ...formData, detalles, archivoPdf: nombreArchivo };

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/insertarDocumento`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(contratoData),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (result.success) {
      mostrarNotificacion("Documento guardado exitosamente", "#01b204");
      await subirArchivo(fileInput.files[0]);
      limpiarCampos();
    } else {
      mostrarNotificacion("Hubo un error al guardar el documento", "#C70039");
    }
  } catch (error) {
    const mensaje =
      error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    console.error("Error al enviar los datos:", error);
    mostrarNotificacion(`Error al guardar: ${mensaje}`, "#C70039");
  }
}

async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "documents");

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
      method: "POST",
      enctype: "multipart/form-data",
      body: formData,
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (!result.success) {
      mostrarNotificacion("Error al subir el archivo PDF", "#C70039");
    }
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    mostrarNotificacion("Ocurrió un error al subir el archivo", "#C70039");
  }
}

async function validarArchivo(nombreArchivo) {
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/validarArchivo?nombre=${nombreArchivo}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      }
    );
    const result = await response.json();

    if (result.existe) {
      mostrarNotificacion("El archivo PDF ya existe en el servidor", "#C70039");
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error("Error al validar archivo PDF:", error);
    mostrarNotificacion("Error al validar archivo PDF", "#C70039");
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

function mostrarNotificacion(mensaje, color) {
  const notification = document.getElementById("notification");
  notification.textContent = mensaje;
  notification.style.backgroundColor = color || "#d4edda"; // Verde suave por defecto
  notification.classList.add("show");

  // Mostrar la notificación con el efecto
  setTimeout(() => {
    notification.classList.remove("show");
  }, 3000);
}

function limpiarCampos() {
  // Limpiar los campos de texto (inputs)
  console.log("Función limpiarCampos ejecutada");
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
  const uploadMessage = document.getElementById("uploadMessage");
  uploadMessage.textContent = "Haz clic o arrastra un archivo aquí"; // Restablece el mensaje
  uploadMessage.style.display = "block";
  // Limpiar el checkbox
  document.getElementById("especial").checked = false;

  const tbody = document.getElementById("contratos-tbody");
  // Eliminar todo el contenido del tbody
  tbody.innerHTML = ` <tr>
                            <td><input type="text" name="item[]" value="1" disabled></td>
                            <td>
                                <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" id="tipoModelo" style="width: 100%;" data-tooltip="Selecciona el modelo">
                                    <option value="">Seleccione un modelo</option>
                                </select>
                            </td>
                            <td>
                                <select name="tipo_terreno[]" class="cbo-form-cliente-deta tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
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
                            <td><input type="text" name="duracion[]" class="tooltip-input" value="0" data-tooltip="Duracion contrato" disabled></td>
                            <td><input type="text" name="compra_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la compra del vehiculo"></td>
                            <td><input type="text" name="precio_veh[]" class="tooltip-input" value="" data-tooltip="Precio promedio de la venta del vehiculo"></td>
                        </td>`;
  resetSelect("combo-cliente", "Seleccione un cliente");
  resetSelect("combo-contrato", "Seleccione un contrato");
  resetSelect("combo-motivo", "Seleccione un Motivo");
  resetSelect("combo-raz", "Seleccione un tipo");
  cargarModelos();
  $(document).ready(function () {
    $("#tipoModelo").select2({
      placeholder: "Seleccione el tipo",
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

function adicionaVeh() {
  window.location = "adicionar_vehiculos.php";
}
