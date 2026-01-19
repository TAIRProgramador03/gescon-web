require('dotenv').config();
const IP_LOCAL = process.env.IP_LOCAL;

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("btnClear").addEventListener("click", limpiarCampos);
  document
    .getElementById("grabarButton")
    .addEventListener("click", guardaLeasing);

  // Cargar las tablas

  localStorage.setItem("clienteSeleccionadoID", "");
  localStorage.setItem("clienteSeleccionadoNombre", "");
  cargartablaClienteLeas();
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

  // Buscador para la tabla de vehículos
  const buscadorVehi = document.getElementById("buscadorTablaVehi");
  if (buscadorVehi) {
    buscadorVehi.addEventListener("input", function () {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll(
        ".tabla-form-vehi table tbody tr"
      );

      filas.forEach((fila) => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? "" : "none";
      });
    });
  }
});

document.addEventListener("DOMContentLoaded", cargarSeleccionados);

async function cargartablaClienteLeas() {
  document
    .getElementById("openModalCli")
    .addEventListener("click", async function () {
      try {
        const response = await fetch(
          `http://${IP_LOCAL}:3000/tablaClienteLeas`
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
                    <td class="icono-seleccion" data-id="${cliente.IDCLI
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
        // try {
        //   // Llamada asincrónica al servidor para obtener una solución de OpenAI
        //   const response = await fetch("/get-openai-response", {
        //     method: "GET",
        //   });

        //   if (!response.ok) {
        //     throw new Error("No se pudo obtener la respuesta de OpenAI");
        //   }

        //   const fixMessage = await response.text();

        //   // Mostrar la posible solución en la consola
        //   console.log(fixMessage);

        //   // Mostrarla al usuario, por ejemplo, en un alert o en el DOM
        //   alert("Posible solución: " + fixMessage);
        // } catch (error) {
        //   console.error("Error al contactar a OpenAI:", error);
        //   alert(
        //     "Error al obtener los datos de OpenAI. Inténtelo de nuevo más tarde."
        //   );
        // }
        alert("Error al obtener los datos. Inténtelo de nuevo más tarde.");
      }
    });
}

function agregarEventosSeleccion() {
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
      } else {
        filas.forEach((f) => f.classList.remove("seleccionado"));
        this.classList.add("seleccionado");
        this.querySelector("i").classList.remove("fa-check-circle");
        this.querySelector("i").classList.add("fa-times-circle");
        this.querySelector("i").style.color = "red";

        const clienteID = this.dataset.id;
        const clienteNombre = this.dataset.nombre;
        document.getElementById(
          "inputClienteSeleccionado"
        ).value = `${clienteNombre}`;
        const seleccionado = document.querySelector(
          ".icono-seleccion.seleccionado"
        );

        if (!seleccionado) {
          mostrarNotificacion("Por favor, seleccione un cliente.", "#C70039");
        } else {
          mostrarNotificacion("Se agrego el cliente seleccionado", "#01b204");
          cargarContratosPorCliente(clienteID);
        }
        // Guardar en localStorage
        localStorage.setItem("clienteSeleccionadoID", clienteID);
        localStorage.setItem("clienteSeleccionadoNombre", clienteNombre);
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
      `.icono-seleccion[data-id="${clienteID}"]`
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

async function cargartablaVehiculo() {
  document
    .getElementById("openModal")
    .addEventListener("click", async function () {
      try {
        // Realiza una solicitud al servidor para obtener los contratos del cliente
        const response = await fetch(`http://${IP_LOCAL}:3000/tablaVehiculo`);
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
                    <td class="icono-seleccion" data-id="${tablaVehiculo.ID
            }" data-nombre="${tablaVehiculo.PLACA}">
                        <i class="fas fa-check-circle" style="color: green; font-size: 22px;"></i>
                    </td>
                    <td>${tablaVehiculo.CODINI}</td> <!-- Número de contrato -->
                    <td>${tablaVehiculo.PLACA}</td> <!-- Número de contrato -->
                    <td>${tablaVehiculo.MARCA || "Sin marca"
            }</td> <!-- Fecha de firma -->
                    <td>${tablaVehiculo.MODELO || "Sin modelo"
            }</td> <!-- Periodo -->
                    <td>${tablaVehiculo.GENERICO || "Sin generico"
            }</td> <!-- Cantidad total -->
                    <td>${tablaVehiculo.TERRENO || "Sin terreno"
            }</td> <!-- Cantidad total -->
                `;
          tbody.appendChild(row);
        });
        agregarEventosSeleccionVehi();
        restaurarSeleccionVehi();
      } catch (error) {
        mostrarNotificacion(
          "Error al obtener los datos. Inténtelo de nuevo más tarde.",
          "#C70039"
        );
      }
    });
}

function agregarEventosSeleccionVehi() {
  const filas = document.querySelectorAll(".icono-seleccion");
  const tablaSeleccionados = document.querySelector(
    "#tablaSeleccionados tbody"
  );

  filas.forEach((fila) => {
    fila.addEventListener("click", function () {
      const placaID = this.dataset.id;
      const modelo = this.parentElement.children[4].textContent; // Columna 2 (RUC)
      const terreno = this.parentElement.children[6].textContent; // Columna 3 (Cliente)
      const placa = this.parentElement.children[2].textContent; // Columna 3 (Cliente)
      const codini = this.parentElement.children[1].textContent; // Columna 3 (Cliente)

      // Asegurarse de que localStorage tiene un valor válido antes de hacer JSON.parse()
      let seleccionados = localStorage.getItem("vehiculosSeleccionados");
      seleccionados = seleccionados ? JSON.parse(seleccionados) : [];

      if (this.classList.contains("seleccionado")) {
        // Quitar selección
        this.classList.remove("seleccionado");
        this.querySelector("i").classList.replace(
          "fa-times-circle",
          "fa-check-circle"
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
          "fa-times-circle"
        );
        this.querySelector("i").style.color = "red";

        if (
          ![...tablaSeleccionados.children].some(
            (row) => row.dataset.id === placaID
          )
        ) {
          const nuevaFila = document.createElement("tr");
          nuevaFila.dataset.id = placaID;
          const contador = 0;

          nuevaFila.innerHTML = `
                        <td><input type="text" name="item[]" value="${contador + 1
            }" disabled></td>
                        <td><input type="text" name="id[]" value="${placaID}" disabled></td>
                        <td><input type="text" name="modelo[]" value="${modelo}" disabled></td>
                        <td><input type="text" name="tipo_terreno[]" value="${terreno}" disabled></td>
                        <td><input type="text" name="placa[]" value="${placa}" disabled></td>
                        <td><input type="text" name="codini[]" value="${codini}" disabled></td>
                        <td><input type="number" name="cantidad[]" value="1" disabled></td>
                    `;

          tablaSeleccionados.appendChild(nuevaFila);
          mostrarNotificacion("Se agregó el vehículo seleccionado", "#01b204");
          actualizarContador();
        }

        // Guardar en localStorage
        seleccionados.push({ id: placaID, modelo, terreno, placa, codini });
      }

      // Guardar el array corregido en localStorage
      localStorage.setItem(
        "vehiculosSeleccionados",
        JSON.stringify(seleccionados)
      );
    });
  });
}

function cargarSeleccionados() {
  const tablaSeleccionados = document.querySelector(
    "#tablaSeleccionados tbody"
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
            <td><input type="text" name="item[]" value="${index + 1
      }" disabled></td>
            <td><input type="text" name="id[]" value="${vehiculo.id
      }" disabled></td>
            <td><input type="text" name="modelo[]" value="${vehiculo.modelo
      }" disabled></td>
            <td><input type="text" name="tipo_terreno[]" value="${vehiculo.terreno
      }" disabled></td>
            <td><input type="text" name="placa[]" value="${vehiculo.placa
      }" disabled></td>
            <td><input type="text" name="codini[]" value="${vehiculo.codini
      }" disabled></td>
            <td><input type="number" name="cantidad[]" value="1" disabled></td>
        `;

    tablaSeleccionados.appendChild(nuevaFila);
  });

  actualizarContador(); // Para actualizar el número de vehículos
}

// Llamar a la función al cargar la página para restaurar la selección

function restaurarSeleccionVehi() {
  const seleccionados =
    JSON.parse(localStorage.getItem("vehiculosSeleccionados")) || [];
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

async function guardaLeasing() {
  // Obtener valores de los campos del formulario
  let formData = {
    //idCliente: document.querySelector("#combo-cliente").value,
    idCliente: localStorage.getItem("clienteSeleccionadoID"),
    nroLeasing: document.querySelector("#NroLeasing").value,
    banco: document.querySelector("#banco").value,
    cantVehiculos: document.querySelector("#cantVehi").value,
    fechaIni: document.querySelector("#fechaIni").value || "0",
    fechaFin: document.querySelector("#fechaFin").value || "0",
    periGracia: document.querySelector("#periGracia").value || "0",
    idContrato: document.querySelector("#combo-box-asig").value,
    //story: document.querySelector("#fileInput").value
  };

  if (!formData.fechaIni || !formData.fechaFin) {
    console.log("Ambas fechas son obligatorias");
  } else {
    const fechaInicio = new Date(formData.fechaIni);
    const fechaFinal = new Date(formData.fechaFin);

    if (fechaFinal <= fechaInicio) {
      mostrarNotificacion(
        "La fecha de finalización debe ser mayor que la fecha de inicio",
        "#C70039"
      );
      return;
    } else {
      console.log("Fechas válidas");
    }
  }

  for (let i = 0; i < formData.cantVehiculos.length; i++) {
    if (formData.cantVehiculos[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "La cantidad de vehiculo no es inválido, solo debe contener números",
        "#C70039"
      );
      return;
    }
  }

  for (let i = 0; i < formData.periGracia.length; i++) {
    if (formData.periGracia[i] < 10) {
      console.log("Todo conforme.");
    } else {
      mostrarNotificacion(
        "el periodo de gracia no es inválido, solo debe contener números",
        "#C70039"
      );
      return;
    }
  }

  // Validación de campos obligatorios
  if (
    !formData.idCliente ||
    !formData.nroLeasing ||
    !formData.banco ||
    !formData.cantVehiculos ||
    !formData.fechaIni ||
    !formData.fechaFin ||
    !formData.idContrato
  ) {
    mostrarNotificacion(
      "Por favor, completa todos los campos obligatorios.",
      "#C70039"
    );
    return;
  }

  let conta = 0;
  // Obtener detalles de contratos
  const detalles = Array.from(document.querySelectorAll("#contratos-tbody tr"))
    .map((fila, index) => {
      let modelo = fila.querySelector('input[name="modelo[]"]').value;
      let tipoTerreno = fila.querySelector(
        'input[name="tipo_terreno[]"]'
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

  if (formData.cantVehiculos == conta) {
    console.log("Todo conforme.");
  } else {
    mostrarNotificacion(
      "Debe coincidir la cantidad de vehiculos con los vehiculos seleccionados.",
      "#C70039"
    );
    return;
  }

  /*const fileInput = document.querySelector("#fileInput");
    const fileData = fileInput.files.length > 0 ? await leerArchivoBase64(fileInput.files[0]) : null;*/

  // Construcción del objeto final de datos
  //const contratoData = { ...formData, detalles, archivoPdf: fileData };

  const nombreArchivo = fileInput.files[0].name;

  if (nombreArchivo) {
    const yaExiste = await validarArchivo(nombreArchivo); // Solo el nombre, ya es string
    if (!yaExiste) {
      await subirArchivo(fileInput.files[0]); // Aquí mandas el archivo como tal (tipo File)
    } else {
      console.warn("El archivo ya existe, no se sube.");
      mostrarNotificacion("El archivo PDF ya existe en el servidor", "#C70039");
      return;
    }
  }

  // Construcción del objeto final de datos
  const contratoData = { ...formData, detalles, archivoPdf: nombreArchivo };

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/insertaLeasing`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(contratoData),
    });

    const result = await response.json();
    if (result.success) {
      mostrarNotificacion("Leasing guardado exitosamente", "#01b204");
      await subirArchivo(fileInput.files[0]);
      limpiarCampos();
    } else {
      mostrarNotificacion("Hubo un error al guardar el Leasing", "#C70039");
    }
  } catch (error) {
    const mensaje =
      error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    console.error("Error al enviar los datos:", error);
    mostrarNotificacion(`Error al guardar: ${mensaje}`, "#C70039");
  }
}

async function subirArchivo(archivo) {
  const formData = new FormData();
  formData.append("archivoPdf", archivo);
  formData.append("documentType", "leasings");

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/subirArchivo`, {
      method: "POST",
      enctype: "multipart/form-data",
      body: formData,
    });

    const result = await response.json();
    if (!result.success) {
      mostrarNotificacion("Error al subir el archivo PDF", "#C70039");
    }
  } catch (error) {
    console.error("Error al subir el archivo:", error);
    mostrarNotificacion("Ocurrió un error al subir el archivo", "#C70039");
  }
}

async function validarArchivo(nombreArchivo) {
  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/validarArchivo?nombre=${nombreArchivo}`
    );
    const result = await response.json();

    if (result.existe) {
      mostrarNotificacion("El archivo PDF ya existe en el servidor", "#C70039");
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error("Error al validar archivo PDF:", error);
    mostrarNotificacion("Error al validar archivo PDF", "#C70039");
    return false;
  }
}

function limpiarCampos() {
  // Limpiar los campos de texto (inputs)
  console.log("Función limpiarCampos ejecutada");
  document.getElementById("inputClienteSeleccionado").value = "";
  document.getElementById("NroLeasing").value = "";
  document.getElementById("banco").value = "";
  //document.getElementById('banco').value = "";
  resetSelect("combo-box-asig", "Seleccione un contrato");
  document.getElementById("cantVehi").value = "";
  document.getElementById("fechaIni").value = "";
  document.getElementById("fechaFin").value = "";
  document.getElementById("periGracia").value = "";

  // Limpiar los valores de los divs (contenidos de texto)
  document.getElementById("fileInput").value = ""; // Esto limpia el archivo seleccionado
  document.getElementById("fileName").textContent = ""; // Esto limpia el nombre del archivo mostrado
  document.getElementById("fileInfo").style.display = "none"; // Oculta el área de información del archivo
  const uploadMessage = document.getElementById("uploadMessage");
  uploadMessage.textContent = "Haz clic o arrastra un archivo aquí"; // Restablece el mensaje
  uploadMessage.style.display = "block";

  // Limpiar el checkbox
  localStorage.setItem("clienteSeleccionadoID", "");
  localStorage.setItem("clienteSeleccionadoNombre", "");

  // Limpiar la tabla de contratos
  const tbodyContratos = document.getElementById("contratos-tbody");
  tbodyContratos.innerHTML = ""; // Vaciar la tabla de contratos

  // **LIMPIAR LA TABLA DE VEHÍCULOS SELECCIONADOS**
  localStorage.removeItem("vehiculosSeleccionados"); // Eliminar los vehículos guardados en localStorage
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
    const response = await fetch(
      `http://${IP_LOCAL}:3000/contratosNroAdi?idCli=${idCli}`
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
    alert("Error al obtener los contratos. Inténtelo de nuevo más tarde.");
  }
}
