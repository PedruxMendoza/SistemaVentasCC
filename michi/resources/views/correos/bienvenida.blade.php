<!doctype html>
<html lang="es">
    <body>
    	<?php date_default_timezone_set('America/El_Salvador'); ?>
        <h1>¡Olvidaste la Contraseña, {{$nombre}} !</h1>
        <p>Este dia <?php echo date('d-m-Y') ?>, a las <?php echo date('h:i') ?> has solicitado la recuperacion de su cuenta. Te hemos cambiados tu credenciales temporalmente. En este correo te enviaremos una contraseña temporal con la siguiente informacion :)</p>
        <h4>Correo: {{$correo}}</h4>
		<h4>Contraseña: {{$contraseña}}</h4>
    </body>
</html>