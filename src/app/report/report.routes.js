const Router = require('express').Router();
const authenticateToken = require("../../shared/middleware/jwt-valid.js")
const {contVehicleFeet, contLeasings} = require("./report.controller.js")

Router.get("/contVehicleFleet", authenticateToken, contVehicleFeet);
Router.get("/contLeasing", authenticateToken, contLeasings);

module.exports = Router;