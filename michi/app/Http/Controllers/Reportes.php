<?php

namespace App\Http\Controllers;
//LLAMANDO A MI CLASE FACTURASQUERIES
use Illuminate\Http\Request;
use App\Queries\FacturasQueries;
use Illuminate\Support\Facades\Auth;
use PDF;

class Reportes extends Controller
{
    //Se almacenará en una propiedad  heredable.
	protected $FacturasQueries;
    //En el método constructor, se pasará para poder utilizarlo cuando desee dentro de la clase.
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*Fn: Constructor de la Clase
    @param: Objeto de tipo FacturasQueries
    @return: na */
    public function __construct(FacturasQueries $FacturasQueries)
    {
    	$this->middleware('auth');
    	$this->FacturasQueries = $FacturasQueries;
    }
    /*Fn: Mostrar vista principal de Facturas al Contado
    @param: na
    @return: Vista Principal */
    public function contado()
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $modo = $this->FacturasQueries->getModoPago();
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            $tarjeta = $this->FacturasQueries->getTarjetas();
            $contado = $this->FacturasQueries->getContado();
            return view('reportes.contado',compact(['rol', 'modo', 'contado', 'tarjeta']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar vista principal de Facturas al Credito
    @param: na
    @return: Vista Principal */
    public function credito()
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            $cliente = $this->FacturasQueries->getClientes();
            $credito = $this->FacturasQueries->getCredito();
            return view('reportes.credito',compact(['rol','credito', 'cliente']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar vista principal de Facturas realizadas por los Cajeros
    @param: na
    @return: Vista Principal */
    public function cajero()
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            $cajero = $this->FacturasQueries->getEmpleadoCajero();
            $cajeros = $this->FacturasQueries->getCajero();
            return view('reportes.cajero',compact(['rol','cajeros', 'cajero']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar vista principal de la busqueda realizada a los cajeros
    @param: Objeto de tipo Request
    @return: Vista Mostrando los Resultado de la Busqueda */
    public function mostrarcajero(Request $request)
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $inicio = $request->finicial;
            $final = $request->ffinal;
            $cashier = $request->cajero;
            $cajero = $this->FacturasQueries->getEmpleadoCajero();
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            if (empty($inicio) && empty($final) && empty($cashier)) {
                $cajeros = $this->FacturasQueries->getCajero();
            }else{
                if (empty($cashier)) {
                    $cajeros = $this->FacturasQueries->getCajeroFechas($inicio, $final);
                }else{
                    if (empty($inicio) && empty($final)) {
                        $cajeros = $this->FacturasQueries->getCajeroFechas3($cashier);
                    }elseif (empty($inicio) || empty($final)){
                        $cajeros = $this->FacturasQueries->getCajeroFechas3($cashier);
                    }else{
                        $cajeros = $this->FacturasQueries->getCajeroFechas2($inicio, $final, $cashier);
                    }
                }
            }
            return view('reportes.cajero',compact(['rol','cajeros', 'cajero']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar vista principal de la busqueda realizada al credito
    @param: Objeto de tipo Request
    @return: Vista Mostrando los Resultado de la Busqueda */
    public function mostrarcredito(Request $request)
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $inicio = $request->finicial;
            $final = $request->ffinal;
            $clientes = $request->cliente;
            $cliente = $this->FacturasQueries->getClientes();
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            if (empty($inicio) && empty($final) && empty($clientes)) {
                $credito = $this->FacturasQueries->getCredito();
            }else{
                if (empty($clientes)) {
                    $credito = $this->FacturasQueries->getCreditoFechas($inicio, $final);
                }else{
                    if (empty($inicio) && empty($final)) {
                        $credito = $this->FacturasQueries->getCreditoFechas3($clientes);
                    }elseif (empty($inicio) || empty($final)){
                        $credito = $this->FacturasQueries->getCreditoFechas3($clientes);
                    }else{
                        $credito = $this->FacturasQueries->getCreditoFechas2($inicio, $final, $clientes);
                    }
                }
            }
            return view('reportes.credito',compact(['rol','credito','cliente']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar vista principal de la busqueda realizada al contado
    @param: Objeto de tipo Request
    @return: Vista Mostrando los Resultado de la Busqueda */
    public function mostrarcontado(Request $request)
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $inicio = $request->finicial;
            $final = $request->ffinal;
            $modop = $request->modo;
            $cards = $request->tarjeta;
            $modo = $this->FacturasQueries->getModoPago();
            $tarjeta = $this->FacturasQueries->getTarjetas();
            $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
            foreach ($cargo as $row) {
                $rol = $row->idRol;
            }
            if (empty($inicio) && empty($final) && empty($modop) && empty($cards)) {
                $contado = $this->FacturasQueries->getContado();
            }else{
                if ($modop == 1){
                    if (empty($inicio) && empty($final)) {
                        $contado = $this->FacturasQueries->getContadoFechas3($modop);
                    }elseif (empty($inicio) || empty($final)){
                        $contado = $this->FacturasQueries->getContadoFechas3($modop);
                    }else{
                        $contado = $this->FacturasQueries->getContadoFechas2($inicio, $final, $modop);
                    }
                }elseif ($modop == 2){
                    if (empty($cards)) {
                        if (empty($inicio) && empty($final)) {
                            $contado = $this->FacturasQueries->getContadoFechas3($modop);
                        }elseif (empty($inicio) || empty($final)){
                            $contado = $this->FacturasQueries->getContadoFechas3($modop);
                        }else{
                            $contado = $this->FacturasQueries->getContadoFechas2($inicio, $final, $modop);
                        }
                    }else{
                        if (empty($inicio) && empty($final)) {
                            $contado = $this->FacturasQueries->getContadoFechas4($modop, $cards);
                        }elseif (empty($inicio) || empty($final)){
                            $contado = $this->FacturasQueries->getContadoFechas4($modop, $cards);
                        }else{
                            $contado = $this->FacturasQueries->getContadoFechas5($inicio, $final, $modop, $cards);
                        }
                    }
                }else{
                    $contado = $this->FacturasQueries->getContadoFechas($inicio, $final);
                }
            }
            return view('reportes.contado',compact(['rol', 'modo', 'contado', 'tarjeta']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
    /*Fn: Mostrar PDF de acuerdo a la busqueda realizada al contado
    @param: Objeto de tipo Request
    @return: PDF Mostrando los Resultado de la Busqueda */
    public function pdfcontado(Request $request)
    {
        $inicio = $request->finicial;
        $final = $request->ffinal;
        $modop = $request->modo;
        $cards = $request->tarjeta;
        if (empty($inicio) && empty($final) && empty($modop) && empty($cards)) {
            $contado = $this->FacturasQueries->getContado();
        }else{
            if ($modop == 1){
                if (empty($inicio) && empty($final)) {
                    $contado = $this->FacturasQueries->getContadoFechas3($modop);
                }elseif (empty($inicio) || empty($final)){
                    $contado = $this->FacturasQueries->getContadoFechas3($modop);
                }else{
                    $contado = $this->FacturasQueries->getContadoFechas2($inicio, $final, $modop);
                }
            }elseif ($modop == 2){
                if (empty($cards)) {
                    if (empty($inicio) && empty($final)) {
                        $contado = $this->FacturasQueries->getContadoFechas3($modop);
                    }elseif (empty($inicio) || empty($final)){
                        $contado = $this->FacturasQueries->getContadoFechas3($modop);
                    }else{
                        $contado = $this->FacturasQueries->getContadoFechas2($inicio, $final, $modop);
                    }
                }else{
                    if (empty($inicio) && empty($final)) {
                        $contado = $this->FacturasQueries->getContadoFechas4($modop, $cards);
                    }elseif (empty($inicio) || empty($final)){
                        $contado = $this->FacturasQueries->getContadoFechas4($modop, $cards);
                    }else{
                        $contado = $this->FacturasQueries->getContadoFechas5($inicio, $final, $modop, $cards);
                    }
                }
            }else{
                $contado = $this->FacturasQueries->getContadoFechas($inicio, $final);
            }
        }
        $modo = $this->FacturasQueries->getModoPagoID($modop);
        $tarjeta = $this->FacturasQueries->getTarjetasID($cards);
        $pdf = PDF::loadView('reportes.pdf_contado', compact(['modo','modop', 'contado', 'tarjeta','cards', 'inicio', 'final']));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('rep_contado.pdf');
    }
    /*Fn: Mostrar PDF de acuerdo a la busqueda realizada al credito
    @param: Objeto de tipo Request
    @return: PDF Mostrando los Resultado de la Busqueda */
    public function pdfcredito(Request $request)
    {
        $inicio = $request->finicial;
        $final = $request->ffinal;
        $clientes = $request->cliente;
        if (empty($inicio) && empty($final) && empty($clientes)) {
            $credito = $this->FacturasQueries->getCredito();
        }else{
            if (empty($clientes)) {
                $credito = $this->FacturasQueries->getCreditoFechas($inicio, $final);
            }else{
                if (empty($inicio) && empty($final)) {
                    $credito = $this->FacturasQueries->getCreditoFechas3($clientes);
                }elseif (empty($inicio) || empty($final)){
                    $credito = $this->FacturasQueries->getCreditoFechas3($clientes);
                }else{
                    $credito = $this->FacturasQueries->getContadoFechas2($inicio, $final, $clientes);
                }
            }
        }
        $cliente = $this->FacturasQueries->getClienteID($clientes);
        $pdf = PDF::loadView('reportes.pdf_credito', compact('credito','clientes', 'cliente', 'inicio', 'final'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('rep_credito.pdf');
    }
    /*Fn: Mostrar PDF de acuerdo a la busqueda realizada a los cajeros
    @param: Objeto de tipo Request
    @return: PDF Mostrando los Resultado de la Busqueda */
    public function pdfcajero(Request $request)
    {
        $inicio = $request->finicial;
        $final = $request->ffinal;
        $cashier = $request->cajero;
        if (empty($inicio) && empty($final) && empty($cashier)) {
            $cajeros = $this->FacturasQueries->getCajero();
        }else{
            if (empty($cashier)) {
                $cajeros = $this->FacturasQueries->getCajeroFechas($inicio, $final);
            }else{
                if (empty($inicio) && empty($final)) {
                    $cajeros = $this->FacturasQueries->getCajeroFechas3($cashier);
                }elseif (empty($inicio) || empty($final)){
                    $cajeros = $this->FacturasQueries->getCajeroFechas3($cashier);
                }else{
                    $cajeros = $this->FacturasQueries->getCajeroFechas2($inicio, $final, $cashier);
                }
            }
        }
        $cajero = $this->FacturasQueries->getEmpleadoID($cashier);
        $pdf = PDF::loadView('reportes.pdf_cajero', compact('cajeros','cashier', 'cajero', 'inicio', 'final'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('rep_cajero.pdf');
    }

    public function graficas()
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 2) {
            $cajeros = $this->FacturasQueries->getCajerosFact();
            $meses = $this->FacturasQueries->getFacturasMeses();
            $dias = $this->FacturasQueries->getFacturasDias();
            $anio = $this->FacturasQueries->getFacturasAño();
            $tipoPago = $this->FacturasQueries->getFacturasTipoPago();
            return view('reportes.graficas', compact(['rol', 'cajeros','meses', 'dias', 'anio', 'tipoPago']));
        }else{
            return redirect()->action('HomeController@error404');
        }
    }
}
