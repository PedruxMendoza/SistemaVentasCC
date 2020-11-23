<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="{{{ asset('img/Logo3.png') }}}">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
  <link href="{{ asset('css/chart.css') }}" rel="stylesheet">
  <style type="text/css">
    @font-face {
      font-family: "Nunito";
      font-style: normal;
      font-weight: 400;
      src: url("fonts/Nunito/Nunito-Regular.ttf") format('ttf');
    }
  </style>
</head>
<body class="sb-nav-fixed">
  @include('layouts.topnavbar')
  <div id="layoutSidenav">
    @include('layouts.navbar')
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Graficas</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Graficas</li>
          </ol>
          <div class="card mb-4">
            <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Ventas Registradas al Día</div>
            <div class="card-body">
                <input class="btn btn-secondary" id="sales-day-pdf" type="button" value="Guardar como PDF" disabled />
                <div id="dashboard">
                    <div id="chart_div"></div>
                    <div id="control_div"></div>
                    <div class="form-row d-none"><p><span id='dbgchart'></span></p></div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Ventas Registradas al Mes</div>
                <div class="card-body"><input class="btn btn-secondary" id="sales-month-pdf" type="button" value="Guardar como PDF" disabled /><div id="month_area" class="chart"></div></div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Ventas Registradas al Año</div>
                <div class="card-body"><input class="btn btn-secondary" id="sales-year-pdf" type="button" value="Guardar como PDF" disabled /><div id="year_area" class="chart"></div></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-pie mr-1"></i>Ventas Regitradas por los Cajeros</div>
                <div class="card-body"><input class="btn btn-secondary" id="sales-cashier-pdf" type="button" value="Guardar como PDF" disabled /><div id="piechart" class="chart"></div></div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Ventas Totales por Tipo de Pago
                </div>
                <div class="card-body"><input class="btn btn-secondary" id="sales-TP-pdf" type="button" value="Guardar como PDF" disabled /><div id="tipo_pago" class="chart"></div></div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Cool Sales 2020</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/contras.js') }}"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
  @include('sweet::alert')
  <script type="text/javascript">
      // Cargar gráficos y el paquete corechart.
      google.charts.load('current', {'packages':['corechart']});
      // Dibuje el gráfico circular para la pizza de Cajero cuando se carguen los Gráficos..
      google.charts.setOnLoadCallback(drawCashierChart);
      // Dibuje el gráfico por area para las ventas del mes cuando se carguen los Gráficos..
      google.charts.setOnLoadCallback(drawAreaMonthChart);
      // Dibuje el gráfico por area para las ventas del dia cuando se carguen los Gráficos..
      google.charts.setOnLoadCallback(drawAreaYearChart);
      // Cargar gráficos y el paquete barchart.
      google.charts.load("current", {packages:['corechart']});
      // Dibuje el gráfico circular para la pizza de Sarah cuando se carguen los Gráficos.
      google.charts.setOnLoadCallback(drawTypeBillsChart);
      // Load the Visualization API and the controls package.
      google.charts.load('current', {'packages':['corechart', 'controls']});
      // Dibuje el gráfico por area para las ventas del dia cuando se carguen los Gráficos..
      google.charts.setOnLoadCallback(drawDashboard);

      function drawCashierChart() {

        var data = google.visualization.arrayToDataTable([
          ['Cajero', 'Ventas Regitradas'],
          <?php foreach ($cajeros as $caj) { ?>
            ['<?php echo $caj->Cajero ?>', <?php echo $caj->Cantidad ?>],
          <?php } ?>
          ]);

        var options = {
          title: 'Ventas Regitradas por Cajeros'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        var btnSave = document.getElementById('sales-cashier-pdf');

        google.visualization.events.addListener(chart, 'ready', function () {
          btnSave.disabled = false;
        });

        btnSave.addEventListener('click', function () {
          var doc = new jsPDF('p', 'mm', 'letter');
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 0, 356, 20, 'F')
          doc.setFontSize(30)
          doc.setTextColor(255, 255, 255)
          doc.addFont("fonts/Nunito/Nunito-Regular.ttf", "Nunito", "normal");
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(33, 14, 'Ventas Regitradas por Cajeros')
          doc.addImage(chart.getImageURI(), 1, 60, 210, 130);
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 259.3, 356, 20, 'F')
          doc.setFontSize(15)
          doc.setTextColor(255,255,255)
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(85, 272, 'Cool Sales 2020')
          doc.save('rep_ventascashier.pdf');
        }, false);

        chart.draw(data, options);
      }

      function drawAreaMonthChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', 'Ventas'],
          <?php foreach ($meses as $mes) { ?>
            ['<?php echo $mes->Mes ?>', <?php echo $mes->Cantidad ?>],
          <?php } ?>
          ]);

        var options = {
          title: 'Ventas Regitradas al Mes',
          hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('month_area'));

        var btnSave = document.getElementById('sales-month-pdf');

        google.visualization.events.addListener(chart, 'ready', function () {
          btnSave.disabled = false;
        });

        btnSave.addEventListener('click', function () {
          var doc = new jsPDF('p', 'mm', 'letter');
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 0, 356, 20, 'F')
          doc.setFontSize(30)
          doc.setTextColor(255, 255, 255)
          doc.addFont("fonts/Nunito/Nunito-Regular.ttf", "Nunito", "normal");
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(42, 14, 'Ventas Registradas al Mes')
          doc.addImage(chart.getImageURI(), 1, 60, 210, 130);
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 259.3, 356, 20, 'F')
          doc.setFontSize(15)
          doc.setTextColor(255,255,255)
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(85, 272, 'Cool Sales 2020')
          doc.save('rep_ventasmes.pdf');
        }, false);


        chart.draw(data, options);
      }

    function drawDashboard() {
    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Fecha');
    data.addColumn('number', 'Ventas');

    <?php foreach ($dias as $dia) { ?>
            data.addRow([new Date('<?php echo $dia->Fecha ?>'), <?php echo $dia->Cantidad ?>]);
    <?php } ?>

    var dash = new google.visualization.Dashboard(document.getElementById('dashboard'));

    var control = new google.visualization.ControlWrapper({
        controlType: 'ChartRangeFilter',
        containerId: 'control_div',
        options: {
            filterColumnIndex: 0,
            ui: {
                chartOptions: {
                    height: 50,
                    chartArea: {
                        width: '100%'
                    }
                }
            }
        }
    });

    var chart = new google.visualization.ChartWrapper({
        chartType: 'AreaChart',
        containerId: 'chart_div',
        options: {
          'height': 400,
          'title': 'Ventas Regitradas al Día',
          'vAxis': {
            minValue: 0,
            textPosition: 'none',
        },
          'hAxis': {'title': 'Dias'},
        }
    });

    function setOptions (wrapper) {
        wrapper.setOption('chartArea.width', '100%');

    }

    var btnSave = document.getElementById('sales-day-pdf');

    google.visualization.events.addListener(chart, 'ready', function () {
        btnSave.disabled = false;
    });

    btnSave.addEventListener('click', function () {
    var doc = new jsPDF('l', 'mm', 'legal');
    doc.setFillColor(52, 58, 64)
    doc.rect(0, 0, 356, 20, 'F')
    doc.setFontSize(30)
    doc.setTextColor(255, 255, 255)
    doc.addFont("fonts/Nunito/Nunito-Regular.ttf", "Nunito", "normal");
    doc.setFont('Nunito')
    doc.setFontType('normal')
    doc.text(112, 14, 'Ventas Registradas al Dia')
    doc.addImage(chart.getChart().getImageURI(), 20, 60);
    doc.setFillColor(52, 58, 64)
    doc.rect(0, 196, 356, 20, 'F')
    doc.setFontSize(15)
    doc.setTextColor(255,255,255)
    doc.setFont('Nunito')
    doc.setFontType('normal')
    doc.text(156, 208, 'Cool Sales 2020')
    doc.save('rep_ventasdias.pdf');
    }, false);

    setOptions(chart);

    dash.bind([control], [chart]);
    dash.draw(data);
  	google.visualization.events.addListener(control, 'statechange', function () {
        var v = control.getState();
        document.getElementById('dbgchart').innerHTML = v.range.start+ ' to ' +v.range.end;
        return 0;
    });

    }

      function drawAreaYearChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', 'Ventas'],
          <?php foreach ($anio as $ani) { ?>
            ['<?php echo $ani->Año ?>', <?php echo $ani->Cantidad ?>],
          <?php } ?>
          ]);

        var options = {
          title: 'Ventas Regitradas al Año',
          hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('year_area'));

        var btnSave = document.getElementById('sales-year-pdf');

        google.visualization.events.addListener(chart, 'ready', function () {
          btnSave.disabled = false;
        });

        btnSave.addEventListener('click', function () {
          var doc = new jsPDF('p', 'mm', 'letter');
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 0, 356, 20, 'F')
          doc.setFontSize(30)
          doc.setTextColor(255, 255, 255)
          doc.addFont("fonts/Nunito/Nunito-Regular.ttf", "Nunito", "normal");
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(41, 14, 'Ventas Registradas al Anio')
          doc.addImage(chart.getImageURI(), 1, 60, 210, 130);
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 259.3, 356, 20, 'F')
          doc.setFontSize(15)
          doc.setTextColor(255,255,255)
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(85, 272, 'Cool Sales 2020')
          doc.save('rep_ventasaño.pdf');
        }, false);

        chart.draw(data, options);
      }

      function drawTypeBillsChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo de Pago', 'Ventas'],
          <?php foreach ($tipoPago as $tp) { ?>
            ['<?php echo $tp->NombreTipoPago ?>', <?php echo $tp->Cantidad ?>],
          <?php } ?>
          ]);

        var options = {
          title: "Ventas Totales por Tipo de Pago",
          bar: {groupWidth: '95%'},
          legend: 'none',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('tipo_pago'));

        var btnSave = document.getElementById('sales-TP-pdf');

        google.visualization.events.addListener(chart, 'ready', function () {
          btnSave.disabled = false;
        });

        btnSave.addEventListener('click', function () {
          var doc = new jsPDF('p', 'mm', 'letter');
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 0, 356, 20, 'F')
          doc.setFontSize(30)
          doc.setTextColor(255, 255, 255)
          doc.addFont("fonts/Nunito/Nunito-Regular.ttf", "Nunito", "normal");
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(25, 14, 'Ventas Totales por Tipo de Pago')
          doc.addImage(chart.getImageURI(), 1, 60, 210, 130);
          doc.setFillColor(52, 58, 64)
          doc.rect(0, 259.3, 356, 20, 'F')
          doc.setFontSize(15)
          doc.setTextColor(255,255,255)
          doc.setFont('Nunito')
          doc.setFontType('normal')
          doc.text(85, 272, 'Cool Sales 2020')
          doc.save('rep_ventastp.pdf');
        }, false);

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      $(window).resize(function(){
        drawCashierChart();
        drawAreaMonthChart();
        drawDashboard();
        drawAreaYearChart();
        drawTypeBillsChart();
      });
    </script>
  </body>
  </html>
