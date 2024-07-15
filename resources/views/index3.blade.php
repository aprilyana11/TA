<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThingSpeak Data</title>
    <link rel="stylesheet" href="{{ asset('css/style3.css') }}">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>
        i.bx {
            font-size: 24px;
            /* Ukuran font */
            display: inline-block;
            vertical-align: middle;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile .name {
            font-weight: bold;
        }
    </style>
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
                    <span class="text">Maps</span>
                </a>
            </li>
            <li>
                <a href="/profile">
                    <i class="bx bxs-user"></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
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
            <input type="checkbox" id="switch-mode" hidden />
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class="bx bxs-bell"></i>
                <span class="num">8</span>
            </a>

        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
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
                <a href="#" class="btn-download">
                    <i class="bx bxs-cloud-download"></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>

            <ul class="box-info">
                <li>
                    <i class="bx bxs-cloud-rain"></i>
                    <span class="text">
                        <h3>{{ $feed['field1'] ?? '8' }} µg/m³</h3>
                        <p>PM2.5</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-cloud"></i>
                    <span class="text">
                        <h3>{{ $feed['field2'] ?? '9' }} µg/m³</h3>
                        <p>PM10</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-thermometer"></i>
                    <span class="text">
                        <h3>{{ $feed['field3'] ?? 'N/A' }} °C</h3>
                        <p>Temperature</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-droplet"></i>
                    <span class="text">
                        <h3>{{ $feed['field4'] ?? 'N/A' }} %</h3>
                        <p>Humidity</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-gas-pump"></i>
                    <span class="text">
                        <h3>{{ $feed['field5'] ?? 'N/A' }} ppm</h3>
                        <p>TVOC</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-gauge"></i>
                    <span class="text">
                        <h3>{{ $feed['field6'] ?? 'N/A' }} ppm</h3>
                        <p>eCO2</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-wind"></i>
                    <span class="text">
                        <h3>{{ $feed['field7'] ?? 'N/A' }} hPa</h3>
                        <p>Pressure</p>
                    </span>
                </li>
            </ul>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
</body>

</html>