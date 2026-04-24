const getLeasings = async (bank, clientId, contractId, typeContract) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingAll${bank ? `?bank=${bank}` : ""}${clientId ? `&clientId=${clientId}` : ""}${contractId ? `&contractId=${contractId}` : ""}${typeContract ? `&typeContract=${typeContract}` : ""}`,
    {
      credentials: "include",
    },
  );

  const data = await response.json();

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

const getClients = async () => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
    credentials: "include",
  });

  const data = await response.json();

  return data;
};

const getContractsByClient = async (clientId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contratosNro?idCli=${clientId}`,
    {
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

const getDocumentsByContract = async (contractId, clientId) => {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(
    `http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contractId}&clienteId=${clientId}`,
    {
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

const verFlota = async (id) => {
  const modal = document.getElementById("modal-leasing");
  modal.style.display = "flex";

  Motion.animate(
    ".modal-container",
    {
      opacity: [0, 1],
      scale: [0.7, 1.05, 1],
    },
    {
      duration: 0.45,
      easing: "ease-out",
    },
  );

  const vehicles = await getVehByLeasing(id);

  $("#modal-body-info").append(`
      <table id="listVeh" class="display">
        <thead>
          <tr>
            <th class="!font-medium bg-yellow-500 text-white">Item</th>
            <th class="!font-medium bg-yellow-500 text-white">Placa</th>
            <th class="!font-medium bg-yellow-500 text-white">Marca</th>
            <th class="!font-medium bg-yellow-500 text-white">Modelo</th>
            <th class="!font-medium bg-yellow-500 text-white">Terreno</th>
            <th class="!font-medium bg-yellow-500 text-white">Año</th>
            <th class="!font-medium bg-yellow-500 text-white">Color</th>
            <th class="!font-medium bg-yellow-500 text-white">Operación</th>
            <th class="!font-medium bg-green-500 text-white">Leasing</th>
            <th class="!font-medium bg-green-500 text-white">Fecha Fin</th>
            <th class="!font-medium bg-green-500 text-white">Vencimiento</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    `);

  $("#listVeh").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
    },
    select: true,
    scrollY: "300px",
    scrollCollapse: true,
    dom: '<"superior"f<"leyendas">B>rt<"inferior"i<"derecha-inferior"lp>>',
    initComplete: function () {
      $(".leyendas").html(`
          <div class="w-full flex justify-center items-center gap-4">
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-yellow-400"></span>
              <p class="text-xs !m-0">Unidad</p>
            </div>
            <div class="flex justify-center items-center gap-1">
              <span class="size-5 bg-green-400"></span>
              <p class="text-xs !m-0">Leasing</p>
            </div>
          </div>
        `);
    },
    buttons: [
      {
        extend: "excelHtml5",
        text: '<span>Exportar</span><i class="bi bi-file-earmark-excel"></i>',
        titleAttr: "Excel",
        className: "btn-excel",
        filename:
          `Reporte_Placas_Leasing_${vehicles[0].nroLeasing}_` +
          new Date().toLocaleDateString(),
        title: `Lista de placas de los Leasings ${vehicles[0].nroLeasing}`,
      },
    ],
    data: vehicles,
    columnDefs: [
      // Centrar contenido y cabecera en las columnas 0, 1 y 2
      {
        className: "dt-center",
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
        data: "placa",
      },
      {
        data: "marca",
      },
      {
        data: "modelo",
      },
      {
        data: "terreno",
      },
      {
        data: "año",
      },
      {
        data: "color",
      },
      {
        data: "operacion",
      },
      {
        data: "nroLeasing",
      },
      {
        data: "fechaFin",
        render: function (data) {
          if (data) {
            return dayjs(convertirFecha(data.toString())).format("DD/MM/YYYY");
          } else {
            return "--";
          }
        },
      },
      {
        data: "fechaFin",
        render: function (data) {
          if (data) {
            const fechaTsf = convertirFecha(data);
            const dias = obtenerDiasVencimiento(fechaTsf);
            if (dias > 0) {
              return `${dias} dias`;
            } else if (dias < 0) {
              return `Hace ${Math.abs(dias)} dias`;
            } else {
              return `Vence hoy`;
            }
          } else {
            return "--";
          }
        },
      },
    ],
  });
};

async function generarExcel(data, title) {
  const wb = new ExcelJS.Workbook();
  const ws = wb.addWorksheet("Leasings");

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
      const fechaIni = row.fechaIni ? dayjs(convertirFecha(row.fechaIni)).toDate() : null;
      const fechaFin = row.fechaFin
        ? dayjs(convertirFecha(row.fechaFin)).toDate()
        : null;

      return [
        i + 1,
        row.nroLeasing,
        row.banco,
        `${row.cantidad} und.`,
        fechaIni,
        fechaFin,
        row.perGracia ? row.perGracia > 0 ? `${row.perGracia} meses` : `Sin periodo` : `Sin periodo`,
        row.cliente,
        row.clienteOrigen ? row.clienteOrigen : row.cliente,
        row.nroContrato,
      ];
    }),
  );

  ws.addTable({
    name: "TablaLeasings",
    ref: "A2",
    headerRow: true,
    style: {
      theme: "TableStyleMedium2",
      showRowStripes: true,
    },
    columns: [
      { name: "Item", filterButton: true },
      { name: "N° Leasing", filterButton: true },
      { name: "Banco", filterButton: true },
      { name: "Cantidad Vehiculos", filterButton: true },
      { name: "Fecha Inicio", filterButton: true },
      { name: "Fecha Fin", filterButton: true },
      { name: "Periodo de Gracia", filterButton: true },
      { name: "Cliente", filterButton: true },
      { name: "Cliente Origen", filterButton: true },
      { name: "Contrato/Adenda", filterButton: true },
    ],
    rows,
  });

  ws.getTable("TablaLeasings").commit();

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
  ws.getColumn(5).numFmt = "dd/mm/yyyy";
  ws.getColumn(6).numFmt = "dd/mm/yyyy";

  // Tamaño columnas
  ws.getColumn(1).width = 8; // Item
  ws.getColumn(2).width = 25; // Nro Leasing
  ws.getColumn(3).width = 30; // Banco
  ws.getColumn(4).width = 20; // Cantidad
  ws.getColumn(5).width = 30; // Fecha inicio
  ws.getColumn(6).width = 30; // Fecha fin
  ws.getColumn(7).width = 20; // Periodo
  ws.getColumn(8).width = 45; // Cliente
  ws.getColumn(9).width = 45; // Cliente Origen
  ws.getColumn(10).width = 40; // Contrato / Adenda

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
  link.download = `Gescon_Reporte_Leasings_${new Date().toLocaleDateString()}.xlsx`;
  link.click();
}

function convertirFecha(date) {
  const fecha = `${date}`;

  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

function transformType(value, object) {
  return object[value];
}

function obtenerDiasVencimiento(fecha) {
  const fechaActual = new Date(Date.now());
  const fechaFin = new Date(fecha);
  const diferenciaTiempo = fechaFin - fechaActual;
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}
