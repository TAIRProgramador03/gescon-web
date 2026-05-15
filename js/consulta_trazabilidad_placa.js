// const IP_LOCAL = "localhost";
import { animate } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
    timeout: 10000,
  });
};

let instance;

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
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
export const getAssigns = async (
  clienteId,
  contratoId,
  leasingId,
  tipoTerr,
  status,
) => {
  instance = await obtenerInstancia();
  const response = await instance.get(`/trazabilidadPlaca`, {
    withCredentials: true,
    params: {
      idCliente: clienteId,
      idContrato: contratoId,
      idLeasing: leasingId,
      tipoTerr: tipoTerr,
      status,
    },
  });

  const assigns = await response.data;

  return assigns;
};

export const getLeasings = async (clienteId, contratoId) => {
  instance = await obtenerInstancia();

  const response = await instance.get(`/leasingGeneral`, {
    withCredentials: true,
    params: {
      clienteId,
      contratoId,
    },
  });

  return response.data;
};

export const getClients = async () => {
  instance = await obtenerInstancia();

  const response = await instance.get("/clientes", {
    withCredentials: true,
  });

  return response.data;
};

export const getContracts = async (clientId) => {
  instance = await obtenerInstancia();

  const response = await instance.get("/contratosNroAdi", {
    withCredentials: true,
    params: {
      idCli: clientId,
    },
  });

  return response.data;
};

const getFile = async (key) => {
  try {
    const IP_LOCAL = await obtenerConfig();

    const viewPDF = await fetch(
      `${IP_LOCAL}/previsualizarArchivo?key=${key}`,
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

export const verPdf = async (key) => {
  const link = await getFile(key);

  window.open(link, "_blank");
};

export async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "acta");

  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`${IP_LOCAL}/subirArchivo`, {
      enctype: "multipart/form-data",
      method: "POST",
      body: formData,
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (!result.success) {
      toastr.warning(result.message, "Oops...");
    }

    return result;
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    toastr.warning(error.message, "Oops...");
  }
}

export async function updateAssign(id, assign) {
  try {
    instance = await obtenerInstancia();

    const response = await instance.put(`/actualizarAsignacion/${id}`, assign, {
      withCredentials: true,
    });

    const data = response.data;

    if (data.success) {
      toastr.success(data.message, "¡Éxito!");

      clearFields();
    }
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

export async function getHistory(id) {
  try {
    instance = await obtenerInstancia();

    const result = await instance.get(`/historialMovimientos/${id}`, {
      withCredentials: true,
    });

    return result.data;
  } catch (error) {
    console.error(error.response.data);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

export async function getHistoryById(id) {
  try {
    instance = await obtenerInstancia();

    const result = await instance.get(`/obtenerReasignacion/${id}`, {
      withCredentials: true,
    });

    return result.data;
  } catch (error) {
    console.error(error.response.data);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

export async function clearFields() {
  const anim = animate(
    ".modal-container",
    {
      opacity: [1, 0],
      scale: [1, 1.05, 0.75],
    },
    {
      duration: 0.45,
      easing: "ease-in",
    },
  );

  await anim.finished;

  $("#modal-assign")
    .removeClass("opacity-100 z-[9999]")
    .addClass("opacity-0 -z-[9999]");

  $("#fechaEntrega").val(null);
  $("#fechaDevolucion").val(null);
  $("#cbo-terreno-upd").val(null).trigger("change");
  $("#cbo-condicion-upd").val(null).trigger("change");
  fileInput.value = "";
}

export async function generarExcel(data, title) {
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
        row.marca,
        row.modelo,
        row.año,
        row.color,
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
      { name: "Marca", filterButton: true },
      { name: "Modelo", filterButton: true },
      { name: "Año", filterButton: true },
      { name: "Color", filterButton: true },
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
      { name: "Situación Actual", filterButton: true },
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
  ws.getColumn(3).width = 30; // Marca
  ws.getColumn(4).width = 45; // Modelo
  ws.getColumn(5).width = 30; // Año
  ws.getColumn(6).width = 40; // Color
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
  ws.getColumn(23).width = 25; // Situación Actual
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

function transformType(value, object) {
  return object[value];
}

export function calcularPorcentaje(fechaIni, fechaFinal) {
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

  let porcentaje = (tiempoRestante / tiempoTotal) * 100;

  // Aseguramos que no baje de 0 ni suba de 100
  porcentaje = Math.min(Math.max(porcentaje, 0), 100);

  return porcentaje;
}

export function convertirFecha(date) {
  const fecha = `${date}`;
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}
