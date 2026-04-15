const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `http://${IP_LOCAL}:3000`,
    timeout: 3000,
  });
};

let instance;

export const getNewUsers = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerNuevosUsuarios", {
      withCredentials: true,
    });

    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
}

export const getRoles = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerRoles", {
      withCredentials: true,
    });

    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message)
    toastr.error(error.response.data.message, "Oops...")
  }
}