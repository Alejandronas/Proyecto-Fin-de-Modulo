<?php include_once('views/footeryheader/header.php'); ?>

<style>
    .card-tiempo {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .card-dia {
        border-radius: 12px;
        padding: 1.2rem;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    .card-dia:hover {
        transform: translateY(-4px);
    }
    .tabla-semana thead {
        background-color: #aac0aa;
    }
    .tabla-semana tbody tr:hover {
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

<?php if ($dias == null): ?>
    <div class="alert" style="background-color:#f8d7da; border-left: 4px solid #f44336; border-radius:8px">
        <i class="fas fa-exclamation-triangle"></i> No se pudieron obtener los datos.
    </div>
<?php else: ?>

<div class="card-tiempo">
    <h4 class="fw-bold mb-3">
        <i class="fas fa-calendar-week"></i> Previsión semanal — <?= $ciudad->nombre ?>, <?= $ciudad->pais ?>
    </h4>
    <div class="row g-3">
        <?php
        $colores = ['#fcdfa6','#cbe896','#f4b886','#aac0aa','#cbe896','#fcdfa6','#f4b886'];
        foreach ($dias as $i => $dia):
        ?>
        <div class="col-6 col-md-3">
            <div class="card-dia" style="background-color: <?= $colores[$i % count($colores)] ?>">
                <div class="fw-bold"><?= date('d/m/Y', strtotime($dia->fecha)) ?></div>
                <img src="<?= $api->icono($dia->icono) ?>" alt="" style="width:50px">
                <div class="fw-bold" style="color:#a18276">
                    <i class="fas fa-temperature-high"></i> <?= round($dia->temp_max) ?>°
                    / <span style="color:#666"><?= round($dia->temp_min) ?>°</span>
                </div>
                <small><?= ucfirst($dia->descripcion) ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="card-tiempo">
    <h5 class="fw-bold mb-3">
        <i class="fas fa-table"></i> Detalle semanal
    </h5>
    <div class="table-responsive">
        <table class="table tabla-semana">
            <thead>
                <tr>
                    <th><i class="fas fa-calendar"></i> Fecha</th>
                    <th></th>
                    <th><i class="fas fa-info-circle"></i> Descripción</th>
                    <th><i class="fas fa-temperature-low"></i> Mínima</th>
                    <th><i class="fas fa-temperature-high"></i> Máxima</th>
                    <th><i class="fas fa-tint"></i> Humedad</th>
                    <th><i class="fas fa-wind"></i> Viento</th>
                    <th><i class="fas fa-umbrella"></i> Lluvia</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dias as $dia): ?>
                <tr>
                    <td><strong><?= date('d/m/Y', strtotime($dia->fecha)) ?></strong></td>
                    <td><img src="<?= $api->icono($dia->icono) ?>" alt="" style="width:40px"></td>
                    <td><?= ucfirst($dia->descripcion) ?></td>
                    <td><?= round($dia->temp_min) ?>°C</td>
                    <td><?= round($dia->temp_max) ?>°C</td>
                    <td><?= $dia->humedad ?>%</td>
                    <td><?= round($dia->viento * 3.6) ?> km/h</td>
                    <td><?= round($dia->lluvia * 100) ?>%</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card-tiempo">
    <h5 class="fw-bold mb-3">
        <i class="fas fa-chart-line"></i> Temperaturas de la semana
    </h5>
    <canvas id="graficaSemana" height="100"></canvas>
</div>

<script>
    new Chart(document.getElementById('graficaSemana'), {
        type: 'line',
        data: {
            labels: [<?php foreach ($dias as $dia) echo '"' . date('d/m/Y', strtotime($dia->fecha)) . '",' ?>],
            datasets: [
                {
                    label: 'Máxima (°C)',
                    data: [<?php foreach ($dias as $dia) echo round($dia->temp_max) . ',' ?>],
                    borderColor: '#f4b886',
                    backgroundColor: '#f4b88622',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5
                },
                {
                    label: 'Mínima (°C)',
                    data: [<?php foreach ($dias as $dia) echo round($dia->temp_min) . ',' ?>],
                    borderColor: '#aac0aa',
                    backgroundColor: '#aac0aa22',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { ticks: { callback: v => v + ' °C' } } }
        }
    });
</script>

<?php endif; ?>

<?php include_once('views/footeryheader/footer.php'); ?>