<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personal Air Monitoring</title>

  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />


  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
  <div class="grid-container">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <!-- Your sidebar content -->
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="main-container">
      <div class="main-title">
        <h2></h2>
      </div>

      <div class="charts">
        <div class="charts-card">
          <h2 class="chart-title">Grafik PM2.5</h2>
          <iframe width="600" height="400" src="https://thingspeak.com/channels/2590205/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=PM2.5&type=line">
          </iframe>
        </div>
      </div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik PM10</h2>
    <div id="area-chart-2"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik Humidity</h2>
    <div id="area-chart-3"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik Temperature</h2>
    <div id="area-chart-4"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik Pressure</h2>
    <div id="area-chart-5"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik TVOC</h2>
    <div id="area-chart-6"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Grafik ECO2</h2>
    <div id="area-chart-7"></div>
  </div>

  <div class="charts-card">
    <h2 class="chart-title">Air Quality Indeks</h2>
    <div id="gauge-chart"></div>
  </div>
  </div>
  </main>
  <!-- End Main -->
  </div>

  <!-- Scripts -->
  <!-- ApexCharts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
  <script>
    function generateDummyData() {
      const data = [];
      const now = new Date().getTime();

      for (let i = 0; i < 10; i++) {
        data.push({
          x: new Date(now - i * 3600000),
          y: Math.random() * 100,
        });
      }

      return data.reverse();
    }

    async function renderChart(selector, title, yAxisTitle) {
      const data = generateDummyData();
      const options = {
        chart: {
          type: "area",
          height: 350,
          zoom: {
            enabled: false,
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        series: [{
          name: title,
          data: data,
        }, ],
        xaxis: {
          type: "datetime",
        },
        yaxis: {
          title: {
            text: yAxisTitle,
          },
        },
        tooltip: {
          x: {
            format: "dd MMM yyyy HH:mm",
          },
        },
      };

      const chart = new ApexCharts(document.querySelector(selector), options);
      chart.render();
    }

    function renderCharts() {
      renderChart("#area-chart-1", "PM2.5", "PM2.5 (µg/m³)");
      renderChart("#area-chart-2", "PM10", "PM10 (µg/m³)");
      renderChart("#area-chart-3", "Humidity", "Humidity (%)");
      renderChart("#area-chart-4", "Temperature", "Temperature (°C)");
      renderChart("#area-chart-5", "Pressure", "Pressure (hPa)");
      renderChart("#area-chart-6", "TVOC", "TVOC (ppb)");
      renderChart("#area-chart-7", "eCO2", "eCO2 (ppm)");

      const latestAqi = Math.random() * 100;
      const gaugeOptions = {
        chart: {
          type: "radialBar",
          height: 350,
        },
        series: [latestAqi],
        labels: ["AQI"],
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: "22px",
              },
              value: {
                fontSize: "16px",
              },
              total: {
                show: true,
                label: "AQI",
                formatter: function() {
                  return latestAqi.toFixed(2);
                },
              },
            },
          },
        },
      };

      const gaugeChart = new ApexCharts(
        document.querySelector("#gauge-chart"),
        gaugeOptions
      );
      gaugeChart.render();
    }

    renderCharts();
  </script>
</body>

</html>