// const IP_LOCAL = 'localhost';

document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("btnClear")
    .addEventListener("click", deshabilitarSelect);
  document
    .getElementById("grabarButton")
    .addEventListener("click", guardaAsignacion);

  const btnFlotaTotal = document.getElementById("btn-flota-total");

  document
    .querySelector("#combo-box")
    .addEventListener("change", () => limpiarSelect("#combo-box-leasing"));
  // document
  //   .querySelector("#combo-box-leasing")
  //   .addEventListener("change", () => limpiarSelect("#combo-box"));
  cargarClientes();
  // cargarLeasing();

  const selectClientes = document.querySelector(".select-form-clientes");
  const selectLeasingAnonim = document.getElementById("combo-box-leasing");

  selectClientes.addEventListener("change", async (e) => {
    // deshabilitarSelect();
    // btnSelectLeasing.setAttribute("disabled", "disabled");
    cargarLeasingOfClient(e.target.value).then(() => {
      listaVehiculosAsignables();
    });
  });

  selectLeasingAnonim.addEventListener("change", async (e) => {
    listaVehiculosAsignables();
  });

  cargarClientesAsig();
  const checkAll = document.getElementById("checkAll");
  checkAll?.addEventListener("change", function () {
    const checkboxes = document.querySelectorAll('input[name="item[]"]');
    checkboxes.forEach((cb) => (cb.checked = this.checked));
  });
});

// Operacciones para el formulario de asignacion de vehiculos

async function cargarClientes() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const clientes = await response.json();
    const comboBox = document.querySelector('#combo-box[name="opciones"]');
    comboBox.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un cliente"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    clientes.forEach((cliente) => {
      const option = document.createElement("option");
      option.value = cliente.IDCLI; // El ID del cliente
      option.textContent = cliente.CLINOM; // El nombre del cliente
      comboBox.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

async function cargarLeasingOfClient(idCli) {
  try {
    const btnSelectLeasing = document.getElementById("combo-box-leasing");
    const response = await fetch(
      `http://${IP_LOCAL}:3000/leasingOfClient?idCli=${idCli}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      }
    ); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const leasing = await response.json();

    const comboBox2 = document.getElementById("combo-box-leasing");
    comboBox2.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un Leasing"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox2.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    leasing.forEach((leasing) => {
      const option = document.createElement("option");
      option.value = leasing.NRO_LEASING; // El ID del cliente
      option.textContent = leasing.NRO_LEASING; // El nombre del cliente
      comboBox2.appendChild(option);
    });

    if (leasing.length === 0) {
      console.log(comboBox2);
      comboBox2.setAttribute("disabled", "disabled");
    } else {
      const allOption = document.createElement("option");
      allOption.value = "all"; // Valor "all"
      allOption.textContent = "Todos"; // Texto visible
      allOption.selected = true;
      comboBox2.appendChild(allOption);

      comboBox2.removeAttribute("disabled");
    }
  } catch (error) {
    console.error("Error al cargar el leasing:", error);
  }
}

async function cargarLeasing() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/leasing`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const leasing = await response.json();
    const comboBox2 = document.querySelector(
      '#combo-box-leasing[name="opciones"]'
    );
    comboBox2.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un leasing"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox2.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    leasing.forEach((leasing) => {
      const option = document.createElement("option");
      option.value = leasing.ID; // El ID del cliente
      option.textContent = leasing.NRO_LEASING; // El nombre del cliente
      comboBox2.appendChild(option);
    });
  } catch (error) {
    console.error("Error al cargar el leasing:", error);
  }
}

function limpiarSelect(selector) {
  const select = document.querySelector(selector);
  select.selectedIndex = 0;
}

async function listaVehiculosAsignables() {
  // let id = "";

  const idCli = document.getElementById("combo-box").value;
  const idLea = document.getElementById("combo-box-leasing").value;

  console.log({ idCli, idLea });

  // if (idCli !== "" && idLea === "") {
  //   id = idCli;
  // } else if (idLea !== "" && idCli === "") {
  //   id = idLea;
  // } else {
  //   console.error("Error al cargar el leasing");
  //   return;
  // }

  try {
    const response = await fetch(
      `http://${IP_LOCAL}:3000/consultaVehiculoLeasing?idCli=${idCli}&nroLeasing=${idLea}`,
      {
        method: "GET",
        credentials: "include", // Asegura que las cookies se envíen con la solicitud
      }
    );
    const vehiLeasing = await response.json();

    if (!vehiLeasing.success || vehiLeasing.data.length === 0) {
      document.querySelector(".table-container table tbody").innerHTML = `
                <tr>
                    <td colspan="12">No hay vehículos disponibles</td>
                </tr>
            `;
      return;
    }

    const tbody = document.querySelector(".table-container table tbody");
    tbody.innerHTML = ""; // Limpia las filas existentes
    let contador = 0;
    vehiLeasing.data.forEach((vehi, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
                <td>${(contador =
          contador +
          1)} &nbsp;&nbsp;<input type="checkbox" name="item[]" value=""></td>
                <td><input type="text" name="codini[]" value="${vehi.codini
        }" disabled></td>
                <td><input type="text" name="placa[]" value="${vehi.placa
        }" disabled></td>
                <td><input type="text" name="marca[]" value="${vehi.marca
        }" disabled></td>
                <td><input type="text" name="modelo[]" value="${vehi.modelo
        }" disabled></td>
                <td><input type="text" name="leasing[]" value="${vehi.nro_leasing
        }" disabled></td>
                <td><input type="text" name="tarifa[]" value=""></td>
                <td><input type="date" name="fechaIni[]" value=""></td>
                <td><input type="date" name="fechaFin[]" value=""></td>
                <td><select name="operacion[]" class="combo-operacion cbo-form-cliente">
                    </select></td>
                <td><select name="contrato[]" class="combo-contrato cbo-form-cliente">
                    </select></td>
                <td><select name="tipo_terreno[]" class="cbo-form-cliente">
                        <option value="4">Seleccione el tipo</option>
                        <option value="0">Superficie</option>
                        <option value="1">Socavon</option>
                        <option value="2">Ciudad</option>
                        <option value="3">Severo</option>
                    </select></td>
            `;
      tbody.appendChild(row);

      document.getElementById("combo-box-asig").removeAttribute("disabled");
      document.getElementById("checkAll").removeAttribute("disabled");
      document.getElementById("repeticion").removeAttribute("disabled");
    });
  } catch (error) {
    console.error("Error al enviar los datos:", error);
    mostrarNotificacion("Ocurrió un error al procesar la solicitud", "#C70039");
  }
}

async function cargarClientesAsig() {
  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/clientes`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }); // Ruta relativa al servidor
    if (!response.ok) throw new Error("Error en la solicitud");

    const clientes = await response.json();
    const comboBox = document.querySelector('#combo-box-asig[name="opciones"]');
    comboBox.innerHTML = ""; // Limpia las opciones previas

    // Agregar opción predeterminada
    const defaultOption = document.createElement("option");
    defaultOption.value = ""; // Valor vacío
    defaultOption.textContent = "Seleccione un cliente"; // Texto visible
    defaultOption.disabled = true; // Hacer que la opción no sea seleccionable por defecto
    defaultOption.selected = true; // Seleccionarla como predeterminada
    comboBox.appendChild(defaultOption);

    // Agregar las opciones de los clientes
    clientes.forEach((cliente) => {
      const option = document.createElement("option");
      option.value = cliente.IDCLI; // El ID del cliente
      option.textContent = cliente.CLINOM; // El nombre del cliente
      comboBox.appendChild(option);
    });
    cargarOperaciones();
    cargarContrato();
  } catch (error) {
    console.error("Error al cargar clientes:", error);
  }
}

function deshabilitarSelect() {
  document.getElementById("combo-box-asig").setAttribute("disabled", "true");
  document.getElementById("checkAll").setAttribute("disabled", "true");
  document.getElementById("repeticion").setAttribute("disabled", "true");
  document.querySelector(".table-container table tbody").innerHTML = `
        <tr>
            <td colspan="12">Seleccione un cliente para ver los vehiculos por asignar</td>
        </tr>
    `;

  const comboBox = document.getElementById("combo-box");
  comboBox.value = ""; // Restablece el valor al predeterminado

  const comboBox2 = document.getElementById("combo-box-leasing");
  comboBox2.value = ""; // Restablece el valor al predeterminado

  const comboBox3 = document.getElementById("combo-box-asig");
  comboBox3.value = ""; // Restablece el valor al predeterminado

  document.getElementById("checkAll").checked = false;
  document.getElementById("repeticion").checked = false;

  comboBox2.innerHTML = "";

  const reloadOption = document.createElement("option");
  reloadOption.value = "";
  reloadOption.textContent = "Seleccione un Leasing";
  reloadOption.disabled = true;
  reloadOption.selected = true;
  comboBox2.appendChild(reloadOption);
  comboBox2.setAttribute("disabled", "disabled");
}

async function cargarOperaciones() {
  document
    .getElementById("combo-box-asig")
    .addEventListener("change", async function () {
      const idCli = this.value; // Obtiene el ID del cliente seleccionado

      if (!idCli) {
        // Si no hay cliente seleccionado, limpia todos los combos de operación en la tabla
        document.querySelectorAll(".combo-operacion").forEach((select) => {
          select.innerHTML =
            '<option value="">Seleccione una Operacion</option>';
        });
        return;
      }
      try {
        // Realiza una solicitud al servidor para obtener las operaciones asignadas al cliente
        const response = await fetch(
          `http://${IP_LOCAL}:3000/operacionesAsig?idCli=${idCli}`, {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          }
        );
        const operaciones = await response.json();

        // Si no hay operaciones, limpiar todos los selects
        if (operaciones.length === 0) {
          document.querySelectorAll(".combo-operacion").forEach((select) => {
            select.innerHTML =
              '<option value="">No hay operaciones disponibles</option>';
          });
          return;
        }

        // Recorre todos los selects en las filas de la tabla y los llena con las operaciones disponibles
        document.querySelectorAll(".combo-operacion").forEach((select) => {
          select.innerHTML =
            '<option value="">Seleccione una operacion</option>'; // Opción por defecto
          operaciones.forEach((operacion) => {
            const option = document.createElement("option");
            option.value = operacion.ID; // Valor del contrato
            option.textContent = operacion.DESCRIPCION; // Descripción del contrato
            select.appendChild(option);
          });
        });
      } catch (error) {
        console.error("Error al obtener las operaciones:", error);
        alert(
          "Error al obtener las operaciones. Inténtelo de nuevo más tarde."
        );
      }
    });
}

async function cargarContrato() {
  document
    .getElementById("combo-box-asig")
    .addEventListener("change", async function () {
      const idCli = this.value; // Obtiene el ID del cliente seleccionado

      if (!idCli) {
        // Si no hay cliente seleccionado, limpia todos los combos de operación en la tabla
        document.querySelectorAll(".combo-contrato").forEach((select) => {
          select.innerHTML = '<option value="">Seleccione un contrato</option>';
        });
        return;
      }
      try {
        // Realiza una solicitud al servidor para obtener las operaciones asignadas al cliente
        const response = await fetch(
          `http://${IP_LOCAL}:3000/contratosNroAdi?idCli=${idCli}`,
          {
            method: "GET",
            credentials: "include", // Asegura que las cookies se envíen con la solicitud
          }
        );
        const contratos = await response.json();

        // Si no hay operaciones, limpiar todos los selects
        if (contratos.length === 0) {
          document.querySelectorAll(".combo-contrato").forEach((select) => {
            select.innerHTML =
              '<option value="">No hay contratos disponibles</option>';
          });
          return;
        }

        // Recorre todos los selects en las filas de la tabla y los llena con las operaciones disponibles
        document.querySelectorAll(".combo-contrato").forEach((select) => {
          select.innerHTML = '<option value="">Seleccione un contrato</option>'; // Opción por defecto
          contratos.forEach((contrato) => {
            const option = document.createElement("option");
            option.value = contrato.ID; // Valor del contrato
            option.textContent = contrato.DESCRIPCION; // Descripción del contrato
            select.appendChild(option);
          });
        });
      } catch (error) {
        console.error("Error al obtener las operaciones:", error);
        alert(
          "Error al obtener las operaciones. Inténtelo de nuevo más tarde."
        );
      }
    });
}

async function guardaAsignacion() {
  // Obtener valores de los campos del formulario
  let formData = {
    idCliente: document.querySelector("#combo-box-asig").value,
    valorRepe: document.getElementById("checkAll").checked,
  };
  console.log(formData);
  // Validación de campos obligatorios
  if (!formData.idCliente) {
    mostrarNotificacion(
      "Por favor, completa todos los campos obligatorios.",
      "#C70039"
    );
    return;
  }

  // Filtrar solo los checkboxes seleccionados
  const detalles = Array.from(document.querySelectorAll("#asignacion-tbody tr"))
    .filter((fila) => fila.querySelector('input[name="item[]"]').checked) // Solo los seleccionados
    .map((fila, index) => {
      let idveh = fila.querySelector('input[name="codini[]"]').value;
      let numpla = fila.querySelector('input[name="placa[]"]').value;
      let marca = fila.querySelector('input[name="marca[]"]').value;
      let modelo = fila.querySelector('input[name="modelo[]"]').value;
      let tarifa = fila.querySelector('input[name="tarifa[]"]').value;
      let fechaIni = fila.querySelector('input[name="fechaIni[]"]').value;
      let fechaFin = fila.querySelector('input[name="fechaFin[]"]').value;
      let idOperacion = fila.querySelector('select[name="operacion[]"]').value; // Cambié de input a select
      let idContrato = fila.querySelector('select[name="contrato[]"]').value;
      let leasing = fila.querySelector('input[name="leasing[]"]').value;
      let idTerreno = fila.querySelector('select[name="tipo_terreno[]"]').value;

      // Validación y asignación de valores predeterminados
      idveh = idveh === "" ? 0 : idveh;
      numpla = numpla === "" ? 0 : numpla;
      tarifa = tarifa === "" ? 0 : tarifa;

      if (!fechaIni || !fechaFin) {
        console.log("Ambas fechas son obligatorias");
      } else {
        const fechaInicio = new Date(fechaIni);
        const fechaFinal = new Date(fechaFin);

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

      return {
        secCon: index + 1,
        idveh,
        numpla,
        marca,
        modelo,
        tarifa,
        fechaIni,
        fechaFin,
        idOperacion,
        idContrato,
        leasing,
        idTerreno,
      };
    });

  if (detalles.length === 0) {
    mostrarNotificacion("Debe seleccionar al menos un vehículo.", "#C70039");
    return;
  }

  const validacionResult = await validarAsignacion(detalles);
  if (!validacionResult.success) {
    mostrarNotificacion(
      validacionResult.mensaje || "Validación fallida",
      "#C70039"
    );
    return false;
  }

  const asignacionData = { ...formData, detalles };

  try {
    const response = await fetch(`http://${IP_LOCAL}:3000/insertaAsignacion`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(asignacionData),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    const result = await response.json();
    if (result.success) {
      mostrarNotificacion("Asignación guardada exitosamente", "#067e28");
      deshabilitarSelect();
    } else {
      mostrarNotificacion("Hubo un error al guardar la asignación", "#C70039");
    }
  } catch (error) {
    const mensaje =
      error?.odbcErrors?.[0]?.message || error.message || "Error desconocido";
    console.error("Error al enviar los datos:", error);
    mostrarNotificacion(`Error al guardar: ${mensaje}`, "#C70039");
  }
}

function mostrarNotificacion(mensaje, color) {
  const notification = document.getElementById("notification");
  notification.textContent = mensaje;
  notification.style.backgroundColor = color || "#d4edda"; // Verde suave por defecto
  notification.classList.add("show");

  // Mostrar la notificación con el efecto
  setTimeout(() => {
    notification.classList.remove("show");
  }, 3000);
}

const validarAsignacion = async (detalles) => {
  if (!detalles || detalles.length === 0) return { success: true };

  console.log(detalles);

  const validacionResponse = await fetch(
    `http://${IP_LOCAL}:3000/validaContratoCantidad`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ detalles }),
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    }
  );

  const validacionResult = await validacionResponse.json();

  if (!validacionResult.success) {
    console.error("Error de validación:", validacionResult.mensaje);
    return { success: false, mensaje: validacionResult.mensaje };
  }

  return { success: true };
};
