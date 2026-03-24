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

const getLeasings = async (contratoId, clienteId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByContract?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
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

const getDetailLeasing = async (
  leasingId,
  nroLeasing,
  clienteId,
  contratoId,
) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/detailLeasing?leasingId=${leasingId.toString()}&nroLeasing=${nroLeasing.trim()}&clienteId=${clienteId.toString()}&contratoId=${contratoId.toString()}&tipoCont=P`,
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

const getAssignByLeasing = async (nroLeasing, clienteId, contratoId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/assignByLeasing?nroLeasing=${nroLeasing}&clienteId=${clienteId}&contratoId=${contratoId}&tipoCont=P`,
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
  const fechaFin = new Date(fecha);
  const fechaActual = new Date(Date.now());
  const diferenciaTiempo = fechaFin - fechaActual;
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}
