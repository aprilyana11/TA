<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GPS Tracking</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
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
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/datamaps">Data</a>
            </li>
            <!-- Add more navigation items as needed -->
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
                      <td>: <a id="time_date"></a></td>
                    </tr>
                    <tr>
                      <td>Time</td>
                      <td>: <a id="time_time"></a></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                      <td>Latitude</td>
                      <td>: <a id="latitude"></a></td>
                    </tr>
                    <tr>
                      <td>Longitude</td>
                      <td>: <a id="longitude"></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <button id="startPolylineButton" class="btn btn-success">
                    Start Tracking
                  </button>
                </div>
                <div class="col-md-3">
                  <button
                    type="button"
                    class="btn btn-primary"
                    id="resetButton"
                    style="display: none"
                  >
                    Reset
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Bootstrap JS (optional) -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbE yER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script>
var map = L.map("map").setView([-6.8915, 107.6107], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Tambahkan marker untuk menandai lokasi Universitas Telkom Bandung
var marker = L.marker([-6.8915, 107.6107],
  {alt: 'Telkom University'}).addTo(map) // "Telkom University" is the accessible name of this marker
  .bindPopup('Universitas Telkom Bandung, Indonesia.');

marker.bindPopup('Universitas Telkom Bandung, Indonesia.');
// Ganti koordinat pada map.setView ke Universitas Telkom Bandung
map.setView([-6]). modify
 Cascading


      //https://github.com/pointhi/leaflet-color-markers
      var blueIcon = new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      });
      var redIcon = new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      });

      var greenIcon = new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      });

      var orangeIcon = new L.Icon({
        iconUrl:
          "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png",
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      });

      var initialMarker = L.marker([51.505, -0.09], { icon: redIcon });
      var updatedMarker = L.marker([51.505, -0.09], { icon: blueIcon });
      var finishMarker = L.marker([51.505, -0.09], { icon: greenIcon });
      var polyline = L.polyline([], { color: "blue" });
      var startPolylineButton = document.getElementById("startPolylineButton");
      var resetButton = document.getElementById("resetButton");
      var stat_btn = 0;

      L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution:
          '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);

      // Sample GPS tracking history data
      var trackingHistory = [
        { lat: 51.505, lng: -0.09, timestamp: "2023-06-10 10:00:00" },
        { lat: 51.51, lng: -0.1, timestamp: "2023-06-10 10:05:00" },
        { lat: 51.52, lng: -0.12, timestamp: "2023-06-10 10:10:00" },
        { lat: 51.53, lng: -0.13, timestamp: "2023-06-10 10:15:00" }, // Add more points here
        { lat: 51.54, lng: -0.14, timestamp: "2023-06-10 10:20:00" },
      ];

      function updateMap(data) {
        // Extract latitude and longitude from the API response
        var latitude = parseFloat(data.lat);
        var longitude = parseFloat(data.lng);
        var timestamp = data.timestamp;
        var [date_now, time_now] = timestamp.split(" ");

        document.getElementById("latitude").textContent = latitude.toFixed(6);
        document.getElementById("longitude").textContent = longitude.toFixed(6);
        document.getElementById("time_date").textContent = date_now;
        document.getElementById("time_time").textContent = time_now;

        // Update markers
        updateMarker(latitude, longitude, date_now, time_now);
        if (stat_btn == 1) {
          // Update polyline
          polyline.addLatLng([latitude, longitude]);
          polyline.addTo(map);
        }

        // Center the map on the updated location
        map.panTo([latitude, longitude]);

        // Update air quality monitoring table
        updateAirQualityTable(data);
      }

      function updateMarker(latitude, longitude, date_now, time_now) {
        var customPopup =
          "<b>Stored Data<br>" + date_now + " " + time_now + "</b>";

        var marker;

        if (stat_btn == 0) {
          marker = initialMarker.addTo(map);
        } else if (stat_btn == 1) {
          marker = updatedMarker.addTo(map);
        } else if (stat_btn == 2) {
          marker = finishMarker.addTo(map);
        }
        marker.setLatLng([latitude, longitude]).update();
        marker.bindPopup(customPopup).addTo(map);
        map.setView([latitude, longitude], map.getZoom());
      }

      function updateAirQualityTable(data) {
        var tableBody = document.getElementById("airQualityTableBody");

        var newRow = document.createElement("tr");

        var dateCell = document.createElement("td");
        dateCell.textContent = data.timestamp.split(" ")[0];
        newRow.appendChild(dateCell);

        var timeCell = document.createElement("td");
        timeCell.textContent = data.timestamp.split(" ")[1];
        newRow.appendChild(timeCell);

        var tempCell = document.createElement("td");
        tempCell.textContent = data.temperature + " C";
        newRow.appendChild(tempCell);

        var humidityCell = document.createElement("td");
        humidityCell.textContent = data.humidity + " %";
        newRow.appendChild(humidityCell);

        var pm25Cell = document.createElement("td");
        pm25Cell.textContent = data["PM2.5"] + " %";
        newRow.appendChild(pm25Cell);

        var pm10Cell = document.createElement("td");
        pm10Cell.textContent = data.PM10;
        newRow.appendChild(pm10Cell);

        var tvocCell = document.createElement("td");
        tvocCell.textContent = data.TVOC;
        newRow.appendChild(tvocCell);

        var eco2Cell = document.createElement("td");
        eco2Cell.textContent = data.ECO2;
        newRow.appendChild(eco2Cell);

        tableBody.appendChild(newRow);
      }

      function startPolyline() {
        if (stat_btn == 0) {
          stat_btn = 1;
          startPolylineButton.textContent = "Stop";
          startPolylineButton.classList.remove("btn-success");
          startPolylineButton.classList.add("btn-danger");
          resetButton.style.display = "none"; // Hide reset button when starting polyline
        } else if (stat_btn == 1) {
          stat_btn = 2;
          startPolylineButton.textContent = "Start Tracking";
          startPolylineButton.classList.remove("btn-danger");
          startPolylineButton.classList.add("btn-success");
          startPolylineButton.disabled = true;
          resetButton.style.display = "block"; // Show reset button when stopping polyline
        }
        console.log("Button Status:", stat_btn);
      }

      function resetMap() {
        stat_btn = 0;
        map.eachLayer(function (layer) {
          if (layer instanceof L.Marker || layer instanceof L.Polyline) {
            map.removeLayer(layer);
          }
        });
        startPolylineButton.disabled = false;
        document.getElementById("latitude").textContent = "";
        document.getElementById("longitude").textContent = "";
        document.getElementById("time_date").textContent = "";
        document.getElementById("time_time").textContent = "";
        initialMarker = L.marker([51.505, -0.09], { icon: redIcon });
        updatedMarker = L.marker([51.505, -0.09], { icon: blueIcon });
        finishMarker = L.marker([51.505, -0.09], { icon: greenIcon });
        polyline = L.polyline([], { color: "blue" });
        resetButton.style.display = "none";
        loadTrackingHistory(); // Load tracking history data after reset

        // Clear air quality monitoring table
        var tableBody = document.getElementById("airQualityTableBody");
        while (tableBody.firstChild) {
          tableBody.removeChild(tableBody.firstChild);
        }
      }

      function loadTrackingHistory() {
        trackingHistory.forEach((data, index) => {
          setTimeout(() => {
            updateMap(data);
          }, index * 1000);
        });
      }

      startPolylineButton.addEventListener("click", startPolyline);
      resetButton.addEventListener("click", resetMap);

      // Initial load of tracking history
      loadTrackingHistory();
    </script>
  </body>
</html>
