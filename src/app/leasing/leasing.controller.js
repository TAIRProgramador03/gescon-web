const odbc = require("odbc");
const { dbConfig } = require("../../shared/conf.js");
const {
  decodeString,
  convertirFecha,
  funcionNumerica,
  funcionParteVar,
  obtenerUltimoIdLea,
} = require("../../shared/utils.js");

const listLeasing = async (req, res) => {
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
      "SELECT ID, NRO_LEASING FROM SPEED400AT.TBL_LEASING_CAB ORDER BY NRO_LEASING ASC",
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID: String(row.ID).trim(),
        NRO_LEASING: decodeString(row.NRO_LEASING.trim()),
      };
    });

    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener leasing" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

const listLeasingOfClient = async (req, res) => {
  const { idCli } = req.query;

  // Validación de parametros query
  if (!idCli) {
    return res.status(400).json({
      success: false,
      message: "Los parámetros idCli son obligatorios.",
    });
  }

  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
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
    // const result = await connection.query(
    //   `SELECT ID, NRO_LEASING FROM SPEED400AT.TBL_LEASING_CAB WHERE ID_CLIENTE='${idCli}' ORDER BY NRO_LEASING ASC`
    // );

    const query = `
        SELECT ID, NRO_LEASING 
        FROM SPEED400AT.TBL_LEASING_CAB 
        WHERE ID_CLIENTE = ? ORDER BY NRO_LEASING ASC
      `;

    const result = await connection.query(query, [idCli]);

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID:
          row.ID !== null && row.ID !== undefined
            ? String(row.ID).trim()
            : null,
        NRO_LEASING:
          row.NRO_LEASING !== null && row.NRO_LEASING !== undefined
            ? decodeString(row.NRO_LEASING.trim())
            : null,
      };
    });

    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener leasing" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

const insertLeasing = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const {
    idCliente,
    nroLeasing,
    banco,
    cantVehiculos,
    fechaIni,
    fechaFin,
    periGracia,
    idContrato,
    //story,
    detalles,
    archivoPdf,
  } = req.body;

  const fechaIniDB = convertirFecha(fechaIni);
  const fechaFinDB = convertirFecha(fechaFin);

  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/leasings/${archivoPdf}`;
  let connection;

  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`,
    );

    const queryCabecera = `
              INSERT INTO SPEED400AT.TBL_LEASING_CAB 
              (ID_CLIENTE, NRO_LEASING, BANCO, CANT_VEH, FECHA_INI, FECHA_FIN, PERIODO_GRACIA, PDF, ID_CONTRATO, TIPCON)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    const result = await connection.query(queryCabecera, [
      idCliente,
      nroLeasing,
      banco,
      cantVehiculos,
      fechaIniDB,
      fechaFinDB,
      periGracia,
      nombreArchivo,
      funcionNumerica(idContrato),
      funcionParteVar(idContrato),
    ]);

    const idLeasingCab =
      result.insertId || (await obtenerUltimoIdLea(connection));

    const queryDetalle = `
              INSERT INTO SPEED400AT.TBL_LEASING_DET 
              (ID_LEA_CAB, ID_VEH, SEC_CON, MODELO, TIPO_TERRENO, PLACA, CODINI, CANTIDAD)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
          `;

    const queryUpdateVehiculo = `
              UPDATE SPEED400AT.PO_VEHICULO 
              SET INIVAL1 = '1' 
              WHERE ID = ?
          `;

    if (detalles && detalles.length > 0) {
      for (const detalle of detalles) {
        await connection.query(queryDetalle, [
          idLeasingCab,
          detalle.idpla,
          detalle.secCon,
          detalle.modelo,
          detalle.tipoTerreno,
          detalle.numpla,
          detalle.codini,
          detalle.cantidad,
        ]);

        await connection.query(queryUpdateVehiculo, [detalle.idpla]);
      }
    }

    res.json({ success: true });
  } catch (error) {
    console.error("Error al insertar Leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al insertar Leasing" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

module.exports = {
  listLeasing,
  listLeasingOfClient,
  insertLeasing,
};
