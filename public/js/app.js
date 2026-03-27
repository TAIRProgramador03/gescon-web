/*const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');

function toggleSidebar() {
  sidebar.classList.toggle('close');
  toggleButton.classList.toggle('rotate');
}

function toggleSubMenu(button) {
  const subMenu = button.nextElementSibling;
  // Mostrar u ocultar solo el submenú clickeado
  subMenu.classList.toggle('show');
  button.classList.toggle('rotate');
}

function closeAllSubMenus() {
  Array.from(sidebar.getElementsByClassName('show')).forEach(subMenu => {
    subMenu.classList.remove('show');
    subMenu.previousElementSibling.classList.remove('rotate');
  });
}*/
lucide.createIcons();

const IP_LOCAL = "192.168.5.95";

async function authenticateValid() {
  const response = await fetch(`http://${IP_LOCAL}:3000/verify`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  });

  if (!response.ok) {
    window.location.replace("/gescon-web/index.html"); // replace no guarda la página en el historial
    return;
  }

  const data = response.json()

  return data;
}

$(document).on("DOMContentLoaded", async () => {
  const user = await authenticateValid();

  $("#user-data").text(`${user.globalDbUser.toUpperCase()}`)
});

window.addEventListener('pageshow', async function () {
    await authenticateValid();
});

$("#dropdown-menu-btn").on("click", () => {
  document.querySelector('.dropdown-menu').classList.toggle('show');
})

const toggleButton = document.getElementById("toggle-btn");
const sidebar = document.getElementById("sidebar");

function toggleSidebar() {
  sidebar.classList.toggle("close");
  toggleButton.classList.toggle("rotate");
  closeAllSubMenus(); // Cierra todos los submenús al cerrar el sidebar
}

function toggleSubMenu(button) {
  let subMenu = button.nextElementSibling;

  // Si el submenú ya está abierto, simplemente lo oculta
  if (subMenu.classList.contains("show")) {
    subMenu.classList.remove("show");
    button.classList.remove("rotate");
    closeAllSubMenusSec();
  } else {
    closeAllSubMenus(); // Cierra todos los submenús principales y secundarios
    subMenu.classList.add("show");
    button.classList.add("rotate");
  }

  if (sidebar.classList.contains("close")) {
    sidebar.classList.toggle("close");
    toggleButton.classList.toggle("rotate");
  }
}

function closeAllSubMenus() {
  document.querySelectorAll(".sub-menu.show").forEach((ul) => {
    ul.classList.remove("show");
    ul.previousElementSibling.classList.remove("rotate");
  });

  closeAllSubMenusSec(); // También cierra los submenús secundarios
}

function toggleSubMenuSec(button) {
  let subMenuSec = button.nextElementSibling;

  if (subMenuSec.classList.contains("show")) {
    subMenuSec.classList.remove("show");
    button.classList.remove("rotate");
  } else {
    closeAllSubMenusSec(); // Cierra los otros submenús secundarios
    subMenuSec.classList.add("show");
    button.classList.add("rotate");
  }
}

function closeAllSubMenusSec() {
  document.querySelectorAll(".sub-menu-sec.show").forEach((ul) => {
    ul.classList.remove("show");
    ul.previousElementSibling.classList.remove("rotate");
  });
}
