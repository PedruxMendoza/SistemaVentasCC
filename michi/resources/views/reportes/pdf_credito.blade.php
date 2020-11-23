<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        @font-face {
          font-family: "Nunito";
          font-style: normal;
          font-weight: 400;
          src: url("{{ resource_path('assets/fonts/Nunito/Nunito-Regular.ttf') }}");
          /* IE9 Compat Modes */
          src: 
          local("Nunito"), 
          local("Nunito"), 
          url("{{ resource_path('assets/fonts/Nunito/Nunito-Regular.ttf') }}") format("truetype");
      }        

      body {
        font-family: "Nunito", sans-serif;
        margin: 3cm 2cm 2cm;
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        background-color: #343A40;
        color: white;
        text-align: center;
        line-height: 30px;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        background-color: #343A40;
        color: white;
        text-align: center;
        line-height: 35px;
        clear: both;
    }
    table.table-style-one {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#333333;
        border-width: 1px;
        border-color: #3A3A3A;
        border-collapse: collapse;
        width: 100%;
    }
    table.table-style-one th {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #3A3A3A;
        background-color: #B3B3B3;
    }
    table.table-style-one td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #3A3A3A;
        background-color: #ffffff;
    }    
</style>
</head>
<body>
    <header>
        <h1>Reporte de Ventas al Credito</h1>
    </header>

    <main>
        <h1>Ventas efectuadas al credito</h1>       
        @if (is_null($clientes) && is_null($inicio) && is_null($final))

        @else
        @if (is_null($clientes))
        <?php 
        $formato = 'Y/m/d';
        $fechai = DateTime::createFromFormat($formato, $inicio);
        $fechaf = DateTime::createFromFormat($formato, $final);
        ?>
        <h2>del {{$fechai->format('d M Y')}} al {{$fechaf->format('d M Y')}}</h2>
        @else
        @if (is_null($inicio) && is_null($final))
        @foreach($cliente as $cli) 
        <h2>por {{$cli->Nombre_Completo}}</h2>
        @endforeach
        @else
        <?php 
        $formato = 'Y/m/d';
        $fechai = DateTime::createFromFormat($formato, $inicio);
        $fechaf = DateTime::createFromFormat($formato, $final);
        ?>
        @foreach($cliente as $cli) 
        <h2>por {{$cli->Nombre_Completo}} del {{$fechai->format('d M Y')}} al {{$fechaf->format('d M Y')}}</h2>
        @endforeach
        @endif 
        @endif  
        @endif        
        <!-- Table goes in the document BODY -->
        <table class="table-style-one">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Cliente</th>
                    <th>Telefono</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($credito as $row)
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
                    <td>${{ number_format($row->Total_Pago, 2) }}</td>
                </tr>
                @empty
                <tr>                    
                    <td colspan="5" align="center"><p>No existen Facturas, Por favor intente de nuevo!</p></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </main>
    <footer>
        <h5>Copyright &copy; Cool Sales 2020</h5>
    </footer>
</body>
</html>