const getLeasings = async (bank, clientId, contractId, typeContract) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingAll${bank ? `?bank=${bank}` : ""}${clientId ? `&clientId=${clientId}` : ""}${contractId ? `&contractId=${contractId}` : ""}${typeContract ? `&typeContract=${typeContract}` : ""}`,
    {
      credentials: 'include'
    }
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
    credentials: 'include'
  })

  const data = await response.json();

  return data;
}

const getContractsByClient = async (clientId) => {
  const response = await fetch(`http://${IP_LOCAL}:3000/contratosNro?idCli=${clientId}`, {
    credentials: 'include'
  })

  const data = await response.json();

  return data;
}

const getDocumentsByContract = async (contractId, clientId) => {
  const response = await fetch(`http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contractId}&clienteId=${clientId}`, {
    credentials: 'include'
  })

  const data = await response.json();

  return data;
}

const verPdf = (link) => {
  window.open(link, '_blank');
}

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${dia}/${mes}/${anio}`;
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