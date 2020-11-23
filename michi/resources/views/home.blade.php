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
</head>
<body class="sb-nav-fixed">
  @include('layouts.topnavbar')
  <div id="layoutSidenav">
    @include('layouts.navbar')
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Inicio</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Inicio</li>
          </ol>
          <div class="row">
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Top Clientes Credito</div>
                <div class="card-body"><div id="Anthony_chart_div" class="chart"></div></div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Top Clientes Contado</div>
                <div class="card-body"><div id="Sarah_chart_div" class="chart"></div></div>
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
  @include('sweet::alert')
  <script type="text/javascript">
      // Cargar gráficos y el paquete barchart.        
      google.charts.load('current', {'packages':['bar']});
      // Dibuje el gráfico circular para la pizza de Sarah cuando se carguen los Gráficos.
      google.charts.setOnLoadCallback(drawSarahChart);
      // Dibuje el gráfico circular para la pizza de Anthony cuando se carguen los Gráficos..
      google.charts.setOnLoadCallback(drawAnthonyChart);
      // Dibuja el gráfico circular de la pizza de Sarah.
      function drawSarahChart() {
        var data = new google.visualization.arrayToDataTable([
          ['Clientes', 'No. de Veces'],
          <?php foreach ($contado as $cont) { ?>
            ['<?php echo $cont->Nombre_Completo ?>', <?php echo $cont->Cantidad ?>],
          <?php } ?>
          ]);

        // Establecer opciones para el gráfico de barras de Sarah..
        var options = {
          title: 'Clientes al Contado',
          colors: ['silver'],
          width: '100%',
          legend: { position: 'none' },
          chart: { title: 'Clientes',
          subtitle: 'Que mas pagan al contado' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'No. de Veces'} // Top x-axis.
            }
          },
          bar: { groupWidth: "80%" }
        };

        // Instanciamos y dibujamos la tabla para la pizza de Sarah.
        var chart = new google.charts.Bar(document.getElementById('Sarah_chart_div'));
        chart.draw(data, options);
      };

      // Dibuja el gráfico circular de la pizza de Anthony.
      function drawAnthonyChart() {
        var data = new google.visualization.arrayToDataTable([
          ['Clientes', 'No. de Veces'],
          <?php foreach ($credito as $cred) { ?>
            ['<?php echo $cred->Nombre_Completo ?>', <?php echo $cred->Cantidad ?>],
          <?php } ?>
          ]);

        // Establecer opciones para el gráfico de barras de Anthony.
        var options = {
          title: 'Clientes al Credito',
          colors: ['silver'],
          width: '100%',
          legend: { position: 'none' },
          chart: { title: 'Clientes',
          subtitle: 'Que mas pagan al credito' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'No. de Veces'} // Top x-axis.
            }
          },
          bar: { groupWidth: "80%" }
        };

        // Instanciamos y dibujamos la tabla para la pizza de Anthony.
        var chart = new google.charts.Bar(document.getElementById('Anthony_chart_div'));
        chart.draw(data, options);
      };      
    </script>
    <script type="text/javascript">
      $(window).resize(function(){
        drawSarahChart();
        drawAnthonyChart();
      });
    </script>        
  </body>
  </html>