<?php
require './templates/header.html';
?>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ESTILOS -->
<style>
    <?php include '../css/views/register_leasing.css'; ?>
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
<div id="notification" class="hidden"></div>
<main>
    <div class="contenedor">
        <div class="regis-form-leasing">
            <div class="leasing-tittle">
                <div class="tittle-h3">
                    <h3>Registrar Leasing</h3>
                </div>
            </div>
            <div class="form-cuerpo">
                <div class="leasing-adenda">
                    <label>Cliente</label>
                    <div class="input-container">
                        <input type="text" id="inputClienteSeleccionado" placeholder="Selecciona el cliente" readonly>
                        <button id="openModalCli" class="btn-busca tooltip-input" data-tooltip="Selecciona el cliente">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
                <div class="leasing-adenda">
                    <label>N° de leasing</label>
                    <input type="text" placeholder="" id="NroLeasing" class="tooltip-input" data-tooltip="Numero del leasing">
                </div>
                <div class="leasing-adenda">
                    <label for="combo-box">Contratos</label>
                    <select id="combo-box-asig" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato" style="text-align: center;">
                        <option value="">Seleccione un contrato</option>
                    </select>
                    <!--<label>Contratos</label>
                    <select id="banco" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona un contrato" style="text-align: center;">
                        <option value="">Seleccione un contrato</option>
                    </select>-->
                </div>
                <div class="leasing-adenda">
                    <label>Banco</label>
                    <select id="banco" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el banco" style="text-align: center;">
                        <option value="">Seleccione un banco</option>
                        <option value="1">BANBIF</option>
                        <option value="2">BBVA</option>
                        <option value="3">BCP</option>
                        <option value="4">HSBC</option>
                        <option value="5">INTERBANK</option>
                        <option value="6">SCOTIABANK</option>
                        <option value="7">TAIR</option>
                        <option value="8">SANTANDER</option>
                    </select>
                </div>
                <div class="leasing-adenda">
                    <label>Cant. Vehiculos</label>
                    <input type="text" placeholder="" id="cantVehi" class="tooltip-input" data-tooltip="Cantidad de unidades adquiridas">
                </div>
                <div class="leasing-adenda">
                    <label>Fecha Inicio</label>
                    <input type="date" placeholder="" id="fechaIni" class="tooltip-input" data-tooltip="Fecha inicio del leasing">
                </div>
                <div class="leasing-adenda">
                    <label>Fecha Fin</label>
                    <input type="date" placeholder="" id="fechaFin" class="tooltip-input" data-tooltip="Fecha fin del leasing">
                </div>
                <div class="leasing-adenda">
                    <label>Periodo de Gracia</label>
                    <input type="text" placeholder="" id="periGracia" class="tooltip-input" data-tooltip="Periodo de gracia en meses">
                </div>
                <div class="pdf-car">
                    <div class="form-cliente adjunto-pdf">
                        <label for="combo-box">Adjuntar PDF:</label>
                        <div class="file-adjunta">
                            <label class="file-upload tooltip-input" id="dropZone" data-tooltip="Arrastra o pega aqui tu excel">
                                <span id="uploadMessage">Haz clic o arrastra un archivo aquí</span>
                                <input type="file" id="fileInput" accept=".pdf">
                                <div class="file-info" id="fileInfo"><i class="fa fa-money"></i>
                                    <img src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Icon">
                                    <span id="fileName"></span>
                                    <button class="view-file" id="viewFile">👁️</button>
                                    <button class="remove-file" id="removeFile">X</button>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="form-modal cart-dos">
                        <button id="openModal" class="btn-vehi cart-dos tooltip-input" data-tooltip="Selecciona las unidades adquiridas"> <strong><i class="fa-solid fa-plus"></i> Vehiculos </strong><img src="../img/car-wash.png" alt="Freepik" width="30" height="30" style="position: relative; top: 01px;"></button>
                    </div>
                </div>
                <div class="form-seven">
                    <div class="tabla-form">
                        <table id="tablaSeleccionados">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>ID</th>
                                    <th>Modelo</th>
                                    <th>Tipo terreno</th>
                                    <th>Placa</th>
                                    <th>Codini</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>

                            <!--<tbody>
                            </tbody>-->
                            <tbody id="contratos-tbody" class="table-detalle">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="butto-form">
                    <!--<input type="checkbox" id="c">
                    <label for="c" id="upload_app">
                        <div id="app">
                            <div id="arrow"></div>
                            <div id="success">
                            <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </label>-->
                    <button class="add-action" id="btnClear">
                        <div>
                            <div class="broom"></div>
                            <div class="trash">
                                <div class="trash-top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper-clear"></div>
                            </div>
                        </div>
                        Limpiar
                    </button>
                    <button class="continue-application" id="grabarButton">
                        <div>
                            <div class="pencil"></div>
                            <div class="folder">
                                <div class="top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper"></div>
                            </div>
                        </div>
                        Grabar
                    </button>
                    <button class="add-action" onclick="asignacionVehicular()">
                        <div>
                            <div class="broom"></div>
                            <div class="trash">
                                <div class="trash-top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper-clear"></div>
                            </div>
                        </div>
                        Asignacion
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="myModalCli" class="modal">
        <div class="main">
            <!-- Header del modal -->
            <div class="modal-header header-cliente">
                <h3>Listado de clientes</h3>
                <span class="closeCli">&times;</span> <!-- Botón de cerrar -->
            </div>

            <!-- Body del modal -->
            <div class="modal-body">
                <div class="buscador" style="padding: 10px 25px; color: #000000;">
                    <label for="buscadorTabla">Buscar Cliente:</label>
                    <input type="text" id="buscadorTabla" placeholder="Ingrese un término...">
                </div>
                <div class="form-seven">
                    <div class="tabla-form-cli">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>RUC</th>
                                    <th>Cliente</th>
                                    <th>Direccion</th>
                                    <th>ID</th>
                                    <th>Abrev.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">Seleccione un cliente para ver los contratos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <!--<button class="btn-acepta" id="btnAceptar">Aceptar</button>
                <button class="btn-cancelar" id="btnCancelar">Cancelar</button>-->
            </div>
        </div>
    </div>
    <div id="myModal" class="modal">
        <!-- Contenido de la ventana modal -->
        <div class="main">
            <!-- Header del modal -->
            <div class="modal-header header-vehiculo">
                <h3>Listado de Vehiculos</h3>
                <span class="close">&times;</span> <!-- Botón de cerrar -->
            </div>

            <!-- Body del modal -->
            <div class="modal-body">
                <div class="buscador" style="padding: 10px 25px; color: #000;">
                    <label for="buscadorTabla">Buscar Vehiculo:</label>
                    <input type="text" id="buscadorTablaVehi" placeholder="Ingrese un término...">
                </div>
                <div class="form-seven">
                    <div class="tabla-form-vehi">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Codini</th>
                                    <th>Placa</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Generico</th>
                                    <th>Tipo Terreno</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7">Seleccione un vehiculo para ver los contratos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <!--<button class="btn-acepta" id="btnVehiculo">Aceptar</button>
                <button class="btn-cancelar">Cancelar</button>-->
            </div>
        </div>
    </div>
    <div id="pdfModal" class="modal-pdf">
        <div class="modal-content-pdf">
            <span class="close-modal-pdf" id="closeModal">&times;</span>
            <iframe id="modalPdfViewer" width="100%" height="500px"></iframe>
        </div>
    </div>
</main>

<!-- SCRIPTS -->
<script>
    function asignacionVehicular() {
        window.location = 'adicionar_vehiculos.php';
    };
</script>
<script type="module">
    const inputs = document.querySelectorAll(".tooltip-input");
    const tooltip = document.createElement("div");

    tooltip.style.position = "fixed"; // Se mueve con el cursor
    tooltip.style.background = "black";
    tooltip.style.color = "white";
    tooltip.style.padding = "5px 10px";
    tooltip.style.borderRadius = "5px";
    tooltip.style.fontSize = "12px";
    tooltip.style.display = "none";
    tooltip.style.opacity = "0";
    tooltip.style.transition = "opacity 0.2s ease-in-out";
    tooltip.style.zIndex = "1000";
    tooltip.style.whiteSpace = "nowrap";
    document.body.appendChild(tooltip);

    inputs.forEach(input => {
        input.addEventListener("mouseenter", function(event) {
            const tooltipText = input.getAttribute("data-tooltip");
            if (!tooltipText) return;

            tooltip.textContent = tooltipText;
            tooltip.style.display = "block";
            tooltip.style.opacity = "1";
        });

        input.addEventListener("mousemove", function(event) {
            let x = event.clientX + 10; // 10px de margen a la derecha del cursor
            let y = event.clientY + 10; // 10px abajo del cursor

            // Evitar que el tooltip se salga de la pantalla
            if (x + tooltip.offsetWidth > window.innerWidth) {
                x = event.clientX - tooltip.offsetWidth - 10; // Lo mueve a la izquierda si no cabe
            }
            if (y + tooltip.offsetHeight > window.innerHeight) {
                y = event.clientY - tooltip.offsetHeight - 10; // Lo sube si no cabe abajo
            }

            tooltip.style.left = `${x}px`;
            tooltip.style.top = `${y}px`;
        });

        input.addEventListener("mouseleave", function() {
            tooltip.style.opacity = "0";
            setTimeout(() => {
                tooltip.style.display = "none";
            }, 200);
        });
    });

    /* window.onload = function() {
        setTimeout(() => {
            document.body.classList.add('loaded');
            document.getElementById('preloader').style.display = 'none';
        }, 2000); 
    };*/

    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModal");
    const span = document.getElementsByClassName("close")[0];

    // Abrir la ventana modal al hacer clic en el botón
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Cerrar la ventana modal al hacer clic en la "x"
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cerrar la ventana modal al hacer clic fuera de ella
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    const modalCli = document.getElementById("myModalCli");
    const btnCli = document.getElementById("openModalCli");
    const spanCli = document.getElementsByClassName("closeCli")[0];

    // Abrir la ventana modal al hacer clic en el botón
    btnCli.onclick = function() {
        modalCli.style.display = "block";
    }

    // Cerrar la ventana modal al hacer clic en la "x"
    spanCli.onclick = function() {
        modalCli.style.display = "none";
    }

    // Cerrar la ventana modal al hacer clic fuera de ella
    window.onclick = function(event) {
        if (event.target == modalCli) {
            modalCli.style.display = "none";
        }
    }

    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameDisplay = document.getElementById('fileName');
    const uploadMessage = document.getElementById('uploadMessage');
    const removeFileButton = document.getElementById('removeFile');

    window.onload = function() {
        setTimeout(() => {
            document.body.classList.add('loaded');
            document.getElementById('preloader-mini').style.display = 'none';
        }, 2000);
        fileInfo.style.display = 'none'; // Asegúrate de que la información del archivo no aparezca.
        uploadMessage.style.display = 'block'; // Muestra el mensaje inicial.
        fileInput.value = ''; // Limpia el campo de archivo si existe algo previamente.
    };
    // Mostrar nombre del archivo al seleccionar
    fileInput.addEventListener('change', handleFile);

    // Eventos para drag and drop
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.classList.remove('dragover');

        const file = event.dataTransfer.files[0];
        if (file) {
            fileInput.files = event.dataTransfer.files; // Asignar archivo al input
            handleFile();
        }
    });

    // Mostrar archivo y cambiar el contenido visual
    function handleFile() {
        const file = fileInput.files[0];
        if (file) {
            uploadMessage.style.display = 'none'; // Ocultar mensaje de carga
            fileInfo.style.display = 'flex'; // Mostrar el área con el archivo
            fileNameDisplay.textContent = truncateFileName(file.name); // Mostrar el nombre truncado del archivo
        }
    }


    const viewFileButton = document.getElementById('viewFile');
    const pdfModal = document.getElementById('pdfModal');
    const modalPdfViewer = document.getElementById('modalPdfViewer');
    const closeModal = document.getElementById('closeModal');

    // Evento para abrir el modal con vista previa
    viewFileButton.addEventListener('click', () => {
        const file = fileInput.files[0];
        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            modalPdfViewer.src = fileURL;
            pdfModal.style.display = 'block';
        }
    });

    // Cerrar modal
    closeModal.addEventListener('click', () => {
        pdfModal.style.display = 'none';
        modalPdfViewer.src = '';
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', (event) => {
        if (event.target === pdfModal) {
            pdfModal.style.display = 'none';
            modalPdfViewer.src = '';
        }
    });


    // Función para truncar el nombre del archivo
    function truncateFileName(name) {
        const maxLength = 25;
        if (name.length <= maxLength) return name;

        const fileExtension = name.slice(name.lastIndexOf('.'));
        const truncatedName = name.slice(0, maxLength - fileExtension.length - 3);
        return truncatedName + '...' + fileExtension;
    }

    // Eliminar archivo seleccionado
    removeFileButton.addEventListener('click', () => {
        fileInput.value = ''; // Limpiar input
        fileInfo.style.display = 'none'; // Ocultar el área del archivo
        uploadMessage.style.display = 'block'; // Mostrar mensaje de carga
    });
</script>
<script type="module" src="../js/registrar_leasing.js"></script>

<?php
require './templates/footer.html';
?>