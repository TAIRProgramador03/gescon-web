const { convertirFecha, obtenerUltimoIdDoc } = require("../../shared/utils.js");
const connection = require("../../shared/connect.js");

const listDocumentByNroContract = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { contratoId } = req.query;

  if (!contratoId)
    return res.status(400).json({
      success: false,
      message: "El parametro contratoId es obligatorio",
    });

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const sql = `
      SELECT A.NRO_DOC, A.CANT_VEHI, A.FECHA_FIRMA, A.DURACION
      FROM SPEED400AT.TBLDOCUMENTO_CAB A 
      INNER JOIN SPEED400AT.TBLCONTRATO_CAB B ON B.ID=A.ID_PADRE 
      WHERE B.NRO_CONTRATO = ?
    `;

    const result = await cn.query(sql, [contratoId]);

    const cleanedResult = result.map((row) => ({
      nroDocumento: row.NRO_DOC ? row.NRO_DOC.trim() : "",
      fechaFirma: row.FECHA_FIRMA ? row.FECHA_FIRMA.trim() : "",
      cantVehi: row.CANT_VEHI,
      duracion: row.DURACION ? row.DURACION.trim() : "",
    }));

    return res.status(200).json(cleanedResult);
  } catch (error) {
    console.error("Error al listar documentos por contrato: ", error);
    return res.status(500).json({
      success: false,
      message: "Error al listar documentos por contrato",
    });
  } finally {
    if (cn) await cn.close();
  }
};

const detailDocument = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const { contratoId } = req.query;

  if (!contratoId)
    return res.status(400).json({
      success: false,
      message: "El parametro contratoId es obligatorio",
    });

  const cn = await connection(globalDbUser, globalPassword);

  try {
    const sql = `
      SELECT TIPO_DOC, CANT_VEHI, FECHA-FIRMA, DURACION, KM_ADI, KM_TOTAL, VEH_SUP, VEH_SEV, VEH_SOC, VEH_CIU, TIPO_ESPE, ARCHIVO_PDF, DESCRIPCION, MOTIVO 
      FROM SPEED400AT.TBLDOCUMENTO_CAB 
      WHERE NRO_DOC = ?
    `;
  } catch (error) {
    console.error("Error al obtener detalle de documento", error);
  }
};

const insertDocument = async (req, res) => {
  const { globalDbUser, globalPassword } = req.user;

  // Validación de token y sus datos
  if (!globalDbUser || !globalPassword) {
    return res
      .status(401)
      .json({ success: false, message: "Token inválido o no proporcionado" });
  }

  const {
    idCliente,
    idContrato,
    tipoContrato,
    nroContrato,
    vehiculo,
    duracion,
    kmAdicional,
    kmTotal,
    vehSup,
    vehSev,
    vehSoc,
    vehCiu,
    fechaFirma,
    Especial,
    motivo,
    story,
    detalles,
    archivoPdf,
  } = req.body;

  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/documents/${archivoPdf}`;

  const claseDocu = "H";
  const fechaFormatoDB = convertirFecha(fechaFirma);

  const cn = await connection(globalDbUser, globalPassword);

  try {
    console.log("Valores para queryCabecera:", [
      idCliente,
      idContrato,
      tipoContrato,
      nroContrato,
      vehiculo,
      fechaFormatoDB,
      duracion,
      kmAdicional,
      kmTotal,
      vehSup,
      vehSev,
      vehSoc,
      vehCiu,
      Especial,
      motivo,
      story,
    ]);

    const queryCabecera = `
              INSERT INTO SPEED400AT.TBLDOCUMENTO_CAB 
              (ID_CLIENTE, ID_PADRE, TIPO_DOC, NRO_DOC, CANT_VEHI, FECHA_FIRMA, DURACION, KM_ADI, KM_TOTAL, VEH_SUP, VEH_SEV, VEH_SOC, VEH_CIU, TIPO_ESPE, DESCRIPCION, ARCHIVO_PDF, CLASE, MOTIVO)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    console.log(queryCabecera, [
      idCliente,
      idContrato,
      tipoContrato,
      nroContrato,
      vehiculo,
      fechaFormatoDB,
      duracion,
      kmAdicional,
      kmTotal,
      vehSup,
      vehSev,
      vehSoc,
      vehCiu,
      Especial,
      story,
      nombreArchivo,
      claseDocu,
      motivo,
    ]);
    const result = await cn.query(queryCabecera, [
      idCliente,
      idContrato,
      tipoContrato,
      nroContrato,
      vehiculo,
      fechaFormatoDB,
      duracion,
      kmAdicional,
      kmTotal,
      vehSup,
      vehSev,
      vehSoc,
      vehCiu,
      Especial,
      story,
      nombreArchivo,
      claseDocu,
      motivo,
    ]);

    const idDocumentoCab = result.insertId || (await obtenerUltimoIdDoc(cn));

    const queryDetalle = `
              INSERT INTO SPEED400AT.TBLDOCUMENTO_DET
              (ID_CON_CAB, SEC_CON, MODELO, TIPO_TERRENO, TARIFA, CPK, RM, CANTIDAD, DURACION, PRECIO_VEH, PRECIO_VENTA)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          `;

    if (detalles && detalles.length > 0) {
      for (const detalle of detalles) {
        console.log("Valores para queryDetalle:", [
          idDocumentoCab,
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
        await cn.query(queryDetalle, [
          idDocumentoCab,
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
    console.error("Error al insertar documento:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al insertar documento" });
  } finally {
    if (cn) {
      await cn.close();
    }
  }
};

module.exports = {
  insertDocument,
  listDocumentByNroContract,
};
