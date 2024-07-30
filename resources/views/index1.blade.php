<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personal Air Monitoring</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml" />
  <link rel="stylesheet" href={{asset("css/style1.css")}} />
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
        <option value="indonesia">Indonesia</option>
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
            <img src="{{ asset('images/subtitle-img-white.png')}}" width="32" height="7" alt="Wavy line" />
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
            <a class="nav-link" href="{{ url('/login') }}">
              <div class="green-box">
                <span>Login</span>
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
                <img src="{{ asset('images/a.png')}}" width="315" height="380" loading="lazy" alt="Tiger" class="about-img w-100" />
                <img src="{{ asset('images/b.png')}}" width="386" height="250" loading="lazy" alt="" class="about-img about-img-2 w-100" />
              </div>
              <div class="banner-col">
                <img src="{{ asset('images/c.png')}}" width="250" height="277" loading="lazy" alt="" class="about-img about-img-3 w-100" />
                <img src="{{ asset('images/d.png')}}" width="260" height="300" loading="lazy" alt="" class="about-img w-100" />
              </div>
            </div>
          </div>
          <div class="about-content">
            <p class="section-subtitle">
              <img src="{{ asset('images/subtitle')
                <span>Why ?</span>
              </p>

              <h2 class="h2 section-title">
                Why choose<strong>Wearable ? </strong>
              </h2>

              <ul class="tab-nav">
                <li>
                  <button class="tab-btn active">Our Mission</button>
                </li>

                <li>
                  <button class="tab-btn">Our Vision</button>
                </li>

                <li>
                  <button class="tab-btn">Next Plan</button>
                </li>
              </ul>

              <div class="tab-content">
                <p class="section-text">
                  This device is designed for personal daily air quality
                  monitoring, aimed at measuring air quality parameters and
                  evaluating exposure based on IoT.
                </p>

                <ul class="tab-list">
                  <li class="tab-item">
                    <div class="item-icon">
                      <ion-icon name="checkmark-circle"></ion-icon>
                    </div>

                    <p class="tab-text">Charity For Foods</p>
                  </li>

                  <li class="tab-item">
                    <div class="item-icon">
                      <ion-icon name="checkmark-circle"></ion-icon>
                    </div>

                    <p class="tab-text">Air Quality at your Fingertips</p>

                  </li>

                  <li class="tab-item">
                    <div class="item-icon">
                      <ion-icon name="checkmark-circle"></ion-icon>
                    </div>

                    <p class="tab-text">Comfort and Mobility</p>
                  </li>

                  <li class="tab-item">
                    <div class="item-icon">
                      <ion-icon name="checkmark-circle"></ion-icon>
                    </div>

                    <p class="tab-text">Practical and Efficient Solution</p>
                  </li>
                </ul>
                  <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                </button>
              </div>
            </div>
          </div>
        </section>

        <!-- 
        - #Feature
      -->

        <section
          class="section service"
          id="Features"

        
          <div class="container">
            <p class="section-subtitle">
              <img
                src="./assets/imagess/subtitle-img-green.png"
                width="32"
                height="7"
                alt="Wavy line"
              />

              <span>What We Do</span>
            </p>

            <h2 class="h2 section-title">
              We Work Differently to <strong>keep The Healthy Safe</strong>
            </h2>

            <ul class="service-list">
              <li>
                <div class="service-card">
                  <div class="card-icon">
                    <ion-icon name="leaf-outline"></ion-icon>
                  </div>

                  <h3 class="h3 card-title">
                    Real-Time Air Quality Monitoring
                  </h3>

                  <p class="card-text">
                    Stay updated with the latest air quality information around
                    you. Our system provides real-time data, ensuring you are
                    always aware of the air you are breathing.
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon
                      name="arrow-forward"
                      aria-hidden="true"
                    ></ion-icon>
                  </a>
                </div>
              </li>

              <li>
                <div class="service-card">
                  <div class="card-icon">
                    <ion-icon name="earth-outline"></ion-icon>
                  </div>

                  <h3 class="h3 card-title">Compact and Wearable Design</h3>

                  <p class="card-text">
                    Experience the convenience of our lightweight and
                    ergonomically designed device. Wear it comfortably
                    throughout the day and monitor air quality wherever you go.
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon
                      name="arrow-forward"
                      aria-hidden="true"
                    ></ion-icon>
                  </a>
                </div>
              </li>

              <li>
                <div class="service-card">
                  <div class="card-icon">
                    <ion-icon name="flower-outline"></ion-icon>
                  </div>

                  <h3 class="h3 card-title">Advanced Sensor Technology</h3>

                  <p class="card-text">
                    Benefit from cutting-edge sensors that detect various
                    pollutants, including particulate matter (PM2.5 and PM10),
                    Equivalent carbon dioxide (ECO2), and Total volatile organic
                    compounds (TVOCs), Temperature, Humidity.
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon
                      name="arrow-forward"
                      aria-hidden="true"
                    ></ion-icon>
                  </a>
                </div>
              </li>

              <li>
                <div class="service-card">
                  <div class="card-icon">
                    <ion-icon name="boat-outline"></ion-icon>
                  </div>

                  <h3 class="h3 card-title">Mobile App Integration</h3>

                  <p class="card-text">
                    Easily sync the device with our user-friendly mobile app to
                    access detailed insights, historical data, and personalized
                    alerts directly on your smartphone.
                  </p>

                  <a href="#" class="btn-link">
                    <span>Read More</span>

                    <ion-icon
                      name="arrow-forward"
                      aria-hidden="true"
                    ></ion-icon>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </section>