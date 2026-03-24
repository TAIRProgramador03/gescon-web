<?php
    require './templates/header.html';
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CSS DE LA VISTA ADICIONAR VEHICULOS -->
<style>
    <?php include '../css/views/add_vehicle.css'; ?>
</style>

<!-- MAQUETACIÓN DE LA VISTA -->

<div id="preloader-mini">
    <div class="gif-container">
        <img src="../img/carpeta.gif" alt="Cargando...">
    </div>
    <div class="welcome-message">
        <p>¡Cargando!.....</p>
    </div>
</div>
<main class="main-register">
    <div id="notification" class="hidden"></div>

    <div class="contenedor">
        <div class="form-adicionar">
            <div class="tittle-adiciona">
                <div class="tittle-form-adi">
                    <h3>ASIGNAR UNIDADES</h3>
                </div>
            </div>
            <div class="body-adiciona">
                <div class="cbo-form-dig">
                    <div class="cbo-form-adiciona-header">
                        <div class="cbo-clau-te">
                            <label for="combo-box-cliente">Cliente:</label>
                            <select id="combo-box" name="opciones" class="cbo-form-cliente select-form-clientes"></select>
                        </div>
                        <div class="cbo-clau-te">
                            <label for="combo-box-leasing">N° De Leasing:</label>
                            <select id="combo-box-leasing" disabled name="opciones" class="cbo-form-leasing">
                                <option value="" disabled selected>Seleccione un Leasing</option>
                            </select>
                        </div> 
                    </div>
                    <div class="cbo-form-adiciona">
                        <!-- onclick="listaVehiculosAsignables()" -->
                        <!-- <button id="btn-flota-total" class="btn-flota-adi" >Flota Total</button> -->
                    </div>
                </div>
                <div class="tabla-form-adi">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th><input class="check-xtodo" type="checkbox" id="checkAll" disabled> Select</th>
                                    <th>ID</th>
                                    <th>Placa</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Leasing</th>
                                    <th>Tarifa</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Fecha Devolucion</th>
                                    <th>Operacion</th>
                                    <th>Contrato</th>
                                    <th>Terreno</th>
                                </tr>   
                            </thead>
                            <tbody id="asignacion-tbody">
                                <tr>
                                    <td colspan="12">Seleccione un cliente para ver los vehiculos por asignar</td>
                                </tr>
                            </tbody>
                            <!--<tbody id="contratos-tbody" class="table-detalle">
                            </tbody>-->
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="cbo-form-adiciona">
                        <label for="combo-box-asig">Asignar Cliente:</label>
                        <select id="combo-box-asig" name="opciones" class="cbo-form-leasing" disabled></select>
                        <div class="btn-footer-adi">
                            <input class="check-xtodo" type="checkbox" id="repeticion" disabled> Repetir
                            <button class="btn-acepta-adi" id="grabarButton">Grabar</button>
                            <button class="btn-cancelar-adi" id="btnClear" >Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- SCRIPTS DE LA VISTA -->

<script type="module">
    window.onload = function() {
        setTimeout(() => {
            document.body.classList.add('loaded');
            document.getElementById('preloader-mini').style.display = 'none';
        }, 2000); 
    };
</script>
<script type="module" src="../js/adiciona_vehiculo.js"></script>

<?php
    require './templates/footer.html';
?>