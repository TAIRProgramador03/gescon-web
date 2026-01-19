require('dotenv').config();

const express = require("express");
const odbc = require("odbc");
const cors = require("cors");
const multer = require("multer");
const path = require("path");
const fs = require("fs");
const app = express();
const port = 3000;
const IP_LOCAL = process.env.IP_LOCAL;
const IP_ODBC_BD = process.env.IP_ODBC_BD;

require("dotenv").config(); // Esto carga las variables del archivo .env

// const { OpenAI } = require("openai");

// // Crear una instancia de OpenAI con tu API Key cargada desde las variables de entorno
// const openai = new OpenAI({
//   apiKey: process.env.OPENAI_API_KEY, // Usar la clave de API desde las variables de entorno
// });

// Variables globales
const dbConfig = {
  DSN: `QDSN_${IP_ODBC_BD}`,
  system: IP_ODBC_BD,
};

let globalDbUser = "";
let globalPassword = "";

const iconv = require("iconv-lite");

// Función para decodificar correctamente desde latin1
const decodeString = (str) => {
  return iconv.decode(Buffer.from(str, "binary"), "latin1"); // Decodifica desde latin1
};

app.use(cors());
app.use(express.json({ limit: "50mb" }));
app.use(express.urlencoded({ limit: "50mb", extended: true }));

// const storage = multer.diskStorage({
//   destination: (req, file, cb) => {
//     const type = (req.body.documentType || "").replace(/\/+$/, "");
//     const pathFileNew = path.join(__dirname, "public/pdf", type);

//     fs.mkdirSync(pathFileNew, { recursive: true });

//     cb(null, pathFileNew);
//   },
//   filename: (req, file, cb) => {
//     // Guarda el archivo con su nombre original o genera un nombre único si lo prefieres
//     cb(null, file.originalname);
//   },
// });

// const upload = multer({ storage });

const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const rutaDestino = path.join(__dirname, "public/pdf/tmp");
    fs.mkdirSync(rutaDestino, { recursive: true });
    cb(null, rutaDestino);
  },
  filename: (req, file, cb) => {
    cb(null, file.originalname);
  },
});

const upload = multer({ storage }).single("archivoPdf");

// Ruta para manejar el inicio de sesión
app.post("/login", async (req, res) => {
  const { dbUser, password } = req.body;
  globalDbUser = dbUser;
  globalPassword = password;
  try {
    // Conexión a DB2 con los valores del login
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${dbUser};PWD=${password};System=${dbConfig.system};charset=utf8`
    );

    console.log("Conexión exitosa"); // Mensaje de éxito
    res.json({ success: true, message: "Conexión exitosa" });

    await connection.close();
  } catch (error) {
    console.error("Error de conexión:", error);
    res.json({ success: false, message: "Error de conexión" });
  }
});

app.get("/validarArchivo", (req, res) => {
  const nombreArchivo = req.query.nombre;

  if (!nombreArchivo) {
    return res.status(400).json({
      existe: false,
      mensaje: "No se proporcionó el nombre del archivo",
    });
  }

  // Ruta absoluta al archivo dentro del directorio 'public/pdf'
  const ruta = path.join(__dirname, "public", "pdf", nombreArchivo);

  // Verificar si el archivo existe
  fs.access(ruta, fs.constants.F_OK, (err) => {
    if (err) {
      return res.json({ existe: false });
    } else {
      return res.json({ existe: true });
    }
  });
});

// Servir el archivo HTML
app.get("/", (req, res) => {
  res.sendFile(__dirname + "/Index.html");
});

app.get("/get-openai-response", async (req, res) => {
  try {
    // Usar OpenAI para generar una respuesta
    const response = await openai.completions.create({
      model: "text-davinci-003", // Modelo de OpenAI
      prompt: "Escribe un poema sobre el sol",
      max_tokens: 50,
    });

    // Enviar la respuesta de OpenAI al cliente
    res.send(response.choices[0].text);
  } catch (error) {
    console.error("Error al contactar a OpenAI:", error);
    res.status(500).send("Error al contactar con OpenAI");
  }
});

// Ruta para obtener clientes
app.get("/clientes", async (req, res) => {
  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(
      "SELECT DISTINCT A.IDCLI, B.CLINOM FROM SPEED400AT.PO_OPERACIONES A INNER JOIN SPEED400AT.TCLIE B ON A.IDCLI=B.CLICVE WHERE A.ID<>86 AND B.CLINOM <> '*** ANULADO ***' ORDER BY CLINOM ASC"
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        IDCLI: row.IDCLI.trim(),
        CLINOM: decodeString(row.CLINOM.trim()),
      };
    });

    await connection.close();
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los clientes:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener clientes" });
  }
});

app.get("/modelos", async (req, res) => {
  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(
      "SELECT ID, TRIM(DESCRIPCION) AS MODELO FROM SPEED400AT.PO_MODELO GROUP BY ID, DESCRIPCION ORDER BY TRIM(DESCRIPCION) ASC"
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID: String(row.ID).trim(),
        MODELO: decodeString(row.MODELO.trim()),
      };
    });

    await connection.close();
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los modelos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los modelos" });
  }
});

app.get("/leasing", async (req, res) => {
  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(
      "SELECT ID, NRO_LEASING FROM SPEED400AT.TBL_LEASING_CAB ORDER BY NRO_LEASING ASC"
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID: String(row.ID).trim(),
        NRO_LEASING: decodeString(row.NRO_LEASING.trim()),
      };
    });

    await connection.close();
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener leasing" });
  }
});

// recibe: idCli
app.get("/leasingOfClient", async (req, res) => {
  const { idCli } = req.query;
  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(
      `SELECT ID, NRO_LEASING FROM SPEED400AT.TBL_LEASING_CAB WHERE ID_CLIENTE='${idCli}' ORDER BY NRO_LEASING ASC`
    );

    // Decodificar los resultados desde latin1
    const cleanedResult = result.map((row) => {
      return {
        ID: String(row.ID).trim(),
        NRO_LEASING: decodeString(row.NRO_LEASING.trim()),
      };
    });

    await connection.close();
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los leasing:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener leasing" });
  }
});

// Iniciar servidor IP_LOCAL/
app.listen(port, () => {
  console.log(`Servidor corriendo en https://${IP_LOCAL}:${port}`);
});

/*app.get('/contratos', async (req, res) => {
    const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

    if (!idCli) {
        return res.status(400).json({ success: false, message: 'El idCli es obligatorio' });
    }

    try {
        const connection = await odbc.connect(`DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`);

        // Consulta los contratos asociados al cliente
        const query = ` SELECT ID, DESCRIPCION FROM SPEED400AT.PO_CONTRATOCAB WHERE IDCLI='${idCli}'`;
        const result = await connection.query(query);

        const cleanedResult = result.map(row => {
            return {
                ID: row.ID !== null && row.ID !== undefined ? row.ID.toString().trim() : null, // Convierte a string si es necesario
                DESCRIPCION: row.DESCRIPCION !== null && row.DESCRIPCION !== undefined 
                    ? decodeString(row.DESCRIPCION.toString().trim()) 
                    : null
            };
        });

        await connection.close();

        // Devuelve los contratos como respuesta
        res.json(cleanedResult);
    } catch (error) {
        console.error("Error al obtener los contratos:", error);
        res.status(500).json({ success: false, message: 'Error al obtener contratos' });
    }
});*/

app.get("/contratosNro", async (req, res) => {
  const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

  if (!idCli) {
    return res
      .status(400)
      .json({ success: false, message: "El idCli es obligatorio" });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    const query = ` SELECT ID, NRO_CONTRATO AS DESCRIPCION FROM SPEED400AT.TBLCONTRATO_CAB WHERE ID_CLIENTE='${idCli}'`;
    const result = await connection.query(query);

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

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener contratos" });
  }
});

app.get("/contratosNroAdi", async (req, res) => {
  const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

  if (!idCli) {
    return res
      .status(400)
      .json({ success: false, message: "El idCli es obligatorio" });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    //const query = ` SELECT ID, NRO_CONTRATO AS DESCRIPCION FROM SPEED400AT.TBLCONTRATO_CAB WHERE ID_CLIENTE='${idCli}'`;
    const query = `SELECT * FROM ((SELECT CONCAT('P_', ID) AS ID, NRO_CONTRATO AS DESCRIPCION FROM SPEED400AT.TBLCONTRATO_CAB WHERE ID_CLIENTE='${idCli}') 
                        UNION ALL (SELECT CONCAT('H_', ID) AS ID, NRO_DOC AS DESCRIPCION FROM SPEED400AT.TBLDOCUMENTO_CAB WHERE ID_CLIENTE='${idCli}')) AS CONTRATOS 
                        ORDER BY DESCRIPCION ASC`;
    const result = await connection.query(query);

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

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los contratos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener contratos" });
  }
});

app.get("/tablaCliente", async (req, res) => {
  const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

  if (!idCli) {
    return res
      .status(400)
      .json({ success: false, message: "El idCli es obligatorio" });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    const query = `SELECT NRO_CONTRATO AS DESCRIPCION, FECHA_FIRMA AS FECHACREA, CANT_VEHI AS TOTVEH, DURACION FROM SPEED400AT.TBLCONTRATO_CAB WHERE ID_CLIENTE='${idCli}'`;
    const result = await connection.query(query);

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

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  }
});

app.get("/tablaContrato", async (req, res) => {
  const { idCli, id } = req.query; // Obtiene los parámetros de consulta

  // Validación inicial
  if (!idCli || !id) {
    return res.status(400).json({
      success: false,
      message: "Los parámetros idCli e id son obligatorios.",
    });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Usa parámetros preparados para prevenir inyección SQL
    const query = `
            SELECT NRO_CONTRATO AS DESCRIPCION, FECHA_FIRMA AS FECHACREA, CANT_VEHI AS TOTVEH, DURACION
            FROM SPEED400AT.TBLCONTRATO_CAB
            WHERE ID_CLIENTE = ? AND ID = ?
        `;
    const result = await connection.query(query, [idCli, id]);

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

    await connection.close();

    // Envía los resultados como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res.status(500).json({
      success: false,
      message: "Error al obtener los datos. Por favor intente más tarde.",
    });
  }
});

// PRUEBA*

app.get("/todosLosVehiculos", async (req, res) => {
  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    // A.INIVAL1='0' AND
    const query = `SELECT A.ID, A.CODINI AS CODINI, A.NUMPLA AS PLACA, C.DESCRIPCION AS MARCA, B.DESCRIPCION AS MODELO, B.DESMODGEN AS GENERICO, D.DESCRIP AS TERRENO FROM SPEED400AT.PO_VEHICULO A LEFT JOIN SPEED400AT.PO_MODELO B ON A.IDMOD=B.ID AND A.IDMODGEN=B.IDMODGEN LEFT JOIN SPEED400AT.PO_MARCA C ON A.IDMAR=C.ID LEFT JOIN SPEED400AT.PO_TERRENO D ON A.TP_TRABAJO=D.TPTRA LEFT JOIN SPEED400AT.TBL_LEASING_DET E ON A.ID=E.ID_VEH WHERE E.ID_VEH IS NULL ORDER BY A.ID DESC`;
    const result = await connection.query(query);

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(result);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  }
});

// END PRUEBA

app.get("/tablaClienteLeas", async (req, res) => {
  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
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

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  }
});

app.get("/tablaVehiculo", async (req, res) => {
  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    // A.INIVAL1='0' AND
    const query = `SELECT A.ID, A.CODINI AS CODINI, A.NUMPLA AS PLACA, C.DESCRIPCION AS MARCA, B.DESCRIPCION AS MODELO, B.DESMODGEN AS GENERICO, D.DESCRIP AS TERRENO FROM SPEED400AT.PO_VEHICULO A LEFT JOIN SPEED400AT.PO_MODELO B ON A.IDMOD=B.ID AND A.IDMODGEN=B.IDMODGEN LEFT JOIN SPEED400AT.PO_MARCA C ON A.IDMAR=C.ID LEFT JOIN SPEED400AT.PO_TERRENO D ON A.TP_TRABAJO=D.TPTRA LEFT JOIN SPEED400AT.TBL_LEASING_DET E ON A.ID=E.ID_VEH WHERE E.ID_VEH IS NULL ORDER BY A.ID DESC`;
    const result = await connection.query(query);

    const cleanedResult = result.map((row) => {
      return {
        ID:
          row.ID !== null && row.ID !== undefined
            ? row.ID.toString().trim()
            : null,
        CODINI:
          row.CODINI !== null && row.CODINI !== undefined
            ? decodeString(row.CODINI.toString().trim())
            : null,
        PLACA:
          row.PLACA !== null && row.PLACA !== undefined
            ? decodeString(row.PLACA.toString().trim())
            : null,
        MARCA:
          row.MARCA !== null && row.MARCA !== undefined
            ? decodeString(row.MARCA.toString().trim())
            : null,
        MODELO:
          row.MODELO !== null && row.MODELO !== undefined
            ? row.MODELO.toString().trim()
            : null,
        GENERICO:
          row.GENERICO !== null && row.GENERICO !== undefined
            ? decodeString(row.GENERICO.toString().trim())
            : null,
        TERRENO:
          row.TERRENO !== null && row.TERRENO !== undefined
            ? decodeString(row.TERRENO.toString().trim())
            : null,
      };
    });

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  }
});

app.post("/insertarContrato", async (req, res) => {
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

  function convertirFecha(fecha) {
    return fecha.replace(/-/g, "");
  }

  const claseContra = "P";
  const fechaFormatoDB = convertirFecha(fechaFirma);
  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/contracts/${archivoPdf}`;

  let connection;
  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    const queryCabecera = `
            INSERT INTO SPEED400AT.TBLCONTRATO_CAB 
            (ID_CLIENTE, NRO_CONTRATO, CANT_VEHI, FECHA_FIRMA, DURACION, KM_ADI, KM_TOTAL, VEH_SUP, VEH_SEV, VEH_SOC, VEH_CIU, TIPO_CONT, TIPO_CLI, MONEDA, DESCRIPCION, ARCHIVO_PDF, CLASE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        `;

    const result = await connection.query(queryCabecera, [
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
      result.insertId || (await obtenerUltimoId(connection));

    const queryDetalle = `
            INSERT INTO SPEED400AT.TBLCONTRATO_DET 
            (ID_CON_CAB, SEC_CON, MODELO, TIPO_TERRENO, TARIFA, CPK, RM, CANTIDAD, DURACION, PRECIO_VEH, PRECIO_VENTA)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        `;

    if (detalles && detalles.length > 0) {
      for (const detalle of detalles) {
        await connection.query(queryDetalle, [
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
    if (connection) {
      await connection.close();
    }
  }
});

// Ruta para manejar la subida de archivos | guardar en local
// app.post("/subirArchivo", upload.single("archivoPdf"), (req, res) => {
//   if (!req.file) {
//     return res.json({
//       success: false,
//       message: "No se recibió ningún archivo",
//     });
//   }
//   res.json({ success: true, message: "Archivo subido correctamente" });
// });

// app.post("/subirArchivo", (req, res, next) => {
//   console.log(req.body.documentType);

//   const form = multer({
//     storage: multer.diskStorage({
//       destination: (req, file, cb) => {
//         const tipo = req.body.documentType?.replace(/\/+$/, "") || "";
//         // const pathBase = `public/pdf/${tipo}`;
//         const rutaDestino = path.join(__dirname, "public/pdf/contract");
//         fs.mkdirSync(rutaDestino, { recursive: true });
//         cb(null, rutaDestino);
//       },
//       filename: (req, file, cb) => {
//         cb(null, file.originalname);
//       },
//     }),
//   }).single("archivoPdf");

//   form(req, res, function (err) {
//     if (err) {
//       return res
//         .status(500)
//         .json({ success: false, message: "Error al subir el archivo" });
//     }

//     if (!req.file) {
//       return res.json({
//         success: false,
//         message: "No se recibió ningún archivo",
//       });
//     }

//     res.json({
//       success: true,
//       message: "Archivo subido correctamente",
//       ruta: req.file.path,
//     });
//   });
// });

app.post("/subirArchivo", (req, res) => {
  upload(req, res, function (err) {
    if (err) {
      return res
        .status(500)
        .json({ success: false, message: "Error al subir el archivo" });
    }

    if (!req.file) {
      return res.json({
        success: false,
        message: "No se recibió ningún archivo",
      });
    }

    const tipo = req.body.documentType?.replace(/\/+$/, "") || "";
    const destinoFinal = path.join(__dirname, "public/pdf", tipo);
    fs.mkdirSync(destinoFinal, { recursive: true });
    const rutaFinal = path.join(destinoFinal, req.file.originalname);
    fs.renameSync(req.file.path, rutaFinal);

    res.json({
      success: true,
      message: "Archivo subido correctamente",
      ruta: rutaFinal,
    });
  });
});

async function obtenerUltimoId(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBLCONTRATO_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

app.post("/insertarDocumento", async (req, res) => {
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

  function convertirFecha(fecha) {
    return fecha.replace(/-/g, "");
  }

  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/documents/${archivoPdf}`;

  const claseDocu = "H";
  const fechaFormatoDB = convertirFecha(fechaFirma);

  let connection;
  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

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
    const result = await connection.query(queryCabecera, [
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
      result.insertId || (await obtenerUltimoIdDoc(connection));

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
        await connection.query(queryDetalle, [
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
    if (connection) {
      await connection.close();
    }
  }
});

async function obtenerUltimoIdDoc(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBLDOCUMENTO_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

app.get("/contratoDetalle", async (req, res) => {
  const { contratoId } = req.query; // Obtiene el contratoId de los parámetros de consulta

  if (!contratoId) {
    return res
      .status(400)
      .json({ success: false, message: "El contratoId es obligatorio" });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los detalles del contrato
    const query = `
            SELECT A.DESCRIPCION, A.FECHA_FIRMA, A.DURACION, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, (A.CANT_VEHI + COALESCE(SUM(B.CANT_VEHI), 0)) AS TOTAL_VEHICULOS, COUNT(B.ID) AS CANT_DOC 
            FROM SPEED400AT.TBLCONTRATO_CAB A LEFT JOIN SPEED400AT.TBLDOCUMENTO_CAB B ON A.ID=B.ID_PADRE WHERE NRO_CONTRATO='${contratoId}' 
            GROUP BY A.DESCRIPCION, A.FECHA_FIRMA, A.DURACION, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, A.CANT_VEHI, A.ID`;
    const result = await connection.query(query);

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

    await connection.close();
  } catch (error) {
    console.error("Error al obtener los detalles del contrato:", error);
    res.status(500).json({
      success: false,
      message: "Error al obtener los detalles del contrato",
    });
  }
});

app.get("/contContrato", async (req, res) => {
  try {
    // Conexión a DB2 con los valores globales de dbUser y password
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(
      "SELECT COUNT(DISTINCT A.ID) AS PADRE, SUM(CASE WHEN B.TIPO_DOC = 1 THEN 1 ELSE 0 END) AS TIPO_1, SUM(CASE WHEN B.TIPO_DOC = 2 THEN 1 ELSE 0 END) AS TIPO_2, SUM(CASE WHEN B.TIPO_DOC = 3 THEN 1 ELSE 0 END) AS TIPO_3 FROM SPEED400AT.TBLCONTRATO_CAB A FULL OUTER JOIN SPEED400AT.TBLDOCUMENTO_CAB B ON A.ID=B.ID_PADRE"
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

    await connection.close();
  } catch (error) {
    console.error("Error al obtener los contadores:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los contadores" });
  }
});

app.get("/contCliente", async (req, res) => {
  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );
    const result = await connection.query(`
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

    await connection.close();
  } catch (error) {
    console.error("Error al obtener los contadores:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los contadores" });
  }
});

app.get("/tablaconVehiculo", async (req, res) => {
  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    const query = `SELECT*FROM (SELECT MODELO, PRECIO_VEH FROM SPEED400AT.TBLCONTRATO_DET) UNION (SELECT MODELO, PRECIO_VEH FROM SPEED400AT.TBLDOCUMENTO_CAB A LEFT JOIN SPEED400AT.TBLDOCUMENTO_DET B ON A.ID=B.ID_CON_CAB) ORDER BY PRECIO_VEH ASC`;
    const result = await connection.query(query);

    const cleanedResult = result.map((row) => {
      return {
        MODELO:
          row.MODELO !== null && row.MODELO !== undefined
            ? decodeString(row.MODELO.toString().trim())
            : null,
        PRECIO_VEH:
          row.PRECIO_VEH !== null && row.PRECIO_VEH !== undefined
            ? row.PRECIO_VEH.toString().trim()
            : null,
      };
    });

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener los datos:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener los datos" });
  }
});

app.post("/insertaLeasing", async (req, res) => {
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

  const fechaIniDB = convertirFecha(fechaIni);
  const fechaFinDB = convertirFecha(fechaFin);

  let nombreArchivo = `http://${IP_LOCAL}/tair-web/public/pdf/leasings/${archivoPdf}`;
  let connection;
  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
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
});

async function obtenerUltimoIdLea(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBL_LEASING_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

app.get("/consultaVehiculoLeasing", async (req, res) => {
  const { idCli, nroLeasing } = req.query;
  let query = "";

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    if (nroLeasing === "all") {
      query = `SELECT DISTINCT A.CODINI, A.PLACA, TRIM(D.DESCRIPCION) AS MARCA, TRIM(A.MODELO) AS MODELO, A.NRO_LEASING  FROM (SELECT A.ID, A.ID_CLIENTE, TRIM(B.ID_VEH) AS CODINI, TRIM(B.PLACA) AS PLACA, A.NRO_LEASING, B.ID_VEH, B.MODELO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID = B.ID_LEA_CAB) A LEFT JOIN SPEED400AT.PO_VEHICULO C ON A.ID_VEH = C.ID LEFT JOIN SPEED400AT.PO_MARCA D ON C.IDMAR = D.ID LEFT JOIN (SELECT * FROM (SELECT A.ID, A.ID_CLIENTE, A.NRO_LEASING, A.CANT_VEH, B.PLACA, B.ID_VEH AS VEHICULO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID=B.ID_LEA_CAB) A LEFT JOIN (SELECT ID_CLIENTE, ID_ASIGNACION, LEASING, ID_VEH FROM SPEED400AT.TBL_ASIGNACION_CAB A INNER JOIN SPEED400AT.TBL_ASIGNACION_DET B ON A.ID=B.ID_ASIGNACION) B ON TRIM(A.NRO_LEASING)=TRIM(B.LEASING) AND A.VEHICULO=B.ID_VEH) E ON A.NRO_LEASING=E.LEASING AND A.ID_VEH=E.VEHICULO
            WHERE (A.ID_CLIENTE = '${idCli}') AND E.VEHICULO IS NULL GROUP BY A.CODINI, A.PLACA, TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.NRO_LEASING ORDER BY TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.PLACA`;
    } else if (nroLeasing) {
      query = `SELECT DISTINCT A.CODINI, A.PLACA, TRIM(D.DESCRIPCION) AS MARCA, TRIM(A.MODELO) AS MODELO, A.NRO_LEASING  FROM (SELECT A.ID, A.ID_CLIENTE, TRIM(B.ID_VEH) AS CODINI, TRIM(B.PLACA) AS PLACA, A.NRO_LEASING, B.ID_VEH, B.MODELO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID = B.ID_LEA_CAB) A LEFT JOIN SPEED400AT.PO_VEHICULO C ON A.ID_VEH = C.ID LEFT JOIN SPEED400AT.PO_MARCA D ON C.IDMAR = D.ID LEFT JOIN (SELECT * FROM (SELECT A.ID, A.ID_CLIENTE, A.NRO_LEASING, A.CANT_VEH, B.PLACA, B.ID_VEH AS VEHICULO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID=B.ID_LEA_CAB) A LEFT JOIN (SELECT ID_CLIENTE, ID_ASIGNACION, LEASING, ID_VEH FROM SPEED400AT.TBL_ASIGNACION_CAB A INNER JOIN SPEED400AT.TBL_ASIGNACION_DET B ON A.ID=B.ID_ASIGNACION) B ON TRIM(A.NRO_LEASING)=TRIM(B.LEASING) AND A.VEHICULO=B.ID_VEH) E ON A.NRO_LEASING=E.LEASING AND A.ID_VEH=E.VEHICULO
            WHERE (A.NRO_LEASING = '${nroLeasing}' AND A.ID_CLIENTE = '${idCli}') AND E.VEHICULO IS NULL GROUP BY A.CODINI, A.PLACA, TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.NRO_LEASING ORDER BY TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.PLACA`;
    }

    // Consulta los detalles del contrato
    // const query = `
    //         SELECT DISTINCT A.CODINI, A.PLACA, TRIM(D.DESCRIPCION) AS MARCA, TRIM(A.MODELO) AS MODELO, A.NRO_LEASING  FROM (SELECT A.ID, A.ID_CLIENTE, TRIM(B.ID_VEH) AS CODINI, TRIM(B.PLACA) AS PLACA, A.NRO_LEASING, B.ID_VEH, B.MODELO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID = B.ID_LEA_CAB) A LEFT JOIN SPEED400AT.PO_VEHICULO C ON A.ID_VEH = C.ID LEFT JOIN SPEED400AT.PO_MARCA D ON C.IDMAR = D.ID LEFT JOIN (SELECT * FROM (SELECT A.ID, A.ID_CLIENTE, A.NRO_LEASING, A.CANT_VEH, B.PLACA, B.ID_VEH AS VEHICULO FROM SPEED400AT.TBL_LEASING_CAB A INNER JOIN SPEED400AT.TBL_LEASING_DET B ON A.ID=B.ID_LEA_CAB) A LEFT JOIN (SELECT ID_CLIENTE, ID_ASIGNACION, LEASING, ID_VEH FROM SPEED400AT.TBL_ASIGNACION_CAB A INNER JOIN SPEED400AT.TBL_ASIGNACION_DET B ON A.ID=B.ID_ASIGNACION) B ON TRIM(A.NRO_LEASING)=TRIM(B.LEASING) AND A.VEHICULO=B.ID_VEH) E ON A.NRO_LEASING=E.LEASING AND A.ID_VEH=E.VEHICULO
    //         WHERE (A.NRO_LEASING = '${nroLeasing}' AND A.ID_CLIENTE = '${idCli}') AND E.VEHICULO IS NULL GROUP BY A.CODINI, A.PLACA, TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.NRO_LEASING ORDER BY TRIM(D.DESCRIPCION), TRIM(A.MODELO), A.PLACA`;

    const result = await connection.query(query);

    if (result.length === 0) {
      return res
        .status(404)
        .json({ success: false, message: "Contrato no encontrado" });
    }

    res.json({
      success: true,
      data: result.map((row) => ({
        codini: row.CODINI,
        placa: row.PLACA,
        marca: row.MARCA,
        modelo: row.MODELO,
        nro_leasing: row.NRO_LEASING,
      })),
    });

    await connection.close();
  } catch (error) {
    console.error("Error al obtener los detalles del contrato:", error);
    res.status(500).json({
      success: false,
      message: "Error al obtener los detalles del contrato",
    });
  }
});

app.get("/operacionesAsig", async (req, res) => {
  const { idCli } = req.query; // Obtiene el idCli de los parámetros de consulta

  if (!idCli) {
    return res
      .status(400)
      .json({ success: false, message: "El idCli es obligatorio" });
  }

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    // Consulta los contratos asociados al cliente
    const query = ` SELECT ID, DESCRIPCION FROM SPEED400AT.PO_OPERACIONES WHERE SITUACION='S' AND IDCLI='${idCli}'`;
    const result = await connection.query(query);

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

    await connection.close();

    // Devuelve los contratos como respuesta
    res.json(cleanedResult);
  } catch (error) {
    console.error("Error al obtener las operaciones:", error);
    res
      .status(500)
      .json({ success: false, message: "Error al obtener las operaciones" });
  }
});

app.post("/insertaAsignacion", async (req, res) => {
  const { idCliente, valorRepe, detalles } = req.body;

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

  let connection;
  let fechita = new Date().toISOString().split("T")[0];
  let converFecha = convertirFecha(fechita);

  try {
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

    const queryCabecera = `
            INSERT INTO SPEED400AT.TBL_ASIGNACION_CAB 
            (ID_CLIENTE, FECHA, USUARIO)
            VALUES (?, ?, ?)
        `;

    const result = await connection.query(queryCabecera, [
      idCliente,
      converFecha,
      globalDbUser,
    ]);

    const idAsignaCab =
      result.insertId || (await obtenerUltimoIdAsigna(connection));

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
});

async function obtenerUltimoIdAsigna(connection) {
  const result = await connection.query(
    `SELECT MAX(ID) AS ID FROM SPEED400AT.TBL_ASIGNACION_CAB`
  );
  return result.length > 0 ? result[0].ID : null;
}

app.post("/validaContratoCantidad", async (req, res) => {
  const { detalles } = req.body;

  if (!Array.isArray(detalles) || detalles.length === 0) {
    return res
      .status(400)
      .json({ success: false, mensaje: "Detalles faltantes o vacíos" });
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

  try {
    const connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${globalDbUser};PWD=${globalPassword};CCSID=1208`
    );

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
                        FROM SPEED400AT.TBLDOCUMENTO_CAB A WHERE A.ID='${idContrato}' AND CLASE='H'`;
      } else {
        squery = `SELECT A.ID, A.CANT_VEHI, A.VEH_SUP, A.VEH_SEV, A.VEH_SOC, A.VEH_CIU, TRIM(A.CLASE) AS CLASE,
                        (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='0') AS SUPERFICIE,
                        (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='1') AS SOCAVON,
                        (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='2') AS CIUDAD,
                        (SELECT COUNT(TP_TERRENO) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND TRIM(CLASE_CONTRATO)=TRIM(A.CLASE) AND TP_TERRENO='3') AS SEVERO,
                        (SELECT COUNT(*) FROM SPEED400AT.TBL_ASIGNACION_DET WHERE ID_CONTRATO=A.ID AND CLASE_CONTRATO=A.CLASE) AS CANTIDAD 
                        FROM SPEED400AT.TBLCONTRATO_CAB A WHERE A.ID='${idContrato}' AND CLASE='P'`;
      }

      let result = await connection.query(squery);

      if (!result || result.length === 0) {
        await connection.close();
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
          `Tipo: ${v.tipo}, Actual: ${v.actual}, Nuevos: ${nuevos}, Máximo: ${v.maximo}`
        );
        if (v.actual + nuevos > v.maximo) {
          console.log("Límite excedido para terreno tipo: " + v.tipo);
          await connection.close();
          return res.json({
            success: false,
            mensaje: `Límite excedido para terreno tipo ${v.tipo} en contrato ${clase}_${idContrato}. Permitido: ${v.maximo}, asignados: ${v.actual}, nuevos: ${nuevos}.`,
          });
        }
      }
      // Validación de límite de vehículos
      if (row.CANTIDAD + terrenos.length > row.CANT_VEHI) {
        await connection.close();
        return res.json({
          success: false,
          mensaje: `Límite total de vehículos excedido para contrato ${clase}_${idContrato}. Máximo: ${row.CANT_VEHI}, asignados: ${row.CANTIDAD}, nuevos: ${terrenos.length}.`,
        });
      }
    }
    await connection.close();
    return res.json({ success: true });
  } catch (error) {
    console.error("Error en validación de contratos:", error);
    return res.status(500).json({
      success: false,
      mensaje: "Error interno del servidor durante la validación",
    });
  }
});
