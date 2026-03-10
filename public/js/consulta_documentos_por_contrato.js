// const IP_LOCAL = "localhost";

/**
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
const getDocuments = async (contratoId, clienteId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const documents = await response.json();

  // INTEGRAMOS LA LIBRERIA DATATABLE
  const table = $("#listDocuments").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
    },
    data: documents,
    columns: [
      {
        data: "item",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
        width: "5%",
      },
      {
        data: "nroDocumento",
      },
      {
        data: "fechaFirma",
        render: function (data) {
          return convertirFecha(data);
        },
        width: "20%",
      },
      {
        data: "duracion",
        render: function (data) {
          return data && data != "0" ? data + " meses" : "Sin periodo";
        },
        width: "20%",
      },
      { data: "cantVehi", width: "5%" },
    ],
  });

  return table;
};

const getDetailDocument = async (documentoId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/detalleDocumento?documentoId=${documentoId.toString()}`,
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
