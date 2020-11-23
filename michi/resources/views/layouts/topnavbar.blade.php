  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/home') }}">Cool Sales</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
      >
      <!-- Navbar-->
      <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">Cambiar Contraseña</a>
              <div class="dropdown-divider"></div>            
              <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>                        
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="{{ url('/cambiarcontra') }}" method="POST" autocomplete="off" onsubmit="return validar()">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="d-lg-none">
                <label class="sr-only" for="usuario">Usuario</label>
                <div class="input-group-prepend">
                  <div class="input-group-text">Usuario</div>
                </div>
                <input type="number" class="form-control" id="usuario" name="usuario" value="{{ Auth::user()->id }}" readonly>
              </div>
              <div class="input-group mb-2">
                <label class="sr-only" for="pass1">Nueva Clave</label>
                <div class="input-group-prepend">
                  <div class="input-group-text">Nueva Clave</div>
                </div>
                <input type="password" class="form-control" id="pass1" name="newclave1" placeholder="Digite su nueva clave...">
              </div>
              <div class="input-group mb-2">
                <label class="sr-only" for="pass2">Nueva Clave</label>
                <div class="input-group-prepend">
                  <div class="input-group-text">Confirme su Nueva clave</div>
                </div>
                <input type="password" class="form-control" id="pass2" name="newclave2" placeholder="Confirme su nueva clave...">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <input type="submit" value="Guardar Contraseña" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>

    <script type="text/javascript">
            //Este script compara las contraseñas para saber si son identicas 
            //si lo son realiza el INSERT y si no muestra un mensaje de alerta 
            window.onload = function () {
              document.getElementById("pass1").onchange = validatePassword;
              document.getElementById("pass2").onchange = validatePassword;
            }
            function validatePassword(){
              var pass2=document.getElementById("pass2").value;
              var pass1=document.getElementById("pass1").value;
              if(pass1!=pass2)
                document.getElementById("pass1").setCustomValidity("Las contraseñas no coinciden");
              else
                document.getElementById("pass1").setCustomValidity('');  
              
            }
      //Fin del script
    </script>     