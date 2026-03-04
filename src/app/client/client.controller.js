const odbc = require("odbc");
const { dbConfig } = require("../../shared/conf.js");
const { decodeString } = require("../../shared/utils.js");

const listClient = async (req, res) => {
  // Verificar que el token JWT esté presente y decodificarlo para obtener los valores globales de dbUser y password
  const { globalDbUser, globalPassword } = req.user;

  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  let connection;

  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`,
    );

    const sql = `
      SELECT DISTINCT A.IDCLI, B.CLINOM 
      FROM SPEED400AT.PO_OPERACIONES A 
      INNER JOIN SPEED400AT.TCLIE B ON A.IDCLI=B.CLICVE 
      WHERE A.ID<>86 AND B.CLINOM <> '*** ANULADO ***' 
      ORDER BY CLINOM ASC
    `;

    const result = await connection.query(sql);

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        IDCLI: row.IDCLI.trim(),
        CLINOM: decodeString(row.CLINOM.trim()),
      };
    });

    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los clientes:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener clientes" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

const tableClient = async (req, res) => {
  // Verificar que el token JWT esté presente y decodificarlo para obtener los valores globales de dbUser y password
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

  if (!idCli) {
    return res
      .status(400)
      .json({ success: false, message: "El idCli es obligatorio" });
  }

  let connection;

  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`,
    );

    // Consulta los contratos asociados al cliente
    const query = `
      SELECT NRO_CONTRATO AS DESCRIPCION, FECHA_FIRMA AS FECHACREA, CANT_VEHI AS TOTVEH, DURACION 
      FROM SPEED400AT.TBLCONTRATO_CAB 
      WHERE ID_CLIENTE = ?
    `;
    const result = await connection.query(query, [idCli]);

    const cleanedResult = result.map((row) => {
      return {
        DESCRIPCION:
          row.DESCRIPCION !== null && row.DESCRIPCION !== undefined
            ? decodeString(row.DESCRIPCION.toString().trim())
            : null,
        FECHACREA:
          row.FECHACREA !== null && row.FECHACREA !== undefined
            ? row.FECHACREA.toString().trim()
            : null,
        TOTVEH:
          row.TOTVEH !== null && row.TOTVEH !== undefined
            ? row.TOTVEH.toString().trim()
            : null,
        DURACION:
          row.DURACION !== null && row.DURACION !== undefined
            ? row.DURACION.toString().trim()
            : null,
      };
    });

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

const tableClientLea = async (req, res) => {
  // Verificar que el token JWT esté presente y decodificarlo para obtener los valores globales de dbUser y password
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  let connection;

  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`,
    );

    // Consulta los contratos asociados al cliente
    const query = `SELECT DISTINCT A.IDCLI, B.CLINOM, B.CLIRUC, B.CLIABR, B.CLIDIR FROM SPEED400AT.PO_OPERACIONES A INNER JOIN SPEED400AT.TCLIE B ON A.IDCLI=B.CLICVE WHERE A.ID<>86 AND B.CLINOM <> '*** ANULADO ***' ORDER BY CLINOM ASC`;
    const result = await connection.query(query);

    const cleanedResult = result.map((row) => {
      return {
        IDCLI:
          row.IDCLI !== null && row.IDCLI !== undefined
            ? row.IDCLI.toString().trim()
            : null,
        CLINOM:
          row.CLINOM !== null && row.CLINOM !== undefined
            ? decodeString(row.CLINOM.toString().trim())
            : null,
        CLIRUC:
          row.CLIRUC !== null && row.CLIRUC !== undefined
            ? row.CLIRUC.toString().trim()
            : null,
        CLIABR:
          row.CLIABR !== null && row.CLIABR !== undefined
            ? row.CLIABR.toString().trim()
            : null,
        CLIDIR:
          row.CLIDIR !== null && row.CLIDIR !== undefined
            ? decodeString(row.CLIDIR.toString().trim())
            : null,
      };
    });

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

module.exports = {
  listClient,
  tableClient,
  tableClientLea,
};
