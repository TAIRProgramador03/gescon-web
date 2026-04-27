const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `http://${IP_LOCAL}:3000`,
    timeout: 3000,
  });
};

let instance;

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

async function cargarContContrato(clientId) {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(
      `http://${IP_LOCAL}:3000/contContrato${clientId ? `?clienteId=${clientId}` : ""}`,
      {
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    ); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const conContrato = await response.json();

    document.getElementById("con-Contra").textContent =
      conContrato.data.PADRE || "0";
    document.getElementById("con-Adenda").textContent =
      conContrato.data.TIPO_1 || "0";
    document.getElementById("con-Carta").textContent =
      conContrato.data.TIPO_2 || "0";
    document.getElementById("con-OC").textContent =
      conContrato.data.TIPO_3 || "0";
  } catch (error) {
    console.error("Error al cargar los contadores:", error);
  }
}

async function obtenerFlotaVehicular(status, clientId) {
  let paramsString = "";

  if (status && clientId) {
    paramsString = `?status=${status}&clienteId=${clientId}`;
  } else if (status) {
    paramsString = `?status=${status}`;
  } else if (clientId) {
    paramsString = `?clienteId=${clientId}`;
  }

  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleFleet${paramsString}`,
    {
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
}

async function obtenerClientes() {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
    credentials: "include",
  });

  const data = await response.json();

  return data;
}

async function obtenerLeasings(clienteId) {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/contVehicleLeasing", {
      withCredentials: true,
      params: {
        clienteId,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }

  // const IP_LOCAL = await obtenerConfig()

  // const response = await fetch(
  //   `http://${IP_LOCAL}:3000/contVehicleLeasing?draw=${draw}&start=${currentPage}&length=${length}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
  //   {
  //     method: "GET",
  //     credentials: "include",
  //   },
  // );

  // const res = await response.json();

  // return res;
}

async function obtenerCantidadVehicle(clientId) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contLeasing${clientId ? `?clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerVehiculosVencidos(label, clienteId) {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/listVehicleExpires", {
      withCredentials: true,
      params: {
        label,
        clienteId,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }

  // const IP_LOCAL = await obtenerConfig()

  // const response = await fetch(
  //   `http://${IP_LOCAL}:3000/listVehicleExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
  //   {
  //     method: "GET",
  //     credentials: "include",
  //   },
  // );

  // const res = await response.json();

  // return res;
}

async function obtenerVehiculosPorVencer(label, clienteId) {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/listVehicleToExpires", {
      withCredentials: true,
      params: {
        label,
        clienteId,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }

  // const IP_LOCAL = await obtenerConfig()

  // const response = await fetch(
  //   `http://${IP_LOCAL}:3000/listVehicleToExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
  //   {
  //     method: "GET",
  //     credentials: "include",
  //   },
  // );

  // const res = await response.json();

  // return res;
}

async function obtenerTotalVehiculosPorCliente(clientsId) {
  const query = clientsId.map((cli) => `clientesId=${cli}`).join("&");

  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleByClient?${query}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerContratos(clientId) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contratosNro${clientId ? `?idCli=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerLeasingsPorContrato(contractId) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByContract${contractId ? `?contratoId=${contractId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerDiasContratoLeasing(contractId, leasingId) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contComparationDays?contractId=${contractId}&leasingId=${leasingId}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerModelosGenericos() {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/modedosGenericos`, {
    method: "GET",
    credentials: "include",
  });

  const res = await response.json();

  return res;
}

async function obtenerAñosPorModelo(modelId) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/aniosPorModelo?modelId=${modelId}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerTotalCostoPorModelo(modelId, fromYear, toYear) {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contTotalPriceModel?modelId=${modelId}&fromYear=${fromYear}${toYear ? `&toYear=${toYear}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function generarExcelLeasingsVeh(data) {
  const wb = new ExcelJS.Workbook();
  const ws = wb.addWorksheet("Vehiculos");

  ws.mergeCells("A1:O1");
  const titleCell = ws.getCell("A1");

  titleCell.value = "Gescon: Placas por Leasing".toUpperCase();
  titleCell.font = { bold: true, color: { argb: "FFFFFF" } };
  titleCell.alignment = { vertical: "middle", horizontal: "center" };
  titleCell.fill = {
    type: "pattern",
    pattern: "solid",
    fgColor: { argb: "007595" },
  };
  ws.getRow(1).height = 15;

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
      { name: "Modelo", filterButton: true },
      { name: "Fecha de Entrega (Acta)", filterButton: true },
      { name: "Fecha de Devolución", filterButton: true },
      { name: "Tipo", filterButton: true },
      { name: "Fecha Firma Contrato", filterButton: true },
      { name: "Fecha Fin Contrato", filterButton: true },
      { name: "Años Contrato", filterButton: true },
      { name: "N° Leasing", filterButton: true },
      { name: "Fecha Inicio Leasing", filterButton: true },
      { name: "Fecha Fin Leasing", filterButton: true },
      { name: "Años Leasing", filterButton: true },
      { name: "Estado (Diferencia)", filterButton: true },
      { name: "Tipo Estado", filterButton: true },
    ],
    rows: data.map((row, i) => {
      const tipoEstado =
        row.diferenciaDias > 0
          ? "Leasing"
          : row.diferenciaDias < 0
            ? "Contrato"
            : "Igual";

      const estadoTexto =
        row.diferenciaDias > 0
          ? `Leasing vence antes (${Math.abs(row.diferenciaDias)} dias)`
          : row.diferenciaDias < 0
            ? `Contrato vence antes (${Math.abs(row.diferenciaDias)} dias)`
            : "Vencen a la vez";

      return [
        i + 1,
        row.placa,
        row.modelo,
        row.fechaIniActa !== "" ? dayjs(row.fechaIniActa).toDate() : null,
        row.fechaFinActa !== "" ? dayjs(row.fechaFinActa).toDate() : null,
        row.tipoCont == "P" ? "Contrato" : "Documento",
        dayjs(row.fechaIniCont).toDate(),
        dayjs(row.fechaFinCont).toDate(),
        row.añosContrato,
        row.nroLeasing,
        dayjs(row.fechaIniLea).toDate(),
        dayjs(row.fechaFinLea).toDate(),
        row.añosLeasing,
        estadoTexto,
        tipoEstado,
      ];
    }),
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

  ws.getColumn(4).numFmt = "dd/mm/yyyy";
  ws.getColumn(5).numFmt = "dd/mm/yyyy";
  ws.getColumn(7).numFmt = "dd/mm/yyyy";
  ws.getColumn(8).numFmt = "dd/mm/yyyy";
  ws.getColumn(11).numFmt = "dd/mm/yyyy";
  ws.getColumn(12).numFmt = "dd/mm/yyyy";

  // Tamaño columnas
  ws.getColumn(1).width = 8; // Item
  ws.getColumn(2).width = 11; // Placa
  ws.getColumn(3).width = 40; // Modelo
  ws.getColumn(4).width = 27; // Acta entrega
  ws.getColumn(5).width = 27; // Devolucion
  ws.getColumn(6).width = 15; // Tipo contrato
  ws.getColumn(7).width = 27; // Firma
  ws.getColumn(8).width = 27; // Fin contrato
  ws.getColumn(9).width = 18; // Años
  ws.getColumn(10).width = 20; // Leasing
  ws.getColumn(11).width = 27; // Inicio lea
  ws.getColumn(12).width = 27; // Fin lea
  ws.getColumn(13).width = 18; // Años lea
  ws.getColumn(14).width = 30; // Estado
  ws.getColumn(15).width = 18; // Tipo Estado

  ws.views = [{ state: "frozen", ySplit: 2 }];

  ws.eachRow((row, rowNumber) => {
    row.eachCell((cell) => {
      cell.alignment = {
        vertical: "middle",
        horizontal: "center",
      };
    });
  });

  const startRow = 3; // porque A2 es header
  const endRow = startRow + data.length - 1;

  // Columna 14 = Estado
  const col = 14;

  // ROJO → Contrato vence antes
  ws.addConditionalFormatting({
    ref: `N${startRow}:N${endRow}`,
    rules: [
      {
        type: "containsText",
        operator: "containsText",
        text: "Contrato vence antes",
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
        type: "containsText",
        operator: "containsText",
        text: "Leasing vence antes",
        style: {
          fill: {
            type: "pattern",
            pattern: "solid",
            bgColor: { argb: "00B050" },
          },
          font: { color: { argb: "FFFFFF" }, bold: true },
        },
      },
      {
        type: "containsText",
        operator: "containsText",
        text: "Vencen a la vez",
        style: {
          fill: {
            type: "pattern",
            pattern: "solid",
            bgColor: { argb: "FFFF00" },
          },
          font: { color: { argb: "000000" }, bold: true },
        },
      },
    ],
  });

  const buffer = await wb.xlsx.writeBuffer();

  const blob = new Blob([buffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `Gescon_Reporte_Placas_${new Date().toLocaleDateString()}.xlsx`;
  link.click();
}

async function generarExcelVehiclesDonut(data, title) {
  const wb = new ExcelJS.Workbook();
  const ws = wb.addWorksheet("Vehiculos");

  ws.mergeCells("A1:I1");
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
      { name: "Cliente", filterButton: true },
      { name: "Cliente Origen", filterButton: true },
      { name: "N° de Leasing", filterButton: true },
      { name: "Fecha Fin Leasing", filterButton: true },
      { name: "% de Leasing", filterButton: true },
    ],
    rows: data.map((row, i) => {
      const fechaIni = dayjs(row.fechaIni).format("YYYY-MM-DD");
      const fechaFin = dayjs(row.fechaFin).format("YYYY-MM-DD");

      const result = calcularPorcentaje(fechaIni, fechaFin);

      let porcentaje;

      if (typeof result == "string") {
        porcentaje = result;
      } else {
        porcentaje = result / 100;
      }

      return [
        i + 1,
        row.placa,
        row.marca,
        row.modelo,
        row.cliente,
        row.clienteAsoc,
        row.nroLeasing,
        dayjs(row.fechaFin).toDate(),
        porcentaje,
      ];
    }),
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

  ws.getColumn(8).numFmt = "dd/mm/yyyy";
  ws.getColumn(9).numFmt = '0%';

  // Tamaño columnas
  ws.getColumn(1).width = 8; // Item
  ws.getColumn(2).width = 11; // Placa
  ws.getColumn(3).width = 30; // Marca
  ws.getColumn(4).width = 40; // Modelo
  ws.getColumn(5).width = 30; // Cliente
  ws.getColumn(6).width = 30; // Cliente Origen
  ws.getColumn(7).width = 27; // Leasing
  ws.getColumn(8).width = 27; // Fin lea
  ws.getColumn(9).width = 25; // Porcentaje

  ws.views = [{ state: "frozen", ySplit: 2 }];

  ws.eachRow((row, rowNumber) => {
    row.eachCell((cell) => {
      cell.alignment = {
        vertical: "middle",
        horizontal: "center",
        wrapText: true
      };
    });
  });

  const startRow = 3;
  const endRow = startRow + data.length - 1;

  ws.addConditionalFormatting({
    ref: `I${startRow}:I${endRow}`,
    rules: [
      {
        type: "expression",
        formulae: [`AND(ISNUMBER(I${startRow}), I${startRow}<=0.25)`],
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
          `AND(ISNUMBER(I${startRow}), I${startRow}>0.25, I${startRow}<=0.6)`,
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
        formulae: [`AND(ISNUMBER(I${startRow}), I${startRow}>0.6)`],
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

  const buffer = await wb.xlsx.writeBuffer();

  const blob = new Blob([buffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `Gescon_Reporte_Placas_${new Date().toLocaleDateString()}.xlsx`;
  link.click();
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
