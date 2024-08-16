<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GPS Tracking</title>
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <style>
    #map {
      height: 500px;
    }
  </style>
</head>

<body>
  <!-- Top Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">GPS Tracking</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/waqmsmaps" data-page="home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/datamaps" data-page="data">Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/data-location" data-page="location">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/history" data-page="history">History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard" data-page="dashboard">Dashboard</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div id="map"></div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Last Data Received</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td style="width: 20%">Date</td>
                    <td>: <span id="time_date"></span></td>
                  </tr>
                  <tr>
                    <td>Time</td>
                    <td>: <span id="time_time"></span></td>
                  </tr>
                  <tr>
                    <td>Latitude</td>
                    <td>: <span id="latitude"></span></td>
                  </tr>
                  <tr>
                    <td>Longitude</td>
                    <td>: <span id="longitude"></span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    var map = L.map("map").setView([-6.973007, 107.6316854], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var blueIcon = new L.Icon({
      iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png",
      shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });

    var redIcon = new L.Icon({
      iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
      shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });

    function updateMap(locations) {
      if (locations.length === 0) return;

      // Initial marker (first location)
      var initialMarker = L.marker([locations[0].latitude, locations[0].longitude], {
        icon: redIcon
      }).addTo(map).bindTooltip(`
    PM2.5: ${locations[0].pm25} µg/m³<br>
    PM10: ${locations[0].pm10} µg/m³<br>
    Temperature: ${locations[0].temperature} °C<br>
    Humidity: ${locations[0].humidity} %<br>
    Date: ${new Date(locations[0].created_at).toLocaleDateString()}<br>
    Time: ${new Date(locations[0].created_at).toLocaleTimeString()}
  `);

      // Updated marker (last location)
      var updatedMarker = L.marker([locations[locations.length - 1].latitude, locations[locations.length - 1].longitude], {
        icon: blueIcon
      }).addTo(map).bindTooltip(`
    PM2.5: ${locations[locations.length - 1].pm25} µg/m³<br>
    PM10: ${locations[locations.length - 1].pm10} µg/m³<br>
    Temperature: ${locations[locations.length - 1].temperature} °C<br>
    Humidity: ${locations[locations.length - 1].humidity} %<br>
    Date: ${new Date(locations[locations.length - 1].created_at).toLocaleDateString()}<br>
    Time: ${new Date(locations[locations.length - 1].created_at).toLocaleTimeString()}
  `);

      // Add polyline connecting all points
      var polyline = L.polyline(locations.map(function(location) {
        return [location.latitude, location.longitude];
      }), {
        color: "blue"
      }).addTo(map);

      // Add markers for each location
      locations.forEach(function(location) {
        L.marker([location.latitude, location.longitude], {
          icon: blueIcon
        }).addTo(map).bindTooltip(`
      PM2.5: ${location.pm25} µg/m³<br>
      PM10: ${location.pm10} µg/m³<br>
      Temperature: ${location.temperature} °C<br>
      Humidity: ${location.humidity} %<br>
      Date: ${new Date(location.created_at).toLocaleDateString()}<br>
      Time: ${new Date(location.created_at).toLocaleTimeString()}
    `);
      });

      // Update the last received data section
      document.getElementById("time_date").innerHTML = new Date(locations[locations.length - 1].created_at).toLocaleDateString();
      document.getElementById("time_time").innerHTML = new Date(locations[locations.length - 1].created_at).toLocaleTimeString();
      document.getElementById("latitude").innerHTML = locations[locations.length - 1].pm25; // Adjusted to show pm25
      document.getElementById("longitude").innerHTML = locations[locations.length - 1].pm10; // Adjusted to show pm10
    }

    fetch('api/location')
      .then(response => response.json())
      .then(data => {
        updateMap(data);
      })
      .catch(error => console.error('Error fetching location data:', error));

    // JavaScript to handle navigation
    (function() {
      const allowedPages = new Set(['home', 'data', 'location', 'history', 'dashboard']);

      function handleLinkClick(event) {
        const page = event.target.getAttribute('data-page');
        if (allowedPages.has(page)) {
          return; // Allow navigation
        }
        event.preventDefault();
        alert('Navigation is restricted to the navbar links only.');
      }

      document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', handleLinkClick);
      });

      window.addEventListener('beforeunload', function(event) {
        const hash = location.hash;
        if (hash && !allowedPages.has(hash.slice(1))) {
          event.preventDefault();
          event.returnValue = ''; // For most browsers
        }
      });
    })();
  </script>
</body>

</html>