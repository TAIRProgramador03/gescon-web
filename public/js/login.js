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


const IP_LOCAL = '192.168.5.95';

const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");

document.addEventListener("DOMContentLoaded", async () => {
  await authenticateValid();
});

window.addEventListener('pageshow', async function () {
    await authenticateValid();
});

async function authenticateValid() {
  const response = await fetch(`http://${IP_LOCAL}:3000/verify`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  });

  if (response.ok) {
    window.location.replace("./public/vista/dashboard"); // replace no guarda la página en el historial
  }
}
