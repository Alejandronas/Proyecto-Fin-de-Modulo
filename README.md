#  WeatherApp — Proyecto IAW

Aplicación web desarrollada en **PHP** que consulta el tiempo meteorológico de cualquier ciudad del mundo usando la API de **OpenWeatherMap**. Incluye despliegue con **Docker** y persistencia de datos en **MariaDB**.

---

##  Descripción

WeatherApp permite al usuario buscar cualquier ciudad del mundo y consultar:

- El **tiempo actual** (temperatura, humedad, viento, presión)
- La **previsión por horas** (próximas 24h en intervalos de 3h)
- La **previsión semanal** (próximos 5 días)
- Un **historial de consultas** registradas en base de datos

---

##  Tecnologías utilizadas

| Tecnología | Uso |
|---|---|
| PHP 8.2 | Backend / lógica de la aplicación |
| MariaDB 10.11 | Base de datos relacional |
| Nginx | Servidor web |
| Docker + Docker Compose | Contenedores y despliegue |
| Bootstrap 5.3 | Diseño responsive |
| Chart.js | Gráficas de temperatura |
| Font Awesome 6.4 | Iconos de la interfaz |
| OpenWeatherMap API | Datos meteorológicos en tiempo real |

---

##  Estructura del proyecto

```
Proyecto de PHP/
├── controllers/                  # Controladores 
│   ├── ActualController.php      # Lógica del tiempo actual
│   ├── BusquedaController.php    # Lógica de búsqueda de ciudad
│   ├── HistorialController.php   # Lógica del historial
│   ├── HorasController.php       # Lógica de previsión por horas
│   └── SemanaController.php      # Lógica de previsión semanal
│
├── models/                       # Modelos y acceso a datos
│   ├── clases/                   # Clases de datos 
│   │   ├── Ciudad.php            # Clase Ciudad
│   │   ├── TiempoActual.php      # Clase TiempoActual
│   │   ├── TiempoDia.php         # Clase TiempoDia
│   │   └── TiempoHora.php        # Clase TiempoHora
│   ├── CiudadDAO.php             # CRUD de ciudades en BD
│   ├── ConsultaDAO.php           # CRUD de consultas en BD
│   ├── MeteoDAO.php              # CRUD de datos meteorológicos en BD
│   └── WeatherAPI.php            # Comunicación con OpenWeatherMap API
│
├── views/                        # Vistas 
│   ├── footeryheader/
│   │   ├── header.php            # Cabecera común (Bootstrap, Chart.js)
│   │   └── footer.php            # Pie de página común
│   ├── inicio.php                # Página de búsqueda
│   ├── actual.php                # Vista del tiempo actual
│   ├── horas.php                 # Vista de previsión por horas
│   ├── semana.php                # Vista de previsión semanal
│   └── historial.php             # Vista del historial de consultas
│
├── db/
│   ├── config.php                # Conexión a la base de datos 
│   └── weather.sql               # Script SQL de creación de tablas
│
├── docker/
│   ├── nginx/
│   │   ├── Dockerfile            # Imagen personalizada de Nginx
│   │   └── default.conf          # Configuración de Nginx + PHP
│   └── php/
│       ├── Dockerfile            # Imagen de PHP con extensiones
│       └── php.ini               # Configuración de PHP
│
├── docker-compose.yml            # Orquestación de contenedores
└── index.php                     # Punto de entrada 
```

---

##  Base de datos

La base de datos se llama `tiempo_db` y contiene 5 tablas:

### `ciudades`
Almacena las ciudades buscadas por el usuario.

| Campo | Tipo | Descripción |
|---|---|---|
| id | INT PK | Identificador único |
| nombre | VARCHAR(100) | Nombre de la ciudad |
| pais | VARCHAR(10) | Código de país (ES, JP...) |
| lat | DECIMAL(9,6) | Latitud geográfica |
| lon | DECIMAL(9,6) | Longitud geográfica |
| creado_en | TIMESTAMP | Fecha de inserción |

### `consultas`
Registra cada vez que el usuario consulta el tiempo de una ciudad.

| Campo | Tipo | Descripción |
|---|---|---|
| id | INT PK | Identificador único |
| ciudad_id | INT FK | Ciudad consultada |
| tipo_consulta | ENUM | actual / horas / semana |
| ip_cliente | VARCHAR(45) | IP del usuario |
| realizada_en | TIMESTAMP | Fecha y hora de la consulta |

### `datos_actuales`
Guarda los datos del tiempo actual de cada consulta.

| Campo | Tipo | Descripción |
|---|---|---|
| temperatura | DECIMAL(5,2) | Temperatura en °C |
| sensacion_termica | DECIMAL(5,2) | Sensación térmica en °C |
| temp_min / temp_max | DECIMAL(5,2) | Temperaturas mínima y máxima |
| humedad | INT | Humedad relativa en % |
| presion | INT | Presión atmosférica en hPa |
| velocidad_viento | DECIMAL(5,2) | Velocidad del viento en m/s |
| descripcion | VARCHAR(100) | Descripción del tiempo |
| icono | VARCHAR(20) | Código del icono de OpenWeatherMap |

### `datos_horas`
Guarda la previsión por horas (intervalos de 3h).

| Campo | Tipo | Descripción |
|---|---|---|
| dt | VARCHAR(10) | Hora de la previsión (HH:MM) |
| temperatura | DECIMAL(5,2) | Temperatura en °C |
| humedad | INT | Humedad en % |
| velocidad_viento | DECIMAL(5,2) | Viento en m/s |
| probabilidad_lluvia | DECIMAL(4,2) | Probabilidad de lluvia (0-1) |

### `datos_semana`
Guarda la previsión diaria de los próximos 5 días.

| Campo | Tipo | Descripción |
|---|---|---|
| fecha | DATE | Fecha del día (YYYY-MM-DD) |
| temp_min / temp_max | DECIMAL(5,2) | Temperaturas mínima y máxima |
| humedad | INT | Humedad en % |
| velocidad_viento | DECIMAL(5,2) | Viento en m/s |
| probabilidad_lluvia | DECIMAL(4,2) | Probabilidad de lluvia (0-1) |

---

##  Docker

El proyecto usa **Docker Compose** con 4 contenedores:

| Contenedor | Imagen | Puerto |
|---|---|---|
| tiempo_php | PHP 8.2-FPM (build propio) | 9000 (interno) |
| tiempo_nginx | Nginx Alpine (build propio) | 80 |
| tiempo_db | MariaDB 10.11 | 3306 (interno) |
| tiempo_phpmyadmin | phpMyAdmin | 8081 |

Todos los contenedores están en la red interna `tiempo_net`.

---

##  Instalación y puesta en marcha

### Requisitos previos
- Docker Desktop instalado
- Git instalado

### Pasos

**1. Clona el repositorio:**
```bash
git clone https://github.com/TU_USUARIO/weather-app-iaw.git
cd weather-app-iaw
```

**2. Arranca los contenedores:**
```bash
docker-compose up -d --build
```

**3. Crea las tablas en la base de datos:**

Accede a phpMyAdmin en `http://localhost:8081` e importa el archivo `db/weather.sql`, o ejecútalo manualmente en la consola SQL.

**4. Accede a la aplicación:**
```
http://localhost
```

**5. Para parar los contenedores:**
```bash
docker-compose down
```

---

##  API Key

La aplicación usa la API de **OpenWeatherMap**. La API Key está configurada en `models/WeatherAPI.php`.

Para usar tu propia clave:
1. Regístrate en [openweathermap.org](https://openweathermap.org)
2. Ve a tu perfil → API Keys
3. Sustituye la clave en `WeatherAPI.php`:

```php
private $apiKey = 'TU_API_KEY_AQUI';
```

>  La previsión semanal requiere activar la **One Call API 3.0** (gratuita con tarjeta hasta 1000 llamadas/día).

---

##  Paleta de colores

| Color | Hex | Uso |
|---|---|---|
| Lime Cream | `#cbe896` | Fondos secundarios |
| Ash Grey | `#aac0aa` | Navbar y footer |
| Soft Peach | `#fcdfa6` | Tarjetas principales |
| Dusty Taupe | `#a18276` | Textos y bordes |
| Light Caramel | `#f4b886` | Badges y detalles |

---

##  Autor

Proyecto realizado para el módulo **IAW** (Implantación de Aplicaciones Web)  
CFGS Administración de Sistemas Informáticos en Red (**ASIR**)
