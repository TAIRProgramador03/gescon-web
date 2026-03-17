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

    let sumContra =
      conContrato.data.PADRE +
      conContrato.data.TIPO_1 +
      conContrato.data.TIPO_2 +
      conContrato.data.TIPO_3;

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

async function cargarContClient() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/contCliente`, {
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });
    if (!response.ok) throw new Error("Error en la solicitud");

    const { data } = await response.json();

    // Extraer los nombres y valores del Top 3
    const labels = data.map((cliente) => cliente.CLIABR); // Abreviaciones de los clientes
    const values = data.map((cliente) => cliente.TOTAL_VEHICULOS); // Cantidad de vehículos

    actualizarGrafico(labels, values); // Llamar a la función para actualizar el gráfico
  } catch (error) {
    console.error("Error al cargar los contadores:", error);
  }
}

let myChart; // Variable global para guardar la instancia del gráfico

function actualizarGrafico(labels, data) {
  const ctx = document.getElementById("salesChart").getContext("2d");

  if (myChart) myChart.destroy(); // Destruir el gráfico anterior si ya existe

  myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels, // Nombres de los clientes
      datasets: [
        {
          label: "Total Vehículos",
          data: data, // Valores de los vehículos
          backgroundColor: "#a5b4fc",
          borderColor: "#6366f1",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          enabled: true,
          backgroundColor: "#1e293b",
          titleColor: "#ffffff",
          bodyColor: "#ffffff",
        },
        legend: {
          labels: {
            color: "#ffffff",
          },
        },
      },
      scales: {
        x: {
          ticks: {
            color: "#ffffff",
          },
        },
        y: {
          ticks: {
            color: "#ffffff",
          },
        },
      },
    },
  });
}

async function cargarTablaconVehiculo() {
  const response = await fetch(`http://${IP_LOCAL}:3000/tablaconVehiculo`, {
    credentials: "include",
  });

  const conVehi = await response.json();

  return conVehi;
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
      credentials: 'include'
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
      credentials: 'include'
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerVehiculosVencidos(draw, currentPage, length, label, search, clientId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/listVehicleExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: 'include'
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerVehiculosPorVencer(draw, currentPage, length, label, search, clientId) {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/listVehicleToExpires?draw=${draw}&start=${currentPage}&length=${length}&label=${label}&search=${search}${clientId ? `&clienteId=${clientId}` : ""}`,
    {
      method: "GET",
      credentials: 'include'
    },
  );

  const res = await response.json();

  return res;
}

async function obtenerTotalVehiculosPorCliente(clientsId) {
  const query = clientsId
  .map(cli => `clientesId=${cli}`)
  .join("&")

  const response = await fetch(
    `http://${IP_LOCAL}:3000/contVehicleByClient?${query}`,
    {
      method: "GET",
      credentials: 'include'
    },
  );

  const res = await response.json();

  return res;
}