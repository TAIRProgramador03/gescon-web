const getLeasings = async (bank, clientId, contractId, typeContract) => {
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
  const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
    credentials: "include",
  });

  const data = await response.json();

  return data;
};

const getContractsByClient = async (clientId) => {
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
  const response = await fetch(
    `http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contractId}&clienteId=${clientId}`,
    {
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

const verPdf = (link) => {
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
            <th class="!font-medium text-gray-500">Item</th>
            <th class="!font-medium text-gray-500">Placa</th>
            <th class="!font-medium text-gray-500">Modelo</th>
            <th class="!font-medium text-gray-500">Marca</th>
            <th class="!font-medium text-gray-500">Terreno</th>
            <th class="!font-medium text-gray-500">Cantidad</th>
            <th class="!font-medium text-gray-500">Año</th>
            <th class="!font-medium text-gray-500">Color</th>
            <th class="!font-medium text-gray-500">Operación</th>
            <th class="!font-medium text-gray-500">Fecha Fin</th>
            <th class="!font-medium text-gray-500">Vence en</th>
            <th class="!font-medium text-gray-500">Leasing</th>
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
    dom: '<"superior"fB>rt<"inferior"i<"derecha-inferior"lp>>',
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
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
        data: "modelo",
      },
      {
        data: "marca",
      },
      {
        data: "terreno",
      },
      {
        data: "cantidad",
        render: (data) => {
          return `${data} und.`;
        },
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
      {
        data: "nroLeasing",
      },
    ],
  });
};

function convertirFecha(fecha) {
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
