<?php include_once('views/footeryheader/header.php'); ?>

<style>
    .card-tiempo {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .tabla-horas thead {
        background-color: #aac0aa;
    }
    .tabla-horas tbody tr:hover {
        background-color: #fcdfa6;
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

<div class="card-tiempo">
    <h4 class="fw-bold">
        <i class="fas fa-clock"></i> Previsión por horas — <?= $ciudad->nombre ?>, <?= $ciudad->pais ?>
    </h4>
    <p class="text-muted">Próximas 24 horas (intervalos de 3h)</p>

    <?php if ($horas == null): ?>
        <div class="alert" style="background-color:#f8d7da; border-left: 4px solid #f44336; border-radius:8px">
            <i class="fas fa-exclamation-triangle"></i> No se pudieron obtener los datos.
        </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table tabla-horas">
            <thead>
                <tr>
                    <th><i class="fas fa-clock"></i> Hora</th>
                    <th></th>
                    <th><i class="fas fa-info-circle"></i> Descripción</th>
                    <th><i class="fas fa-thermometer-half"></i> Temp.</th>
                    <th><i class="fas fa-tint"></i> Humedad</th>
                    <th><i class="fas fa-wind"></i> Viento</th>
                    <th><i class="fas fa-umbrella"></i> Lluvia</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($horas as $hora): ?>
                <tr>
                    <td><strong><?= $hora->hora ?></strong></td>
                    <td><img src="<?= $api->icono($hora->icono) ?>" alt="" style="width:40px"></td>
                    <td><?= ucfirst($hora->descripcion) ?></td>
                    <td><?= round($hora->temperatura) ?>°C</td>
                    <td><?= $hora->humedad ?>%</td>
                    <td><?= round($hora->viento * 3.6) ?> km/h</td>
                    <td><?= round($hora->lluvia * 100) ?>%</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>


<?php if ($horas != null): ?>
<div class="card-tiempo">
    <h5 class="fw-bold mb-3">
        <i class="fas fa-chart-line"></i> Evolución de temperatura
    </h5>
    <canvas id="graficaHoras" height="100"></canvas>
</div>

<script>
    new Chart(document.getElementById('graficaHoras'), {
        type: 'line',
        data: {
            labels: [<?php foreach ($horas as $hora) echo '"' . $hora->hora . '",' ?>],
            datasets: [{
                label: 'Temperatura (°C)',
                data: [<?php foreach ($horas as $hora) echo round($hora->temperatura) . ',' ?>],
                borderColor: '#a18276',
                backgroundColor: '#fcdfa655',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#a18276'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { ticks: { callback: v => v + ' °C' } } }
        }
    });
</script>
<?php endif; ?>

<?php include_once('views/footeryheader/footer.php'); ?>