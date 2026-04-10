// const IP_LOCAL = "localhost";
const instance = axios.create({
  baseURL: `http://${IP_LOCAL}:3000`,
  timeout: 3000,
});

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-top-right",
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

/**
 * Método para traer la lista de documentos de un contrato especifico
 * @param contratoId Nro de contrato
 */
export const getAssigns = async (clienteId, contratoId, leasingId, tipoTerr, status) => {
  const response = await instance.get(`/trazabilidadPlaca`, {
    withCredentials: true,
    params: {
      idCliente: clienteId,
      idContrato: contratoId,
      idLeasing: leasingId,
      tipoTerr: tipoTerr,
      status
    },
  });

  const assigns = await response.data;

  return assigns;
};

export const getLeasings = async (clienteId, contratoId) => {
  const response = await instance.get(
    `/leasingGeneral`,
    {
      withCredentials: true,
      params: {
        clienteId,
        contratoId
      }
    },
  );

  return response.data;
};

export const getClients = async () => {
  const response = await instance.get("/clientes", {
    withCredentials: true,
  })

  return response.data;
}

export const getContracts = async (clientId) => {
  const response = await instance.get("/contratosNroAdi", {
    withCredentials: true,
    params: {
      idCli: clientId
    }
  })

  return response.data;
}

const getFile = async (key) => {
  try {
    const viewPDF = await fetch(
      `http://${IP_LOCAL}:3000/previsualizarArchivo?key=${key}`,
      {
        credentials: "include",
      },
    );

    const result = await viewPDF.json();

    if (result.success) {
      return result.url;
    } else {
      toastr.warning(result.message, "Oops...");
    }
  } catch (error) {
    console.error(error);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const verPdf = async (key) => {
  const link = await getFile(key);

  window.open(link, "_blank");
};

export function calcularPorcentaje(fechaIni, fechaFinal) {
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