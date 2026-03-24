const IP_LOCAL = '192.168.5.95';

const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

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
    window.location.replace("./public/vista/dashboard.php"); // replace no guarda la página en el historial
  }
}
