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

// const IP_LOCAL = "192.168.5.95";

const obtenerConfig = async () => {
  const BASE_URL = window.location.origin;

  const config = await fetch(`${BASE_URL}/php/config.php`).then((r) =>
    r.json(),
  );

  return config.IP_LOCAL;
};

async function authenticateValid() {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/verify`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  });

  if (!response.ok) {
    window.location.replace("/"); // replace no guarda la página en el historial
    return;
  }

  const data = response.json();

  return data;
}

$(document).on("DOMContentLoaded", async () => {
  const user = await authenticateValid();

  localStorage.setItem("permissions", JSON.stringify(user.permissions));

  $("#user-data").text(
    `${user.role.charAt(0).toUpperCase() + user.role.slice(1).toLowerCase()}`,
  );
  $("#user-role").text(`${user.globalDbUser.toUpperCase()}`);

  aplicarPermisos();
  protegerRutas();
});

window.addEventListener("pageshow", async function () {
  await authenticateValid();
});

$("#dropdown-menu-btn").on("click", () => {
  const menu = document.querySelector(".dropdown-menu");
  const isOpen = menu.classList.contains("show");

  if (!isOpen) {
    // 🔓 ABRIR
    menu.classList.add("show");

    Motion.animate(
      menu,
      {
        opacity: [0, 1],
        transform: ["translateY(-10px)", "translateY(0px)"],
      },
      {
        duration: 0.25,
        easing: "ease-out",
      },
    );
  } else {
    // 🔒 CERRAR
    Motion.animate(
      menu,
      {
        opacity: [1, 0],
        transform: ["translateY(0px)", "translateY(-10px)"],
      },
      {
        duration: 0.2,
        easing: "ease-in",
      },
    ).finished.then(() => {
      menu.classList.remove("show");
    });
  }
});

const toggleButton = document.getElementById("toggle-btn");
const titleSide = document.getElementById("title-sidebar");
const sidebar = document.getElementById("sidebar");

function toggleSidebar() {
  titleSide.classList.toggle("hidden");
  sidebar.classList.toggle("close");
  toggleButton.classList.toggle("rotate");

  closeAllSubMenus(); // Cierra todos los submenús al cerrar el sidebar

  setTimeout(() => {
    window.dispatchEvent(new Event("resize"));
  }, 300);
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
    titleSide.classList.toggle("hidden");
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

function useState(initialValue) {
  let state = initialValue;
  const listeners = [];

  const getState = () => state;

  const setState = (value) => {
    state = typeof value === "function" ? value(state) : value;
    listeners.forEach((fn) => fn(state));
  };

  const subscribe = (fn) => listeners.push(fn);

  return [getState, setState, subscribe];
}

function aplicarPermisos() {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  $("[data-permissions]").each(function () {
    const permisoRequerido = $(this).data("permissions");

    if (!permissions.includes(permisoRequerido)) {
      $(this).hide();
    }
  });
}

function protegerRutas() {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  $("[data-route-permission]").each(function () {
    const permiso = $(this).data("route-permission");

    if (!permissions.includes(permiso)) {
      window.location.href = "/gescon/404";
    }
  });
}
