<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style3.css') }}">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">

</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class="bx bxs-smile"></i>
            <span class="text">WAQMS</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class="bx bxs-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/grafikwaqms">
                    <i class="bx bxs-bar-chart-alt-2"></i>
                    <span class="text">Grafik</span>
                </a>
            </li>
            <li>
                <a href="/waqmsmaps">
                    <i class="bx bxs-map"></i>
                    <span class="text">Tracking</span>
                </a>
            </li>
            <li>
                <a href="/profile">
                    <i class="bx bxs-user"></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <form action="{{ route('actionlogout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout">
                        <i class="bx bxs-log-out-circle"></i>
                        <span class="text">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="bx bx-menu"></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search..." />
                    <button type="submit" class="search-btn">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <!-- HERO SECTION -->
            <div class="hero">
            </div>
            <!-- HERO SECTION -->

            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class="bx bxs-cloud-rain"></i>
                    <span class="text">
                        <p>PM2.5 </p>
                        <p>{{ $pm25 }} µg/m³</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-cloud"></i>
                    <span class="text">
                        <p>PM10</p>
                        <p>{{$pm10}} µg/m³</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-thermometer"></i>
                    <span class="text">
                        <p>Temperature</p>
                        <p>{{$temperature}} °C</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-droplet"></i>
                    <span class="text">
                        <p>Humidity</p>
                        <p>{{$humidity}} %</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-gas-pump"></i>
                    <span class="text">
                        <p>TVOC</p>
                        <p>{{$tvoc}} mg³/m³</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-cloud"></i>
                    <span class="text">
                        <p>eCO2</p>
                        <p>{{$eco2}} ppm</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-cloud-rain"></i>
                    <span class="text">
                        <p>Pressure</p>
                        <p>{{$pressure}} mdpl</p>
                </li>
                <!-- Personal Exposure Box -->
                <li class="personal-exposure {{ strtolower(str_replace(' ', '-', $exposure_level)) }}">
                    <i class="bx bxs-face-mask"></i>
                    <span class="text">
                        <p>Indeks Paparan Personal</p>
                        <p class="level">{{ $exposure_level }}</p>
                        <p class="value">{{ $exposureValue }}</p>
                        <p class="recommendation">{{ $recommendationTime }}</p>
                    </span>
                </li>
            </ul>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>