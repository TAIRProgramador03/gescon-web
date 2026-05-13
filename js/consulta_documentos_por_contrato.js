// const IP_LOCAL = "localhost";

const getDocuments = async (contratoId, clienteId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `${IP_LOCAL}/documentoPorContrato?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const documents = await response.json();

  return documents;
};

const getDetailDocument = async (documentoId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `${IP_LOCAL}/detalleDocumento?documentoId=${documentoId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

const getVehByDocument = async (documentoId, tipoTerr) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `${IP_LOCAL}/placasPorDocumento?documentoId=${documentoId.toString()}&tipoTerr=${tipoTerr}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  if (!response.ok) {
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

    toastr.info(data.message, "Aviso");
  }

  return data;
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

  ws.mergeCells("A1:J1");
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
        row.operacion,
        row.nroLeasing,
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
      { name: "Operación", filterButton: true },
      { name: "Leasing", filterButton: true },
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
  ws.getColumn(7).width = 40; // Operacion
  ws.getColumn(8).width = 30; // Nro Leasing
  ws.getColumn(9).width = 18; // Fecha Fin
  ws.getColumn(10).width = 24; // Vencimiento

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

function isPermission(permission) {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  return permissions.includes(permission);
}
