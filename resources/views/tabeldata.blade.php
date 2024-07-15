<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Air Quality Data</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
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
              <a class="nav-link" href="mapsgps.blade.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Data</a>
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
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Air Quality Monitoring</h5>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
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
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Simulating air quality data for demonstration
        var airQualityData = [
          {
            date: "2023-06-10",
            time: "10:00:00",
            temperature: 25,
            humidity: 60,
            PM2_5: 12,
            PM10: 20,
            TVOC: 150,
            ECO2: 400,
          },
          {
            date: "2023-06-10",
            time: "10:05:00",
            temperature: 26,
            humidity: 62,
            PM2_5: 14,
            PM10: 22,
            TVOC: 155,
            ECO2: 405,
          },
          {
            date: "2023-06-10",
            time: "10:10:00",
            temperature: 27,
            humidity: 65,
            PM2_5: 16,
            PM10: 24,
            TVOC: 160,
            ECO2: 410,
          },
          // Add more air quality data as needed
        ];

        var tableBody = document.getElementById("airQualityTableBody");

        airQualityData.forEach((data) => {
          var newRow = document.createElement("tr");

          var dateCell = document.createElement("td");
          dateCell.textContent = data.date;
          newRow.appendChild(dateCell);

          var timeCell = document.createElement("td");
          timeCell.textContent = data.time;
          newRow.appendChild(timeCell);

          var tempCell = document.createElement("td");
          tempCell.textContent = data.temperature + " C";
          newRow.appendChild(tempCell);

          var humidityCell = document.createElement("td");
          humidityCell.textContent = data.humidity + " %";
          newRow.appendChild(humidityCell);

          var pm25Cell = document.createElement("td");
          pm25Cell.textContent = data.PM2_5 + " %";
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
        });
      });
    </script>
  </body>
</html>
