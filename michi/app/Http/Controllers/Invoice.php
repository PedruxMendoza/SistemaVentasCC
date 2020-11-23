<?php

namespace App\Http\Controllers;
//LLAMANDO A MI CLASE FACTURASQUERIES
use App\Queries\FacturasQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Cart;
use PDF;

class Invoice extends Controller
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
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*Fn: Mostrar vista principal de Factura
    @param: na
    @return: Vista Principal */     
    public function index()
    {
        $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 1) {
            //Declaramos el correlativo para despues usarlo para generar el correlativo
            $corre='';
            //Declaramos el contador para poder buscar un ID inicializado en 0
            $contador = 0;
            /*Entramos a un bucle para poder buscar el id que se encuentre en el DB y le pido el método que llamara a la consulta y traera si ese ID se encuentra disponible*/
            //Mietras el ID de hobbie se encuentre ya en uso            
            do  {
                $contador++;    //Se aumentara en 1
                //Almaceno el resultado en una variable $resp, llamo a la propiedad y le pido el método que llamara a la consulta para comprobar el id y traera el booleano                
                $resp = $this->FacturasQueries->verificarID($contador);

                if ($contador > 0 AND $contador <= 9)
                {
                    $corre =  'PHP000'.$contador;
                }
                else if($contador >= 10 AND $contador <= 99)
                {
                    $corre =  'PHP00'.$contador;
                }
                else if($contador >= 100 AND $contador <= 999)
                {
                    $corre =  'PHP0'.$contador;
                }
                else if($contador >= 1000 AND $contador <= 9999)
                {
                    $corre =  'PHP'.$contador;
                }

            }while($resp == "true"); //Finalizara hasta que encuentre un false en este ciclo
            //Llamo a la propiedad y le pido el método que llamara a la insercion del resultador del contador asi como tambien los datos que mando a pedir con el form de agregar hobbies
            $modo = $this->FacturasQueries->getModoPago();
            $tipo = $this->FacturasQueries->getTipoPago();
            $cliente = $this->FacturasQueries->getClientes();
            $tarjeta = $this->FacturasQueries->getTarjetas();
            $productos = $this->FacturasQueries->getProductos();
            $items = Cart::getContent();
            return view('factura.factura', compact(['modo', 'tipo', 'cliente', 'tarjeta', 'productos', 'corre', 'items', 'rol']));            
        }else{
            return redirect()->action('HomeController@error404');     
        }
    }
    /*Fn: Mostrar vista principal de Carrito
    @param: na
    @return: Vista Principal */ 
    public function carrito()
    {
        $items = Cart::getContent();
        return view('factura.carrito', compact(['items']));
    }        
    /*Fn: Devuelve un cliente
    @param: Objeto de tipo Request
    @return: Informacion del Cliente en formato json */ 
    public function ajaxDailyCustomer(Request $request)
    {
    	$id = $request->id;
    	$customer = $this->FacturasQueries->getClientesID($id);
    	foreach ($customer as $row) {
    		$array = array('dui' => $row->DUI, 'nit' => $row->NIT, 'tel' => $row->Telefono);
    	}
        if (empty($array)) 
        {
            $array = array('vacio' => "true");
            return response()->json($array);
        }
        else{
            return response()->json($array);
        }        
    }    
    /*Fn: Devuelve un credito de un cliente en especifico
    @param: Objeto de tipo Request
    @return: Informacion del Credito en formato json */ 
    public function ajaxCreditCustomer(Request $request)
    {
        $id = $request->id;
        $credit = $this->FacturasQueries->getClientesCreditos($id);
        foreach ($credit as $row) {
            $meses = $row->Dias_Credito * 0.0328549112;
            $subtot = $row->CuotaMensual * $meses;
            $iva = $subtot * 0.13;
            $total = $subtot + $iva;             
            $saldo = $row->Saldo_Actual - $total;
            $array = array('saldo' => $row->Saldo_Actual, 'cuota' => $row->CuotaMensual, 'dias' => $row->Dias_Credito, 'disponible' => round($saldo, 2));
        }
        if (empty($array)) 
        {
            $array = array('vacio' => "true");
            return response()->json($array);
        }
        else{
            return response()->json($array);
        }        
    }
    /*Fn: Crea una nuevo Cliente
    @param: Objeto de tipo Request
    @return: Mensaje del resultado en formato json */ 
    public function ajaxNewCustomer(Request $request)
    {
        $nombre = $request->nombre;
        $dui = $request->dui;
        $nit = $request->nit;
        $telefono = $request->tel;
        $msj = $this->FacturasQueries->insertCliente($dui, $nit, $nombre, $telefono);
        $array = array('msj' => "success");
        return response()->json($array);        
    }
    /*Fn: Devuelve un listado de Clientes
    @param: na
    @return: Listados de Clientes en formato json */ 
    public function ajaxGetCustomer()
    {
        $customers = $this->FacturasQueries->getClientes();
        $array = $customers->toArray();
        return response()->json($array);     
    }
    /*Fn: Devuelve informacion de los productos
    @param: Objeto de tipo Request
    @return: Informacion de los Productos en formato json */ 
    public function ajaxPricesProductos(Request $request)
    {
        $id = $request->id;
        $prices = $this->FacturasQueries->getPricesProductos($id);
        foreach ($prices as $row) {
            $array = array('precio' => $row->PrecioPublico, 'stock' => $row->Stock);
        }
        if (empty($array)) 
        {
            $array = array('vacio' => "true");
            return response()->json($array);
        }
        else{
            return response()->json($array);
        }        
    }
    /*Fn: Devuelve cantidad de un producto
    @param: Objeto de tipo Request
    @return: Cantidad de un producto en formato json */ 
    public function ajaxStockProductos(Request $request)
    {
        $id = $request->id;
        $prices = $this->FacturasQueries->getStockProductos($id);
        foreach ($prices as $row) {
            $array = array('stock' => $row->Stock);
        }
        if (empty($array)) 
        {
            $array = array('vacio' => "true");
            return response()->json($array);
        }
        else{
            return response()->json($array);
        }        
    }
    /*Fn: Agrega un Producto al Carrito de Compras
    @param: Objeto de tipo Request
    @return: Mensaje del resultado en formato json */ 
    public function ajaxAddProducts(Request $request)
    {
        $id = $request->id;
        $cantidad = $request->cantidad;
        $precio = $request->precio;
        $producto = $this->FacturasQueries->getProductoID($id);
        foreach ($producto as $row) {
            Cart::add(array(
                'id' => $id,
                'name' => $row->NombreProducto,
                'price' => $precio,
                'quantity' => $cantidad,
                'attributes' => array(
                    'categoria' => $row->NombreCategoria,
                    'codigo' => $row->CodigoProducto
                )
            ));        
        }
        $subtotal = \Cart::getTotal();
        $iva = $subtotal * 0.13;
        $total = $subtotal + $iva;
        $array = array('total' => $total);
        return response()->json($array);        
    }
    /*Fn: Elimina un Producto del Carrito de Compras
    @param: Objeto de tipo Request
    @return: Mensaje del resultado en formato json */ 
    public function remover(Request $request){
        $id = $request->id;
        Cart::remove($id);
        $subtotal = \Cart::getTotal();
        $iva = $subtotal * 0.13;
        $total = $subtotal + $iva;        
        $array = array('total' => $total);
        return response()->json($array);  
    }
    /*Fn: Factura la Compra realizada
    @param: Objeto de tipo Request
    @return: PDF en forma del ticket de la compra */ 
    public function facturarContado(Request $request){

        $cliente = $request->selecli;
        $tipo = $request->pagos;
        $modo = $request->modo;
        $fecha = $request->fechaactual;
        $empleado = $request->idemp;
        $tarjeta = $request->typecard;
        //Contado
        $totapago = $request->totals;
        //Credito
        $dias = $request->diascredit;
        $cuota = $request->cuota;
        $saldo_act = $request->limitcredit;       

        if ($tipo == 1) {
            $meses = $dias * 0.0328549112;
            $subtot = $cuota * $meses;
            $iva = $subtot * 0.13;
            $total = $subtot + $iva; 
            $saldo = $saldo_act - $total;

            $factcredit = $this->FacturasQueries->insertFacturaCredito($cliente, $tipo, $empleado, $fecha, round($total, 2));

            $this->FacturasQueries->updateCredito($cliente, round($saldo, 2));

            $items = Cart::getContent();

            foreach ($items as $row) {
                $this->FacturasQueries->insertDetalles($factcredit, $row->id, $row->quantity, $row->getPriceSum());
            }

            $factura = $this->FacturasQueries->getFactura($factcredit);
            $detalles = $this->FacturasQueries->getdetalle($factcredit);
            foreach ($factura as $row) {
                $empleado = $this->FacturasQueries->getEmpleadoID($row->idEmpleado);          
            }
            $subtotal = 0;
            $iva = 0;
            foreach ($detalles as $items) {
                $subtotal += $items->Precio;          
            }
            $iva = $subtotal * 0.13;

            $pdf = PDF::loadView('factura.pdf', compact(['factura', 'detalles', 'empleado', 'subtotal', 'iva']));            

        }elseif ($tipo == 2) {
            $items = Cart::getContent();

            if (empty($tarjeta)) {
               $factcont = $this->FacturasQueries->insertFacturaContado($cliente, $tipo, $modo, $empleado, $fecha, $totapago);

           }else{
            $factcont = $this->FacturasQueries->insertFacturaContadoFactura($cliente, $tipo, $modo, $empleado, $fecha, $totapago, $tarjeta);}

            foreach ($items as $row) {
                $this->FacturasQueries->insertDetalles($factcont, $row->id, $row->quantity, $row->getPriceSum());
            }  

            $factura = $this->FacturasQueries->getFactura($factcont);
            $detalles = $this->FacturasQueries->getdetalle($factcont);
            foreach ($factura as $row) {
                $empleado = $this->FacturasQueries->getEmpleadoID($row->idEmpleado);          
            }
            $subtotal = 0;
            $iva = 0;
            foreach ($detalles as $items) {
                $subtotal += $items->Precio;          
            }
            $iva = $subtotal * 0.13;

            $pdf = PDF::loadView('factura.pdf', compact(['factura', 'detalles', 'empleado', 'subtotal', 'iva']));             
        }

        $customPaper = array(0,0,200,600);

        $pdf->setPaper($customPaper);

        Cart::clear();

        return $pdf->stream('ticket.pdf');   
    }
    /*Fn: Mostrar vista principal de las Facturas realizadas por el cajero
    @param: na
    @return: Vista Principal */  
    public function mostrarListado()
    {
        // Get the currently authenticated user's IDEmpleado...
        $id = Auth::user()->idEmpleado;        
        $cargo = $this->FacturasQueries->ObtenerCargo($id);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }
        if ($rol == 1) {
            $facturas = $this->FacturasQueries->getFacturas($id);
            return view('factura.listado', compact(['facturas', 'rol']));
        }else{
            return redirect()->action('HomeController@error404');   
        }
    }
    /*Fn: Mostrar vista principal del detalle de la Facturas
    @param: na
    @return: Vista Principal */ 
    public function mostrardetalles($id)
    {
        $id = base64_decode($id);
        $cargo = $this->FacturasQueries->ObtenerCargo(Auth::user()->idEmpleado);
        foreach ($cargo as $fila) {
            $rol = $fila->idRol;
        }
        if ($rol == 1) {
            $factura = $this->FacturasQueries->getFactura($id);
            $detalles = $this->FacturasQueries->getdetalle($id);
            foreach ($factura as $row) {
                $cliente = $this->FacturasQueries->getClienteID($row->idCliente);
                $tipo = $this->FacturasQueries->getTipoPagoID($row->idTPago);
                $empleado = $this->FacturasQueries->getEmpleadoID($row->idEmpleado);
                if (is_null($row->idModoPago)) {
                    $modo = '';
                }else{
                    $modo = $this->FacturasQueries->getModoPagoID($row->idModoPago);  
                }
                if (is_null($row->idTarjeta)) {
                    $tarjeta = '';
                }else{
                    $tarjeta = $this->FacturasQueries->getTarjetasID($row->idTarjeta);  
                }            
            }
            $subtotal = 0;
            foreach ($detalles as $items) {
                $subtotal += $items->Precio;          
            }
            return view('factura.detalles', compact(['factura', 'detalles','modo', 'tipo', 'cliente', 'tarjeta', 'empleado', 'subtotal', 'rol']));            
        }else{
            return redirect()->action('HomeController@error404');   
        }
    }

}
