// const IP_LOCAL = "localhost";

const getVehicles = async (contratoId, clienteId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/vehiculosPorContrato?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const vehicles = await response.json();

  return vehicles;
};

// const getDetailDocument = async (documentoId) => {
//   const response = await fetch(
//     `http://${IP_LOCAL}:3000/detalleDocumento?documentoId=${documentoId.toString()}`,
//     {
//       method: "GET",
//       credentials: "include",
//     },
//   );

//   const data = await response.json();

//   return data;
// }

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

function transformType(value, object) {
  return object[value];
}