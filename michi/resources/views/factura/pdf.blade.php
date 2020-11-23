<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="shortcut icon" href="{{{ asset('img/Logo3.png') }}}">
	<style>
		#invoice-POS{
			box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
			padding:2mm;
			margin: 0 auto;
			width: 44mm;
			background: #FFF;


			::selection {background: #f31544; color: #FFF;}
			::moz-selection {background: #f31544; color: #FFF;}
			h1{
				font-size: 1.5em;
				color: #222;
			}
			h2{font-size: .9em;}
			h3{
				font-size: 1.2em;
				font-weight: 300;
				line-height: 2em;
			}
			p{
				font-size: .7em;
				color: #666;
				line-height: 1.2em;
			}

			#top, #mid,#bot{ /* Targets all id with 'col-' */
			border-bottom: 1px solid #EEE;
		}

		#top{min-height: 100px;}
		#mid{min-height: 80px;} 
		#bot{ min-height: 50px;}

		#top .logo{
			//float: left;
			margin-left: 55px;
			height: 60px;
			width: 60px;
			background: url(img/Logo2.png) no-repeat;
			background-size: 60px 60px;
		}
		.clientlogo{
			float: left;
			height: 60px;
			width: 60px;
			background: url(img/Logo2.png) no-repeat;
			background-size: 60px 60px;
			border-radius: 50px;
		}
		.info{
			display: block;
			//float:left;
			margin-left: 0;
		}
		.title{
			float: right;
		}
		.title p{text-align: right;} 
		table{
			width: 100%;
			border-collapse: collapse;
		}
		td{
			//padding: 5px 0 5px 15px;
			//border: 1px solid #EEE
		}
		.tabletitle{
			//padding: 5px;
			font-size: .5em;
			background: #EEE;
		}
		.service{border-bottom: 1px solid #EEE;}
		.item{width: 24mm;}
		.itemtext{font-size: .5em;}

		#legalcopy{
			margin-top: 5mm;
		}



	}	
</style>	
</head>
<body>
	@foreach($factura as $fact) 	
	<div id="invoice-POS">

		<center id="top">
			<div class="logo"><img src="img/Logo2.png" style=" height: 70px; width: 70px;"></div>
			<div class="info"> 
				<h2 style="color: black;">Cool Sales</h2>
			</div><!--End Info-->
		</center><!--End InvoiceTop-->

		<div id="mid">
			<div class="info">
				<h2 style="color: black;">Contacto</h2>
				<p style="color: black;">
					@foreach($empleado as $emp)
					Cajero: {{$emp->Nombre_Completo}}<br>
					@endforeach	
					Direccion : Ronda Lorem ipsum dolor sit, 144A 1ºE<br>
					Phone   : 7404-1061<br>
				</p>
			</div>
		</div><!--End Invoice Mid-->

		<div id="bot">

			<div id="table">
				<table>
					<tr class="tabletitle">
						<td class="item" style="color: black;"><h2>Producto</h2></td>
						<td class="Hours" style="color: black;"><h2>Cantidad</h2></td>
						<td class="Rate" style="color: black;"><h2>Sub Total</h2></td>
					</tr>

					@foreach($detalles as $items)
					<tr class="service">
						<td class="tableitem"><p class="itemtext">{{$items->NombreProducto}}</p></td>
						<td class="tableitem"><p class="itemtext">{{ $items->Cantidad }}</p></td>
						<td class="tableitem"><p class="itemtext">${{ number_format($items->Precio, 2) }}</p></td>
					</tr>
					@endforeach

					<tr class="tabletitle">
						<td></td>
						<td class="Rate" style="color: black;"><h2>Sub Total</h2></td>
						<td class="payment" style="color: black;"><h2>${{ number_format($subtotal, 2) }}</h2></td>
					</tr>

					<tr class="tabletitle">
						<td></td>
						<td class="Rate" style="color: black;"><h2>IVA</h2></td>
						<td class="payment" style="color: black;"><h2>${{ number_format($iva, 2) }}</h2></td>
					</tr>

					<tr class="tabletitle">
						<td></td>
						<td class="Rate" style="color: black;"><h2>Total</h2></td>
						<td class="payment" style="color: black;"><h2>${{ number_format($fact->Total_Pago, 2) }}</h2></td>
					</tr>

				</table>
			</div><!--End Table-->
			@if ($fact->idTPago == 1)
			<div id="legalcopy">
				<p class="legal"><strong>Gracias por hacer negocios!</strong>  El pago se espera dentro de los siguiente 30 días; procese esta factura dentro de ese tiempo. Habrá un cargo de interés del 5% por mes en las facturas atrasadas. Si tiene alguna pregunta sobre esta factura, comuníquese con alguno de los datos de contactos.
				</p>
			</div>			
			@else
			<div id="legalcopy">
				<p class="legal"><strong>Gracias por hacer negocios!</strong>  Si tiene alguna pregunta sobre esta factura, comuníquese con alguno de los datos de contactos. 
				</p>
			</div>
			@endif

		</div><!--End InvoiceBot-->
	</div><!--End Invoice-->
	@endforeach
</body>
</html>