// const IP_LOCAL = "localhost";

const getDocuments = async (contratoId, clienteId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/documentoPorContrato?contratoId=${contratoId.toString()}&clienteId=${clienteId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const documents = await response.json();

  return documents;
};

const getDetailDocument = async (documentoId) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/detalleDocumento?documentoId=${documentoId.toString()}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  return data;
};

const getVehByDocument = async (documentoId, tipoTerr) => {
  const response = await fetch(
    `http://${IP_LOCAL}:3000/placasPorDocumento?documentoId=${documentoId.toString()}&tipoTerr=${tipoTerr}`,
    {
      method: "GET",
      credentials: "include",
    },
  );

  const data = await response.json();

  if (!response.ok) {
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

    toastr.info(data.message, "Aviso");
  }

  return data;
};

function convertirFecha(fecha) {
  const anio = fecha.substring(0, 4);
  const mes = fecha.substring(4, 6);
  const dia = fecha.substring(6, 8);
  return `${anio}-${mes}-${dia}`;
}

function obtenerEstado(fechaFin) {
  const fechaActual = new Date();
  const fechaFinObj = new Date(fechaFin);
  if (fechaFinObj >= fechaActual) {
    return "Activo";
  } else {
    return "Finalizado";
  }
}

function calcularFechaFin(fechaInicio, duracionMeses) {
  const fechaInicioObj = new Date(fechaInicio);

  // Obtener el año, mes y día de la fecha de inicio
  const anio = fechaInicioObj.getFullYear();
  const mes = fechaInicioObj.getMonth(); // El mes en formato 0-11 (enero es 0)
  const dia = fechaInicioObj.getDate();

  //fili
  let pruebaDura = parseFloat(duracionMeses.trim()) + 1;
  let pruebaAnio = anio;
  let pruebaMes = mes + 1;
  let pruebDia = dia;
  let datoMes = 0;

  for (var i = 1; i < pruebaDura; i++) {
    pruebaMes = pruebaMes + 1;
    if (pruebaMes > 12) {
      datoMes = pruebaMes - 12;
      pruebaMes = datoMes;
      pruebaAnio = pruebaAnio + 1;
    } else {
      pruebaMes = pruebaMes;
      pruebaAnio = pruebaAnio;
    }
  }

  if (pruebaMes < 10) {
    pruebaMes = pruebaMes.toString().padStart(2, "0");
  } else {
    pruebaMes = pruebaMes;
  }

  if (pruebDia < 10) {
    pruebDia = pruebDia.toString().padStart(2, "0");
  } else {
    pruebDia = pruebDia;
  }

  const year = pruebaAnio;
  const month = pruebaMes;
  const day = pruebDia;
  const fechaFinal = `${year}-${month}-${day}`;
  // Devolver la fecha final
  return fechaFinal;
  //fili
}

function obtenerDiasVencimiento(fecha) {
  const fechaActual = new Date(Date.now());
  const fechaFin = new Date(fecha);
  const diferenciaTiempo = fechaFin - fechaActual;
  return Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
}