const Router = require("express").Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js");
const { insertDocument, listDocumentByNroContract, detailDocument } = require("./document.controller.js");

Router.get("/documentoPorContrato", authenticateToken, listDocumentByNroContract)
Router.get("/detalleDocumento", authenticateToken, detailDocument)
Router.post("/insertarDocumento", authenticateToken, insertDocument);

module.exports = Router;
