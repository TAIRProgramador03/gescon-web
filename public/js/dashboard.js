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

async function cargarContContrato(clientId) {
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/contContrato${clientId ? `?clienteId=${clientId}` : ""}`,
      {
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    ); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const conContrato = await response.json();

    document.getElementById("con-Contra").textContent =
      conContrato.data.PADRE || "0";
    document.getElementById("con-Adenda").textContent =
      conContrato.data.TIPO_1 || "0";
    document.getElementById("con-Carta").textContent =
      conContrato.data.TIPO_2 || "0";
    document.getElementById("con-OC").textContent =
      conContrato.data.TIPO_3 || "0";
  } catch (error) {
    console.error("Error al cargar los contadores:", error);
  }
}

async function obtenerFlotaVehicular(status, clientId) {
  let paramsString = "";

  if (status && clientId) {
    paramsString = `?status=${status}&clienteId=${clientId}`;
  } else if (status) {
    paramsString = `?status=${status}`;
  } else if (clientId) {
    paramsString = `?clienteId=${clientId}`;
  }

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleFleet${paramsString}`,
    {
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
}

async function obtenerClientes() {
  const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
    credentials: "include",
  });

  const data = await response.json();

  return data;
}

async function obtenerLeasings(draw, currentPage, length, search, clientId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleLeasing?draw=${draw}&start=${currentPage}&length=${length}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerCantidadVehicle(clientId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/contLeasing${clientId ? `?clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerVehiculosVencidos(
  draw,
  currentPage,
  length,
  label,
  search,
  clientId,
) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/listVehicleExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerVehiculosPorVencer(
  draw,
  currentPage,
  length,
  label,
  search,
  clientId,
) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/listVehicleToExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerTotalVehiculosPorCliente(clientsId) {
  const query = clientsId.map((cli) => `clientesId=${cli}`).join("&");

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleByClient?${query}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerContratos(clientId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/contratosNro${clientId ? `?idCli=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerLeasingsPorContrato(contractId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/leasingByContract${contractId ? `?contratoId=${contractId}` : ""}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerDiasContratoLeasing(contractId, leasingId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/contComparationDays?contractId=${contractId}&leasingId=${leasingId}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerModelosGenericos() {
  const response = await fetch(`http://${IP_LOCAL}:3000/modedosGenericos`, {
    method: "GET",
    credentials: "include",
  });

  const res = await response.json();

  return res;
}

async function obtenerAñosPorModelo(modelId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/aniosPorModelo?modelId=${modelId}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerTotalCostoPorModelo(modelId, years) {
  const query = years.map((year) => `years=${year}`).join("&");

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contTotalPriceModel?modelId=${modelId}&${query}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const res = await response.json();

  return res;
}

function generarColor() {
  const r = Math.floor(Math.random() * 256);
  const g = Math.floor(Math.random() * 256);
  const b = Math.floor(Math.random() * 256);
  
  return [`rgba(${r}, ${g}, ${b}, 0.2)`, `rgba(${r}, ${g}, ${b})`];
}