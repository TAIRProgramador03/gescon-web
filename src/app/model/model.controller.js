const odbc = require("odbc");
const { dbConfig } = require("../../shared/conf.js");
const { decodeString } = require("../../shared/utils.js");

const listModels = async (req, res) => {
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
    const result = await connection.query(
      "SELECT ID, TRIM(DESCRIPCION) AS MODELO FROM SPEED400AT.PO_MODELO GROUP BY ID, DESCRIPCION ORDER BY TRIM(DESCRIPCION) ASC",
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID: String(row.ID).trim(),
        MODELO: decodeString(row.MODELO.trim()),
      };
    });

    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los modelos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los modelos" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

module.exports = {
  listModels,
};