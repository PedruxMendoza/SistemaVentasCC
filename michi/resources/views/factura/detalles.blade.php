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
						<li class="breadcrumb-item"><a href="{{ url('/listado') }}">Facturas</a></li>
						<li class="breadcrumb-item active">Detalles</li>
					</ol>
					<div class="card mb-4">
						<div class="card-header"><i class="fas fa-file-invoice mr-1"></i>Detalles</div>
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									@foreach($factura as $fact) 									
									<div class="card">
										<div class="card-body p-0">
											<div class="row p-5">
												<div class="col-md-6">
													<img class="img-fluid" src="{{ asset('img/Logo2.png') }}" alt="" width="200px">
												</div> 
												<div class="col-md-6 text-right">
													<?php 
													$corre='';
													if ($fact->idFactura > 0 AND $fact->idFactura <= 9)
													{
														$corre =  'PHP000'.$fact->idFactura;
													}
													else if($fact->idFactura >= 10 AND $fact->idFactura <= 99)
													{
														$corre =  'PHP00'.$fact->idFactura;
													}
													else if($fact->idFactura >= 100 AND $fact->idFactura <= 999)
													{
														$corre =  'PHP0'.$fact->idFactura;
													}
													else if($fact->idFactura >= 1000 AND $fact->idFactura <= 9999)
													{
														$corre =  'PHP'.$fact->idFactura;
													}                      
													?>
													<p class="font-weight-bold mb-1">Factura #{{$corre}}</p>
													<?php 
													$formato = 'Y-m-d';
													$fecha = DateTime::createFromFormat($formato, $fact->Fecha);
													?>
													<p class="text-muted">Emitida: {{$fecha->format('d M, Y')}}</p>
												</div>
											</div>

											<hr class="my-5">

											<div class="row pb-5 p-5">
												<div class="col-md-6">
													@foreach($cliente as $cli)	
													<p class="font-weight-bold mb-4">Informacion del Cliente</p>
													<p class="mb-1">{{$cli->Nombre_Completo}}</p>
													<p class="mb-1"><span class="text-muted">Telefono: </span>{{$cli->Telefono}}</p>
													@endforeach					
												</div>

												<div class="col-md-6 text-right">
													<p class="font-weight-bold mb-4">Detalles de la Venta</p>
													@foreach($empleado as $emp)	
													<p class="mb-1"><span class="text-muted">Cajero: </span>{{$emp->Nombre_Completo}}</p>
													@endforeach													
													@foreach($tipo as $tp)	
													<p class="mb-1"><span class="text-muted">Tipo Pago: </span>{{$tp->NombreTipoPago}}</p>
													@endforeach
													@if (is_null($fact->idModoPago))

													@else
													@foreach($modo as $mod)	
													<p class="mb-1"><span class="text-muted">Modo Pago: </span>{{$mod->nombre_pago}}</p>
													@endforeach
													@endif
													@if (is_null($fact->idTarjeta))

													@else
													@foreach($tarjeta as $card)
													<p class="mb-1"><span class="text-muted">Tarjeta:</span>{{$card->NombreTarjetas}}</p>
													@endforeach
													@endif
												</div>
											</div>

											<div class="row p-5">
												<div class="col-md-12">
													<table class="table">
														<thead>
															<tr>
																<th class="border-0 text-uppercase small font-weight-bold">Codigo</th>
																<th class="border-0 text-uppercase small font-weight-bold">Producto</th>
																<th class="border-0 text-uppercase small font-weight-bold">Description</th>
																<th class="border-0 text-uppercase small font-weight-bold">Categoria</th>
																<th class="border-0 text-uppercase small font-weight-bold">Cantidad</th>
																<th class="border-0 text-uppercase small font-weight-bold">Precio Unitario</th>
																<th class="border-0 text-uppercase small font-weight-bold">Total</th>
															</tr>
														</thead>
														<tbody>
															@forelse($detalles as $items)
															<tr>
																<td>{{ $items->CodigoProducto }}</td>
																<td>{{ $items->NombreProducto }}</td>
																<td>{{ $items->Descripcion }}</td>
																<td>{{ $items->NombreCategoria }}</td>
																<td>{{ $items->Cantidad }}</td>
																<td>${{ number_format($items->PrecioPublico, 2) }}</td>
																<td>${{ number_format($items->Precio, 2) }}</td>
															</tr>
															@empty
															<tr>
																<td colspan="7" align="center"><p>No hay productos disponible</p></td>
															</tr>
															@endforelse															

														</tbody>
													</table>
												</div>
											</div>

											<div class="d-flex flex-row-reverse bg-dark text-white p-4">
												<div class="py-3 px-5 text-right">
													<div class="mb-2">Total</div>
													<div class="h2 font-weight-light">${{ number_format($fact->Total_Pago, 2) }}</div>
												</div>

												<div class="py-3 px-5 text-right">
													<div class="mb-2">IVA</div>
													<div class="h2 font-weight-light">13%</div>
												</div>

												<div class="py-3 px-5 text-right">
													<div class="mb-2">Sub - Total</div>
													<div class="h2 font-weight-light">${{ number_format($subtotal, 2) }}</div>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
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