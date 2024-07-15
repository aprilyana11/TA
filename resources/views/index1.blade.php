<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personal Air Monitoring</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml" />
  <link rel="stylesheet" href="css/style1.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto:wght@300;400;500;700&family=Oswald:wght@600&display=swap" rel="stylesheet" />
</head>

<body>
  <header class="header" data-header>
    <div class="container">
      <h1>
        <a href="#" class="logo">WAQMS</a>
      </h1>
      <select name="language" class="lang-switch">
        <option value="english">Indonesia</option>
      </select>
      <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>
      <nav class="navbar" data-navbar>
        <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
          <ion-icon name="close-outline"></ion-icon>
        </button>
        <a href="#" class="logo">WAQMS</a>
        <ul class="navbar-list">
          <li>
            <a href="#home" class="navbar-link" data-nav-link>
              <span>Home</span>
              <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#waqms" class="navbar-link" data-nav-link>
              <span>WAQMS</span>
              <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
            </a>
          </li>
        </ul>
      </nav>
      <div class="header-action">
        <button class="search-btn" aria-label="Search">
          <ion-icon name="search-outline"></ion-icon>
        </button>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/login') }}">
            <div class="green-box">
              <span>Login</span>
            </div>
          </a>
        </li>
        <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
      </div>
    </div>
  </header>
  <main>
    <article>
      <section class="hero" id="home">
        <div class="container">
          <p class="section-subtitle">
            <img src="{{ asset('img/subtitle-img-white.png')}}" width="32" height="7" alt="Wavy line" />
            <span>Selamat Datang di WAQMS</span>
          </p>
          <h2 class="h1 hero-title">
            Wearable Air Quality Mobile Monitoring System<strong></strong>
          </h2>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/register') }}">
              <div class="green-box">
                <span>Register</span>
              </div>
            </a>
          </li>
          <title>Halaman Signup</title>
        </div>
      </section>
      <section class="section features">
        <div class="container">
          <ul class="features-list">
            <li class="features-item">
              <div class="item-icon">
                <ion-icon name="shield-checkmark-outline"></ion-icon>
              </div>
              <div>
                <h3 class="h4 item-title">Safe Shelter</h3>
                <p class="item-text"></p>
              </div>
            </li>
            <li class="features-item">
              <div class="item-icon">
                <ion-icon name="water-outline"></ion-icon>
              </div>
              <div>
                <h3 class="h4 item-title">Safe Water</h3>
                <p class="item-text"></p>
              </div>
            </li>
            <li class="features-item">
              <div class="item-icon">
                <ion-icon name="leaf-outline"></ion-icon>
              </div>
              <div>
                <h3 class="h4 item-title">Ecology Save</h3>
                <p class="item-text"></p>
              </div>
            </li>
            <li class="features-item">
              <div class="item-icon">
                <ion-icon name="snow-outline"></ion-icon>
              </div>
              <div>
                <h3 class="h4 item-title">Environment</h3>
                <p class="item-text"></p>
              </div>
            </li>
          </ul>
        </div>
      </section>
      <section class="section about" id="about">
        <div class="container">
          <div class="about-banner">
            <h2 class="deco-title">Tentang kami</h2>
            <div class="banner-row">
              <div class="banner-col">
                <img src="{{ asset('img/a.png')}}" width="315" height="380" loading="lazy" alt="Tiger" class="about-img w-100" />
                <img src="{{ asset('img/b.png')}}" width="386" height="250" loading="lazy" alt="" class="about-img about-img-2 w-100" />
              </div>
              <div class="banner-col">
                <img src="{{ asset('img/c.png')}}" width="250" height="277" loading="lazy" alt="" class="about-img about-img-3 w-100" />
                <img src="{{ asset('img/d.png')}}" width="260" height="300" loading="lazy" alt="" class="about-img w-100" />
              </div>
            </div>
          </div>
          <div class="about-content">
            <p class="section-subtitle">
              <img src="{{ asset('img/subtitle