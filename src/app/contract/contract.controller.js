const { IP_LOCAL } = require("../../shared/conf.js");
const {
  decodeString,
  convertirFecha,
  obtenerUltimoId,
} = require("../../shared/utils.js");
const connection = require("../../shared/connect.js");

const contractNro = async (req, res) => {
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

  const cn = await connection(globalDbUser, globalPassword);

  try {
    // Consulta los contratos asociados al cliente
    const query = `
    SELECT ID, NRO_CONTRATO AS DESCRIPCION 
    FROM SPEED400AT.TBLCONTRATO_CAB 
    WHERE ID_CLIENTE = ?
    `;
    const result = await cn.query(query, [idCli]);

    const cleanedResult = result.map((row) => {
      return {
        ID:
          row.ID !== null && row.ID !== undefined
            ? row.ID.toString().trim()
            : null, // Convierte a string si es necesario
        DESCRIPCION:
          row.DESCRIPCION !== null && row.DESCRIPCION !== undefined
            ? decodeString(row.DESCRIPCION.toString().trim())
            : null,
      };
    });

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener contratos" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const contractNroAdi = async (req, res) => {
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

  const cn = await connection(globalDbUser, globalPassword);

  try {
    // Consulta los contratos asociados al cliente
    const query = `
      SELECT * FROM ((SELECT CONCAT('P_', ID) AS ID, NRO_CONTRATO AS DESCRIPCION FROM SPEED400AT.TBLCONTRATO_CAB WHERE ID_CLIENTE= ? ) 
      UNION ALL (SELECT CONCAT('H_', ID) AS ID, NRO_DOC AS DESCRIPCION FROM SPEED400AT.TBLDOCUMENTO_CAB WHERE ID_CLIENTE= ? )) AS CONTRATOS 
      ORDER BY DESCRIPCION ASC
    `;
    const result = await cn.query(query, [idCli, idCli]);

    const cleanedResult = result.map((row) => {
      return {
        ID:
          row.ID !== null && row.ID !== undefined
            ? row.ID.toString().trim()
            : null, // Convierte a string si es necesario
        DESCRIPCION:
          row.DESCRIPCION !== null && row.DESCRIPCION !== undefined
            ? decodeString(row.DESCRIPCION.toString().trim())
            : null,
      };
    });

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener contratos" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const tableContract = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { idCli, id } = req.query; // Obtiene los parámetros de consulta

  // Validación inicial
  if (!idCli || !id) {
    return res.status(400).json({
      success: false,
      message: "Los parámetros idCli e id son obligatorios.",
    });
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    // Usa parámetros preparados para prevenir inyección SQL
    const query = `
              SELECT NRO_CONTRATO AS DESCRIPCION, FECHA_FIRMA AS FECHACREA, CANT_VEHI AS TOTVEH, DURACION
              FROM SPEED400AT.TBLCONTRATO_CAB
              WHERE ID_CLIENTE = ? AND ID = ?
          `;
    const result = await cn.query(query, [idCli, id]);

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

    // Envía los resultados como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res.status(500).json({
      success: false,
      message: "Error al obtener los datos. Por favor intente más tarde.",
    });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const detailContract = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { contratoId } = req.query; // Obtiene el contratoId de los parámetros de consulta

  if (!contratoId) {
    return res
      .status(400)
      .json({ success: false, message: "El contratoId es obligatorio" });
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    // Consulta los detalles del contrato
    const query = `
              SELECT A.DESCRIPCION, A.FECHA_FIRMA, A.DURACION, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, (A.CANT_VEHI + COALESCE(SUM(B.CANT_VEHI), 0)) AS TOTAL_VEHICULOS, COUNT(B.ID) AS CANT_DOC 
              FROM SPEED400AT.TBLCONTRATO_CAB A LEFT JOIN SPEED400AT.TBLDOCUMENTO_CAB B ON A.ID=B.ID_PADRE WHERE NRO_CONTRATO = ? 
              GROUP BY A.DESCRIPCION, A.FECHA_FIRMA, A.DURACION, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, A.CANT_VEHI, A.ID`;
    const result = await cn.query(query, [contratoId]);

    if (result.length === 0) {
      return res
        .status(404)
        .json({ success: false, message: "Contrato no encontrado" });
    }

    // Suponemos que hay solo un contrato en los resultados
    const contrato = result[0];

    // Respuesta con los detalles del contrato
    res.json({
      success: true,
      data: {
        descripcion: contrato.DESCRIPCION,
        fechaFirma: contrato.FECHA_FIRMA,
        duracion: contrato.DURACION,
        vehiculoSup: contrato.VEH_SUP,
        vehiculoSev: contrato.VEH_SEV,
        vehiculoSoc: contrato.VEH_SOC,
        vehiculoCiu: contrato.VEH_CIU,
        cantidadVehiculos: contrato.TOTAL_VEHICULOS,
        cantidadDocumentos: contrato.CANT_DOC,
      },
    });
  } catch (error) {
    console.error("Error al obtener los detalles del contrato:", error);
    res.status(500).json({
      success: false,
      message: "Error al obtener los detalles del contrato",
    });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const contContract = async (req, res) => {
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
      "SELECT COUNT(DISTINCT A.ID) AS PADRE, SUM(CASE WHEN B.TIPO_DOC = 1 THEN 1 ELSE 0 END) AS TIPO_1, SUM(CASE WHEN B.TIPO_DOC = 2 THEN 1 ELSE 0 END) AS TIPO_2, SUM(CASE WHEN B.TIPO_DOC = 3 THEN 1 ELSE 0 END) AS TIPO_3 FROM SPEED400AT.TBLCONTRATO_CAB A FULL OUTER JOIN SPEED400AT.TBLDOCUMENTO_CAB B ON A.ID=B.ID_PADRE",
    );

    // Decodificar los resultados desde latin1
    const contra = result[0];

    // Respuesta con los detalles del contrato
    res.json({
      success: true,
      data: {
        PADRE: contra.PADRE,
        TIPO_1: contra.TIPO_1,
        TIPO_2: contra.TIPO_2,
        TIPO_3: contra.TIPO_3,
      },
    });
  } catch (error) {
    console.error("Error al obtener los contadores:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los contadores" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const contClient = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const result = await cn.query(`
              SELECT C.CLINOM, C.CLIABR, A.ID_CLIENTE, 
                  SUM(COALESCE(A.CANT_VEHI, 0) + COALESCE(B.CANT_VEHI, 0)) AS TOTAL_VEHICULOS 
              FROM SPEED400AT.TBLCONTRATO_CAB A
              LEFT JOIN SPEED400AT.TBLDOCUMENTO_CAB B ON A.ID = B.ID_PADRE
              LEFT JOIN SPEED400AT.TCLIE C ON CASE 
                  WHEN C.CLICVE NOT LIKE '%[^0-9]%' THEN C.CLICVE ELSE NULL END = CAST(A.ID_CLIENTE AS VARCHAR(20))
              GROUP BY A.ID_CLIENTE, C.CLINOM, C.CLIABR
              ORDER BY TOTAL_VEHICULOS DESC 
              FETCH FIRST 3 ROWS ONLY
          `);

    res.json({ success: true, data: result });
  } catch (error) {
    console.error("Error al obtener los contadores:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los contadores" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const insertContract = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const {
    idCliente,
    nroContrato,
    cantVehiculos,
    fechaFirma,
    duracion,
    kmAdicional,
    kmTotal,
    vehSup,
    vehSev,
    vehSoc,
    vehCiu,
    tipoMoneda,
    tipoCliente,
    contratoEspecial,
    story,
    detalles,
    archivoPdf,
  } = req.body;

  const claseContra = "P";
  const fechaFormatoDB = convertirFecha(fechaFirma);
  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/contracts/${archivoPdf}`;

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const queryCabecera = `
              INSERT INTO SPEED400AT.TBLCONTRATO_CAB 
              (ID_CLIENTE, NRO_CONTRATO, CANT_VEHI, FECHA_FIRMA, DURACION, KM_ADI, KM_TOTAL, VEH_SUP, VEH_SEV, VEH_SOC, VEH_CIU, TIPO_CONT, TIPO_CLI, MONEDA, DESCRIPCION, ARCHIVO_PDF, CLASE)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    const result = await cn.query(queryCabecera, [
      idCliente,
      nroContrato,
      cantVehiculos,
      fechaFormatoDB,
      duracion,
      kmAdicional,
      kmTotal,
      vehSup,
      vehSev,
      vehSoc,
      vehCiu,
      contratoEspecial,
      tipoCliente,
      tipoMoneda,
      story,
      nombreArchivo,
      claseContra,
    ]);

    const idContratoCab =
      result.insertId || (await obtenerUltimoId(cn));

    const queryDetalle = `
              INSERT INTO SPEED400AT.TBLCONTRATO_DET 
              (ID_CON_CAB, SEC_CON, MODELO, TIPO_TERRENO, TARIFA, CPK, RM, CANTIDAD, DURACION, PRECIO_VEH, PRECIO_VENTA)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    if (detalles && detalles.length > 0) {
      for (const detalle of detalles) {
        await cn.query(queryDetalle, [
          idContratoCab,
          detalle.secCon,
          detalle.modelo,
          detalle.tipoTerreno,
          detalle.tarifa,
          detalle.cpk,
          detalle.rm,
          detalle.cantidad,
          detalle.duracion,
          detalle.compraVeh,
          detalle.precioVeh,
        ]);
      }
    }

    res.json({ success: true });
  } catch (error) {
    console.error("Error al insertar contrato:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al insertar contrato" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const valideContractQuantity = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { detalles } = req.body;

  if (!Array.isArray(detalles) || detalles.length === 0) {
    return res
      .status(400)
      .json({ success: false, mensaje: "Detalles faltantes o vacíos" });
  }

  const agrupados = {};
  for (let d of detalles) {
    let clase = funcionParteVar(d.idContrato);
    console.log(clase);
    let idContrato = funcionNumerica(d.idContrato);
    console.log(idContrato);

    if (!clase || !idContrato) {
      return res.status(400).json({
        success: false,
        mensaje: `Formato de contrato inválido en el detalle: ${d.idContrato}`,
      });
    }

    let key = `${clase}_${idContrato}`;
    if (!agrupados[key]) {
      agrupados[key] = {
        clase,
        idContrato,
        terrenos: [],
      };
    }

    agrupados[key].terrenos.push(d.idTerreno);
    console.log(d.idTerreno);
  }

  const cn = await connection(globalDbUser, globalPassword);

  try {
    for (let key in agrupados) {
      let { clase, idContrato, terrenos } = agrupados[key];
      let squery = "";

      // Consulta SQL según el tipo de contrato
      if (clase.trim() === "H") {
        squery = `SELECT A.ID, A.CANT_VEHI, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, TRIM(A.CLASE) AS CLASE, 
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='0') AS SUPERFICIE,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='1') AS SOCAVON,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='2') AS CIUDAD,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='3') AS SEVERO,
                          (SELECT COUNT(*) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND CLASE_CONTRATO=A.CLASE) AS CANTIDAD 
                          FROM SPEED400AT.TBLDOCUMENTO_CAB A WHERE A.ID = ? AND CLASE='H'`;
      } else {
        squery = `SELECT A.ID, A.CANT_VEHI, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, TRIM(A.CLASE) AS CLASE,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='0') AS SUPERFICIE,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='1') AS SOCAVON,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='2') AS CIUDAD,
                          (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='3') AS SEVERO,
                          (SELECT COUNT(*) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND CLASE_CONTRATO=A.CLASE) AS CANTIDAD 
                          FROM SPEED400AT.TBLCONTRATO_CAB A WHERE A.ID = ? AND CLASE='P'`;
      }

      let result = await cn.query(squery, [idContrato]);

      if (!result || result.length === 0) {
        return res.status(404).json({
          success: false,
          mensaje: `Contrato no encontrado: ${clase}_${idContrato}`,
        });
      }

      let row = result[0];
      let contadorNuevo = { 0: 0, 1: 0, 2: 0, 3: 0 };

      // Contamos cuántos terrenos de cada tipo existen en el detalle
      terrenos.forEach((tipo) => {
        let t = tipo?.toString();
        if (t in contadorNuevo) contadorNuevo[t]++;
      });

      console.log(contadorNuevo);

      let validaciones = [
        {
          tipo: "SUPERFICIE",
          cod: "0",
          maximo: row.VEH_SUP,
          actual: row.SUPERFICIE,
        },
        { tipo: "SOCAVÓN", cod: "1", maximo: row.VEH_SOC, actual: row.SOCAVON },
        { tipo: "CIUDAD", cod: "2", maximo: row.VEH_CIU, actual: row.CIUDAD },
        { tipo: "SEVERO", cod: "3", maximo: row.VEH_SEV, actual: row.SEVERO },
      ];

      for (let v of validaciones) {
        let nuevos = contadorNuevo[v.cod] || 0;
        console.log(
          `Tipo: ${v.tipo}, Actual: ${v.actual}, Nuevos: ${nuevos}, Máximo: ${v.maximo}`,
        );
        if (v.actual + nuevos > v.maximo) {
          console.log("Límite excedido para terreno tipo: " + v.tipo);
          return res.json({
            success: false,
            mensaje: `Límite excedido para terreno tipo ${v.tipo} en contrato ${clase}_${idContrato}. Permitido: ${v.maximo}, asignados: ${v.actual}, nuevos: ${nuevos}.`,
          });
        }
      }
      // Validación de límite de vehículos
      if (row.CANTIDAD + terrenos.length > row.CANT_VEHI) {
        return res.json({
          success: false,
          mensaje: `Límite total de vehículos excedido para contrato ${clase}_${idContrato}. Máximo: ${row.CANT_VEHI}, asignados: ${row.CANTIDAD}, nuevos: ${terrenos.length}.`,
        });
      }
    }

    return res.json({ success: true });
  } catch (error) {
    console.error("Error en validación de contratos:", error);
    return res.status(500).json({
      success: false,
      mensaje: "Error interno del servidor durante la validación",
    });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

module.exports = {
  contractNro,
  contractNroAdi,
  tableContract,
  detailContract,
  contContract,
  contClient,
  insertContract,
  valideContractQuantity
};
