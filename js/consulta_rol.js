const obtenerInstancia = async () => {
  const IP_LOCAL = await obtenerConfig();
  return axios.create({
    baseURL: `${IP_LOCAL}`,
    timeout: 10000,
  });
};

let instance;

export const getTableRoles = async () => {
  try {
    instance = await obtenerInstancia();

    const response = await instance.get("/obtenerRoles", {
      withCredentials: true,
    });

    const data = response.data;

    const table = $("#listRoles").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/2.3.7/i18n/es-ES.json",
      },
      dom: '<"superior"f<"roles">>rt<"inferior"i<"derecha-inferior"lp>>',
      initComplete: function () {
        $(".roles").html(`
          <a href="registrar_roles" data-permissions="administrar_roles" class="w-fit flex justify-center items-center gap-1 px-4 py-2 rounded bg-green-800 text-white hover:bg-green-600 transition-colors">
            <i class="bi bi-plus"></i>
            Crear nuevo rol
          </a>
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
          targets: [0, 1, 2, 3],
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
          data: "name",
          width: "35%",
        },
        {
          data: "descripcion",
          render: (data) => {
            return data == "" ? "--" : data
          },
          width: "30%",
        },
        {
          data: null,
          render: function (data, type, row) {
            return `
              <div class="w-full flex flex-col gap-2">
                <a href="consultar_permisos_por_rol?rolId=${row.id}" class="flex justify-center items-center gap-1 px-3 py-2 rounded bg-cyan-100 border border-cyan-500 text-cyan-500 hover:bg-cyan-500 hover:text-white transition-colors">
                  <i class="bi bi-person-lines-fill"></i>
                  Permisos
                </a>
              </div>
            `;
          },
          width: "10%",
        },
      ],
    });

    return table;
  } catch (error) {
    console.error(error.response.data.message);
    toastr.error(error.response.data.message, "Oops...");
  }
};
