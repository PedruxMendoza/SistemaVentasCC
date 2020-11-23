<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queries\FacturasQueries;

class HomeController extends Controller
{
    //Se almacenará en una propiedad  heredable.
    protected $FacturasQueries; 
    //En el método constructor, se pasará para poder utilizarlo cuando desee dentro de la clase.   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
    public function index()
    {
        $contado = $this->FacturasQueries->getClientesFactContados();
        $credito = $this->FacturasQueries->getClientesFactCredito();
        $cargo = $this->FacturasQueries->ObtenerCargo(\Auth::user()->idEmpleado);
        foreach ($cargo as $row) {
            $rol = $row->idRol;
        }        
        return view('home', compact(['contado', 'credito', 'rol']));
    }

    public function error404()
    {
        return view('error.404');
    }
}
