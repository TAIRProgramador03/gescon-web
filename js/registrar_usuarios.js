const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
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
};

export const getRoles = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerRoles", {
      withCredentials: true,
    });

    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
};

export const getRolesGesOper = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerRolesGesoper", {
      withCredentials: true,
    });

    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
};

export const registerUser = async (data) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.post(
      "/crearUsuario",
      {
        usuario: data.usuario,
        codEmp: data.codEmp,
        clave: data.clave,
        rol: data.rol,
        perfil: data.perfil,
        inGesoper: data.inGesoper,
      },
      {
        withCredentials: true,
      },
    );

    const result = response.data;

    if(result.success) {
      toastr.success("Usuario registrado correctamente", "¡Éxito!")
    } else {
      toastr.warning(result.message, "Oops...")
    }
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};
