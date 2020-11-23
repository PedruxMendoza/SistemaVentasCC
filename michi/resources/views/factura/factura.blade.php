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
  <link href="{{ asset('css/fieldset.css') }}" rel="stylesheet">
  <!-- Alertify -->
  <!-- CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <!-- Default theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
</head>
<body class="sb-nav-fixed">
  @include('layouts.topnavbar')     
  <div id="layoutSidenav">
    @include('layouts.navbar')
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Factura</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Nueva Factura</li>
          </ol>
          <div class="card mb-4">
            <div class="card-header"><i class="fas fa-file-invoice mr-1"></i>Factura #<?php echo $corre ?></div>
            <div class="card-body">
              <form method="POST" action="{{ url('/facturar1') }}" onsubmit="return validarfact()">
                @csrf
                <div class="form-inline form-row">
                  <div class="col-md-3">
                    <button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#nuevo" aria-expanded="false" aria-controls="nuevo">
                      Cliente Nuevo
                    </button>                      
                  </div>
                  <div class="col-md-3">
                    <button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#frecuente" aria-expanded="false" aria-controls="frecuente" id="btnFrecuente">
                      Cliente Frecuentes
                    </button>                       
                  </div>
                  <div class="col-md-3">
                    <input class="btn btn-primary btn-block" type="submit" name="facturar" id="btnFacturar" value="Facturar">               
                    <!-- <a class="btn btn-primary btn-block" href="#">Facturar</a> -->
                  </div>
                  <div class="col-md-3">
                    <a class="btn btn-danger btn-block" href="#">Borrar Facturar</a>                     
                  </div>                                                       
                </div>
                <br>                                    
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Correlativo</label>
                    <input type="text" class="form-control" value="<?php echo $corre ?>" readonly>
                  </div>                     
                  <div class="form-group col-md-3">
                    <?php date_default_timezone_set('America/El_Salvador'); ?>
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="fechaactual" id="fechaactual" readonly value="<?php echo date("Y-m-d"); ?>">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Pagos</label>
                    <select class="form-control" name="pagos" id="pagos"> 
                      <option value="">--Seleccione una opcion--</option>
                      @foreach($tipo as $tp)
                      <option id="{{$tp->idTipoPago}}" value="{{$tp->idTipoPago}}">{{$tp->NombreTipoPago}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3" id="oculto">
                    <label>Modo</label>
                    <select class="form-control" name="modo" id="modo">
                      <option value="">--Seleccione su modo de pago--</option>
                      @foreach($modo as $mp)
                      <option value="{{$mp->idModoPago}}">{{$mp->nombre_pago}}</option>
                      @endforeach
                    </select>
                  </div>                                      
                </div>
                <div class="form-group collapse" id="nuevo">
                  <fieldset class="the-fieldset">
                    <legend class="the-legend">Nuevo Cliente</legend>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombrenc" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="formGroupExampleInput2">DUI</label>
                        <input type="text" name="duinc" id="duinc" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">NIT</label>
                        <input type="text" name="nitnc" id="nitnc" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="formGroupExampleInput2">Telefono</label>
                        <input type="text" name="telnc" id="telnc" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                      </div>
                    </div>
                    <div class="form-inline form-row">
                      <div class="col-md-3">                    
                      </div>
                      <div class="col-md-3">                     
                      </div>
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-3">
                        <button type="button" class="btn btn-info btn-block" id="btnAgregar" data-toggle="collapse" data-target="#nuevo">Agregar Cliente</button>                    
                      </div>                                                       
                    </div>                      
                  </fieldset>
                </div>
                <div class="form-group collapse collapse-cf" id="frecuente">
                  <fieldset class="the-fieldset">
                    <legend class="the-legend">Cliente Frecuente</legend>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label>Cliente</label>
                        <input type="text" id="txtcf" list="clientes" class="form-control custom-select" name="customer">
                        <datalist id="clientes">
                          @foreach($cliente as $cli)
                          <option value="{{$cli->id_cliente}}">{{$cli->Nombre_Completo}}</option>
                          @endforeach
                        </datalist>
                      </div>
                      <div class="form-group col-md-3">
                        <label>DUI</label>
                        <input type="text" name="duicf" id="duicf" class="form-control" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>NIT</label>
                        <input type="text" name="nitcf" id="nitcf" class="form-control" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Telefono</label>
                        <input type="text" name="telefonocf" id="telefonocf" class="form-control" readonly>
                      </div>
                    </div> 
                  </fieldset>
                </div>
                <div id="hotel" for-field="pagos" for-value="1" class="accordion-body collapse">
                  <fieldset class="the-fieldset">
                    <legend class="the-legend">Credito</legend>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label>Limite a Credito</label>
                        <input type="number" step="0.01" class="form-control" name="limitcredit" id="limitcredit" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Cuota Mensual</label>
                        <input type="number" step="0.01" name="cuota" class="form-control" id="cuota" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Dias de Credito</label>
                        <input type="number" class="form-control" name="diascredit" id="diascredit" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Saldo Disponible</label>
                        <input type="number" step="0.01" class="form-control" id="total" readonly>
                      </div>
                    </div> 
                  </fieldset>
                </div>
                <div id="hotel" for-field="modo" for-value="1" class="accordion-body collapse">
                  <fieldset class="the-fieldset">
                    <legend class="the-legend">Efectivo</legend>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Valor en Efectivo</label>
                        <input type="text" step="0.01" id="valefect" name="valefect" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label>Cambio</label>
                        <input type="number" step="0.01" id="cambio" name="cambio" class="form-control" readonly>
                      </div>
                    </div> 
                  </fieldset>
                </div>
                <div id="hotel" for-field="modo" for-value="2" class="accordion-body collapse">
                  <fieldset class="the-fieldset">
                    <legend class="the-legend">Tarjeta</legend>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label>Numero de la Tarjeta</label>
                        <input type="text" id="tarjeta" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Tipo de Tarjeta</label>
                        <select class="form-control" name="tipocard" id="tipocard" readonly>
                          <option value="0" disabled>--Seleccione su tipo de tarjeta--</option>
                          @foreach($tarjeta as $card)
                          <option value="{{$card->idTarjetas}}" disabled>{{$card->NombreTarjetas}}</option>
                          @endforeach
                        </select>
                      </div>                                           
                      <div class="form-group col-md-3">
                        <label>No. Autorizacion</label>
                        <input type="number" class="form-control" id="authnumber" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Estado</label>
                        <input type="text" name="statuscard" id="statuscard" class="form-control" readonly>
                      </div>                        
                    </div>                      
                  </fieldset>
                </div>
                <br>
                <div class="form-row d-none"><!-- d-none -->
                  <div class="form-group col-md-3">
                    <label>Clientes</label>
                    <select class="form-control" name="selecli" id="selecli"> 
                      <option value="">--Seleccione una opcion--</option>
                      @foreach($cliente as $cli)
                      <option value="{{$cli->id_cliente}}">{{$cli->Nombre_Completo}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Id Empleado</label>
                    <input type="number" id="idemp" name="idemp" class="form-control" value="{{ Auth::user()->idEmpleado }}" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Total Pago</label>
                    <?php 
                    $subtotal = \Cart::getTotal();
                    $iva = $subtotal * 0.13;
                    $total = $subtotal + $iva;
                    ?>
                    <input type="number" id="totals" name="totals" class="form-control" step="0.01" readonly value="{{ number_format($total, 2) }}">
                  </div>  
                  <div class="form-group col-md-3">
                    <label>Tarjetas</label>
                    <select class="form-control" name="typecard" id="typecard">
                      <option value="0">--Seleccione su tipo de tarjeta--</option>
                      @foreach($tarjeta as $card)
                      <option value="{{$card->idTarjetas}}">{{$card->NombreTarjetas}}</option>
                      @endforeach
                    </select>
                  </div>                    
                </div>                  
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Producto</label>
                    <input id="txtprod" list="productos" class="form-control custom-select" name="producto">
                    <datalist id="productos">
                      @foreach($productos as $prod)
                      <option value="{{$prod->idProducto}}">{{$prod->NombreProducto}}</option>
                      @endforeach
                    </datalist>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Precio</label>
                    <input type="number" id="precio" name="precio" class="form-control" step="0.01" readonly>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Cantidad <span class="badge badge-danger" id="msj"></span></label>
                    <input type="number" class="form-control" min="1" max="" name="cantidad" id="cantidad" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                  </div>
                  <div class="col-md-3">
                    <label for="formGroupExampleInput2">&nbsp;</label>
                    <button type="button" class="btn btn-success btn-block" id="btnAgregarP">Agregar</button>
                  </div>                                         
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Codigo</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Precio</th>
                      <th scope="col">Cantidad</th>
                      <th scope="col">Categoria</th>
                      <th scope="col">Costo Total</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody id="new-projects">

                  </tbody>           
                </table>                 
              </form>
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

  <div class="modal" tabindex="-1" role="dialog" id="modalBorrar">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmacion de eliminar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Realmente desea eliminar el registro?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnBorrar">Si, borrar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/factura.js') }}"></script>
  <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('js/contras.js') }}"></script>  
  @include('sweet::alert')  
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>    
  <script>
    $("#txtcf").blur(function(){
    //Obtengo el identificador que automaticamente el 
    //data list pone en el input
    var dataImputBefore = $("#txtcf").val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });    

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxClientes') }}",
      data:{'id':dataImputBefore},
      success:function(datos){      
        if (datos.vacio == "true") {
          $('#duicf').val("");
          $('#nitcf').val("");
          $('#telefonocf').val("");   
        }else{
          $('#duicf').val(datos.dui);
          $('#nitcf').val(datos.nit);
          $('#telefonocf').val(datos.tel);          
        }
      }
    });

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxCreditos') }}",
      data:{'id':dataImputBefore},
      success:function(datos){      
        if (datos.vacio == "true") {
          $('#limitcredit').val("");
          $('#cuota').val("");
          $('#diascredit').val("");   
          $('#total').val("");
          $("#total").css("background-color","");
          $("#total").css("color","");
        }else{
          $('#limitcredit').val((Math.round(datos.saldo * 100) / 100).toFixed(2));
          $('#cuota').val((Math.round(datos.cuota * 100) / 100).toFixed(2));
          $('#diascredit').val(datos.dias);          
          $('#total').val((Math.round(datos.disponible * 100) / 100).toFixed(2));

          if (datos.disponible > 0) {
            $("#total").css("background-color","#b3ff96");
            $("#total").css("color","#000");
          }else{
            $("#total").css("background-color","#ff958c");
            $("#total").css("color","#fff");
          }        
        }
      }
    });    
    
    //Lo seteo en un atributo del input para usarlo mas tarde
    $("#txtcf").prop('data-value',dataImputBefore);
    
    //Busco en el datalist el option correspondiente al id que se obtuvo
    var elementOption = $("#clientes option[value='"+dataImputBefore+"']")
    
    //Como ya guarde el id en una propiedad data-value del input
    //ya puedo poner el valor que quiero mostrar realmente en el input
    //este valor lo obtengo del option que encontre en el paso anterior.
    //Lo tengo en la propiedad text
    $("#txtcf").val(elementOption.text());

    $("#selecli > option").each(function() {
      if (this.value == dataImputBefore) {
        $('[name=selecli] option').filter(function() {
          return ($(this).val() == dataImputBefore);
        }).prop('selected', true);
      }             
    }); 
  });    

    $('#txtcf').on('change',function(){
    //Obtengo el id del data value
    var idValue = $('#txtcf').prop("data-value");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });    

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxClientes') }}",
      data:{'id':idValue},
      success:function(datos){      
        $('#duicf').val(datos.dui);
        $('#nitcf').val(datos.nit);
        $('#telefonocf').val(datos.tel);       
      }
    });

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxCreditos') }}",
      data:{'id':idValue},
      success:function(datos){       
        $('#limitcredit').val((Math.round(datos.saldo * 100) / 100).toFixed(2));
        $('#cuota').val((Math.round(datos.cuota * 100) / 100).toFixed(2));
        $('#diascredit').val(datos.dias);      
        $('#total').val((Math.round(datos.disponible * 100) / 100).toFixed(2));

        if (datos.disponible > 0) {
          $("#total").css("background-color","#b3ff96");
          $("#total").css("color","#000");
        }else if (datos.disponible < 0) {
          $("#total").css("background-color","#ff958c");
          $("#total").css("color","#fff");
        }else{
          $("#total").css("background-color","");
          $("#total").css("color","");
        }
      }
    });   

  });

    function AgregarClientes(){
      $.ajax({
        url : "{{ url('/ajaxgetClientes') }}",
        success:function(datos){
          //Creamos una variable que servira para crear los option del select
          var op = '';
          //variable para recorrer el for
          var i;

          //recorremos los datos recibidos, con datos.length obtenemos la longitud del arreglo
          //osea, numero de registros recibidos
          for(i=0; i<datos.length; i++){
            //en la variable op vamos guardando cada registro obtenido del modelo            
            
            op +="<option value='"+datos[i].id_cliente+"'> "+datos[i].Nombre_Completo+"</option>";

          }
          //al select con el id curso le entregamos la variable op que contiene los option
          $('#clientes').html(op);
          $('#selecli').html(op);
        }
      });  
    }

    $("#btnAgregar").click( function(){

      var nombre = $("input[name=nombrenc]").val();
      var dui = $("input[name=duinc]").val();
      var nit = $("input[name=nitnc]").val();
      var telefono = $("input[name=telnc]").val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });    

      $.ajax({
        type : 'POST',
        url : "{{ url('/ajaxClienteNuevo') }}",
        data:{'nombre':nombre, 'dui':dui, 'nit':nit, 'tel':telefono},
        success:function(datos){
          $("input[name=nombrenc]").val("");   
          $("input[name=duinc]").val("");   
          $("input[name=nitnc]").val("");   
          $("input[name=telnc]").val("");
          $('#btnFrecuente').trigger('click');


          $('#clientes')
          .find('option')
          .remove()
          .end();

          $('#selecli')
          .find('option')
          .remove()
          .end();

          AgregarClientes()
        }
      });
    });

    $("#msj").hide();
    $( "#new-projects" ).load( "{{ url('/carrito') }} #cart #products" );
    $("#txtprod").blur(function() {
    //Obtengo el identificador que automaticamente el 
    //data list pone en el input
    var dataImputBefore = $("#txtprod").val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });    

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxPrecio') }}",
      data:{'id':dataImputBefore},
      success:function(datos){      
        if (datos.vacio == "true") {
          $('#precio').val("");    
        }else{
          $('#precio').val((Math.round(datos.precio * 100) / 100).toFixed(2));
          $("#cantidad").attr("max", datos.stock);         
        }
      }
    });    
    
    //Lo seteo en un atributo del input para usarlo mas tarde
    $("#txtprod").prop('data-value',dataImputBefore);
    
    //Busco en el datalist el option correspondiente al id que se obtuvo
    var elementOption = $("#productos option[value='"+dataImputBefore+"']")
    
    //Como ya guarde el id en una propiedad data-value del input
    //ya puedo poner el valor que quiero mostrar realmente en el input
    //este valor lo obtengo del option que encontre en el paso anterior.
    //Lo tengo en la propiedad text
    $("#txtprod").val(elementOption.text());
  });

    $('#txtprod').on('change',function(){
    //Obtengo el id del data value
    var idValue = $('#txtprod').prop("data-value");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });    

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxPrecio') }}",
      data:{'id':idValue},
      success:function(datos){
        $('#precio').val((Math.round(datos.precio * 100) / 100).toFixed(2));
        $("#cantidad").attr("max", datos.stock);     
      }
    });    

  });
    $("#cantidad").keyup(function(){
    //Obtengo el id del data value
    var idValue = $('#txtprod').prop("data-value");

    var dInput = this.value;

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });    

    $.ajax({
      type : 'POST',
      url : "{{ url('/ajaxStock') }}",
      data:{'id':idValue},
      success:function(datos){     

        if (dInput > datos.stock) {
          $('#msj').text('Cantidad supera al limite de stock');
          $('#btnAgregarP').prop('disabled', true);
          $('#msj').show("slow");
        }else{       
          $('#msj').hide("slow");
          $('#btnAgregarP').prop('disabled', false);
          $('#msj').text('');   
        }
      }
    });
  });

    $("#btnAgregarP").click( function(){

      var id = $('#txtprod').prop("data-value");
      var precio = $("input[name=precio]").val();
      var cantidad = $("input[name=cantidad]").val();

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });    

      $.ajax({
        type : 'POST',
        url : "{{ url('/ajaxAgregar') }}",
        data:{'id':id, 'precio':precio, 'cantidad':cantidad},
        success:function(datos){
          $( "#new-projects" ).load( "{{ url('/carrito') }} #cart #products" );
          $('#totals').val((Math.round(datos.total * 100) / 100).toFixed(2));
        }
      });
    });

//cuando damos click al boton eliminar de cada registro de la tabla_alumnos se ejecutara lo siguiente
$('#new-projects').on('click', '.borrar', function(){
      $id = $(this).attr('data');//para capturar el dato segun el boton que demos click
      $('#modalBorrar').modal('show'); //Para mostrar el modal de confirmacion de eliminar
      //con unbind().click lo que estamos definiendo es que ESPERE a que presionemos el boton
      //del modal confirmando la eliminacion
      $('#btnBorrar').unbind().click(function() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 

        //Definimos que trabajaremos con ajax
        $.ajax({         
          //tipo de solicitud a realizar
          type : 'POST',
          //direccion hacia donde enviaremos la informacion (controlador/metodo)
          url : "{{ url('/ajaxRemover') }}", 
          //datos a enviar, $id es el valor capturado anteriomente del boton
          data: {id:$id},
        //Si la peticion fue exitosa recibiremos una respuesta, en este caso en la variable "respuesta" recibiremos 
        //TRUE o FALSE que nos devolvera el modelo
        success: function(datos){
            $('#modalBorrar').modal('hide'); //Para ocultar el modal
            $( "#new-projects" ).load( "{{ url('/carrito') }} #cart #products" );
            $('#totals').val((Math.round(datos.total * 100) / 100).toFixed(2));
          }
        });
        
      });

    });

$("#valefect").blur(function(){

  var a = parseFloat(this.value);
  var b = parseFloat($('#totals').val());

  var c = a - b;

  $('#cambio').val((Math.round(c * 100) / 100).toFixed(2));

});

$('#valefect').keypress(function(event) {
  var $this = $(this);
  if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
   ((event.which < 48 || event.which > 57) &&
     (event.which != 0 && event.which != 8))) {
   event.preventDefault();
}

var text = $(this).val();
if ((event.which == 46) && (text.indexOf('.') == -1)) {
  setTimeout(function() {
    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
      $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
    }
  }, 1);
}

if ((text.indexOf('.') != -1) &&
  (text.substring(text.indexOf('.')).length > 2) &&
  (event.which != 0 && event.which != 8) &&
  ($(this)[0].selectionStart >= text.length - 2)) {
  event.preventDefault();
}      
});

var duinc = document.getElementById("duinc");
var nitnc = document.getElementById("nitnc");
var telnc = document.getElementById("telnc");
var duicf = document.getElementById("duicf");
var nitcf = document.getElementById("nitcf");
var telefonocf = document.getElementById("telefonocf");

var im1 = new Inputmask("99999999-9", { "clearIncomplete": true });
im1.mask(duinc);

var im2 = new Inputmask("9999-999999-999-9", { "clearIncomplete": true });
im2.mask(nitnc);

var im3 = new Inputmask("9999-9999", { "clearIncomplete": true });
im3.mask(telnc);

var im4 = new Inputmask("99999999-9", { "clearIncomplete": true });
im4.mask(duicf);

var im5 = new Inputmask("9999-999999-999-9", { "clearIncomplete": true });
im5.mask(nitcf);

var im6 = new Inputmask("9999-9999", { "clearIncomplete": true });
im6.mask(telefonocf);
</script>
</body>
</html>