const Router = require("express").Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js");
const {listLeasing, listLeasingOfClient, listLeasingByContract, detailLeasing, insertLeasing, listLeasingByDocument} = require("./leasing.controller.js");

Router.get("/leasing", authenticateToken, listLeasing);
Router.get("/leasingOfClient", authenticateToken, listLeasingOfClient)
Router.get("/leasingByContract", authenticateToken, listLeasingByContract)
Router.get("/leasingByDocument", authenticateToken, listLeasingByDocument)
Router.get("/detailLeasing", authenticateToken, detailLeasing);
Router.post("/insertaLeasing", authenticateToken, insertLeasing);

module.exports = Router;