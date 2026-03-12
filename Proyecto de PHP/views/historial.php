<?php include_once('views/footeryheader/header.php'); ?>

<style>
    .card-tiempo {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .tabla-historial thead {
        background-color: #aac0aa;
    }
    .tabla-historial tbody tr:hover {
        background-color: #fcdfa6;
    }
    .badge-actual  { background-color: #fcdfa6; color: #3a3a3a; padding: 0.3rem 0.8rem; border-radius: 20px; }
    .badge-horas   { background-color: #cbe896; color: #3a3a3a; padding: 0.3rem 0.8rem; border-radius: 20px; }
    .badge-semana  { background-color: #f4b886; color: #3a3a3a; padding: 0.3rem 0.8rem; border-radius: 20px; }
</style>

<div class="card-tiempo">
    <h4 class="fw-bold mb-3">
        <i class="fas fa-history"></i> Historial de consultas
    </h4>

    <?php if (empty($consultas)): ?>
        <p class="text-muted">
            <i class="fas fa-info-circle"></i> No hay consultas registradas todavía.
        </p>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table tabla-historial">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-calendar"></i> Fecha</th>
                    <th><i class="fas fa-map-marker-alt"></i> Ciudad</th>
                    <th><i class="fas fa-flag"></i> País</th>
                    <th><i class="fas fa-tag"></i> Tipo</th>
                    <th><i class="fas fa-network-wired"></i> IP</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($consultas as $i => $consulta): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $consulta['realizada_en'] ?></td>
                    <td><?= $consulta['nombre'] ?></td>
                    <td><?= $consulta['pais'] ?></td>
                    <td>
                        <span class="badge-<?= $consulta['tipo_consulta'] ?>">
                            <?php if ($consulta['tipo_consulta'] == 'actual'): ?>
                                <i class="fas fa-thermometer-half"></i> Actual
                            <?php elseif ($consulta['tipo_consulta'] == 'horas'): ?>
                                <i class="fas fa-clock"></i> Horas
                            <?php else: ?>
                                <i class="fas fa-calendar-week"></i> Semana
                            <?php endif; ?>
                        </span>
                    </td>
                    <td><?= $consulta['ip_cliente'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include_once('views/footeryheader/footer.php'); ?>