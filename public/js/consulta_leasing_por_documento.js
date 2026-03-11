const getLeasings = async (documentoId, clienteId) => {
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
      url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
    },
    data: lesaings,
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
          return convertirFecha(data);
        },
        width: "20%",
      },
      {
        data: "fechaFin",
        render: function (data) {
          return convertirFecha(data);
        },
        width: "20%",
      },
      { data: "cantVehi", width: "5%" },
    ],
  });

  return table;
};

const getDetailLeasing = async (leasingId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/detailLeasing?leasingId=${leasingId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
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
  const fechaActual = new Date(Date.now());
  const fechaFin = new Date(fecha);
  const diferenciaTiempo = Math.abs(fechaFin - fechaActual);
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}