<?php
    require './templates/header.html';
?>
<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<!-- jQuery (Necesario) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- ESTILOS -->
<style>
    <?php include '../css/views/register_document.css'; ?>
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
<main>
    <div id="notification" class="hidden"></div>
    <div class="contenedor">
        <div class="form-registrar">
            <div class="form-tittle">
                <div class="form-tittle-h3">
                    <h3>Nuevo Documento Asociado</h3>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="form-cliente">
                    <label for="combo-box">Cliente(*):</label>
                    <select id="combo-cliente" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente" >
                        <option value="">Seleccione un cliente</option>
                    </select>
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Doc. Padre:</label>
                    <select id="combo-contrato" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato inicial" >
                        <option value="">Seleccione un contrato</option>
                    </select>
                </div>
            </div>
            <div class="form-one">
                <div class="form-cliente">
                    <label for="combo-box">Tipo documento:</label>
                    <select id="combo-raz" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona un tipo de documento: Orden de compra, Adenda o Carta">
                        <option value="">Seleccione un tipo</option>
                        <option value="1">Adenda</option>
                        <option value="2">Carta</option>
                        <option value="3">Orden de Compra</option>
                        <option value="4">Orden de Servicio</option>
                        <option value="5">Orden de Cambio</option>
                    </select>
                </div>
                <div class="form-cliente">
                    <label for="combo-box">N° de documento:</label>
                    <input id="text-nro-contra" name="nro-contrato" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="El número del documento debe ser un correlativo (CLIENTE-MM-AAAA-0001)">
                </div>
            </div>
            <div class="form-two">
                <div class="form-cliente">
                    <label for="combo-box">Cant. Vehiculos:</label>
                    <input id="text-veh" name="Sev" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehiculos contratados">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Duracion (Meses):</label>
                    <input id="text-dura" name="Duracion" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Duracion del contrato en meses">
                </div>
            </div>
            <!--<div class="form-three">
                <div class="form-cliente">
                    <label for="combo-box">Costo Por KM:</label>
                    <input id="text-cpk" name="Costo" type="text" class="resumen-form-contrato">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Recorrido Men:</label>
                    <input id="text-rm" name="Recorrido" type="text" class="resumen-form-contrato">
                </div>
            </div>-->
            <div class="form-four">
                <div class="form-cliente">
                    <label for="combo-box">$ KM Adicional:</label>
                    <input id="text-adic" name="Adicional" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Tarifa por km adicional de recorrido 0.000">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Bolsa KM Total:</label>
                    <input id="text-bolsa" name="Bolsa" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Km total a recorrer por unidad">
                </div>
            </div>
            <div class="form-five">
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Sup:</label>
                    <input id="text-sup" name="Sup" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Superficie">
                </div>
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Soc:</label> 
                    <input id="text-soc" name="Soc" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Socavon">
                </div>
            </div>
            <div class="form-six">
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Ciu:</label>
                    <input id="text-ciu" name="Ciu" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Ciudad">
                </div>
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Sev:</label>
                    <input id="text-sev" name="Sev" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Severo">
                </div>
            </div>
            <div class="form-six">
                <div class="form-cliente custom-date">
                    <label for="combo-box">Fecha Firma:</label>
                    <input id="text-firma" name="Firma" type="date" class="resumen-form-contrato dta tooltip-input" data-tooltip="Fecha de la firma del contrato">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Motivo:</label>
                    <select id="combo-motivo" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona un motivo: Ampliación, Renovación, Cambio de datos del cliente">
                        <option value="">Seleccione un Motivo</option>
                        <option value="1">Ampliación</option>
                        <option value="2">Renovación</option>
                        <option value="3">Cambio de datos del cliente</option>
                        <option value="3">Actualización de condiciones del cliente</option>
                        <option value="4">Devolución</option>
                    </select>
                </div>
            </div>
            <div class="form-six form-adjun">
                <div class="form-cliente adjunto-pdf">
                    <label for="combo-box">Adjuntar pdf:</label>
                    <div class="file-adjunta">
                        <label class="file-upload tooltip-input" id="dropZone" data-tooltip="Arrastra o seleccione un archivo en pdf">
                            <span id="uploadMessage">Haz clic o arrastra un archivo aquí</span>
                            <input type="file" id="fileInput" accept=".pdf">
                            <div class="file-info" id="fileInfo">
                                <img src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Icon">
                                <span id="fileName"></span>
                                <button class="view-file" id="viewFile">👁️</button>
                                <button class="remove-file" id="removeFile">X</button>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-cliente form-especial">
                    <label for="combo-box">Doc. Especial:</label>
                    <input id="especial" name="especial" type="checkbox" class="check-form-contrato tooltip-input" data-tooltip="Contrato especial, Cuando un contrato tiene varios periodos de finalización.">
                </div>
            </div>
            <div class="form-seven">
                <div class="tabla-form">
                    <table id="tabla-dinamica">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Modelo</th>
                                <th>Tipo terreno</th>
                                <th>Tarifa</th>
                                <th>CPK</th>
                                <th>RM</th>
                                <th>Cantidad</th>
                                <th>Duracion</th>
                                <th>Compra Veh. ($)</th>
                                <th>Venta Veh. ($)</th>
                            </tr>
                        </thead>
                        <tbody id="contratos-tbody" class="table-detalle">
                            <tr>
                                <td><input type="text" name="item[]" value="1" disabled></td>
                                <td>
                                    <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" id="tipoModelo" style="width: 100%;" data-tooltip="Selecciona el modelo">
                                        <option value="">Seleccione un modelo</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="tipo_terreno[]" class="cbo-form-cliente-deta tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                                        <option value="4">Seleccione el tipo</option>
                                        <option value="0">Superficie</option>
                                        <option value="1">Socavon</option>
                                        <option value="2">Ciudad</option>
                                        <option value="3">Severo</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tarifa[]" value="" class="tooltip-input" data-tooltip="Tarifa del contrato estipulado"></td>
                                <td><input type="text" name="cpk[]" value="" class="tooltip-input" data-tooltip="Costo por kilometraje"></td>
                                <td><input type="number" name="rm[]" value="0" class="tooltip-input" data-tooltip="Recorrido mensual del vehiculo"></td>
                                <td><input type="number" name="cantidad[]" value="0" class="tooltip-input" data-tooltip="Cantidad de unidades"></td>
                                <td><input type="text" name="duracion[]" value="0" class="tooltip-input" data-tooltip="Duracion vehicular" disabled></td>
                                <td><input type="text" name="compra_veh[]" value="" class="tooltip-input" data-tooltip="Precio promedio de la compra del vehiculo"></td>
                                <td><input type="text" name="precio_veh[]" value="" class="tooltip-input" data-tooltip="Precio promedio de la venta del vehiculo"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="cbo-registrar">
                    <label for="combo-box">Descripcion:</label>
                    <textarea id="story" name="story" rows="4" placeholder="" class="area-campo tooltip-input" data-tooltip="Ingrese aqui algun comentario adicional"></textarea>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="cbo-registrar body">
                    <button class="add-action" id="btnAddVeh" style="font-weight: 800;">
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
                        Adicionar
                    </button>
                    <button class="clear-action" id="btnClear" style="font-weight: 800;">
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
                    <button class="continue-application" id="grabarButton" style="font-weight: 800;">
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
                </div>
            </div>
        </div>
    </div>
</main>
<div id="pdfModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" id="closeModal">&times;</span>
    <iframe id="modalPdfViewer" width="100%" height="500px"></iframe>
  </div>
</div>

<!-- SCRIPTS -->
<script type="module">

    document.addEventListener("DOMContentLoaded", function () {
        const tooltip = document.createElement("div");

        tooltip.style.position = "fixed";
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

        document.addEventListener("mouseenter", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                const tooltipText = event.target.getAttribute("data-tooltip");
                if (!tooltipText) return;

                tooltip.textContent = tooltipText;
                tooltip.style.display = "block";
                tooltip.style.opacity = "1";
            }
        }, true);

        document.addEventListener("mousemove", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                let x = event.clientX + 10;
                let y = event.clientY + 10;

                if (x + tooltip.offsetWidth > window.innerWidth) {
                    x = event.clientX - tooltip.offsetWidth - 10;
                }
                if (y + tooltip.offsetHeight > window.innerHeight) {
                    y = event.clientY - tooltip.offsetHeight - 10;
                }

                tooltip.style.left = `${x}px`;
                tooltip.style.top = `${y}px`;
            }
        });

        document.addEventListener("mouseleave", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                tooltip.style.opacity = "0";
                setTimeout(() => {
                    tooltip.style.display = "none";
                }, 200);
            }
        }, true);
    });


    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameDisplay = document.getElementById('fileName');
    const uploadMessage = document.getElementById('uploadMessage');
    const removeFileButton = document.getElementById('removeFile');

    window.onload = function () {
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

    $(document).ready(function() {
        $("#tipoTerreno").select2({
            placeholder: "Seleccione el tipo",
            allowClear: false // Desactiva la "X"
        });
    });

    $(document).ready(function() {
        $("#tipoModelo").select2({
            placeholder: "Seleccione el tipo",
            allowClear: false // Desactiva la "X"
        });
    });

</script>
<script type="module" src="../js/registrar_documentos.js"></script>

<?php
    require './templates/footer.html';
?>