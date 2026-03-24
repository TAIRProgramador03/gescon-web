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

    // cargarTablacontrato();
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    toastr.error(
      "Error al obtener los contratos. Inténtelo de nuevo más tarde.",
      "Oops...",
    );
  }
}

const getContracts = async (idCli) => {
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/tablaCliente?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const contratos = await response.json();

    return contratos;
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    toastr.error(
      "Error al obtener los datos. Inténtelo de nuevo más tarde.",
      "Oops...",
    );
  }
};

async function cargarTablacontrato(id) {
  limpia();
  const params = new URLSearchParams(window.location.search);
  const idCli = params.get("clienteId"); // ID del cliente seleccionado

  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/tablaContrato?idCli=${idCli}&id=${id}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    // Verifica si la respuesta es exitosa
    if (!response.ok) {
      toastr.error(`Error en la solicitud: ${response.statusText}`);
    }

    const contratos = await response.json();

    return contratos;
  } catch (error) {
    console.error("Error al cargar los datos:", error);
  }
}

async function cargarDatosContrato(clienteId, contratoId) {
  // Realizar la solicitud AJAX al backend para obtener los detalles del contrato
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/contratoDetalle?clienteId=${clienteId}${contratoId ? `&contratoId=${contratoId}` : ""}`,
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
    document.getElementById("text-inicio").value = data.data.fechaFirma != "" ? fechaInicio : "--"; // Asignar FECHA_FIRMA

    // Calcular fecha de fin
    const fechaFin = calcularFechaFin(fechaInicio, data.data.duracion);
    console.log(fechaFin);
    document.getElementById("text-fin").value = data.data.fechaFirma != "" ? fechaFin : "--"; // Asignar fecha de fin

    const estado = obtenerEstado(fechaFin);
    document.getElementById("text-estado").value = data.data.fechaFirma != "" ? estado : "--"; // Asignar DESCRIPCION
    // Establecer el estado según la fecha actual y la fecha de fin
    document.getElementById("story").value = data.data.descripcion; // Asignar estado

    // Aquí asignamos los valores de los vehículos a los campos correspondientes
    document.getElementById("txt-sev").textContent =
      data.data.cantidadLeasing > 0 ? data.data.vehiculoSev : "0";
    document.getElementById("txt-soc").textContent =
      data.data.cantidadLeasing > 0 ? data.data.vehiculoSoc : "0";
    document.getElementById("txt-sup").textContent =
      data.data.cantidadLeasing > 0 ? data.data.vehiculoSup : "0";
    document.getElementById("txt-ciu").textContent =
      data.data.cantidadLeasing > 0 ? data.data.vehiculoCiu : "0";
    document.getElementById("txt-aso").textContent =
      data.data.cantidadDocumentos || "0"; // Asignar texto al div
    document.getElementById("txt-leas").textContent =
      data.data.cantidadLeasing || "0"; // Asignar texto al div
    document.getElementById("txt-vehic").textContent =
      data.data.cantidadLeasing > 0 ? data.data.cantidadVehiculos : "0";
    document.getElementById("txt-assign").textContent =
      data.data.cantidadAsignados || "0";

    if(data.data.hayActivos) {
      $("#cab-href-query-assign").addClass("nom-tp-danger")
    } else {
      $("#cab-href-query-assign").removeClass("nom-tp-danger")
    }
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
  const params = new URL(window.location);
  params.search = ""; // Limpia los parámetros
  window.history.replaceState({}, document.title, params.pathname);

  limpia();

  document.querySelector(".tabla-form table tbody").innerHTML = `
        <tr>
            <td colspan="5">Seleccione un cliente para ver los contratos</td>
        </tr>
    `;

  $("#combo-box").val(null).trigger("change");
  $("#combo-contrato").val(null).trigger("change");
}

const getVehByContract = async (contratoId, tipoTerr) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/placasPorContrato?contratoId=${contratoId.toString()}${tipoTerr ? `&tipoTerr=${tipoTerr}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  if (!response.ok) {
    toastr.info(data.message, "Aviso");
  }

  return data;
};

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

function obtenerDiasVencimiento(fecha) {
  const fechaActual = new Date(Date.now());
  const fechaFin = new Date(fecha);
  const diferenciaTiempo = fechaFin - fechaActual;
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}
