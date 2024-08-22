<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Air Quality Data</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .table {
      margin: 0;
    }
  </style>
</head>

<body>
  <!-- Main Content -->
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

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Function to get URL parameters
      function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
      }

      const startTime = getUrlParameter('start_time');
      const stopTime = getUrlParameter('stop_time');
      const type = '{{ $type }}';

      if (startTime && stopTime && type) {
        const formattedStartTime = formatDateTime(startTime);
        const formattedStopTime = formatDateTime(stopTime);

        // Fetch air quality data from the API
        fetch(`/api/History/${type}?start_time=${formattedStartTime}&stop_time=${formattedStopTime}`)
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
              tempCell.textContent = data.temperature + " C";
              newRow.appendChild(tempCell);

              var humidityCell = document.createElement("td");
              humidityCell.textContent = data.humidity + " %";
              newRow.appendChild(humidityCell);

              var pm25Cell = document.createElement("td");
              pm25Cell.textContent = data.pm25 + " ugr/m^3";
              newRow.appendChild(pm25Cell);

              var pm10Cell = document.createElement("td");
              pm10Cell.textContent = data.pm10;
              newRow.appendChild(pm10Cell);

              var tvocCell = document.createElement("td");
              tvocCell.textContent = data.tvoc;
              newRow.appendChild(tvocCell);

              var eco2Cell = document.createElement("td");
              eco2Cell.textContent = data.eco2;
              newRow.appendChild(eco2Cell);

              tableBody.appendChild(newRow);
            });
          })
          .catch(error => console.error('Error fetching air quality data:', error));
      }

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