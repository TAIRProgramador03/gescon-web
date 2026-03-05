const {convertirFecha, obtenerUltimoIdDoc} = require("../../shared/utils.js");
const connection = require("../../shared/connect.js");

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

    const idDocumentoCab =
      result.insertId || (await obtenerUltimoIdDoc(cn));

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
}