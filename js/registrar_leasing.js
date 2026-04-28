import { animate } from "https://cdn.jsdelivr.net/npm/motion@10/+esm";

let activeRequests = 0;

function showLoader() {
  activeRequests++;
  $("#preloader-mini").css("opacity", "1");
  $("#preloader-mini").css("z-index", "99999");
}

function hideLoader() {
  activeRequests--;
  if (activeRequests <= 0) {
    animate(
      "#preloader-mini",
      {
        opacity: [1, 0],
      },
      {
        duration: 0.45,
        easing: "ease-in",
      },
    );

    setTimeout(() => {
      // $('#preloader-mini').css('opacity', '0');
      $("#preloader-mini").css("z-index", "-99999");
    }, 400);
  }
}

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

let [listVehicles, setListVehicles] = useState([]);
let [clientId, setClientId] = useState(null);
let [clientAsocId, setClientAsocId] = useState(null);
let [clientAsocName, setClientAsocName] = useState("");

document.addEventListener("DOMContentLoaded", () => {
  showLoader();

  $("#combo-box-asig").select2({
    placeholder: "Seleccione un contrato",
    allowClear: false,
    width: "100%",
  });

  $("#banco").select2({
    placeholder: "Seleccione un contrato",
    allowClear: false,
    width: "100%",
  });

  document.getElementById("btnClear").addEventListener("click", limpiarCampos);

  // Cargar las tablas

  localStorage.setItem("clienteSeleccionadoID", "");
  localStorage.setItem("clienteSeleccionadoNombre", "");
  cargartablaClienteLeas();
  cargartablaClienteLeasAsoc();
  cargartablaVehiculo();

  // Manejo de cierre de modal de cliente
  const closeModalCli = document.getElementById("closeModalCli");
  if (closeModalCli) {
    closeModalCli.addEventListener("click", () => {
      // Tu código aquí
    });
  }

  // Manejo de cierre de modal de vehículo
  const closeModalVehi = document.getElementById("closeModalVehi");
  if (closeModalVehi) {
    closeModalVehi.addEventListener("click", () => {
      // Tu código aquí
    });
  }

  // Buscador para la tabla de clientes
  const buscador = document.getElementById("buscadorTabla");
  if (buscador) {
    buscador.addEventListener("input", function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll(".tabla-form-cli table tbody tr");

      filas.forEach((fila) => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? "" : "none";
      });
    });
  }

  // Buscador para la tabla de clientes
  const buscadorAsoc = document.getElementById("buscadorTablaAsoc");
  if (buscadorAsoc) {
    buscadorAsoc.addEventListener("input", function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll(
        ".tabla-form-cli-asoc table tbody tr",
      );

      filas.forEach((fila) => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? "" : "none";
      });
    });
  }

  // Buscador para la tabla de vehículos
  const buscadorVehi = document.getElementById("buscadorTablaVehi");
  if (buscadorVehi) {
    buscadorVehi.addEventListener("input", function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll(
        ".tabla-form-vehi table tbody tr",
      );

      filas.forEach((fila) => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? "" : "none";
      });
    });
  }

  $("#useAssociatedClient").change(function () {
    const clientID = localStorage.getItem("clienteSeleccionadoID");
    const inputClient = $("#inputClienteSeleccionado");
    const inputAsociate = $("#inputClienteAsociado");

    const btnAsociate = $("#openModalCliAsoc");
    if ($(this).is(":checked")) {
      btnAsociate.prop("disabled", false);
      inputAsociate.val("");
      setClientAsocId(null);
      setClientAsocName("");
    } else {
      btnAsociate.prop("disabled", true);
      inputAsociate.val(inputClient.val());
      setClientAsocId(clientID);
      setClientAsocName(inputClient.val());
    }
  });

  flatpickr("#fechaIni", {
    dateFormat: "d/m/Y",
    locale: "es",
    allowInput: true,
    clickOpens: true,
  });

  flatpickr("#fechaFin", {
    dateFormat: "d/m/Y",
    locale: "es",
    allowInput: true,
    clickOpens: true,
  });

  hideLoader();
});

const validInputDate = (e) => {
  let value = e.target.value.replace(/\D/g, ""); // solo números

  if (value.length >= 3 && value.length <= 4) {
    value = value.slice(0, 2) + "/" + value.slice(2);
  } else if (value.length >= 5) {
    value =
      value.slice(0, 2) + "/" + value.slice(2, 4) + "/" + value.slice(4, 8);
  }

  e.target.value = value;
};

document.getElementById("fechaIni").addEventListener("input", function (e) {
  validInputDate(e);
});

document.getElementById("fechaFin").addEventListener("input", function (e) {
  validInputDate(e);
});

// document.addEventListener("DOMContentLoaded", cargarSeleccionados);

async function cargartablaClienteLeas() {
  document
    .getElementById("openModalCli")
    .addEventListener("click", async function () {
      try {
        const IP_LOCAL = await obtenerConfig();

        const response = await fetch(
          `http://${IP_LOCAL}:3000/tablaClienteLeas`,
          {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          },
        );
        const contratos = await response.json();
        const tbody = document.querySelector(".tabla-form-cli table tbody");

        tbody.innerHTML = ""; // Limpiar tabla
        if (contratos.length === 0) {
          tbody.innerHTML = `<tr><td colspan="6">No hay clientes disponibles</td></tr>`;
          return;
        }

        contratos.forEach((cliente, index) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                    <td class="icono-seleccion" data-id="${
                      cliente.IDCLI
                    }" data-nombre="${cliente.CLINOM}">
                        <i class="fas fa-check-circle" style="color: green; font-size: 22px;"></i>
                    </td>
                    <td>${cliente.CLIRUC}</td>
                    <td>${cliente.CLINOM || "Sin nombre"}</td>
                    <td>${cliente.CLIDIR || "Sin dirección"}</td>
                    <td>${cliente.IDCLI || "0"}</td>
                    <td>${cliente.CLIABR || "0"}</td>
                `;
          tbody.appendChild(row);
        });

        agregarEventosSeleccion();
        restaurarSeleccionCliente(); // Restaurar selección después de cargar datos
      } catch (error) {
        toastr.warning(
          "Error al obtener los datos. Inténtelo de nuevo más tarde.",
          "Oops...",
        );
      }
    });
}

async function cargartablaClienteLeasAsoc() {
  $("#openModalCliAsoc").on("click", async function () {
    try {
      const IP_LOCAL = await obtenerConfig();

      const response = await fetch(`http://${IP_LOCAL}:3000/tablaClienteLeas`, {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      });
      const contratos = await response.json();
      const tbody = document.querySelector(".tabla-form-cli-asoc table tbody");

      tbody.innerHTML = ""; // Limpiar tabla
      if (contratos.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6">No hay clientes disponibles</td></tr>`;
        return;
      }

      contratos.forEach((cliente, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td class="icono-seleccion-asoc" data-id="${
                      cliente.IDCLI
                    }" data-nombre="${cliente.CLINOM}">
                        <i class="fas fa-check-circle" style="color: green; font-size: 22px;"></i>
                    </td>
                    <td>${cliente.CLIRUC}</td>
                    <td>${cliente.CLINOM || "Sin nombre"}</td>
                    <td>${cliente.CLIDIR || "Sin dirección"}</td>
                    <td>${cliente.IDCLI || "0"}</td>
                    <td>${cliente.CLIABR || "0"}</td>
                `;
        tbody.appendChild(row);
      });

      agregarEventosSeleccionAsoc();
      restaurarSeleccionClienteAsoc(); // Restaurar selección después de cargar datos
    } catch (error) {
      toastr.warning("No se pudo listar los clientes", "Oops...");
    }
  });
}

function agregarEventosSeleccion() {
  const checked = $("#useAssociatedClient");
  const filas = document.querySelectorAll(".icono-seleccion");

  filas.forEach((fila) => {
    fila.addEventListener("click", function () {
      document.querySelectorAll(".icono-seleccion i").forEach((icono) => {
        icono.classList.remove("fa-times-circle");
        icono.classList.add("fa-check-circle");
        icono.style.color = "green";
      });

      if (this.classList.contains("seleccionado")) {
        this.classList.remove("seleccionado");
        this.querySelector("i").classList.remove("fa-times-circle");
        this.querySelector("i").classList.add("fa-check-circle");
        this.querySelector("i").style.color = "green";

        // Limpiar selección
        localStorage.removeItem("clienteSeleccionadoID");
        localStorage.removeItem("clienteSeleccionadoNombre");
        document.getElementById("inputClienteSeleccionado").value = "";
        if (!checked.prop("checked")) {
          setClientAsocId(null);
          document.getElementById("inputClienteAsociado").value = "";
        }
      } else {
        filas.forEach((f) => f.classList.remove("seleccionado"));
        this.classList.add("seleccionado");
        this.querySelector("i").classList.remove("fa-check-circle");
        this.querySelector("i").classList.add("fa-times-circle");
        this.querySelector("i").style.color = "red";

        const clienteID = this.dataset.id;
        const clienteNombre = this.dataset.nombre;
        document.getElementById("inputClienteSeleccionado").value =
          `${clienteNombre}`;
        if (!checked.prop("checked")) {
          setClientAsocName(clienteNombre);
          document.getElementById("inputClienteAsociado").value =
            `${clienteNombre}`;
        }
        const seleccionado = document.querySelector(
          ".icono-seleccion.seleccionado",
        );

        if (!seleccionado) {
          toastr.info("Por favor, seleccione un cliente.", "Aviso");
        } else {
          toastr.success("Se agrego el cliente seleccionado", "¡Excelente!");
          cargarContratosPorCliente(clienteID);
          document.getElementById("myModalCli").style.display = "none";
        }
        // Guardar en localStorage
        localStorage.setItem("clienteSeleccionadoID", clienteID);
        localStorage.setItem("clienteSeleccionadoNombre", clienteNombre);
        if (!checked.prop("checked")) {
          setClientAsocId(clienteID);
        }
      }
    });
  });
}

/* 🔹 Restaurar selección al abrir el modal
function restaurarSeleccionCliente() {
    const clienteID = localStorage.getItem('clienteSeleccionadoID');
    const clienteNombre = localStorage.getItem('clienteSeleccionadoNombre');

    if (clienteID && clienteNombre) {
        document.getElementById('inputClienteSeleccionado').value = clienteNombre;
        const fila = document.querySelector(`.icono-seleccion[data-id="${clienteID}"]`);
        if (fila) {
            fila.classList.add('seleccionado');
            const icono = fila.querySelector('i');
            icono.classList.remove('fa-check-circle');
            icono.classList.add('fa-times-circle');
            icono.style.color = 'red';
        }
    }
}*/

function restaurarSeleccionCliente() {
  const clienteID = localStorage.getItem("clienteSeleccionadoID");
  const clienteNombre = localStorage.getItem("clienteSeleccionadoNombre");
  if (clienteID && clienteNombre) {
    // Solo restaurar la selección del cliente
    const fila = document.querySelector(
      `.icono-seleccion[data-id="${clienteID}"]`,
    );
    cargarContratosPorCliente(clienteID);
    if (fila) {
      fila.classList.add("seleccionado");
      const icono = fila.querySelector("i");
      icono.classList.replace("fa-check-circle", "fa-times-circle");
      icono.style.color = "red";
    }
  }
}

function agregarEventosSeleccionAsoc() {
  const filas = document.querySelectorAll(".icono-seleccion-asoc");

  filas.forEach((fila) => {
    fila.addEventListener("click", function () {
      document.querySelectorAll(".icono-seleccion-asoc i").forEach((icono) => {
        icono.classList.remove("fa-times-circle");
        icono.classList.add("fa-check-circle");
        icono.style.color = "green";
      });

      if (this.classList.contains("seleccionado")) {
        this.classList.remove("seleccionado");
        this.querySelector("i").classList.remove("fa-times-circle");
        this.querySelector("i").classList.add("fa-check-circle");
        this.querySelector("i").style.color = "green";

        // Limpiar selección
        $("#inputClienteAsociado").val("");
      } else {
        filas.forEach((f) => f.classList.remove("seleccionado"));
        this.classList.add("seleccionado");
        this.querySelector("i").classList.remove("fa-check-circle");
        this.querySelector("i").classList.add("fa-times-circle");
        this.querySelector("i").style.color = "red";

        // Guardamos el cliente asociado
        setClientAsocId(this.dataset.id);
        setClientAsocName(this.dataset.nombre);
        $("#inputClienteAsociado").val(`${this.dataset.nombre}`);
        const seleccionado = document.querySelector(
          ".icono-seleccion-asoc.seleccionado",
        );

        if (!seleccionado) {
          toastr.info("Por favor, seleccione un cliente asociado.", "Aviso");
        } else {
          toastr.success("Se agrego el cliente asociado", "¡Excelente!");
          document.getElementById("myModalCliAsoc").style.display = "none";
        }
      }
    });
  });
}

function restaurarSeleccionClienteAsoc() {
  const clienteIDAsoc = clientAsocId();

  if (clienteIDAsoc) {
    // Solo restaurar la selección del cliente
    const fila = document.querySelector(
      `.icono-seleccion-asoc[data-id="${clienteIDAsoc}"]`,
    );

    if (fila) {
      fila.classList.add("seleccionado");
      const icono = fila.querySelector("i");
      icono.classList.replace("fa-check-circle", "fa-times-circle");
      icono.style.color = "red";
    }
  }
}

async function cargartablaVehiculo() {
  document
    .getElementById("openModal")
    .addEventListener("click", async function () {
      try {
        const IP_LOCAL = await obtenerConfig();

        // Realiza una solicitud al servidor para obtener los contratos del cliente
        const response = await fetch(`http://${IP_LOCAL}:3000/tablaVehiculo`, {
          method: "GET",
          credentials: "include", // Asegura que las cookies se envíen con la solicitud
        });
        const contratos = await response.json();

        // Verifica si hay contratos disponibles
        if (contratos.length === 0) {
          document.querySelector(".tabla-form-vehi table tbody").innerHTML = `
                    <tr>
                        <td colspan="7">No hay vehiculos disponibles</td>
                    </tr>
                `;
          return;
        }

        // Llena la tabla con los datos de los contratos
        const tbody = document.querySelector(".tabla-form-vehi table tbody");
        tbody.innerHTML = ""; // Limpia las filas existentes  <td>${index + 1}</td> <!-- Número de ítem -->

        contratos.forEach((tablaVehiculo, index) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                    <td class="icono-seleccion" data-id="${
                      tablaVehiculo.ID
                    }" data-nombre="${tablaVehiculo.PLACA}">
                        <i class="fas fa-check-circle" style="color: green; font-size: 22px;"></i>
                    </td>
                    <td>${tablaVehiculo.CODINI}</td> <!-- Número de contrato -->
                    <td>${tablaVehiculo.PLACA}</td> <!-- Número de contrato -->
                    <td>${
                      tablaVehiculo.MARCA || "Sin marca"
                    }</td> <!-- Fecha de firma -->
                    <td>${
                      tablaVehiculo.MODELO || "Sin modelo"
                    }</td> <!-- Periodo -->
                    <td>${
                      tablaVehiculo.GENERICO || "Sin generico"
                    }</td> <!-- Cantidad total -->
                    <td>${
                      tablaVehiculo.TERRENO || "Sin terreno"
                    }</td> <!-- Cantidad total -->
                `;
          tbody.appendChild(row);
        });
        agregarEventosSeleccionVehi();
        restaurarSeleccionVehi();
      } catch (error) {
        toastr.warning("No se pudo obtener la lista de vehiculos", "Oops...");
      }
    });
}

function agregarEventosSeleccionVehi() {
  const filas = document.querySelectorAll(".icono-seleccion");
  const tablaSeleccionados = document.querySelector(
    "#tablaSeleccionados tbody",
  );

  filas.forEach((fila) => {
    fila.addEventListener("click", function () {
      const placaID = this.dataset.id;
      const modelo = this.parentElement.children[4].textContent; // Columna 2 (RUC)
      const terreno = this.parentElement.children[6].textContent; // Columna 3 (Cliente)
      const placa = this.parentElement.children[2].textContent; // Columna 3 (Cliente)
      const codini = this.parentElement.children[1].textContent; // Columna 3 (Cliente)

      // Asegurarse de que localStorage tiene un valor válido antes de hacer JSON.parse()
      let seleccionados = listVehicles();
      seleccionados = seleccionados.length > 0 ? seleccionados : [];

      if (this.classList.contains("seleccionado")) {
        // Quitar selección
        this.classList.remove("seleccionado");
        this.querySelector("i").classList.replace(
          "fa-times-circle",
          "fa-check-circle",
        );
        this.querySelector("i").style.color = "green";

        // Eliminar la fila de la tabla de seleccionados
        document
          .querySelectorAll("#tablaSeleccionados tbody tr")
          .forEach((row) => {
            if (row.dataset.id === placaID) {
              row.remove();
              actualizarContador();
            }
          });

        // Eliminar del localStorage
        seleccionados = seleccionados.filter((item) => item.id !== placaID);
      } else {
        // Agregar selección
        this.classList.add("seleccionado");
        this.querySelector("i").classList.replace(
          "fa-check-circle",
          "fa-times-circle",
        );
        this.querySelector("i").style.color = "red";

        if (
          ![...tablaSeleccionados.children].some(
            (row) => row.dataset.id === placaID,
          )
        ) {
          const nuevaFila = document.createElement("tr");
          nuevaFila.dataset.id = placaID;
          const contador = 0;

          nuevaFila.innerHTML = `
                        <td><input type="text" name="item[]" value="${
                          contador + 1
                        }" disabled></td>
                        <td><input type="text" name="id[]" value="${placaID}" disabled></td>
                        <td><input type="text" name="modelo[]" value="${modelo}" disabled></td>
                        <td><input type="text" name="tipo_terreno[]" value="${terreno}" disabled></td>
                        <td><input type="text" name="placa[]" value="${placa}" disabled></td>
                        <td><input type="text" name="codini[]" value="${codini}" disabled></td>
                        <td><input type="number" name="cantidad[]" value="1" disabled></td>
                    `;

          tablaSeleccionados.appendChild(nuevaFila);

          animate(
            nuevaFila,
            {
              opacity: [0, 1],
              transform: ["translateY(10px)", "translateY(0px)"],
              backgroundColor: ["#07E800", "#ffffff"],
            },
            {
              duration: 0.5,
              easing: "ease-out",
            },
          );

          toastr.success("Se agregó el vehículo seleccionado.", "¡Excelente!");
          actualizarContador();
        }

        // Guardar en localStorage
        seleccionados.push({ id: placaID, modelo, terreno, placa, codini });
      }

      // Guardar el array en un estado
      setListVehicles(seleccionados);
    });
  });
}

function cargarSeleccionados() {
  const tablaSeleccionados = document.querySelector(
    "#tablaSeleccionados tbody",
  );

  // Asegurarse de que localStorage tiene un valor antes de hacer JSON.parse()
  const seleccionados = localStorage.getItem("vehiculosSeleccionados");
  const vehiculos = seleccionados ? JSON.parse(seleccionados) : [];

  // Limpiar la tabla antes de recargar los datos
  tablaSeleccionados.innerHTML = "";

  vehiculos.forEach((vehiculo, index) => {
    const nuevaFila = document.createElement("tr");
    nuevaFila.dataset.id = vehiculo.id;

    nuevaFila.innerHTML = `
            <td><input type="text" name="item[]" value="${
              index + 1
            }" disabled></td>
            <td><input type="text" name="id[]" value="${
              vehiculo.id
            }" disabled></td>
            <td><input type="text" name="modelo[]" value="${
              vehiculo.modelo
            }" disabled></td>
            <td><input type="text" name="tipo_terreno[]" value="${
              vehiculo.terreno
            }" disabled></td>
            <td><input type="text" name="placa[]" value="${
              vehiculo.placa
            }" disabled></td>
            <td><input type="text" name="codini[]" value="${
              vehiculo.codini
            }" disabled></td>
            <td><input type="number" name="cantidad[]" value="1" disabled></td>
        `;

    tablaSeleccionados.appendChild(nuevaFila);
  });

  actualizarContador(); // Para actualizar el número de vehículos
}

// Llamar a la función al cargar la página para restaurar la selección

function restaurarSeleccionVehi() {
  const seleccionados = listVehicles();
  seleccionados.forEach(({ id, modelo, terreno }) => {
    const icono = document.querySelector(`.icono-seleccion[data-id="${id}"] i`);
    if (icono) {
      icono.classList.replace("fa-check-circle", "fa-times-circle");
      icono.style.color = "red";
      document
        .querySelector(`.icono-seleccion[data-id="${id}"]`)
        .classList.add("seleccionado");
    }
  });
  actualizarContador();
}

// 🔹 Función para actualizar el contador en la primera columna
function actualizarContador() {
  const filas = document.querySelectorAll("#tablaSeleccionados tbody tr");
  filas.forEach((fila, index) => {
    fila.children[0].textContent = index + 1;
  });
}
// 🔹 Restaurar selección cuando se abra el modal
document.getElementById("openModal").addEventListener("click", () => {
  setTimeout(restaurarSeleccionVehi, 100); // Pequeño delay para asegurar que la tabla ya se cargó
});

function mostrarNotificacion(mensaje, color) {
  const notification = document.getElementById("notification");
  notification.textContent = mensaje;
  notification.style.backgroundColor = color || "#01b204"; // Verde suave por defecto
  notification.classList.add("show");

  // Mostrar la notificación con el efecto
  setTimeout(() => {
    notification.classList.remove("show");
  }, 3000);
}

function showSpinner(element) {
  // Cambiar cursor al boton
  $(element).removeClass("cursor-pointer").addClass("cursor-progress");

  // Mostrar background
  $(element).find(".backgroud-spinner").addClass("w-full").removeClass("w-1/4");

  // Ocultar icono
  $(element).find(".icon-btn").addClass("hidden");

  // Mostrar spinner
  $(element).find(".spinner").removeClass("hidden");
  $(element).prop("disabled", true);
}

function hideSpinner(element) {
  // Cambiar cursor al boton
  $(element).addClass("cursor-pointer").removeClass("cursor-progress");

  // Ocultar background
  $(element).find(".backgroud-spinner").removeClass("w-full").addClass("w-1/4");

  // Ocultar spinner
  $(element).find(".spinner").addClass("hidden");
  $(element).prop("disabled", false);

  // Mostrar icono
  $(element).find(".icon-btn").removeClass("hidden");
}

async function guardaLeasing() {
  // Obtener valores de los campos del formulario
  let formData = {
    //idCliente: document.querySelector("#combo-cliente").value,
    idCliente: localStorage.getItem("clienteSeleccionadoID"),
    idClienteAsoc: clientAsocId(),
    nroLeasing: textoAGuiones(document.querySelector("#NroLeasing").value),
    banco: $("#banco").val(),
    cantVehiculos: document.querySelector("#cantVehi").value,
    fechaIni: document.querySelector("#fechaIni").value
      ? dayjs(document.querySelector("#fechaIni").value, "DD/MM/YYYY").format(
          "YYYY-MM-DD",
        )
      : null,
    fechaFin: document.querySelector("#fechaFin").value
      ? dayjs(document.querySelector("#fechaFin").value, "DD/MM/YYYY").format(
          "YYYY-MM-DD",
        )
      : null,
    periGracia: document.querySelector("#periGracia").value || "0",
    idContrato: $("#combo-box-asig").val(),
    //story: document.querySelector("#fileInput").value
  };

  if (!formData.fechaIni || !formData.fechaFin) {
    toastr.info("Las fechas son obligatorias", "Aviso");
    return;
  } else {
    const fechaInicio = new Date(formData.fechaIni);
    const fechaFinal = new Date(formData.fechaFin);

    if (fechaFinal <= fechaInicio) {
      toastr.info(
        "La fecha de finalización debe ser mayor que la fecha de inicio.",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.cantVehiculos.length; i++) {
    if (formData.cantVehiculos[i] >= 10) {
      toastr.info(
        "La cantidad de vehiculo no es inválido, solo debe contener números",
        "Aviso",
      );
      return;
    }
  }

  for (let i = 0; i < formData.periGracia.length; i++) {
    if (formData.periGracia[i] >= 10) {
      toastr.info(
        "El periodo de gracia no es inválido, solo debe contener números",
        "Aviso",
      );
      return;
    }
  }

  // Validación de campos obligatorios
  if (
    !formData.idCliente ||
    !formData.idClienteAsoc ||
    !formData.nroLeasing ||
    !formData.banco ||
    !formData.cantVehiculos ||
    !formData.fechaIni ||
    !formData.fechaFin ||
    !formData.idContrato
  ) {
    toastr.info("Por favor, completa todos los campos obligatorios.", "Aviso");
    return;
  }

  let conta = 0;
  // Obtener detalles de contratos
  const detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
    .map((fila, index) => {
      let modelo = fila.querySelector('input[name="modelo[]"]').value;
      let tipoTerreno = fila.querySelector(
        'input[name="tipo_terreno[]"]',
      ).value;
      let numpla = fila.querySelector('input[name="placa[]"]').value;
      let codini = fila.querySelector('input[name="codini[]"]').value;
      let cantidad = fila.querySelector('input[name="cantidad[]"]').value;
      let idpla = fila.querySelector('input[name="id[]"]').value;

      // Validación y asignación de valores predeterminados
      numpla = numpla === "" ? 0 : numpla;
      cantidad = cantidad === "" ? 0 : cantidad;
      conta = conta + 1;
      return modelo && numpla && cantidad
        ? {
            secCon: index + 1,
            modelo,
            tipoTerreno,
            numpla,
            codini,
            cantidad,
            idpla,
          }
        : null;
    })
    .filter(Boolean);

  if (formData.cantVehiculos != conta) {
    toastr.info(
      "Debe coincidir la cantidad de vehiculos con los vehiculos seleccionados.",
      "Aviso",
    );
    return;
  }

  /*const fileInput = document.querySelector("#fileInput");
    const fileData = fileInput.files.length > 0 ? await leerArchivoBase64(fileInput.files[0]) : null;*/

  // Construcción del objeto final de datos
  //const contratoData = { ...formData, detalles, archivoPdf: fileData };

  const uploadFile = await subirArchivo(fileInput.files[0]);
  const nombreArchivo = uploadFile.key;

  // Construcción del objeto final de datos
  const contratoData = { ...formData, detalles, archivoPdf: nombreArchivo };

  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/insertaLeasing`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(contratoData),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (result.success) {
      toastr.success("Leasing guardado exitosamente", "¡Excelente!");
      // await subirArchivo(fileInput.files[0]);
      limpiarCampos();
    } else {
      toastr.warning("No se pudo guardar el leasing", "Oops...");
    }
  } catch (error) {
    const mensaje =
      error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    console.error("Error al enviar los datos:", error);
    toastr.warning(`Ocurrio algo al guardar: ${mensaje}`, "Oops...");
  }
}

$("#grabarButton").on("click", async function () {
  showSpinner(this);

  await guardarLeasing();

  hideSpinner(this);
});

async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "leasings");

  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
      method: "POST",
      enctype: "multipart/form-data",
      body: formData,
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (!result.success) {
      toastr.warning("No se pudo subir el archivo PDF", "Oops...");
    }

    return result;
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    toastr.warning(
      "Sucedio algo inesperado al intentar subir el archivo",
      "Oops...",
    );
  }
}

async function validarArchivo(nombreArchivo) {
  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(
      `http://${IP_LOCAL}:3000/validarArchivo?nombre=${nombreArchivo}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const result = await response.json();

    if (result.existe) {
      toastr.info("El archivo PDF ya existe en el servidor", "Aviso");
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error("Error al validar archivo PDF:", error);
    toastr.warning("No se pudo validar el archivo PDF", "Oops...");
    return false;
  }
}

function limpiarCampos() {
  // Limpiar los campos de texto (inputs)
  document.getElementById("inputClienteSeleccionado").value = "";
  document.getElementById("inputClienteAsociado").value = "";
  document.getElementById("NroLeasing").value = "";
  document.getElementById("banco").value = "";
  //document.getElementById('banco').value = "";
  resetSelect("combo-box-asig", "Seleccione un contrato");
  document.getElementById("cantVehi").value = "0";
  document.getElementById("fechaIni").value = "";
  document.getElementById("fechaFin").value = "";
  document.getElementById("periGracia").value = "0";

  // Limpiar los valores de los divs (contenidos de texto)
  document.getElementById("fileInput").value = ""; // Esto limpia el archivo seleccionado
  document.getElementById("fileName").textContent = ""; // Esto limpia el nombre del archivo mostrado
  document.getElementById("fileInfo").style.display = "none"; // Oculta el área de información del archivo
  const uploadMessage = $("#uploadMessage");
  uploadMessage.addClass("flex");
  uploadMessage.removeClass("hidden");

  // Limpiar el checkbox
  localStorage.setItem("clienteSeleccionadoID", "");
  localStorage.setItem("clienteSeleccionadoNombre", "");

  // Limpiar la tabla de contratos
  const tbodyContratos = document.getElementById("contratos-tbody");
  tbodyContratos.innerHTML = ""; // Vaciar la tabla de contratos

  // **LIMPIAR LA TABLA DE VEHÍCULOS SELECCIONADOS**
  setListVehicles([]); // Eliminar los vehículos guardados en estado
  const tbodyVehiculos = document.querySelector("#tablaSeleccionados tbody");
  tbodyVehiculos.innerHTML = ""; // Vaciar la tabla de vehículos seleccionados

  // Remover la clase 'seleccionado' de los íconos de selección
  document.querySelectorAll(".icono-seleccion").forEach((icono) => {
    icono.classList.remove("seleccionado");
    icono
      .querySelector("i")
      .classList.replace("fa-times-circle", "fa-check-circle");
    icono.querySelector("i").style.color = "green";
  });

  actualizarContador(); // Asegurar que el contador también se reinicie
}

function resetSelect(idSelect, defaultText) {
  const select = document.getElementById(idSelect);
  if (select.options.length > 0) {
    select.selectedIndex = 0; // Selecciona la opción por defecto
    select.options[0].textContent = defaultText; // Actualiza el texto de la opción
  }
}

async function cargarContratosPorCliente(idCli) {
  const comboContrato = document.getElementById("combo-box-asig");

  if (!idCli) {
    comboContrato.innerHTML =
      '<option value="">Seleccione un contrato</option>';
    return;
  }

  try {
    const IP_LOCAL = await obtenerConfig();

    const response = await fetch(
      `http://${IP_LOCAL}:3000/contratosNroAdi?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      },
    );
    const contratos = await response.json();

    if (contratos.length === 0) {
      comboContrato.innerHTML =
        '<option value="">No hay contratos disponibles</option>';
      return;
    }

    comboContrato.innerHTML =
      '<option value="">Seleccione un contrato</option>';
    contratos.forEach((contrato) => {
      const option = document.createElement("option");
      option.value = contrato.ID;
      option.textContent = contrato.DESCRIPCION;
      comboContrato.appendChild(option);
    });
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    toastr.warning(
      "Error al obtener los contratos. Inténtelo de nuevo más tarde.",
      "Oops...",
    );
  }
}

function textoAGuiones(texto) {
  return texto.trim().replace(/\s+/g, "-").toUpperCase();
}
