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

const getLeasings = async (documentoId, clienteId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByDocument?documentoId=${documentoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const lesaings = await response.json();

  // INTEGRAMOS LA LIBRERIA DATATABLE
  const table = $("#listLeasing").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
    },
    scrollY: "500px",
    scrollCollapse: true,
    dom: '<"superior"f>rt<"inferior"i<"derecha-inferior"lp>>',
    data: lesaings,
    columnDefs: [
      // Centrar contenido y cabecera en las columnas 0, 1 y 2
      {
        className: "dt-center",
        targets: [0, 1, 2, 3, 4],
      },
    ],
    columns: [
      {
        data: "item",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
        width: "5%",
      },
      {
        data: "nroLeasing",
      },
      {
        data: "fechaInicio",
        render: function (data) {
          return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
        },
        width: "20%",
      },
      {
        data: "fechaFin",
        render: function (data) {
          return dayjs(convertirFecha(data)).format("DD/MM/YYYY");
        },
        width: "20%",
      },
      { data: "cantVehi", width: "5%" },
    ],
  });

  return table;
};

const getDetailLeasing = async (
  leasingId,
  nroLeasing,
  clienteId,
  documentoId,
) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/detailLeasing?leasingId=${leasingId.toString()}&nroLeasing=${nroLeasing.trim()}&clienteId=${clienteId.toString()}&contratoId=${documentoId.toString()}&tipoCont=H`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  if (!response.ok) {
    toastr.error(data.message, "Oops...");
  }

  return data;
};

const getVehByLeasing = async (leasingId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/vehiclesByLeasing?leasingId=${leasingId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

const getAssignByLeasing = async (nroLeasing, clienteId, documentoId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/assignByLeasing?nroLeasing=${nroLeasing}&clienteId=${clienteId}&contratoId=${documentoId}&tipoCont=H`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

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

async function generarExcel(data, title) {
  const wb = new ExcelJS.Workbook();
  const ws = wb.addWorksheet("Vehiculos");

  ws.mergeCells("A1:M1");
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
      const fechaIni = dayjs(convertirFecha(row.fechaIni)).toDate();
      const fechaConv = row.fechaFin ? convertirFecha(row.fechaFin) : null;
      const fechaFin = fechaConv ? dayjs(fechaConv).toDate() : null;

      const dias = fechaConv ? obtenerDiasVencimiento(fechaConv) : null;

      const vencimiento = dias
        ? dias > 0
          ? `En ${dias} dias`
          : dias < 0
            ? `Hace ${Math.abs(dias)} dias`
            : `Vence hoy`
        : "--";

      return [
        i + 1,
        row.placa,
        row.marca,
        row.modelo,
        row.año,
        row.color,
        row.condicion,
        row.terreno,
        row.operacion,
        row.nroLeasing,
        fechaIni,
        fechaFin,
        vencimiento,
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
      { name: "Condición", filterButton: true },
      { name: "Terreno", filterButton: true },
      { name: "Operación", filterButton: true },
      { name: "Leasing", filterButton: true },
      { name: "Fecha Inicio", filterButton: true },
      { name: "Fecha Fin", filterButton: true },
      { name: "Vencimiento", filterButton: true },
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

  // Tamaño columnas
  ws.getColumn(1).width = 8; // Item
  ws.getColumn(2).width = 17; // Placa
  ws.getColumn(3).width = 20; // Marca
  ws.getColumn(4).width = 25; // Modelo
  ws.getColumn(5).width = 13; // Año
  ws.getColumn(6).width = 28; // Color
  ws.getColumn(7).width = 18; // Condición
  ws.getColumn(8).width = 18; // Terreno
  ws.getColumn(9).width = 40; // Operacion
  ws.getColumn(10).width = 30; // Nro Leasing
  ws.getColumn(11).width = 18; // Fecha Inicio
  ws.getColumn(12).width = 18; // Fecha Fin
  ws.getColumn(13).width = 24; // Vencimiento

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

  const buffer = await wb.xlsx.writeBuffer();

  const blob = new Blob([buffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `Gescon_Reporte_Vehiculos_${new Date().toLocaleDateString()}.xlsx`;
  link.click();
}

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

function obtenerEstado(fechaFin) {
  const fechaActual = new Date();
  const fechaFinObj = new Date(fechaFin);
  if (fechaFinObj >= fechaActual) {
    return "Activo";
  } else {
    return "Finalizado";
  }
}

function obtenerDiasVencimiento(fecha) {
  const fechaFin = new Date(fecha);
  const fechaActual = new Date(Date.now());
  const diferenciaTiempo = fechaFin - fechaActual;
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}

function isPermission(permission) {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  return permissions.includes(permission);
}
