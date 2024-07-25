<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bar Charts</title>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    .chart-container {
      width: 100%;
      height: 500px;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="chart-container" id="pm25-chart"></div>
  <div class="chart-container" id="pm10-chart"></div>
  <div class="chart-container" id="temperature-chart"></div>
  <div class="chart-container" id="humidity-chart"></div>
  <div class="chart-container" id="tvoc-chart"></div>
  <div class="chart-container" id="eco2-chart"></div>
  <div class="chart-container" id="pressure-chart"></div>

  <script>
    // Fetch data from the API
    axios.get('api/waqms')
      .then(response => {
        const data = response.data;

        // Convert timestamps to ISO 8601 format
        const timestamps = data.map(item => {
          const date = new Date(item.created_at);
          return date.toISOString(); // Convert to ISO 8601 string
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
            }
          },
          yaxis: {
            title: {
              text: 'eCO2'
            }
          },
          title: {
            text: 'eCO2 Levels Over Time',
            align: 'left'
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
            type: 'bar', // Changed to bar chart
            height: 500
          },
          xaxis: {
            type: 'datetime',
            labels: {
              format: 'HH:mm',
              datetimeUTC: false,
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