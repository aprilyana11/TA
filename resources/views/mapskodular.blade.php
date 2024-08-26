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
    html,
    body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    #map {
      flex-grow: 1;
    }
  </style>
</head>

<body>
  <!-- Main Content -->
  <div id="map"></div>

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
      iconSize: [2, 2],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [0, 0],
    });

    var redIcon = new L.Icon({
      iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
      shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });

    var smallDotIcon = L.divIcon({
      className: 'small-dot-icon',
      html: '<div style="width: 10px; height: 10px; background-color: blue; border-radius: 50%;"></div>',
      iconSize: [2, 2],
      iconAnchor: [1, 1],
    });

    function updateMap(locations) {
      if (locations.length === 0) return;

      // Initial marker (first location)
      L.marker([locations[0].latitude, locations[0].longitude], {
        icon: redIcon
      }).addTo(map).bindTooltip(`
        PM2.5: ${locations[0].pm25} µg/m³<br>
        PM10: ${locations[0].pm10} µg/m³<br>
        Temperature: ${locations[0].temperature} °C<br>
        Humidity: ${locations[0].humidity} %<br>
        Date: ${new Date(locations[0].created_at).toLocaleDateString()}<br>
        Time: ${new Date(locations[0].created_at).toLocaleTimeString()}
      `);

      // Add small dots for each location except the last one
      locations.slice(1, -1).forEach(function(location) {
        L.marker([location.latitude, location.longitude], {
          icon: smallDotIcon
        }).addTo(map).bindTooltip(`
          PM2.5: ${location.pm25} µg/m³<br>
          PM10: ${location.pm10} µg/m³<br>
          Temperature: ${location.temperature} °C<br>
          Humidity: ${location.humidity} %<br>
          Date: ${new Date(location.created_at).toLocaleDateString()}<br>
          Time: ${new Date(location.created_at).toLocaleTimeString()}
        `);
      });

      // Updated marker (last location)
      L.marker([locations[locations.length - 1].latitude, locations[locations.length - 1].longitude], {
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
      L.polyline(locations.map(function(location) {
        return [location.latitude, location.longitude];
      }), {
        color: "blue"
      }).addTo(map);

      // Update the last received data section
      document.getElementById("time_date").innerHTML = new Date(locations[locations.length - 1].created_at).toLocaleDateString();
      document.getElementById("time_time").innerHTML = new Date(locations[locations.length - 1].created_at).toLocaleTimeString();
      document.getElementById("latitude").innerHTML = locations[locations.length - 1].latitude;
      document.getElementById("longitude").innerHTML = locations[locations.length - 1].longitude;
    }

    fetch('api/location')
      .then(response => response.json())
      .then(data => {
        var locations = data.map(location => ({
          latitude: location.latitude,
          longitude: location.longitude,
          pm25: location.pm25,
          pm10: location.pm10,
          temperature: location.temperature,
          humidity: location.humidity,
          created_at: location.created_at
        }));
        updateMap(locations);
      })
      .catch(error => console.error('Error fetching location data:', error));
  </script>
</body>

</html>