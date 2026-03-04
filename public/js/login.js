const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

const IP_LOCAL = "localhost";

async function authenticateValid() {
  try {
    const response = await fetch(`/api/verify`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    if (response.ok) {
      window.location.href = './public/vista/dashboard.php'; // replace no guarda la página en el historial
    }
  } catch (error) {
    window.location.replace("../../Index.html");
  }
}

authenticateValid();