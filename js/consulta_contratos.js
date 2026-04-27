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
    const IP_LOCAL = await obtenerConfig();
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
    const IP_LOCAL = await obtenerConfig();
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
    const IP_LOCAL = await obtenerConfig();
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
    document.getElementById("text-inicio").value =
      data.data.fechaFirma != ""
        ? dayjs(fechaInicio).format("DD/MM/YYYY")
        : "--"; // Asignar FECHA_FIRMA

    // Calcular fecha de fin
    const fechaFin = calcularFechaFin(fechaInicio, data.data.duracion);

    document.getElementById("text-fin").value =
      data.data.fechaFirma != "" ? dayjs(fechaFin).format("DD/MM/YYYY") : "--"; // Asignar fecha de fin

    const estado = obtenerEstado(fechaFin);
    document.getElementById("text-estado").value =
      data.data.fechaFirma != "" ? estado : "--"; // Asignar DESCRIPCION
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

    const isTemp = data.data.isTemp;

    if (isTemp) {
      $("#btn-edit-con").addClass("flex");
      $("#btn-edit-con").removeClass("hidden");
    } else {
      $("#btn-edit-con").addClass("hidden");
      $("#btn-edit-con").removeClass("flex");
    }

    return data;
  } catch (error) {
    console.error("Error al obtener los datos del contrato:", error);
  }
}

async function verificarContratosTemp() {
  try {
    const IP_LOCAL = await obtenerConfig();
    const response = await fetch(
      `http://${IP_LOCAL}:3000/verificarContratosTemp`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const data = await response.json();

    return data;
  } catch (error) {
    console.error("Error al obtener contratos temporales:", error);
  }
}

const getFile = async (key) => {
  try {
    const IP_LOCAL = await obtenerConfig();
    const viewPDF = await fetch(
      `http://${IP_LOCAL}:3000/previsualizarArchivo?key=${key}`,
      {
        credentials: "include",
      },
    );

    const result = await viewPDF.json();

    if (result.success) {
      return result.url;
    } else {
      toastr.warning(result.message, "Oops...");
    }
  } catch (error) {
    console.error(error);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

const verPdf = async (key) => {
  const link = await getFile(key);

  if (!link) {
    return;
  }

  window.open(link, "_blank");
};

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

  $("#btn-assign").addClass("hidden");
  $("#btn-assign").removeClass("flex");
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
  const IP_LOCAL = await obtenerConfig();
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

const getAssignVehActive = async (clienteId, contratoId, status, tipTerr) => {
  const IP_LOCAL = await obtenerConfig();
  const response = await fetch(
    `http://${IP_LOCAL}:3000/asignacionPorContrato?idCliente=${clienteId.toString()}${contratoId ? `&idContrato=${contratoId.toString()}` : ""}${status ? `&status=${status}` : ""}${tipTerr == 0 || tipTerr ? `&tipoTerr=${tipTerr}` : ""}`,
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

const getPendingVeh = async (clienteId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/consultaVehiculoLeasing?idCli=${clienteId.toString()}&nroLeasing=all`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  // if (!response.ok) {
  //   toastr.info(data.message, "Aviso");
  // }

  return data;
};

async function generarExcel(data, title) {
  const wb = new ExcelJS.Workbook();
  const ws = wb.addWorksheet("Vehiculos");

  ws.mergeCells("A1:W1");
  const titleCell = ws.getCell("A1");

  titleCell.value = `Gescon: ${title}`.toUpperCase();
  titleCell.font = { bold: true, color: { argb: "FFFFFF" } };
  titleCell.alignment = { vertical: "middle", horizontal: "center" };
  titleCell.fill = {
    type: "pattern",
    pattern: "solid",
    fgColor: { argb: "007595" },
  };
  ws.getRow(1).height = 15;

  const rows = await Promise.all(
    data.map(async (row, i) => {
      const fechaIni = dayjs(convertirFecha(row.fechaIni)).format("YYYY-MM-DD");
      const fechaFin = row.fechaFin
        ? dayjs(convertirFecha(row.fechaFin)).format("YYYY-MM-DD")
        : null;

      const result = fechaFin
        ? calcularPorcentaje(fechaIni, fechaFin)
        : "No calculado";

      let porcentaje;

      if (typeof result === "string") {
        porcentaje = result;
      } else {
        porcentaje = result / 100;
      }

      const status =
        row.idOpeActual == 109
          ? "Vendido"
          : row.idOpe != row.idOpeActual
            ? "Inactivo"
            : "Activo";

      return [
        i + 1,
        row.placa,
        row.año,
        row.color,
        row.marca,
        row.modelo,
        transformType(row.terreno, {
          0: "Superficie",
          1: "Socavón",
          2: "Ciudad",
          3: "Severo",
          4: "Pendiente",
        }),
        row.leasing,
        dayjs(convertirFecha(row.fechaIniLea)).toDate(),
        dayjs(convertirFecha(row.fechaFinLea)).toDate(),
        row.cliente,
        row.operacion,
        row.contrato,
        dayjs(row.fechaIniCon).toDate(),
        `${row.plazo.trim()} meses`,
        dayjs(row.fechaFinCon).toDate(),
        row.tarifa,
        row.moneda,
        dayjs(convertirFecha(row.fechaIni)).toDate(),
        row.fechaFin ? dayjs(convertirFecha(row.fechaFin)).toDate() : null,
        transformType(row.condicion, {
          0: "Titular",
          1: "Retén",
          2: "Logística",
          3: "Pendiente",
        }),
        porcentaje,
        status,
      ];
    }),
  );

  ws.addTable({
    name: "TablaVehiculos",
    ref: "A2",
    headerRow: true,
    style: {
      theme: "TableStyleMedium2",
      showRowStripes: true,
    },
    columns: [
      { name: "Item", filterButton: true },
      { name: "Placa", filterButton: true },
      { name: "Año", filterButton: true },
      { name: "Color", filterButton: true },
      { name: "Marca", filterButton: true },
      { name: "Modelo", filterButton: true },
      { name: "Terreno", filterButton: true },
      { name: "Leasing", filterButton: true },
      { name: "Fecha Inicio de Leasing", filterButton: true },
      { name: "Fecha Fin de Leasing", filterButton: true },
      { name: "Cliente", filterButton: true },
      { name: "Operación", filterButton: true },
      { name: "Contrato/Adenda", filterButton: true },
      { name: "Fecha Firma de Contrato", filterButton: true },
      { name: "Plazo", filterButton: true },
      { name: "Fecha Fin de Contrato", filterButton: true },
      { name: "Tarifa", filterButton: true },
      { name: "Moneda", filterButton: true },
      { name: "Fecha de Acta de Entrega", filterButton: true },
      { name: "Fecha Devolución", filterButton: true },
      { name: "Condición", filterButton: true },
      { name: "% de Contrato", filterButton: true },
      { name: "Operatividad", filterButton: true },
      // { name: "Acta", filterButton: true },
    ],
    rows,
  });

  ws.getTable("TablaVehiculos").commit();

  const headerRow = ws.getRow(2);

  headerRow.eachCell((cell) => {
    cell.font = { bold: true, color: { argb: "FFFFFF" } };

    cell.fill = {
      type: "pattern",
      pattern: "solid",
      fgColor: { argb: "002141" },
    };

    cell.alignment = { horizontal: "center", vertical: "middle" };

    cell.border = {
      top: { style: "thin" },
      left: { style: "thin" },
      bottom: { style: "thin" },
      right: { style: "thin" },
    };
  });

  // Formatos de columnas
  ws.getColumn(9).numFmt = "dd/mm/yyyy";
  ws.getColumn(10).numFmt = "dd/mm/yyyy";
  ws.getColumn(14).numFmt = "dd/mm/yyyy";
  ws.getColumn(16).numFmt = "dd/mm/yyyy";
  ws.getColumn(19).numFmt = "dd/mm/yyyy";
  ws.getColumn(20).numFmt = "dd/mm/yyyy";
  ws.getColumn(22).numFmt = "0%";

  // Tamaño columnas
  ws.getColumn(1).width = 8; // Item
  ws.getColumn(2).width = 11; // Placa
  ws.getColumn(3).width = 30; // Año
  ws.getColumn(4).width = 40; // Color
  ws.getColumn(5).width = 30; // Marca
  ws.getColumn(6).width = 45; // Modelo
  ws.getColumn(7).width = 27; // Terreno
  ws.getColumn(8).width = 27; // Leasing
  ws.getColumn(9).width = 30; // Fecha Ini Lea
  ws.getColumn(10).width = 30; // Fecha Fin Lea
  ws.getColumn(11).width = 45; // Clientes
  ws.getColumn(12).width = 35; // Operacion
  ws.getColumn(13).width = 35; // Contrato/Adenda
  ws.getColumn(14).width = 25; // Fecha Firma
  ws.getColumn(15).width = 25; // Plazo
  ws.getColumn(16).width = 25; // Fecha Fin Cont
  ws.getColumn(17).width = 25; // Tarifa
  ws.getColumn(18).width = 25; // Moneda
  ws.getColumn(19).width = 25; // Fecha Entrega
  ws.getColumn(20).width = 25; // Fecha Devolucion
  ws.getColumn(21).width = 25; // Condicion
  ws.getColumn(22).width = 25; // Porcentaje
  ws.getColumn(23).width = 25; // Operatividad
  // ws.getColumn(24).width = 25; // Acta

  ws.views = [{ state: "frozen", ySplit: 2 }];

  ws.eachRow((row, rowNumber) => {
    row.eachCell((cell) => {
      cell.alignment = {
        vertical: "middle",
        horizontal: "center",
        wrapText: true,
      };
    });
  });

  // ws.getColumn(24).alignment = {
  //   wrapText: false,
  //   horizontal: "center",
  //   vertical: "middle",
  // };

  const startRow = 3;
  const endRow = startRow + data.length - 1;

  if (data.length > 0) {
    ws.addConditionalFormatting({
      ref: `V${startRow}:V${endRow}`,
      rules: [
        {
          type: "expression",
          formulae: [`AND(ISNUMBER(V${startRow}), V${startRow}<=0.25)`],
          style: {
            fill: {
              type: "pattern",
              pattern: "solid",
              bgColor: { argb: "FF0000" },
            },
            font: { color: { argb: "FFFFFF" }, bold: true },
          },
        },
        {
          type: "expression",
          formulae: [
            `AND(ISNUMBER(V${startRow}), V${startRow}>0.25, V${startRow}<=0.6)`,
          ],
          style: {
            fill: {
              type: "pattern",
              pattern: "solid",
              bgColor: { argb: "FFC000" },
            },
            font: { color: { argb: "000000" }, bold: true },
          },
        },
        {
          type: "expression",
          formulae: [`AND(ISNUMBER(V${startRow}), V${startRow}>0.6)`],
          style: {
            fill: {
              type: "pattern",
              pattern: "solid",
              bgColor: { argb: "00B050" },
            },
            font: { color: { argb: "FFFFFF" }, bold: true },
          },
        },
      ],
    });
  }

  const buffer = await wb.xlsx.writeBuffer();

  const blob = new Blob([buffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `Gescon_Reporte_Vehiculos_${new Date().toLocaleDateString()}.xlsx`;
  link.click();
}

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

  // Obtener el año, mes y día de la fecha de inicio
  const anio = fechaInicioObj.getFullYear();
  const mes = fechaInicioObj.getMonth(); // El mes en formato 0-11 (enero es 0)
  const dia = fechaInicioObj.getDate();

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

function calcularPorcentaje(fechaIni, fechaFinal) {
  const fechaInicio = new Date(fechaIni);
  const fechaFin = new Date(fechaFinal);
  const fechaActual = new Date();

  if (fechaActual > fechaFin) {
    const diffMs = fechaActual - fechaFin;
    const diasVencidos = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    return `Vencido hace ${diasVencidos} días`;
  }

  const tiempoTotal = fechaFin - fechaInicio;

  // INVERSIÓN: Restamos la fecha actual de la fecha fin
  // para obtener cuánto "camino" queda por recorrer.
  const tiempoRestante = fechaFin - fechaActual;

  let porcentaje = Math.round((tiempoRestante / tiempoTotal) * 100);

  // Aseguramos que no baje de 0 ni suba de 100
  porcentaje = Math.min(Math.max(porcentaje, 0), 100);

  return porcentaje;
}

function transformType(value, object) {
  return object[value];
}

function isPermission(permission) {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  return permissions.includes(permission);
}
