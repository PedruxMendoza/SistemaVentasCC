<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{{ asset('img/Logo3.png') }}}">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet"> 
</head>
<body>
  @include('sweet::alert')   
  <div class="sidenav">
   <div class="login-main-text">
    <h2>Contraseña Olvidada</h2>
    <p>Ingrese su correo electronico a continuación y le enviaremos una contraseña nueva temporal.</p>
  </div>
</div>
<div class="main">
 <div class="col-md-6 col-sm-12">
  <div class="login-form">
    <form action="{{ url('/enviado') }}" method="POST">
     {{ csrf_field() }}
     <div class="form-group">
      <label for="email">{{ __('E-Mail Address') }}</label>
      <input id="email" type="text" name="email" class="form-control" required autocomplete="email" autofocus>
    </div>
    <div class="form-group">
      <button type="submit" id='btn-contact' class="btn btn-black">Enviar</button>
    </div>
  </form>
</div>
</div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $("#email").inputmask({ alias: "email" , "clearIncomplete": true});
  });
</script>
</body>
</html>
