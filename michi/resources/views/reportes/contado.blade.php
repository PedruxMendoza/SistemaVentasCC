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
  <link href="{{ asset('css/card.css') }}" rel="stylesheet">
  <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />  
</head>
<body class="sb-nav-fixed">
  @include('layouts.topnavbar')    
  <div id="layoutSidenav">
    @include('layouts.navbar')
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Contado</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Contado</li>
          </ol>
          <!-- Sign up card -->
          <div class="card mb-4 person-card">
            <form id="formContado" action="{{ url('/contado/resultado') }}" method="POST" autocomplete="off" onsubmit="return validarcont()">
              @csrf            
              <div class="card-body">
                <!-- Sex image -->
                <img id="img_sex" class="person-img"
                src="{{ asset('img/wallet.png') }}">
                <h2 id="who_message" class="card-title">Contado</h2>
                <!-- First row (on medium screen) -->
                <div class="row">
                  <div class="form-group col-md-6">
                    <select class="form-control" name="modo" id="modo">
                      <option value="">--Seleccione el modo de pago--</option>
                      @foreach($modo as $mp)
                      <option value="{{$mp->idModoPago}}">{{$mp->nombre_pago}}</option>
                      @endforeach
                    </select>                  
                  </div>
                  <div class="form-group col-md-6">
                    <select class="form-control" name="tarjeta" id="tarjeta">
                      <option value="0">--Seleccione el tipo de tarjeta--</option>
                      @foreach($tarjeta as $card)
                      <option value="{{$card->idTarjetas}}">{{$card->NombreTarjetas}}</option>
                      @endforeach
                    </select>                 
                  </div>                  
                </div>
                <div class="row">
                  <div class="form-group col-md-5">
                    <input type="text" name="finicial" class="form-control datetimepicker-input" id="datetimepicker7" data-toggle="datetimepicker" data-target="#datetimepicker7" placeholder="Fecha inicial"/>
                  </div>
                  <div class="form-group col-md-5">
                    <input type="text" name="ffinal" class="form-control datetimepicker-input" id="datetimepicker8" data-toggle="datetimepicker" data-target="#datetimepicker8" placeholder="Fecha Final"/>
                  </div>
                  <div class="form-group col-md-2">
                    <div class="btn-group btn-block">
                      <input class="btn btn-dark btn-block" type="submit" name="buscar" id="btnBuscar" value="Buscar">
                      <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:;" id="export">Exportar PDF</a>
                      </div>
                    </div>
                  </div>
                </div>              
              </div>
            </form>
          </div>          
          <div class="card mb-4">
            <div class="card-header"><i class="fas fa-wallet mr-1"></i>Contado</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">Codigo</th>
                      <th scope="col">Cliente</th>
                      <th scope="col">Telefono</th>
                      <th scope="col">Fecha</th>
                      <th scope="col">Modo de Pago</th>
                      <th scope="col">Tipo de Tarjeta</th>
                      <th scope="col">Monto</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contado as $row)
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
                      <td>{{$row->Nombre_Completo}}</td>
                      <td>{{$row->Telefono}}</td>
                      <td>{{$row->Fecha}}</td>
                      <td>{{$row->nombre_pago}}</td>
                      <td>{{$row->nombre_tarjeta}}</td>
                      <td>${{ number_format($row->Total_Pago, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>
                      <td style="display: none"></td>                     
                      <td style="display: none"></td>                     
                      <td colspan="7" align="center"><p>No existen Facturas, Por favor intente de nuevo!</p></td>
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
  <!--<script src="{{ asset('js/validarcont.js') }}"></script>-->
  @include('sweet::alert')    
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>   
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable( {
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        lengthMenu: [[10,25,50,100,-1],[10,25,50,100,"Mostrar Todo"]],         
        dom: 'Bfrtip',
        buttons: {
          dom: {
            container:{
              tag:'div',
              className:'flexcontent'
            },
            buttonLiner: {
              tag: null
            }
          },
          buttons: [
          {
            extend:    'copyHtml5',
            text:      '<i class="fa fa-paste"></i>Copiar',
            title:'Ventas efectuadas al contado',
            titleAttr: 'Copiar',
            className: 'btn btn-app export barras'
          },
          {
            extend:    'excelHtml5',
            text:      '<i class="fa fa-file-excel"></i>Excel',
            title:'Ventas efectuadas al contado',
            titleAttr: 'Excel',
            className: 'btn btn-app export excel'
          },
          {
            extend:    'csvHtml5',
            text:      '<i class="fa fa-file-csv"></i>CSV',
            title:'Ventas efectuadas al contado',
            titleAttr: 'CSV',
            className: 'btn btn-app export csv'
          },
          {
            extend:    'print',
            text:      '<i class="fa fa-print"></i>Imprimir',
            title:'Ventas efectuadas al contado',
            titleAttr: 'Imprimir',
            className: 'btn btn-app export imprimir'
          },
          {
            extend:    'pageLength',
            titleAttr: 'Registros a mostrar',
            className: 'selectTable'
          }
          ]
        }
      } );
    } );

    $(function () {
      $('#datetimepicker7').datetimepicker({
        format: 'L',
        format: 'YYYY/MM/DD'
      });
      $('#datetimepicker8').datetimepicker({
        useCurrent: false,
        format: 'L',
        format: 'YYYY/MM/DD'
      });

      $("#datetimepicker7").on("change.datetimepicker", function (e) {
        $('#datetimepicker8').datetimepicker('minDate', e.date);
      });
      $("#datetimepicker8").on("change.datetimepicker", function (e) {
        $('#datetimepicker7').datetimepicker('maxDate', e.date);
      });
    });

    $( "#export" ).click(function() {
      $('#formContado').attr("action","{{ url('/pdfcontado') }}");
      $('#btnBuscar').trigger('click');
    });

    $('#tarjeta').prop('disabled', true);

    $("#modo").change(function(){
      $('#tarjeta').prop('disabled', true);
      if ($(this).val() == 2) {
        $('#tarjeta').prop('disabled', false);
      }     
    });

  </script>
</body>
</html>