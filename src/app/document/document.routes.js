const Router = require("express").Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js");
const { insertDocument, listDocumentByNroContract } = require("./document.controller.js");

Router.get("/documentoPorContrato", authenticateToken, listDocumentByNroContract)
Router.post("/insertarDocumento", authenticateToken, insertDocument);

module.exports = Router;
