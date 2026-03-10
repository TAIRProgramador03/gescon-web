// const IP_LOCAL = "localhost";

/**
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
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
