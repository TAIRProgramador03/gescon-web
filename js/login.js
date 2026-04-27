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

const obtenerConfig = async () => {
  const BASE_URL = window.location.origin;

  const config = await fetch(`${BASE_URL}/php/config.php`).then((r) => r.json());

  return config.IP_LOCAL;
};

const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");

document.addEventListener("DOMContentLoaded", async () => {
  await authenticateValid();
});

window.addEventListener("pageshow", async function () {
  await authenticateValid();
});

async function authenticateValid() {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/verify`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  });

  if (response.ok) {
    if (data.permissions.includes("ver_dashboard")) {
      window.location.href = "./vista/";
    } else {
      window.location.href = "./vista/sistema";
    }
  }
}
