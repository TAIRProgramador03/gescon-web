const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
    timeout: 3000,
  });
};

let instance;

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

export const getVehiclesPending = async (idCli, idOpe) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/vehiculosPendientesReasginar", {
      withCredentials: true,
      params: {
        idCli,
        idOpe,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getVehiclesNoPending = async (idCli, idOpe) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/vehiculosReasginar", {
      withCredentials: true,
      params: {
        idCli,
        idOpe,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getClients = async () => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/clientes", {
      withCredentials: true,
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getContracts = async (idCli) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/contratosNroAdi", {
      withCredentials: true,
      params: {
        idCli,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getContractId = async (id) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get(`/contratoPorId/${id}`, {
      withCredentials: true,
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getDocumentId = async (id) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get(`/obtenerDocumentoPorId/${id}`, {
      withCredentials: true,
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export const getOperations = async (idCli) => {
  try {
    instance = await obtenerInstancia();
    const response = await instance.get("/operacionesAsig", {
      withCredentials: true,
      params: {
        idCli,
      },
    });

    return response.data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

export async function uploadFileS3(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "reassignment-records");

  try {
    instance = await obtenerInstancia();

    const response = await instance.post(`/subirArchivo`, formData, {
      withCredentials: "include",
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    const result = await response.data;
    if (!result.success) {
      toastr.warning(result.message, "Oops...");
    }

    return result;
  } catch (error) {
    console.error(error.response.data);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

export async function saveOperation(id, data) {
  try {
    instance = await obtenerInstancia();

    const response = await instance.post(`/traspasarOperacion/${id}`, data, {
      withCredentials: true,
    });

    const result = response.data;

    return result;
  } catch (error) {
    $("#btn-guardar").find(".spinner").addClass("hidden");
    $("#btn-guardar").prop("disabled", false);

    console.error(error.response.data);
    toastr.warning(error.response.data.message, "Oops...");
  }
}

export const validInputDate = (e) => {
  let value = e.target.value.replace(/\D/g, ""); // solo números

  if (value.length >= 3 && value.length <= 4) {
    value = value.slice(0, 2) + "/" + value.slice(2);
  } else if (value.length >= 5) {
    value =
      value.slice(0, 2) + "/" + value.slice(2, 4) + "/" + value.slice(4, 8);
  }

  e.target.value = value;
};

export function convertirFecha(date) {
  const fecha = `${date}`;
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

export const manejarArchivo = (file) => {
  if (!file) return null;

  // Validación básica (PDF opcional)
  if (file.type !== "application/pdf") {
    toastr.warning("Solo se permiten archivos PDF", "Cuidado");
    return null;
  }

  // Mostrar info
  $("#nombreArchivo").text(file.name);

  // Cambiar vista
  $("#contenedorArchivo .flex-col.hidden")
    .removeClass("hidden")
    .addClass("flex");

  $("#contenedorArchivo .flex-col.text-gray-400").addClass("hidden");

  $("#labelActa").removeClass("flex").addClass("hidden");

  // Guardar archivo en input (para backend)
  const dt = new DataTransfer();
  dt.items.add(file);
  $("#acta")[0].files = dt.files;

  return file;
};
