const connection = require("../../shared/connect.js");
const { SCHEMA_BD } = require("../../shared/conf.js");

const contVehicleFeet = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { clienteId, status } = req.query; // Obtiene el idCli de los parámetros de consulta

  const cn = await connection(globalDbUser, globalPassword);

  try {
    let sql = `
      SELECT COALESCE(SUM(TOTAL_VEHICULO), 0) AS TOTAL_VEHICULO, COALESCE(SUM(TOTAL_VENTA), 0) AS TOTAL_VENTA 
      FROM (
        SELECT CC.ID_CLIENTE, SUM(CD.PRECIO_VEH * CD.CANTIDAD) AS TOTAL_VEHICULO, SUM(CD.PRECIO_VENTA * CD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLCONTRATO_DET CD
        LEFT JOIN ${SCHEMA_BD}.TBLCONTRATO_CAB CC
        ON CC.ID = CD.ID_CON_CAB
        GROUP BY CC.ID_CLIENTE

        UNION ALL

        SELECT DC.ID_CLIENTE, SUM(DD.PRECIO_VEH * DD.CANTIDAD) AS TOTAL_VEHICULO, SUM(DD.PRECIO_VENTA * DD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLDOCUMENTO_DET DD
        LEFT JOIN ${SCHEMA_BD}.TBLDOCUMENTO_CAB DC
        ON DC.ID = DD.ID_CON_CAB
        GROUP BY DC.ID_CLIENTE
      )
    `;

    const params = [];

    if (status) {
      if (status == "A") {
        sql = `
          SELECT COALESCE(SUM(TOTAL_VEHICULO), 0) AS TOTAL_VEHICULO, COALESCE(SUM(TOTAL_VENTA), 0) AS TOTAL_VENTA 
          FROM (
            SELECT CC.ID_CLIENTE, SUM(CD.PRECIO_VEH * CD.CANTIDAD) AS TOTAL_VEHICULO, SUM(CD.PRECIO_VENTA * CD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLCONTRATO_DET CD
            LEFT JOIN ${SCHEMA_BD}.TBLCONTRATO_CAB CC
            ON CC.ID = CD.ID_CON_CAB
            WHERE ADD_MONTHS(
              DATE(
                SUBSTR(CC.FECHA_FIRMA, 1, 4) || '-' || 
                SUBSTR(CC.FECHA_FIRMA, 5, 2) || '-'  ||
                SUBSTR(CC.FECHA_FIRMA, 7, 2)
              ),
              CAST(CC.DURACION AS INT)
            ) > CURRENT DATE
            GROUP BY CC.ID_CLIENTE

            UNION ALL

            SELECT DC.ID_CLIENTE, SUM(DD.PRECIO_VEH * DD.CANTIDAD) AS TOTAL_VEHICULO, SUM(DD.PRECIO_VENTA * DD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLDOCUMENTO_DET DD
            LEFT JOIN ${SCHEMA_BD}.TBLDOCUMENTO_CAB DC
            ON DC.ID = DD.ID_CON_CAB
            WHERE ADD_MONTHS(
              DATE(
                SUBSTR(DC.FECHA_FIRMA, 1, 4) || '-' || 
                SUBSTR(DC.FECHA_FIRMA, 5, 2) || '-'  ||
                SUBSTR(DC.FECHA_FIRMA, 7, 2)
              ),
              CAST(DC.DURACION AS INT)
            ) > CURRENT DATE
          GROUP BY DC.ID_CLIENTE
          )
        `;
      } else if (status == "F") {
        sql = `
          SELECT COALESCE(SUM(TOTAL_VEHICULO), 0) AS TOTAL_VEHICULO, COALESCE(SUM(TOTAL_VENTA), 0) AS TOTAL_VENTA 
          FROM (
            SELECT CC.ID_CLIENTE, SUM(CD.PRECIO_VEH * CD.CANTIDAD) AS TOTAL_VEHICULO, SUM(CD.PRECIO_VENTA * CD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLCONTRATO_DET CD
            LEFT JOIN ${SCHEMA_BD}.TBLCONTRATO_CAB CC
            ON CC.ID = CD.ID_CON_CAB
            WHERE ADD_MONTHS(
              DATE(
                SUBSTR(CC.FECHA_FIRMA, 1, 4) || '-' || 
                SUBSTR(CC.FECHA_FIRMA, 5, 2) || '-'  ||
                SUBSTR(CC.FECHA_FIRMA, 7, 2)
              ),
              CAST(CC.DURACION AS INT)
            ) < CURRENT DATE
            GROUP BY CC.ID_CLIENTE

            UNION ALL

            SELECT DC.ID_CLIENTE, SUM(DD.PRECIO_VEH * DD.CANTIDAD) AS TOTAL_VEHICULO, SUM(DD.PRECIO_VENTA * DD.CANTIDAD) AS TOTAL_VENTA FROM ${SCHEMA_BD}.TBLDOCUMENTO_DET DD
            LEFT JOIN ${SCHEMA_BD}.TBLDOCUMENTO_CAB DC
            ON DC.ID = DD.ID_CON_CAB
            WHERE ADD_MONTHS(
              DATE(
                SUBSTR(DC.FECHA_FIRMA, 1, 4) || '-' || 
                SUBSTR(DC.FECHA_FIRMA, 5, 2) || '-'  ||
                SUBSTR(DC.FECHA_FIRMA, 7, 2)
              ),
              CAST(DC.DURACION AS INT)
            ) < CURRENT DATE
          GROUP BY DC.ID_CLIENTE
          )
        `;
      }
    }

    if (clienteId) {
      sql += ` WHERE ID_CLIENTE = ?`;
      params.push(clienteId);
    }

    const result = await cn.query(sql, params);

    if (result.length == 0 || !result[0])
      return res
        .status(400)
        .json({ success: false, message: "No se encontraron resultados" });

    return res.status(200).json({
      totalCosto: result[0].TOTAL_VEHICULO,
      totalVenta: result[0].TOTAL_VENTA,
    });
  } catch (error) {
    console.error("Error al obtener reporte de flota vehicular", error);
    return res.status(500).json({
      success: false,
      message: "Error al obtener reporte de flota vehicular",
    });
  } finally {
    if (cn) await cn.close();
  }
};

const contLeasings = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { clienteId } = req.query;

  const draw = parseInt(req.query.draw);
  let start = parseInt(req.query.start) || 0;
  let length = parseInt(req.query.length) || 10;

  const cn = await connection(globalDbUser, globalPassword);

  try {
    let sql = `
      SELECT * FROM (
      SELECT 
        LD.ID,
        LD.PLACA,
        LD.MODELO,
        LC.NRO_LEASING,
        LC.ID_CLIENTE AS CLIENTE,
        LC.TIPCON AS TIPO_CON,
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        ) AS FECHA_INI_CON,
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        ) AS FECHA_FIN_CON,
        CAST(ROUND((DAYS(
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_CONTRATO,
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        ) AS FECHA_INI_LEA,
        DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        ) AS FECHA_FIN_LEA,
        CAST(ROUND((DAYS(
          DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_LEA,
        DAYS(
          ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
            CAST(C.DURACION AS INT)
          )
        ) - DAYS (
          DATE(
            SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
            SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
            SUBSTR(LC.FECHA_FIN, 7, 2)
          )
        ) AS DIFERENCIA_DIAS
      FROM SPEED400AT.TBL_LEASING_DET LD
      LEFT JOIN SPEED400AT.TBL_LEASING_CAB LC
      ON LD.ID_LEA_CAB = LC.ID
      LEFT JOIN SPEED400AT.TBLCONTRATO_CAB C
      ON LC.ID_CONTRATO = C.ID
      WHERE LC.TIPCON = 'P'
      UNION ALL
      SELECT 
        LD.ID,
        LD.PLACA,
        LD.MODELO,
        LC.NRO_LEASING,
        LC.ID_CLIENTE AS CLIENTE,
        LC.TIPCON AS TIPO_CON,
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        ) AS FECHA_INI_CON,
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        ) AS FECHA_FIN_CON,
        CAST(ROUND((DAYS(
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_CONTRATO,
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        ) AS FECHA_INI_LEA,
        DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        ) AS FECHA_FIN_LEA,
        CAST(ROUND((DAYS(
          DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_LEA,
        DAYS(
          ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
            CAST(C.DURACION AS INT)
          )
        ) - DAYS (
          DATE(
            SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
            SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
            SUBSTR(LC.FECHA_FIN, 7, 2)
          )
        ) AS DIFERENCIA_DIAS
      FROM SPEED400AT.TBL_LEASING_DET LD
      LEFT JOIN SPEED400AT.TBL_LEASING_CAB LC
      ON LD.ID_LEA_CAB = LC.ID
      LEFT JOIN SPEED400AT.TBLDOCUMENTO_CAB C
      ON LC.ID_CONTRATO = C.ID
      WHERE LC.TIPCON = 'H')
      ${clienteId ? `WHERE CLIENTE = ?` : ""}
      ORDER BY ID
      OFFSET ? ROWS
      FETCH NEXT ? ROWS ONLY
    `;

    const params = [];

    let sqlCount = `
    SELECT COUNT(ID) AS TOTAL FROM (
      SELECT 
        LD.ID,
        LD.PLACA,
        LD.MODELO,
        LC.NRO_LEASING,
        LC.ID_CLIENTE AS CLIENTE,
        LC.TIPCON AS TIPO_CON,
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        ) AS FECHA_INI_CON,
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        ) AS FECHA_FIN_CON,
        CAST(ROUND((DAYS(
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_CONTRATO,
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        ) AS FECHA_INI_LEA,
        DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        ) AS FECHA_FIN_LEA,
        CAST(ROUND((DAYS(
          DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_LEA,
        DAYS(
          ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
            CAST(C.DURACION AS INT)
          )
        ) - DAYS (
          DATE(
            SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
            SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
            SUBSTR(LC.FECHA_FIN, 7, 2)
          )
        ) AS DIFERENCIA_DIAS
      FROM SPEED400AT.TBL_LEASING_DET LD
      LEFT JOIN SPEED400AT.TBL_LEASING_CAB LC
      ON LD.ID_LEA_CAB = LC.ID
      LEFT JOIN SPEED400AT.TBLCONTRATO_CAB C
      ON LC.ID_CONTRATO = C.ID
      WHERE LC.TIPCON = 'P'
      UNION ALL
      SELECT 
        LD.ID,
        LD.PLACA,
        LD.MODELO,
        LC.NRO_LEASING,
        LC.ID_CLIENTE AS CLIENTE,
        LC.TIPCON AS TIPO_CON,
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        ) AS FECHA_INI_CON,
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        ) AS FECHA_FIN_CON,
        CAST(ROUND((DAYS(
        ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
          CAST(C.DURACION AS INT)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
          SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
          SUBSTR(C.FECHA_FIRMA, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_CONTRATO,
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        ) AS FECHA_INI_LEA,
        DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        ) AS FECHA_FIN_LEA,
        CAST(ROUND((DAYS(
          DATE(
          SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_FIN, 7, 2)
        )
        ) -
        DAYS (
        DATE(
          SUBSTR(LC.FECHA_INI, 1, 4) || '-' || 
          SUBSTR(LC.FECHA_INI, 5, 2) || '-'  ||
          SUBSTR(LC.FECHA_INI, 7, 2)
        )
        )) / 365.25, 0) AS INTEGER) AS ANOS_LEA,
        DAYS(
          ADD_MONTHS(
          DATE(
            SUBSTR(C.FECHA_FIRMA, 1, 4) || '-' || 
            SUBSTR(C.FECHA_FIRMA, 5, 2) || '-'  ||
            SUBSTR(C.FECHA_FIRMA, 7, 2)
          ),
            CAST(C.DURACION AS INT)
          )
        ) - DAYS (
          DATE(
            SUBSTR(LC.FECHA_FIN, 1, 4) || '-' || 
            SUBSTR(LC.FECHA_FIN, 5, 2) || '-'  ||
            SUBSTR(LC.FECHA_FIN, 7, 2)
          )
        ) AS DIFERENCIA_DIAS
      FROM SPEED400AT.TBL_LEASING_DET LD
      LEFT JOIN SPEED400AT.TBL_LEASING_CAB LC
      ON LD.ID_LEA_CAB = LC.ID
      LEFT JOIN SPEED400AT.TBLDOCUMENTO_CAB C
      ON LC.ID_CONTRATO = C.ID
      WHERE LC.TIPCON = 'H')
      ${clienteId ? `WHERE CLIENTE = ?` : ""}
    `;

    const paramsTotal = [];

    if (clienteId) {
      params.push(clienteId, start, length);
      paramsTotal.push(clienteId);
    } else {
      params.push(start, length)
    }

    const result = await cn.query(sql, params);

    const resultTotal = await cn.query(sqlCount, paramsTotal);

    const cleanedResult = result.map((row) => ({
      id: row.ID,
      placa: row.PLACA.trim(),
      modelo: row.MODELO.trim(),
      nroLeasing: row.NRO_LEASING.trim(),
      cliente: row.CLIENTE,
      tipoCont: row.TIPO_CON.trim(),
      fechaIniCont: row.FECHA_INI_CON.trim(),
      fechaFinCont: row.FECHA_FIN_CON.trim(),
      añosContrato: row.ANOS_CONTRATO,
      fechaIniLea: row.FECHA_INI_LEA.trim(),
      fechaFinLea: row.FECHA_FIN_LEA.trim(),
      añosLeasing: row.ANOS_LEA,
      diferenciaDias: row.DIFERENCIA_DIAS,
    }));

    const totalElements = resultTotal[0].TOTAL;
    const totalPages = Math.ceil(totalElements / length);

    return res.status(200).json({
      draw: draw,
      recordsTotal: totalElements,
      recordsFiltered: totalElements,
      totalPages: totalPages,
      page: start / length + 1,
      data: cleanedResult,
    });
  } catch (error) {
    console.error("Error al obtener reporte de leasings", error);
    return res
      .status(500)
      .json({
        success: false,
        message: "Error al obtener reportes de leasings",
      });
  } finally {
    if (cn) await cn.close();
  }
};

module.exports = {
  contVehicleFeet,
  contLeasings,
};
