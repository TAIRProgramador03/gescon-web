// const IP_LOCAL = "localhost";

const getDocuments = async (contratoId, clienteId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const documents = await response.json();

  return documents;
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
};

const getVehByDocument = async (documentoId, tipoTerr) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/placasPorDocumento?documentoId=${documentoId.toString()}&tipoTerr=${tipoTerr}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();
  
  if(!response.ok) {
    toastr.error(data.message);
  }

  return data;
};

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}
