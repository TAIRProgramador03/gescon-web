const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `http://${IP_LOCAL}:3000`,
    timeout: 3000,
  });
};

let instance;

export const getTableUsers = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerUsuarios", {
      withCredentials: true,
    });

    const data = response.data;

    const table = $("#listUsers").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      dom: '<"superior"f<"roles">>rt<"inferior"i<"derecha-inferior"lp>>',
      initComplete: function () {
        $(".roles").html(`
          <div class="flex justify-end items-center gap-2">
            <a href="registrar_usuarios" data-permissions="insertar_usuarios" class="w-fit px-4 py-2 rounded bg-green-800 text-white hover:bg-green-600 transition-colors">
              <i class="bi bi-plus"></i>
              Nuevo
            </a>
            <a href="consultar_roles" data-permissions="administrar_roles" class="w-fit px-4 py-2 rounded bg-blue-800 text-white hover:bg-blue-600 transition-colors">Administrar Roles</a>
          </div>
        `);

        aplicarPermisos();
      },
      scrollCollapse: true,
      scrollY: 550,
      data,
      columnDefs: [
        // Centrar contenido y cabecera en las columnas 0, 1 y 2
        {
          className: "dt-center",
          targets: [0, 1, 2, 3, 4],
        },
      ],
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
          width: "5%",
        },
        {
          data: "usuario",
          width: "40%",
        },
        {
          data: "codEmp",
          render: (data) => {
            return data == "" ? "--" : data;
          },
          width: "15%",
        },
        {
          data: "descripcion",
          render: function (data, type, row) {
            return row.rol.name;
          },
          width: "15%",
        },
        {
          data: null,
          render: function (data, type, row) {
            return `
              <div class="w-full flex flex-wrap justify-center items-center gap-2">
                <button 
                  class="open-modal cursor-pointer flex justify-center items-center gap-1 px-3 py-2 rounded bg-lime-100 border border-lime-500 text-lime-500 hover:bg-lime-500 hover:text-white transition-colors"
                  data-id="${row.id}"
                  >
                    <i class="bi bi-pencil-square"></i>
                  Actualizar rol
                </button>
                <a href="consultar_permisos_por_usuario?usuarioId=${row.id}" class="flex justify-center items-center gap-1 px-3 py-2 rounded bg-cyan-100 border border-cyan-500 text-cyan-500 hover:bg-cyan-500 hover:text-white transition-colors">
                  <i class="bi bi-person-lines-fill"></i>
                  Permisos
                </a>
                <button 
                  class="open-modal-pass cursor-pointer flex justify-center items-center gap-1 px-3 py-2 rounded bg-violet-100 border border-violet-500 text-violet-500 hover:bg-violet-500 hover:text-white transition-colors"
                  data-id="${row.id}"
                  >
                    <i class="bi bi-asterisk"></i>
                  Actualizar contraseña
                </button>
              </div>
            `;
          },
          width: "25%",
        },
      ],
    });

    return table;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
};

export const getUserById = async (id) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get(`/obtenerUsuarioPorId/${id}`, {
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

export const updateRoleUser = async (id, roleId) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.put(`/actualizarUsuario/${id}`, {
      roleId
    }, {
      withCredentials: true
    })

    const data = response.data;

    if(data.success) {
      toastr.success("Rol actualizado correctamente", "¡Éxito!");
    } else {
      toastr.warning(data.message, "Oops...");
    }
  } catch (error) {
    console.error(error.response.data.message)
    toastr.error(error.response.data.message, "Oops...")
  }
}

export const updatePasswordUser = async (id, body) => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.put(`/actualizarClave/${id}`, body, {
      withCredentials: true
    })

    const data = response.data;

    if(data.success) {
      toastr.success("Contraseña actualizada correctamente", "¡Éxito!");
      return true;
    } else {
      toastr.warning(data.message, "Oops...");
      return false;
    }
  } catch (error) {
    console.error(error.response.data)
    toastr.error(error.response.data.message, "Oops...")
    return false;
  }
}