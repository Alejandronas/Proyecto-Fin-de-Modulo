<?php include_once('views/footeryheader/header.php'); ?>

<style>
    .hero {
        background-color: #fcdfa6;
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .search-input {
        border: 2px solid #a18276;
        border-radius: 10px 0 0 10px;
        padding: 0.6rem 1rem;
        width: 60%;
    }
    .search-input:focus {
        outline: none;
        border-color: #f4b886;
    }
    .btn-buscar {
        background-color: #a18276;
        color: #fff;
        border: none;
        border-radius: 0 10px 10px 0;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-buscar:hover {
        background-color: #8a6e63;
    }
    .card-opcion {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    .card-opcion:hover {
        transform: translateY(-5px);
    }
    .card-opcion i {
        font-size: 2.5rem;
        color: #a18276;
        margin-bottom: 0.5rem;
    }
    .btn-opcion {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border: none;
        color: #3a3a3a;
        text-decoration: none;
        display: inline-block;
    }
    .btn-opcion:hover {
        opacity: 0.85;
        color: #3a3a3a;
    }
    .error {
        background-color: #f8d7da;
        border-left: 4px solid #f44336;
        padding: 0.8rem 1.2rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .resultado-ciudad {
        background-color: #fcdfa6;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
</style>


<div class="hero">
    <h2 class="fw-bold">
        <i class="fas fa-cloud-sun"></i> ¿Qué tiempo hace hoy?
    </h2>
    <p class="text-muted mb-4">Busca cualquier ciudad del mundo</p>
    <form method="GET" action="/index.php" class="d-flex justify-content-center">
        <input type="hidden" name="vista" value="busqueda">
        <input type="text" name="ciudad" class="search-input" placeholder="Ej: Madrid, Tokyo..." required
               value="<?= isset($_GET['ciudad']) ? htmlspecialchars($_GET['ciudad']) : '' ?>">
        <button type="submit" class="btn-buscar">
            <i class="fas fa-search"></i> Buscar
        </button>
    </form>
</div>


<?php if (isset($error)): ?>
    <div class="error">
        <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
    </div>
<?php endif; ?>


<?php if (isset($ciudad)): ?>
    <div class="resultado-ciudad">
        <h4 class="fw-bold">
            <i class="fas fa-map-marker-alt" style="color:#f44336"></i>
            <?= $ciudad->nombre ?>, <?= $ciudad->pais ?>
        </h4>
        <p class="text-muted">
            <i class="fas fa-crosshairs"></i>
            Lat: <?= $ciudad->lat ?> | Lon: <?= $ciudad->lon ?>
        </p>
        <div class="d-flex flex-wrap gap-3 mt-3">
            <a href="/index.php?vista=actual&id=<?= $ciudad->id ?>" class="btn-opcion" style="background-color: #AAC0AA;">
                <i class="fas fa-thermometer-half"></i> Tiempo actual
            </a>
            <a href="/index.php?vista=horas&id=<?= $ciudad->id ?>" class="btn-opcion" style="background-color: #cbe896;">
                <i class="fas fa-clock"></i> Por horas
            </a>
            <a href="/index.php?vista=semana&id=<?= $ciudad->id ?>" class="btn-opcion" style="background-color: #f4b886;">
                <i class="fas fa-calendar-week"></i> Semanal
            </a>
        </div>
    </div>
<?php endif; ?>


<?php if (!isset($ciudad)): ?>
<div class="row g-4 mt-2">
    <div class="col-md-4">
        <div class="card-opcion" style="background-color: #fcdfa6;">
            <i class="fas fa-thermometer-half"></i>
            <h5 class="fw-bold mt-2">Tiempo actual</h5>
            <p class="text-muted">Temperatura, humedad, viento y más</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-opcion" style="background-color: #cbe896;">
            <i class="fas fa-clock"></i>
            <h5 class="fw-bold mt-2">Por horas</h5>
            <p class="text-muted">Previsión de las próximas 24 horas</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-opcion" style="background-color: #f4b886;">
            <i class="fas fa-calendar-week"></i>
            <h5 class="fw-bold mt-2">Semanal</h5>
            <p class="text-muted">Previsión para los próximos 7 días</p>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('views/footeryheader/footer.php'); ?>