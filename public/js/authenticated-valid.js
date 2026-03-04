const IP_LOCAL = "localhost";

async function authenticateValid() {
  try {
    const response = await fetch(`/api/verify`, {
      method: "GET",
      credentials: "include", // Asegura que las cookies se envíen con la solicitud
    });

    if (!response.ok) {
      window.location.replace("../../Index.html"); // replace no guarda la página en el historial
    }
  } catch (error) {
    window.location.replace("../../Index.html");
  }
}

authenticateValid();