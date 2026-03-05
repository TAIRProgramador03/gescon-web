const {
  decodeString,
  obtenerUltimoIdAsigna,
  convertirFecha,
  funcionNumerica,
  funcionParteVar,
} = require("../../shared/utils.js");
const connection = require("../../shared/connect.js");

const listOperations = async (req, res) => {
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
      SELECT ID, DESCRIPCION 
      FROM SPEED400AT.PO_OPERACIONES 
      WHERE SITUACION='S' AND IDCLI = ?
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
    console.error("Error al obtener las operaciones:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener las operaciones" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

const insertOperation = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { idCliente, valorRepe, detalles } = req.body;

  const cn = await connection(globalDbUser, globalPassword);

  let fechita = new Date().toISOString().split("T")[0];
  let converFecha = convertirFecha(fechita);

  try {
    const queryCabecera = `
              INSERT INTO SPEED400AT.TBL_ASIGNACION_CAB 
              (ID_CLIENTE, FECHA, USUARIO)
              VALUES (?, ?, ?)
          `;

    const result = await cn.query(queryCabecera, [
      idCliente,
      converFecha,
      globalDbUser,
    ]);

    const idAsignaCab =
      result.insertId || (await obtenerUltimoIdAsigna(cn));

    const queryDetalle = `
              INSERT INTO SPEED400AT.TBL_ASIGNACION_DET 
              (ID_ASIGNACION, ID_VEH, SEC_CON, PLACA, TARIFA, ID_OPE, ID_CONTRATO, TP_TERRENO, FECHA_INI, FECHA_FIN, LEASING, CLASE_CONTRATO)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    /*const queryTarifa = `
              INSERT INTO SPEED400AT.PO_TARIFAS 
              (PLACA, REGISTRO, INIVAL, TARIFA, MONEDA, CPK, RECMEN, FECHADEVOLUCION, IDOPE, USUARIO)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;*/

    /*if (detalles && detalles.length > 0) {
              for (const detalle of detalles) {
                  await connection.query(queryDetalle, [
                      idAsignaCab,
                      detalle.idveh,
                      detalle.secCon,
                      detalle.numpla,
                      detalle.tarifa,
                      detalle.idOperacion,
                      funcionNumerica(detalle.idContrato),
                      detalle.idTerreno,
                      convertirFecha(detalle.fechaIni),
                      convertirFecha(detalle.fechaFin),
                      detalle.leasing,
                      funcionParteVar(detalle.idContrato)
                  ]);
              }
          }*/

    if (detalles && detalles.length > 0) {
      let fechaIniGlobal = null;
      let fechaFinGlobal = null;

      for (let i = 0; i < detalles.length; i++) {
        const detalle = detalles[i];

        // Si valorRepe es true, toma las fechas del primer detalle y reutilízalas
        if (valorRepe === true || valorRepe === "true") {
          if (i === 0) {
            fechaIniGlobal = convertirFecha(detalle.fechaIni);
            fechaFinGlobal = convertirFecha(detalle.fechaFin);
          }
        }

        await connection.query(queryDetalle, [
          idAsignaCab,
          detalle.idveh,
          detalle.secCon,
          detalle.numpla,
          detalle.tarifa,
          detalle.idOperacion,
          funcionNumerica(detalle.idContrato),
          detalle.idTerreno,
          valorRepe ? fechaIniGlobal : convertirFecha(detalle.fechaIni),
          valorRepe ? fechaFinGlobal : convertirFecha(detalle.fechaFin),
          detalle.leasing,
          funcionParteVar(detalle.idContrato),
        ]);
      }
    }

    /*if (detalles && detalles.length > 0) {
              for (const detalle of detalles) {
                  await connection.query(queryTarifa, [
                      detalle.numpla,
                      date.now(),
                      convertirFecha(detalle.fechaIni),
                      detalle.tarifa,
                      '1',
                      '0',
                      '0',
                      convertirFecha(detalle.fechaFin),
                      detalle.idOperacion,
                      globalDbUser
                  ]);
              }
          }*/

    res.json({ success: true });
  } catch (error) {
    console.error("Error al insertar la asignacion vehicular:", error);
    res.status(500).json({
      success: false,
      message: "Error al insertar la asignacion vehicular",
    });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

module.exports = {
  listOperations,
  insertOperation,
};
