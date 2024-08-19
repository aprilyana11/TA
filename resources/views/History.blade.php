<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Air Quality Data</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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
            <a class="nav-link" href="/waqmsmaps">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/datamaps">Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/data-location">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/history">History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Dashboard</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Air Quality Monitoring</h5>
          </div>
          <div class="card-body">
            <form id="timeRangeForm">
              <div class="mb-3">
                <label for="startTime" class="form-label">Start Time</label>
                <input type="datetime-local" id="startTime" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="stopTime" class="form-label">Stop Time</label>
                <input type="datetime-local" id="stopTime" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="dataType" class="form-label">Data Type</label>
                <div>
                  <input type="radio" id="valid" name="dataType" value="valid" checked>
                  <label for="valid">Valid</label>
                </div>
                <div>
                  <input type="radio" id="raw" name="dataType" value="raw">
                  <label for="raw">Raw</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Fetch Data</button>
            </form>
            <table class="table table-bordered mt-4">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Temperature (C)</th>
                  <th>Humidity (%)</th>
                  <th>PM2.5 (%)</th>
                  <th>PM10</th>
                  <th>TVOC</th>
                  <th>ECO2</th>
                </tr>
              </thead>
              <tbody id="airQualityTableBody">
                <!-- Air quality data will be dynamically inserted here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.getElementById('timeRangeForm');

      form.addEventListener('submit', function(event) {
        event.preventDefault();

        const startTime = document.getElementById('startTime').value;
        const stopTime = document.getElementById('stopTime').value;
        const dataType = document.querySelector('input[name="dataType"]:checked').value;

        const formattedStartTime = formatDateTime(startTime);
        const formattedStopTime = formatDateTime(stopTime);

        // Fetch air quality data from the API
        console.log(`/api/History/${dataType}?start_time=${(formattedStartTime)}&stop_time=${(formattedStopTime)}`)
        fetch(`/api/History/${dataType}?start_time=${(formattedStartTime)}&stop_time=${(formattedStopTime)}`)
          .then(response => response.json())
          .then(airQualityData => {
            var tableBody = document.getElementById("airQualityTableBody");
            tableBody.innerHTML = ''; // Clear existing data

            airQualityData.forEach(data => {
              var newRow = document.createElement("tr");

              var dateCell = document.createElement("td");
              dateCell.textContent = new Date(data.time).toLocaleDateString();
              newRow.appendChild(dateCell);

              var timeCell = document.createElement("td");
              timeCell.textContent = new Date(data.time).toLocaleTimeString();
              newRow.appendChild(timeCell);

              var tempCell = document.createElement("td");
              tempCell.textContent = data.temperature.toFixed(2) + " C";
              newRow.appendChild(tempCell);

              var humidityCell = document.createElement("td");
              humidityCell.textContent = data.humidity.toFixed(0) + " %";
              newRow.appendChild(humidityCell);

              var pm25Cell = document.createElement("td");
              pm25Cell.textContent = data.pm25.toFixed(0) + " ug/m^3";
              newRow.appendChild(pm25Cell);

              var pm10Cell = document.createElement("td");
              pm10Cell.textContent = data.pm10.toFixed(0);
              newRow.appendChild(pm10Cell);

              var tvocCell = document.createElement("td");
              tvocCell.textContent = data.tvoc.toFixed(0);
              newRow.appendChild(tvocCell);

              var eco2Cell = document.createElement("td");
              eco2Cell.textContent = data.eco2.toFixed(0);
              newRow.appendChild(eco2Cell);

              tableBody.appendChild(newRow);
            });
          })
          .catch(error => console.error('Error fetching air quality data:', error));
      });

      function formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      }
    });
  </script>
</body>

</html>