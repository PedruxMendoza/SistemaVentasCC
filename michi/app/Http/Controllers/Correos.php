<?php

namespace App\Http\Controllers;
//LLAMANDO A MI CLASE USUARIOQUERIES
use Illuminate\Http\Request;
use App\Queries\UsuarioQueries;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mail;

class Correos extends Controller
{
	//Se almacenará en una propiedad  heredable.	
	protected $UsuarioQueries;
    //En el método constructor, se pasará para poder utilizarlo cuando desee dentro de la clase.   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*Fn: Constructor de la Clase
    @param: Objeto de tipo UsuarioQueries
    @return: na */
    public function __construct(UsuarioQueries $UsuarioQueries)
    {
    	$this->UsuarioQueries = $UsuarioQueries;
    }
    /*Fn: Mostrar vista del formulario de contraseña olvidada
    @param: na
    @return: Vista Principal */ 
    public function index()
    {
    	return view('correos/olvidado');
    }
    /*Fn: Envia un correo con una contraseña temporal
    @param: Objeto de tipo Request
    @return: Vista Principal de Login */ 
    public function enviar(Request $request){
    	$destinatario = $request->email;
    	$num = $this->UsuarioQueries->Verificar($destinatario);
    	if ($num > 0) {
    		$empleado = $this->UsuarioQueries->ObtenerId($destinatario);
    		foreach ($empleado as $row) {
    			$id = $row->idEmpleado;
    		}
    		$empID = $this->UsuarioQueries->getEmpleadoID($id);
    		foreach ($empID as $row1) {
    			$nombre = $row1->Nombre_Completo;
    		}
			//Funcion que servira para generar la nueva contraseña
    		/***********************************************************/
    		function randomChars($str, $numChars){
    			return substr(str_shuffle($str), 0, $numChars);
    		}
			//CARACTERES QUE SE TOMARAN PARA GENERAR LA NUEVA CONTRASEÑA
    		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			//Se llama a la funcion para que tome 6 letras del string enviado y el resultado que devuelva se guardara
			//en la variable nueva, dicha variable se enviara al usuario
    		$nueva = randomChars($string, 8);
    		/***********************************************************/			
    		// Armar correo y pasarle datos para el constructor
    		$this->UsuarioQueries->CambiarContraseña($destinatario, Hash::make($nueva));
    		$correo = new \App\Mail\ProbarCorreo($nombre, $destinatario, $nueva);
			# ¡Enviarlo!
    		Mail::to($destinatario)->send($correo);
    		alert()->success('Se envio su contraseña al correo especificado!', 'Correo enviado!')->persistent('Close');
    		return redirect('/login');
    	}else{
    		alert()->error('El correo no se encuentra registrado!', 'Error en correo!')->persistent('Close');
    		return redirect()->back();
    	}
    }
    /*Fn: Cambiar la Contraseña de un usuario ingresado
    @param: Objeto de tipo Request
    @return: Pagina Donde estaba antes */ 
    public function CambiarContra(Request $request)
    {
    	$usuario = $request->usuario;
    	$newclave = $request->newclave1;
    	$num = $this->UsuarioQueries->CambiarContraseña2($usuario, Hash::make($newclave));
    	if ($num > 0) {
    		alert()->success('La proxima vez, inicie con su nueva contraseña!', 'Contraseña Modificada!')->persistent('Close');
    		return redirect()->back();
    	}else{
    		alert()->error('Ha escrito mal su contraseña, Por favor intentelo de Nuevo!', 'Error en Contraseña!')->persistent('Close');
    		return redirect()->back();
    	}
    }	
}
