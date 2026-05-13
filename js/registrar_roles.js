const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
    timeout: 3000,
  });
};

let instance;

export const getPermissions = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerPermisos", {
      withCredentials: true,
    });

    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
};

export const registerRole = async (data) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.post(
      "/crearRol",
      {
        name: data.name,
        description: data.description,
        permissions: data.permissions,
      },
      {
        withCredentials: true,
      },
    );

    const result = response.data;

    if (result.success) {
      toastr.success("Rol registrado correctamente", "¡Éxito!");
      limpiar();
    } else {
      toastr.warning(result.message, "Oops...");
    }
  } catch (error) {
    console.error(error.response.data.message);
    toastr.warning(error.response.data.message, "Oops...");
  }
};

const limpiar = () => {
  $('input[name="name"]').val("");
  $('input[name="descripcion"]').val("");
  $(".permission-checkbox").prop("checked", false);
}

export const convertTitle = (str) => {
  return str
    .split("_")
    .map((text) => text.charAt(0).toUpperCase() + text.slice(1).toLowerCase())
    .join(" ");
};
