// const IP_LOCAL = "localhost";

/**
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
const getAssigns = async (clienteId, contratoId, leasingId, tipoTerr) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/asignacionPorContrato?idCliente=${clienteId.toString()}${contratoId ? `&idContrato=${contratoId.toString()}` : ""}${leasingId ? `&idLeasing=${leasingId}` : ""}${tipoTerr ? `&tipoTerr=${tipoTerr}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const assigns = await response.json();

  return assigns;
};

const getLeasings = async (clienteId, contratoId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByContract?clienteId=${clienteId.toString()}${contratoId ? `&contratoId=${contratoId.toString()}` : ""}`,
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

function calcularPorcentaje(fechaIni, fechaFinal) {
  const fechaInicio = new Date(fechaIni);
  const fechaFin = new Date(fechaFinal);
  const fechaActual = new Date();

  if (fechaActual > fechaFin) {
    const diffMs = fechaActual - fechaFin;
    const diasVencidos = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    return `Vencido hace ${diasVencidos} días`;
  }

  const tiempoTotal = fechaFin - fechaInicio;

  // INVERSIÓN: Restamos la fecha actual de la fecha fin
  // para obtener cuánto "camino" queda por recorrer.
  const tiempoRestante = fechaFin - fechaActual;

  let porcentaje = Math.round((tiempoRestante / tiempoTotal) * 100);

  // Aseguramos que no baje de 0 ni suba de 100
  porcentaje = Math.min(Math.max(porcentaje, 0), 100);

  return porcentaje;
}
