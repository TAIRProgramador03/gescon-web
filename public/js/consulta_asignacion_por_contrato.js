const IP_LOCAL = "localhost";

/**
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
const getAssigns = async (contratoId, leasingId, tipoTerr) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/asignacionPorContrato?idContrato=${contratoId.toString()}${leasingId ? `&idLeasing=${leasingId}` : ""}${tipoTerr ? `&tipoTerr=${tipoTerr}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const assigns = await response.json();

  return assigns;
};

const getLeasings = async (contratoId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByContract?contratoId=${contratoId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const lesaings = await response.json();

  return lesaings;
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
