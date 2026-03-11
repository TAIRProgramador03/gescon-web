const Router = require("express").Router();
const {
  listVehicles,
  tableVehicles,
  contVehicles,
  vehicleLeasing,
  listVehiclesByContract
} = require("./vehicle.controller.js");
const authenticateToken = require("../../shared/middleware/jwt-valid.js");

Router.get("/todosLosVehiculos", authenticateToken, listVehicles);
Router.get("/tablaVehiculo", authenticateToken, tableVehicles);
Router.get("/tablaconVehiculo", authenticateToken, contVehicles);
Router.get("/consultaVehiculoLeasing", authenticateToken, vehicleLeasing);
Router.get("/vehiculosPorContrato", authenticateToken, listVehiclesByContract)

module.exports = Router;
