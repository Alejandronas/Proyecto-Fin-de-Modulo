<?php include_once('views/footeryheader/header.php'); ?>

<style>
    .card-tiempo {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .temperatura-grande {
        font-size: 4rem;
        font-weight: 700;
        color: #a18276;
    }
    .dato-item {
        background-color: #fcdfa6;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .dato-item i {
        font-size: 1.5rem;
        color: #a18276;
        margin-bottom: 0.3rem;
    }
    .dato-valor {
        font-size: 1.4rem;
        font-weight: 700;
        color: #a18276;
    }
    .dato-label {
        font-size: 0.8rem;
        color: #666;
    }
    .btn-volver {
        background-color: #aac0aa;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        color: #3a3a3a;
        font-weight: 600;
        text-decoration: none;
    }
    .btn-volver:hover {
        background-color: #8fa68f;
        color: #3a3a3a;
    }
</style>

<a href="javascript:history.back()" class="btn-volver mb-3 d-inline-block">
    <i class="fas fa-arrow-left"></i> Volver
</a>

<?php if ($tiempo == null): ?>
    <div class="alert" style="background-color:#f8d7da; border-left: 4px solid #f44336; border-radius:8px">
        <i class="fas fa-exclamation-triangle"></i> No se pudieron obtener los datos. Revisa tu API Key.
    </div>
<?php else: ?>

<div class="card-tiempo" style="background-color: #fcdfa6;">
    <h4 class="fw-bold">
        <i class="fas fa-cloud-sun"></i> Tiempo actual en <?= $ciudad->nombre ?>, <?= $ciudad->pais ?>
    </h4>
    <div class="d-flex align-items-center gap-3 mt-3">
        <img src="<?= $api->icono($tiempo->icono) ?>" alt="<?= $tiempo->descripcion ?>" style="width:80px">
        <div>
            <div class="temperatura-grande"><?= round($tiempo->temperatura) ?>°C</div>
            <p class="text-muted mb-0"><?= ucfirst($tiempo->descripcion) ?></p>
            <small class="text-muted">
                <i class="fas fa-thermometer-half"></i> Sensación térmica: <?= round($tiempo->sensacion) ?>°C
            </small>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="dato-item">
            <i class="fas fa-temperature-low"></i>
            <div class="dato-valor"><?= round($tiempo->temp_min) ?>°C</div>
            <div class="dato-label">Mínima</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dato-item">
            <i class="fas fa-temperature-high"></i>
            <div class="dato-valor"><?= round($tiempo->temp_max) ?>°C</div>
            <div class="dato-label">Máxima</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dato-item">
            <i class="fas fa-tint"></i>
            <div class="dato-valor"><?= $tiempo->humedad ?>%</div>
            <div class="dato-label">Humedad</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dato-item">
            <i class="fas fa-wind"></i>
            <div class="dato-valor"><?= round($tiempo->viento * 3.6) ?> km/h</div>
            <div class="dato-label">Viento</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dato-item">
            <i class="fas fa-tachometer-alt"></i>
            <div class="dato-valor"><?= $tiempo->presion ?> hPa</div>
            <div class="dato-label">Presión</div>
        </div>
    </div>
</div>


<div class="card-tiempo">
    <h5 class="fw-bold mb-3">
        <i class="fas fa-chart-bar"></i> Resumen de temperaturas
    </h5>
    <canvas id="graficaActual" height="100"></canvas>
</div>

<script>
    new Chart(document.getElementById('graficaActual'), {
        type: 'bar',
        data: {
            labels: ['Temperatura', 'Sensación', 'Mínima', 'Máxima'],
            datasets: [{
                label: '°C',
                data: [
                    <?= round($tiempo->temperatura) ?>,
                    <?= round($tiempo->sensacion) ?>,
                    <?= round($tiempo->temp_min) ?>,
                    <?= round($tiempo->temp_max) ?>
                ],
                backgroundColor: ['#fcdfa6', '#f4b886', '#aac0aa', '#cbe896'],
                borderColor:     ['#a18276', '#a18276', '#a18276', '#a18276'],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { ticks: { callback: v => v + ' °C' } } }
        }
    });
</script>

<?php endif; ?>

<?php include_once('views/footeryheader/footer.php'); ?>