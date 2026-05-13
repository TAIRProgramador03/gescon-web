const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
    timeout: 3000,
  });
};

let instance;

export const getPermissions = async(id) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get(`/obtenerPermisosDeUsuario/${id}`, {
      withCredentials: true
    })
    
    const data = response.data;

    return data;
  } catch (error) {
    console.error(error.response.data.message)
    toastr.error(error.response.data.message, "Oops...")
  }
}