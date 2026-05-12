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

function isGetPermission(permission) {
  const permissions = JSON.parse(localStorage.getItem("permissions")) || [];

  return permissions.includes(permission);
}

async function listarNotificaciones() {
  const IP_LOCAL = await obtenerConfig();

  const response = await fetch(`http://${IP_LOCAL}:3000/notifications`, {
    method: "GET",
    credentials: "include", // Asegura que las cookies se envíen con la solicitud
  });

  const data = response.json();

  return data;
}

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

  const notifications = await listarNotificaciones();

  const tContratos = notifications.totalContratos;
  const tDocumentos = notifications.totalDocumentos;
  const tReasignacion = notifications.totalReasignaciones;

  const perm1 = isGetPermission('ver_contratos');
  const perm2 = isGetPermission('ver_documentos')
  const perm3 = isGetPermission('insertar_reasignacion')

  const getNotif = JSON.parse(sessionStorage.getItem("isNotification"));

  if ((tContratos > 0 && perm1) || (tDocumentos > 0 && perm2) || (tReasignacion > 0 && perm3)) {
    $(".list-notifications").empty();
    $(".flag-alter-not").removeClass("hidden");
  }

  if (tContratos > 0 && perm1) {
    $(".list-notifications").append(`
      <div class="w-full flex items-center gap-3">
        <div class="size-12 flex justify-center items-center bg-blue-200 rounded-lg p-2">
          <i
          class="bi bi-file-earmark-fill text-xl text-blue-600"
          ></i>
        </div>
        <div class="w-full flex flex-col gap-1">
          <h3 class="!text-base !font-medium !m-0">Contratos</h3>
          <p class="text-sm text-gray-500 !m-0">Existen <b>${tContratos}</b> contratos pendientes que se deben completar.</p>
        </div>
      </div>
    `);

    if (!getNotif) {
      if (Notification.permission === "granted") {
        new Notification("Nuevo mensaje", {
          body: `Tienes ${tContratos} contratos pendientes por completar`,
          icon: "/public/img/tair.webp",
        });
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then((permission) => {
          if (permission === "granted") {
            new Notification("Nuevo mensaje", {
              body: `Tienes ${tContratos} contratos pendientes por completar`,
              icon: "/public/img/tair.webp",
            });
          }
        });
      }
    }
  }

  if (tDocumentos > 0 && perm2) {
    $(".list-notifications").append(`
      <div class="w-full flex items-center gap-3">
        <div class="size-12 flex justify-center items-center bg-taupe-200 rounded-lg p-2">
          <i
          class="bi bi-filetype-doc text-xl text-taupe-600"
          ></i>
        </div>
        <div class="w-full flex flex-col gap-1">
          <h3 class="!text-base !font-medium !m-0">Documentos</h3>
          <p class="text-sm text-gray-500 !m-0">Existen <b>${tDocumentos}</b> documentos pendientes que se deben completar.</p>
        </div>
      </div>
    `);

    if (!getNotif) {
      if (Notification.permission === "granted") {
        new Notification("Nuevo mensaje", {
          body: `Tienes ${tDocumentos} documentos pendientes por completar`,
          icon: "/public/img/tair.webp",
        });
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then((permission) => {
          if (permission === "granted") {
            new Notification("Nuevo mensaje", {
              body: `Tienes ${tDocumentos} documentos pendientes por completar`,
              icon: "/public/img/tair.webp",
            });
          }
        });
      }
    }
  }

  if (tReasignacion > 0 && perm3) {
    $(".list-notifications").append(`
      <div class="w-full flex items-center gap-3">
        <div class="size-12 flex justify-center items-center bg-yellow-200 rounded-lg p-2">
          <i
          class="fa-solid fa-rotate text-xl text-yellow-600"
          ></i>
        </div>
        <div class="w-full flex flex-col gap-1">
          <h3 class="!text-base !font-medium !m-0">Reasignaciones</h3>
          <p class="text-sm text-gray-500 !m-0">Se han detectado <b>${tReasignacion}</b> vehiculos pendientes que se deben reasignar.</p>
        </div>
      </div>
    `);

    if (!getNotif) {
      if (Notification.permission === "granted") {
        new Notification("Nuevo mensaje", {
          body: `Tienes ${tReasignacion} reasingaciones pendientes por completar`,
          icon: "/public/img/tair.webp",
        });
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then((permission) => {
          if (permission === "granted") {
            new Notification("Nuevo mensaje", {
              body: `Tienes ${tReasignacion} reasingaciones pendientes por completar`,
              icon: "/public/img/tair.webp",
            });
          }
        });
      }
    }
  }

  sessionStorage.setItem("isNotification", true);
});

window.addEventListener("pageshow", async function () {
  await authenticateValid();
});

$("#dropdown-menu-btn").on("click", function (e) {
  e.stopPropagation();

  const menu = document.querySelector(".dropdown-menu");
  const isOpen = menu.classList.contains("show");

  if (!isOpen) {
    Motion.animate(
      ".drop-down-notification-container",
      {
        opacity: [1, 0],
        transform: ["translateY(0px)", "translateY(-10px)"],
      },
      {
        duration: 0.2,
        easing: "ease-in",
      },
    ).finished.then(() => {
      $("#dropDownNotification")
        .addClass("-z-[200] hidden")
        .removeClass("z-[200] flex");
    });

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
