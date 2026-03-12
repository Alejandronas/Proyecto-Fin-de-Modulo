<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeatherApp IAW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --lime-cream:    #cbe896;
            --ash-grey:      #aac0aa;
            --soft-peach:    #fcdfa6;
            --dusty-taupe:   #a18276;
            --light-caramel: #f4b886;
        }

        body {
            background-color: #f9f5f0;
            color: #3a3a3a;
        }

        .navbar {
            background-color: var(--ash-grey) !important;
            border-bottom: 3px solid var(--dusty-taupe);
        }

        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 700;
            color: #3a3a3a !important;
        }

        .navbar-nav .nav-link {
            color: #3a3a3a !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--dusty-taupe) !important;
        }

        .navbar-nav .nav-link.active {
            color: var(--dusty-taupe) !important;
            font-weight: 700;
        }

        main {
            min-height: 80vh;
            padding: 2rem 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/index.php">
            <i class="fas fa-cloud-sun"></i> WeatherApp
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">
                        <i class="fas fa-search"></i> Buscar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/index.php?vista=historial">
                        <i class="fas fa-history"></i> Historial
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">