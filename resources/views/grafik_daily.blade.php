<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bar Charts</title>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    body {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 50px;
      background-color: #C1E0A2;
      position: relative;
      /* Ensure the absolute positioning works */
      /* Ensure the absolute positioning works */
    }

    .chart-wrapper {
      width: 95%;
      height: 400px;
      margin-bottom: 20px;
      margin-top: 50px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      background-color: #ffff;
      padding: 10px;
    }

    .chart-container {
      width: 100%;
      height: 100%;
    }

    /* Styles for back-button */

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-button a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #fff;
      background-color: #527321FE;
      padding: 10px 20px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .back-button a:hover {
      background-color: #435D21;
    }

    .back-button a::before {
      content: '←';
      margin-right: 1px;
    }

    /* Container for the right-aligned buttons */

    .right-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      flex-direction: row;
      gap: 10px;
      /* Space between the buttons */
    }

    /* Styles for second-button */

    .chart-wrapper {
      width: 95%;
      height: 400px;
      margin-bottom: 20px;
      margin-top: 50px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      background-color: #ffff;
      padding: 10px;
    }

    .chart-container {
      width: 100%;
      height: 100%;
    }

    .second-button {
      background-color: #3A6D41;
    }

    .second-button a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .second-button a:hover {
      background-color: #2C5A2F;
    }

    .second-button a::before {
      content: '→';
      margin-right: 1px;
    }

    /* Styles for third-button */
    .chart-wrapper {
      width: 95%;
      height: 400px;
      margin-bottom: 20px;
      margin-top: 50px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      background-color: #ffff;
      padding: 10px;
    }

    .chart-container {
      width: 100%;
      height: 100%;
    }

    .third-button {
      background-color: #3B7A57;
    }

    .third-button a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .third-button a:hover {
      background-color: #2F6A47;
    }

    .third-button a::before {
      content: '→';
      margin-right: 1px;
    }
  </style>
</head>

<body>
  <div class="back-button">
    <a href="/dashboard"></a>
  </div>
  <div class="right-buttons">
    <div class="second-button">
      <a href="/grafikwaqms">Valid</a>
    </div>
    <div class="third-button">
      <a href="/grafikwaqms_1H">Hourly</a>
    </div>
  </div>


  <div class="chart-wrapper">
    <div class="chart-container" id="pm25-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="pm10-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="temperature-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="humidity-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="tvoc-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="eco2-chart"></div>
  </div>
  <div class="chart-wrapper">
    <div class="chart-container" id="pressure-chart"></div>
  </div>

  <script>
    // Fetch data from the API
    axios.get('api/waqms/1D')
      .then(response => {
        const data = response.data;

        // Convert timestamps to ISO 8601 format
        const timestamps = data.map(item => {
          const date = new Date(item.created_at);
          return date.getTime(); // Use timestamp in milliseconds
        });

        // Prepare data for the charts
        const pm25 = data.map(item => parseFloat(item.pm25));
        const pm10 = data.map(item => parseFloat(item.pm10));
        const temperature = data.map(item => parseFloat(item.temperature));
        const humidity = data.map(item => parseFloat(item.humidity));
        const tvoc = data.map(item => parseFloat(item.tvoc));
        const eco2 = data.map(item => parseFloat(item.eco2));
        const pressure = data.map(item => parseFloat(item.pressure));

        // Create PM2.5 chart
        const pm25Options = {
          series: [{
            name: 'PM2.5',
            data: pm25.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'PM2.5'
            }
          },
          title: {
            text: 'PM2.5 Levels Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const pm25Chart = new ApexCharts(document.querySelector("#pm25-chart"), pm25Options);
        pm25Chart.render();

        // Create PM10 chart
        const pm10Options = {
          series: [{
            name: 'PM10',
            data: pm10.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'PM10'
            }
          },
          title: {
            text: 'PM10 Levels Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const pm10Chart = new ApexCharts(document.querySelector("#pm10-chart"), pm10Options);
        pm10Chart.render();

        // Create Temperature chart
        const temperatureOptions = {
          series: [{
            name: 'Temperature',
            data: temperature.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'Temperature (°C)'
            }
          },
          title: {
            text: 'Temperature Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const temperatureChart = new ApexCharts(document.querySelector("#temperature-chart"), temperatureOptions);
        temperatureChart.render();

        // Create Humidity chart
        const humidityOptions = {
          series: [{
            name: 'Humidity',
            data: humidity.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'Humidity (%)'
            }
          },
          title: {
            text: 'Humidity Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), humidityOptions);
        humidityChart.render();

        // Create TVOC chart
        const tvocOptions = {
          series: [{
            name: 'TVOC',
            data: tvoc.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'TVOC'
            }
          },
          title: {
            text: 'TVOC Levels Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const tvocChart = new ApexCharts(document.querySelector("#tvoc-chart"), tvocOptions);
        tvocChart.render();

        // Create eCO2 chart
        const eco2Options = {
          series: [{
            name: 'eCO2',
            data: eco2.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'eCO2'
            }
          },
          title: {
            text: 'eCO2 Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const eco2Chart = new ApexCharts(document.querySelector("#eco2-chart"), eco2Options);
        eco2Chart.render();

        // Create Pressure chart
        const pressureOptions = {
          series: [{
            name: 'Pressure',
            data: pressure.map((value, index) => [timestamps[index], value])
          }],
          chart: {
            type: 'bar',
            height: '100%'
          },
          colors: ['#527321FE'],
          xaxis: {
            type: 'datetime',
            labels: {
              datetimeUTC: false,
              format: 'MM-dd', // Format jam pada label sumbu X
            }
          },
          yaxis: {
            title: {
              text: 'Pressure'
            }
          },
          title: {
            text: 'Pressure Over Time',
            align: 'left'
          },
          dataLabels: {
            enabled: false
          }
        };
        const pressureChart = new ApexCharts(document.querySelector("#pressure-chart"), pressureOptions);
        pressureChart.render();
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  </script>
</body>

</html>