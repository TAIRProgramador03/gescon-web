const iconv = require("iconv-lite");

const decodeString = (str) => {
  return iconv.decode(Buffer.from(str, "binary"), "latin1"); // Decodifica desde latin1
};

function convertirFecha(fecha) {
  return fecha.replace(/-/g, "");
}

function funcionNumerica(valor) {
  if (!valor) return null;
  const partes = valor.split("_");
  return partes.length === 2 ? parseInt(partes[1], 10) : null;
}

// 🔠 Devuelve la primera letra (antes del "_")
function funcionParteVar(valor) {
  if (!valor) return null;
  return valor.charAt(0);
}

function transformType(value, object) {
  return object[value];
}

async function obtenerUltimoId(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBLCONTRATO_CAB`,
  );
  return result.length > 0 ? result[0].ID : null;
}

async function obtenerUltimoIdDoc(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBLDOCUMENTO_CAB`,
  );
  return result.length > 0 ? result[0].ID : null;
}

async function obtenerUltimoIdLea(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBL_LEASING_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

async function obtenerUltimoIdAsigna(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBL_ASIGNACION_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

module.exports = {
  decodeString,
  convertirFecha,
  funcionNumerica,
  funcionParteVar,
  obtenerUltimoId,
  obtenerUltimoIdDoc,
  obtenerUltimoIdLea,
  obtenerUltimoIdAsigna,
  transformType
};
