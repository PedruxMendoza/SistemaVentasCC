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
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />   
</head>
<body class="sb-nav-fixed">
  @include('layouts.topnavbar')    
  <div id="layoutSidenav">
    @include('layouts.navbar')
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Facturas</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Facturas</li>
          </ol>
          <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Facturas</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">Codigo</th>
                      <th scope="col">Fecha</th>
                      <th scope="col">Cliente</th>
                      <th scope="col">Monto</th>
                      <th scope="col">Modo Pago</th>
                      <th scope="col">Detalles</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($facturas as $row)
                    <tr>
                      <?php 
                      $corre='';
                      if ($row->idFactura > 0 AND $row->idFactura <= 9)
                      {
                        $corre =  'PHP000'.$row->idFactura;
                      }
                      else if($row->idFactura >= 10 AND $row->idFactura <= 99)
                      {
                        $corre =  'PHP00'.$row->idFactura;
                      }
                      else if($row->idFactura >= 100 AND $row->idFactura <= 999)
                      {
                        $corre =  'PHP0'.$row->idFactura;
                      }
                      else if($row->idFactura >= 1000 AND $row->idFactura <= 9999)
                      {
                        $corre =  'PHP'.$row->idFactura;
                      }                      
                      ?>
                      <td>{{$corre}}</td>
                      <td>{{$row->Fecha}}</td>
                      <td>{{$row->Nombre_Completo}}</td>
                      <td>${{ number_format($row->Total_Pago, 2) }}</td>
                      <td>{{$row->NombreTipoPago}}</td>
                      <?php $id = base64_encode($row->idFactura) ?>
                      <td><a href="{{ url('/detalles/'.$id) }}" class="btn btn-dark btn-block">Mostrar</a></td>
                    </tr>
                    @empty
                    <tr>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>                     
                      <td colspan="6" align="center"><p>No existen Facturas, Por favor genere una!</p></td>
                    </tr>
                    @endforelse                  
                  </tbody>           
                </table>                                  
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
  @include('sweet::alert')    
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>  
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
    } );  
  </script>
</body>
</html>