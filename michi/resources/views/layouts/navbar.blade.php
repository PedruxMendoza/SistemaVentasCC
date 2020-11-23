    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            @if ($rol == 1)            
            <div class="sb-sidenav-menu-heading">Cajero</div>
            @else
            <div class="sb-sidenav-menu-heading">Supervisor</div>
            @endif            
            <a class="nav-link" href="{{ url('/home') }}"
            ><div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
            Inicio</a
            >
            @if ($rol == 1)            
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
            ><div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
            Facturas
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
              ></a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="{{ url('/factura') }}">Generar Facturas</a><a class="nav-link" href="{{ url('/listado') }}">Mostrar Facturas</a></nav>
              </div>              
            @else
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
            ><div class="sb-nav-link-icon"><i class="fas fa-paste"></i></div>
            Reportes
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
              ></a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="{{ url('/credito') }}">Credito</a><a class="nav-link" href="{{ url('/contado') }}">Contado</a><a class="nav-link" href="{{ url('/cajero') }}">Cajeros</a><a class="nav-link" href="{{ url('/graficas') }}">Graficas</a></nav>
              </div>
            @endif
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Conectado como:</div>
            {{ Auth::user()->name }}
          </div>
        </nav>
      </div>