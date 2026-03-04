const Router = require("express").Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js");
const {listLeasing, listLeasingOfClient, insertLeasing} = require("./leasing.controller.js");

Router.get("/leasing", authenticateToken, listLeasing);
Router.get("/leasingOfClient", authenticateToken, listLeasingOfClient)
Router.post("/insertaLeasing", authenticateToken, insertLeasing);

module.exports = Router;