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
    <h2>Login</h2>
    <p>Ingrese su correo y contraseña para iniciar sesion.</p>
  </div>
</div>
<div class="main">
 <div class="col-md-6 col-sm-12">
  <div class="login-form">
   <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
     <label>{{ __('E-Mail Address') }}</label>
     <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

     @error('email')
     <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="form-group">
   <label>{{ __('Password') }}</label>
   <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

   @error('password')
   <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>
<button type="submit" class="btn btn-black">{{ __('Login') }}</button>
<a class="btn btn-secondary" href="{{ url('/correolvidado') }}">Contraseña Olvidada</a>
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
