<div id="direcciones" class="tab-content" style="display:none;">
    <h3>Direcciones de Envío</h3>
    <p class="subtitle-p">Puedes guardar hasta 3 direcciones. Selecciona una con el círculo para usarla como predeterminada.</p>

    <div class="map-container-wrapper">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <div id="map" style="width: 100%; height: 300px; border-radius: 12px; border: 1px solid #ddd; z-index: 1;"></div>
    </div>

    <div class="grid-form">
        <div class="form-group">
            <label>Ciudad / Estado</label>
            <input type="text" id="dirCiudad" placeholder="Ej: Ciudad de México" class="input-address">
        </div>
        <div class="form-group">
            <label>Código Postal</label>
            <input type="text" id="dirCP" placeholder="15420" class="input-address">
        </div>
        <div class="form-group">
            <label>Calle y Número</label>
            <input type="text" id="dirCalle" placeholder="C. Transvaal 15" class="input-address">
        </div>
        <div class="form-group">
            <label>Casa / Depto / Interior</label>
            <input type="text" id="dirDepto" placeholder="Apto 4B">
        </div>
    </div>

    <button class="btn-save" onclick="intentarGuardarDireccion()">
        <i class="fa-solid fa-plus"></i> Guardar Nueva Dirección
    </button>

    <div class="direcciones-guardadas-container">
        <h4>Tus Direcciones (Máx. 3)</h4>
        <div id="listaDirecciones" class="direcciones-grid">
            </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>