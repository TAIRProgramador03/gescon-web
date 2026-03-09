// const IP_LOCAL = "localhost";

// document.addEventListener("DOMContentLoaded", () => {
//   cargarClientes();
//   document.getElementById("btnClear").addEventListener("click", limpiarCampos);
// });

$(document).ready(async function () {
  await cargarClientes();
  document.getElementById("btnClear").addEventListener("click", limpiarCampos);

  const params = new URLSearchParams(window.location.search);
  const idClient = params.get("clienteId");
  const idContract = params.get("contratoId")

  $("#combo-box").select2({
    placeholder: "Seleccione un cliente",
    allowClear: false, // Desactiva la "X"
  });

  $("#combo-contrato").select2({
    placeholder: "Seleccione un contrato",
    allowClear: false, // Desactiva la "X"
  });

  if (idClient) {
    $("#combo-box").val(`${idClient}`).trigger("change");

    await cargarContrato(idClient);
    await cargarTablacliente(idClient);
  }

  if(idContract) {
    await cargarDatosContrato(idContract)
  }
});

$("#combo-box").on("select2:select", async function (e) {
  const params = new URLSearchParams(window.location.search);
  params.set("clienteId", e.params.data.id);

  const nuevaURL = `${window.location.pathname}?${params.toString()}`;
  window.history.replaceState({}, "", nuevaURL);

  await cargarContrato(e.params.data.id);
  await cargarTablacliente(e.params.data.id);
});

$("#combo-contrato").on("select2:select", async function (e) {
  const params = new URLSearchParams(window.location.search);
  params.delete("contratoId")
  window.history.replaceState({}, '', `${window.location.pathname}?${params}`);

  await cargarTablacontrato(e.params.data.id);
});

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
    cargarContrato();
    cargarTablacliente();
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

async function cargarContrato(idCli) {
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

    cargarTablacontrato();
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    alert("Error al obtener los contratos. Inténtelo de nuevo más tarde.");
  }
}

async function cargarTablacliente(idCli) {
  limpia();
  if (!idCli) {
    // Si no hay cliente seleccionado, limpia la tabla
    document.querySelector(".tabla-form table tbody").innerHTML = `
                <tr>
                    <td colspan="5">Seleccione un cliente para ver los contratos</td>
                </tr>
            `;
    return;
  }

  try {
    // Realiza una solicitud al servidor para obtener los contratos del cliente
    const response = await fetch(
      `http://${IP_LOCAL}:3000/tablaCliente?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const contratos = await response.json();

    // Verifica si hay contratos disponibles
    if (contratos.length === 0) {
      document.querySelector(".tabla-form table tbody").innerHTML = `
                    <tr>
                        <td colspan="5">No hay contratos disponibles para este cliente</td>
                    </tr>
                `;
      return;
    }
    // Llena la tabla con los datos de los contratos
    // const fechita = convertirFecha(tablaCliente.FECHACREA);
    const tbody = document.querySelector(".tabla-form table tbody");
    tbody.innerHTML = ""; // Limpia las filas existentes
    contratos.forEach((tablaCliente, index) => {
      const fechita = convertirFecha(tablaCliente.FECHACREA);
      const row = document.createElement("tr");
      row.innerHTML = `
                    <td>${index + 1}</td> <!-- Número de ítem -->
                    <td style="display: none;">${tablaCliente.ID}</td> <!-- Número de ítem -->
                    <td>${
                      tablaCliente.DESCRIPCION
                    }</td> <!-- Número de contrato -->
                    <td>${fechita || "Sin fecha"}</td> <!-- Fecha de firma -->
                    <td>${
                      tablaCliente.DURACION + " MESES" || "Sin periodo"
                    }</td> <!-- Periodo -->
                    <td>${
                      tablaCliente.TOTVEH || "0"
                    }</td> <!-- Cantidad total -->
                `;
      tbody.appendChild(row);
    });
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    alert("Error al obtener los datos. Inténtelo de nuevo más tarde.");
  }
}

async function cargarTablacontrato(id) {
  limpia();
  const params = new URLSearchParams(window.location.search);
  const idCli = params.get("clienteId"); // ID del cliente seleccionado

  const tbody = document.querySelector(".tabla-form table tbody"); // Elemento tbody de la tabla

  // Validación inicial
  if (!idCli || !id) {
    tbody.innerHTML = `
                <tr>
                    <td colspan="5">Seleccione un cliente y un contrato para ver los datos.</td>
                </tr>
            `;
    return;
  }

  try {
    // Llamada al servidor
    const response = await fetch(
      `http://${IP_LOCAL}:3000/tablaContrato?idCli=${idCli}&id=${id}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    // Verifica si la respuesta es exitosa
    if (!response.ok) {
      throw new Error(`Error en la solicitud: ${response.statusText}`);
    }

    const contratos = await response.json();

    // Limpia el contenido previo de la tabla
    tbody.innerHTML = "";

    // Verifica si hay datos
    if (contratos.length === 0) {
      tbody.innerHTML = `
                    <tr>
                        <td colspan="5">No hay contratos disponibles para este cliente y contrato seleccionado.</td>
                    </tr>
                `;
      return;
    }

    // Rellena la tabla con los datos
    contratos.forEach((tablaContrato, index) => {
      const row = document.createElement("tr");
      const fechito = convertirFecha(tablaContrato.FECHACREA);
      row.innerHTML = `
                    <td>${index + 1}</td> <!-- Número de ítem -->
                    <td style="display: none;">${tablaContrato.ID}</td>
                    <td>${tablaContrato.DESCRIPCION}</td> <!-- Descripción -->
                    <td>${fechito || "Sin fecha"}</td> <!-- Fecha -->
                    <td>${
                      tablaContrato.DURACION + " MESES" || "Sin periodo"
                    }</td> <!-- Periodo -->
                    <td>${
                      tablaContrato.TOTVEH || "0"
                    }</td> <!-- Total vehículos -->
                `;
      tbody.appendChild(row);
    });
  } catch (error) {
    console.error("Error al cargar los datos:", error);
    tbody.innerHTML = `
                <tr>
                    <td colspan="5">Hubo un error al cargar los datos. Intente de nuevo más tarde.</td>
                </tr>
            `;
  }
}

async function cargarDatosContrato(contratoId) {
  // Realizar la solicitud AJAX al backend para obtener los detalles del contrato
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/contratoDetalle?contratoId=${contratoId}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const data = await response.json();

    if (!data.success) {
      console.error("Error al obtener los detalles del contrato");
      return;
    }

    // Asignar valores a los campos de entrada con los datos obtenidos
    const fechaFirma = data.data.fechaFirma; // Se espera en formato yyyymmdd

    // Convertir fecha firma a formato yyyy-mm-dd
    const fechaInicio = convertirFecha(fechaFirma);
    document.getElementById("text-inicio").value = fechaInicio; // Asignar FECHA_FIRMA

    // Calcular fecha de fin
    const fechaFin = calcularFechaFin(fechaInicio, data.data.duracion);
    console.log(fechaFin);
    document.getElementById("text-fin").value = fechaFin; // Asignar fecha de fin

    const estado = obtenerEstado(fechaFin);
    document.getElementById("text-estado").value = estado; // Asignar DESCRIPCION
    // Establecer el estado según la fecha actual y la fecha de fin
    document.getElementById("story").value = data.data.descripcion; // Asignar estado

    // Aquí asignamos los valores de los vehículos a los campos correspondientes
    document.getElementById("txt-sev").textContent =
      data.data.vehiculoSev || "0";
    document.getElementById("txt-soc").textContent =
      data.data.vehiculoSoc || "0";
    document.getElementById("txt-sup").textContent =
      data.data.vehiculoSup || "0";
    document.getElementById("txt-ciu").textContent =
      data.data.vehiculoCiu || "0";
    document.getElementById("txt-aso").textContent =
      data.data.cantidadDocumentos || "0"; // Asignar texto al div
    document.getElementById("txt-leas").textContent =
      data.data.cantidadLeasing || "0"; // Asignar texto al div
    document.getElementById("txt-vehic").textContent =
      data.data.cantidadVehiculos || "0";
    document.getElementById("txt-assign").textContent =
      data.data.cantidadAsignados || "0";
  } catch (error) {
    console.error("Error al obtener los datos del contrato:", error);
  }
}

function limpia() {
  // Limpiar los campos de texto (inputs)
  document.getElementById("text-estado").value = "";
  document.getElementById("text-inicio").value = "";
  document.getElementById("text-fin").value = "";
  document.getElementById("story").value = "";

  // Limpiar los valores de los divs (contenidos de texto)
  document.getElementById("txt-sev").textContent = "0";
  document.getElementById("txt-soc").textContent = "0";
  document.getElementById("txt-sup").textContent = "0";
  document.getElementById("txt-ciu").textContent = "0";
  document.getElementById("txt-aso").textContent = "0"; // Asignar texto al div
  document.getElementById("txt-leas").textContent = "0"; // Asignar texto al div
  document.getElementById("txt-vehic").textContent = "0";
  document.getElementById("txt-assign").textContent = "0";
}

document
  .getElementById("contratos-tbody")
  .addEventListener("click", async function (e) {
    // Verificar si se hace clic en una fila <tr>
    if (e.target.tagName.toLowerCase() === "td") {
      const fila = e.target.closest("tr"); // Obtener la fila
      const contratoId = fila.querySelectorAll("td")[1].textContent.trim(); // Obtener el ID de contrato (ajusta según tu estructura de tabla)

      // MOSTRAMOS EL PARAMETRO EN LA URL
      const params = new URLSearchParams(window.location.search);
      params.set("contratoId", contratoId);

      const nuevaURL = `${window.location.pathname}?${params.toString()}`;
      window.history.replaceState({}, "", nuevaURL);

      // Realizar la solicitud AJAX al backend para obtener los detalles del contrato
      try {
        const response = await fetch(
          `http://${IP_LOCAL}:3000/contratoDetalle?contratoId=${contratoId}`,
          {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          },
        );
        const data = await response.json();

        if (!data.success) {
          console.error("Error al obtener los detalles del contrato");
          return;
        }

        // Asignar valores a los campos de entrada con los datos obtenidos
        const fechaFirma = data.data.fechaFirma; // Se espera en formato yyyymmdd

        // Convertir fecha firma a formato yyyy-mm-dd
        const fechaInicio = convertirFecha(fechaFirma);
        document.getElementById("text-inicio").value = fechaInicio; // Asignar FECHA_FIRMA

        // Calcular fecha de fin
        const fechaFin = calcularFechaFin(fechaInicio, data.data.duracion);
        console.log(fechaFin);
        document.getElementById("text-fin").value = fechaFin; // Asignar fecha de fin

        const estado = obtenerEstado(fechaFin);
        document.getElementById("text-estado").value = estado; // Asignar DESCRIPCION
        // Establecer el estado según la fecha actual y la fecha de fin
        document.getElementById("story").value = data.data.descripcion; // Asignar estado

        // Aquí asignamos los valores de los vehículos a los campos correspondientes
        document.getElementById("txt-sev").textContent =
          data.data.vehiculoSev || "0";
        document.getElementById("txt-soc").textContent =
          data.data.vehiculoSoc || "0";
        document.getElementById("txt-sup").textContent =
          data.data.vehiculoSup || "0";
        document.getElementById("txt-ciu").textContent =
          data.data.vehiculoCiu || "0";
        document.getElementById("txt-aso").textContent =
          data.data.cantidadDocumentos || "0"; // Asignar texto al div
        document.getElementById("txt-leas").textContent =
          data.data.cantidadLeasing || "0"; // Asignar texto al div
        document.getElementById("txt-vehic").textContent =
          data.data.cantidadVehiculos || "0";
        document.getElementById("txt-assign").textContent =
          data.data.cantidadAsignados || "0";
      } catch (error) {
        console.error("Error al obtener los datos del contrato:", error);
      }
    }
  });

// Función para convertir la fecha yyyymmdd a yyyy-mm-dd
function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

// Función para calcular la fecha de fin sumando la duración (en meses) a la fecha de inicio
function calcularFechaFin(fechaInicio, duracionMeses) {
  const fechaInicioObj = new Date(fechaInicio);
  console.log("Fecha de inicio convertida a objeto Date:", fechaInicioObj);

  // Obtener el año, mes y día de la fecha de inicio
  const anio = fechaInicioObj.getFullYear();
  const mes = fechaInicioObj.getMonth(); // El mes en formato 0-11 (enero es 0)
  const dia = fechaInicioObj.getDate();
  console.log("Año:", anio, "Mes:", mes + 1, "Día:", dia);

  //fili
  let pruebaDura = parseFloat(duracionMeses.trim()) + 1;
  let pruebaAnio = anio;
  let pruebaMes = mes + 1;
  let pruebDia = dia;
  let datoMes = 0;

  for (var i = 1; i < pruebaDura; i++) {
    pruebaMes = pruebaMes + 1;
    if (pruebaMes > 12) {
      datoMes = pruebaMes - 12;
      pruebaMes = datoMes;
      pruebaAnio = pruebaAnio + 1;
    } else {
      pruebaMes = pruebaMes;
      pruebaAnio = pruebaAnio;
    }
  }

  console.log("Dato - Año:", pruebaAnio, "Mes:", pruebaMes, "Día:", dia);

  if (pruebaMes < 10) {
    pruebaMes = pruebaMes.toString().padStart(2, "0");
  } else {
    pruebaMes = pruebaMes;
  }

  if (pruebDia < 10) {
    pruebDia = pruebDia.toString().padStart(2, "0");
  } else {
    pruebDia = pruebDia;
  }

  const year = pruebaAnio;
  const month = pruebaMes;
  const day = pruebDia;
  const fechaFinal = `${year}-${month}-${day}`;
  // Devolver la fecha final
  return fechaFinal;
  //fili
}

// Función para obtener el estado del contrato según la fecha de fin
function obtenerEstado(fechaFin) {
  const fechaActual = new Date();
  const fechaFinObj = new Date(fechaFin);
  if (fechaFinObj >= fechaActual) {
    return "Activo";
  } else {
    return "Finalizado";
  }
}

function limpiarCampos() {
  limpia();

  document.querySelector(".tabla-form table tbody").innerHTML = `
        <tr>
            <td colspan="5">Seleccione un cliente para ver los contratos</td>
        </tr>
    `;

  const comboBox = document.getElementById("combo-box");
  comboBox.value = ""; // Restablece el valor al predeterminado

  const comboBox2 = document.getElementById("combo-contrato");
  comboBox2.value = ""; // Restablece el valor al predeterminado
}
