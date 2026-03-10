const {
  decodeString,
  convertirFecha,
  funcionNumerica,
  funcionParteVar,
  obtenerUltimoIdLea,
} = require("../../shared/utils.js");
const connection = require("../../shared/connect.js");
const { SCHEMA_BD, IP_LOCAL } = require("../../shared/conf.js");

const listLeasing = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const result = await cn.query(
      `SELECT ID, NRO_LEASING FROM ${SCHEMA_BD}.TBL_LEASING_CAB ORDER BY NRO_LEASING ASC`,
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
    if (cn) {
      await cn.close();
    }
  }
};

const listLeasingOfClient = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { idCli } = req.query;

  // Validación de parametros query
  if (!idCli) {
    return res.status(400).json({
      success: false,
      message: "Los parámetros idCli son obligatorios.",
    });
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const query = `
        SELECT ID, NRO_LEASING 
        FROM ${SCHEMA_BD}.TBL_LEASING_CAB 
        WHERE ID_CLIENTE = ? ORDER BY NRO_LEASING ASC
      `;

    const result = await cn.query(query, [idCli]);

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
    if (cn) {
      await cn.close();
    }
  }
};

const listLeasingByContract = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { contratoId, clienteId } = req.query;

  if (!contratoId || !clienteId)
    return res.status(400).json({
      success: false,
      message: "El parametro contratoId y clienteId son obligatorio",
    });

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const sql = `
      SELECT A.NRO_LEASING, A.CANT_VEH, A.FECHA_INI, A.FECHA_FIN, A.ID_CONTRATO, A.ID_CLIENTE
      FROM ${SCHEMA_BD}.TBL_LEASING_CAB A 
      WHERE A.ID_CONTRATO = ? AND A.ID_CLIENTE = ?
    `;

    const result = await cn.query(sql, [contratoId, clienteId]);

    const cleanedResult = result.map((row) => ({
      nroLeasing: row.NRO_LEASING ? row.NRO_LEASING.trim() : "",
      fechaInicio: row.FECHA_INI ? row.FECHA_INI.toString().trim() : "",
      fechaFin: row.FECHA_FIN ? row.FECHA_FIN.toString().trim() : "",
      cantVehi: row.CANT_VEH,
    }));

    return res.status(200).json(cleanedResult);
  } catch (error) {
    console.error("Error al listar leasings por contrato: ", error);
    return res.status(500).json({
      success: false,
      message: "Error al listar leasings por contrato",
    });
  } finally {
    if (cn) await cn.close();
  }
};

const detailLeasing = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { leasingId } = req.query;

  if (!leasingId)
    return res.status(400).json({
      success: false,
      message: "El parametro leasingId es obligatorio",
    });

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const sql = `
      SELECT NRO_LEASING, BANCO, CANT_VEH, FECHA_INI, FECHA_FIN, PERIODO_GRACIA, PDF, DESCRIPCION, TIPCON FROM ${SCHEMA_BD}.TBL_LEASING_CAB
      WHERE NRO_LEASING = ?
    `;

    const result = await cn.query(sql, [leasingId]);

    if (result.length == 0 || !result[0])
      return res
        .status(404)
        .json({ success: false, message: "No se encontro el leasing" });

    const findLeasing = result[0];

    return res.status(200).json({
      nroLeasing: findLeasing.NRO_LEASING.trim(),
      banco: findLeasing.BANCO.trim(),
      cantVehi: findLeasing.CANT_VEH,
      fechaInicio: findLeasing.FECHA_INI.toString(),
      fechaFin: findLeasing.FECHA_FIN.toString(),
      periGracia: findLeasing.PERIODO_GRACIA,
      archivoPdf: findLeasing.PDF.trim(),
      descripcion: findLeasing.DESCRIPCION
        ? findLeasing.DESCRIPCION.trim()
        : "",
      tipo: findLeasing.TIPCON.trim(),
    });
  } catch (error) {
    console.error("Error al obtener detalle de leasing: ", error);
    return res
      .status(500)
      .json({ success: false, message: "Error al obtener detalle de leasing" });
  } finally {
    if (cn) await cn.close();
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

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const queryCabecera = `
              INSERT INTO ${SCHEMA_BD}.TBL_LEASING_CAB 
              (ID_CLIENTE, NRO_LEASING, BANCO, CANT_VEH, FECHA_INI, FECHA_FIN, PERIODO_GRACIA, PDF, ID_CONTRATO, TIPCON)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    const result = await cn.query(queryCabecera, [
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
      result.insertId || (await obtenerUltimoIdLea(cn));

    const queryDetalle = `
              INSERT INTO ${SCHEMA_BD}.TBL_LEASING_DET 
              (ID_LEA_CAB, ID_VEH, SEC_CON, MODELO, TIPO_TERRENO, PLACA, CODINI, CANTIDAD)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
          `;

    const queryUpdateVehiculo = `
              UPDATE ${SCHEMA_BD}.PO_VEHICULO 
              SET INIVAL1 = '1' 
              WHERE ID = ?
          `;

    if (detalles && detalles.length > 0) {
      for (const detalle of detalles) {
        await cn.query(queryDetalle, [
          idLeasingCab,
          detalle.idpla,
          detalle.secCon,
          detalle.modelo,
          detalle.tipoTerreno,
          detalle.numpla,
          detalle.codini,
          detalle.cantidad,
        ]);

        await cn.query(queryUpdateVehiculo, [detalle.idpla]);
      }
    }

    res.json({ success: true });
  } catch (error) {
    console.error("Error al insertar Leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al insertar Leasing" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

module.exports = {
  listLeasing,
  listLeasingOfClient,
  listLeasingByContract,
  detailLeasing,
  insertLeasing,
};
