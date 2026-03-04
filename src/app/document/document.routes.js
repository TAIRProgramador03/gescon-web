const Router = require("express").Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js");
const { insertDocument } = require("./document.controller.js");

Router.post("/insertarDocumento", authenticateToken, insertDocument);

module.exports = Router;
