<?php
//Especifico la ruta donde se encuentra este archivo
namespace App\Queries;
//Nombre de la clase
class FacturasQueries{
//Metodos que llamaran a mis consultas DB
    //Usuarios
    /*Fn: Devuelve el id del rol por medio del id del empleado
    @param: id del empleado
    @return: Id del Rol del Empleado en la DB*/
    public function ObtenerCargo($id)
    {
        return \DB::table('empleados')->select('idRol')->where('idEmpleado', '=', $id)->get();
    }
    //Facturas
    /*Fn: Devuelve un listado de Modo de Pago
    @param: na
    @return: Listados de Modo de Pagos en DB*/
    public function getModoPago()
    {
        return \DB::table('modopago')->select('idModoPago', 'nombre_pago')->get();
    }
    /*Fn: Devuelve un listado de Tipo de Pago
    @param: na
    @return: Listados de Tipo de Pagos en DB*/
    public function getTipoPago()
    {
        return \DB::table('tipopago')->select('idTipoPago', 'NombreTipoPago')->get();
    }
    /*Fn: Devuelve un listado de Clientes
    @param: na
    @return: Listados de Clientes en DB*/
    public function getClientes()
    {
        return \DB::table('clientes')->select('id_cliente', 'Nombre_Completo')->get();
    }
    /*Fn: Devuelve un Cliente por Medio del ID
    @param: id del Cliente
    @return: Informacion del Cliente que se encuentra en la DB*/
    public function getClientesID($id)
    {
        return \DB::table('clientes')->select('DUI', 'NIT', 'Telefono')->where('id_cliente', '=', $id)->get();
    }
    /*Fn: Devuelve un listado de Tarjetas de Credito
    @param: na
    @return: Listados de Tarjetas de Credito en DB*/
    public function getTarjetas()
    {
        return \DB::table('tarjetas')->select('idTarjetas', 'NombreTarjetas')->get();
    }
    /*Fn: Devuelve un listado de Productos
    @param: na
    @return: Listados de Productos en DB*/
    public function getProductos()
    {
        return \DB::table('productos')->select('idProducto', 'NombreProducto')->get();
    }
    /*Fn: Devuelve un Credito por Medio del ID del Cliente
    @param: id del Cliente
    @return: Informacion de Credito que se encuentra en la DB*/
    public function getClientesCreditos($id)
    {
        return \DB::table('clientes')->join('creditos', 'creditos.idCreditos', '=', 'clientes.idCredito')->select('creditos.Saldo_Actual', 'creditos.CuotaMensual', 'creditos.Dias_Credito')->where('id_cliente', '=', $id)->get();
    }
    /*Fn: Verifica si el id existe en la tabla factura
    @param: id de la Factura
    @return: Valor booleano si existe en la DB*/
    public function verificarID($id)
    {
        $fact = \DB::table('factura')->where('idFactura', '=', $id)->get();
        if ($fact->count() > 0) {
            return "true";
        }else{
            return "false";
        }
    }
    /*Fn: Inserta una Cliente
    @param: DUI, NIT, Nombre y Telefono del Cliente
    @return: Insecion del Cliente en la DB*/
    public function insertCliente($dui, $nit, $nombre, $telefono)
    {
        return \DB::table('clientes')->insert(['DUI' => $dui, 'NIT' => $nit, 'Nombre_Completo' => $nombre, 'Telefono'=> $telefono]);
    }
    /*Fn: Devuelve el Precio por Medio del ID del Producto
    @param: id del Producto
    @return: Precio y Cantidad del Producto en la DB*/
    public function getPricesProductos($id)
    {
        return \DB::table('productos')->select('PrecioPublico','Stock')->where('idProducto', '=', $id)->get();
    }
    /*Fn: Devuelve la Cantidad por Medio del ID del Producto
    @param: id del Producto
    @return: Cantidad del Producto en la DB*/
    public function getStockProductos($id)
    {
        return \DB::table('productos')->select('Stock')->where('idProducto', '=', $id)->get();
    }
    /*Fn: Devuelve un Producto por Medio del ID
    @param: id del Producto
    @return: Informacion de Producto que se encuentra en la DB*/
    public function getProductoID($id)
    {
        return \DB::table('productos')->join('categorias', 'categorias.idCategoria', '=', 'productos.idCategoria')->select('productos.CodigoProducto', 'productos.NombreProducto', 'categorias.NombreCategoria')->where('productos.idProducto', '=', $id)->get();
    }
    /*Fn: Inserta una Factura al Contado
    @param: Id Cliente, Id tipo de pago, id modo de pago, id empleado, fecha y el total
    @return: Ultimo Id Insertado en Factura en la DB*/
    public function insertFacturaContado($cliente, $tipo, $modo, $empleado, $fecha, $total)
    {
        \DB::table('factura')->insert(['idCliente' => $cliente, 'idTPago' => $tipo, 'idEmpleado' => $empleado, 'Fecha' => $fecha, 'Total_Pago' => $total, 'idModoPago' => $modo]);

        $last_id = \DB::getPDO()->lastInsertId();

        return $last_id;
    }
    /*Fn: Inserta un Detalle de la compra
    @param: id factura, id producto, la cantidad y precio del producto
    @return: Insecion del Detalle en la DB*/
    public function insertDetalles($factura, $producto, $cantidad, $precio)
    {
        return \DB::table('detalles_pf')->insert(['idFactura' => $factura, 'idProducto' => $producto, 'Cantidad' => $cantidad, 'Precio' => $precio]);
    }
    /*Fn: Modifica un Credito del Cliente
    @param: id del Cliente y el saldo que le queda disponible
    @return: Modificacion del Credito en la DB*/
    public function updateCredito($cliente, $saldo)
    {
        $idCredit = \DB::table('clientes')->select('idCredito')->where('id_cliente', '=', $cliente)->get();

        foreach ($idCredit as $row) {
            $id = $row->idCredito;
        }

        return \DB::table('creditos')->where('idCreditos', '=', $id)->update(['Saldo_Actual' => $saldo]);
    }
    /*Fn: Inserta una Factura al Credito
    @param: Id Cliente, Id tipo de pago, id empleado, fecha y el total
    @return: Ultimo Id Insertado en Factura en la DB*/
    public function insertFacturaCredito($cliente, $tipo, $empleado, $fecha, $total)
    {
        \DB::table('factura')->insert(['idCliente' => $cliente, 'idTPago' => $tipo, 'idEmpleado' => $empleado, 'Fecha' => $fecha, 'Total_Pago' => $total]);

        $last_id = \DB::getPDO()->lastInsertId();

        return $last_id;
    }
    /*Fn: Inserta una Factura al Contado con Tarjeta
    @param: Id Cliente, Id tipo de pago, id modo de pago, id empleado, fecha , total y tarjeta de credito
    @return: Ultimo Id Insertado en Factura en la DB*/
    public function insertFacturaContadoFactura($cliente, $tipo, $modo, $empleado, $fecha, $total, $tarjeta)
    {
        \DB::table('factura')->insert(['idCliente' => $cliente, 'idTPago' => $tipo, 'idEmpleado' => $empleado, 'Fecha' => $fecha, 'Total_Pago' => $total, 'idModoPago' => $modo, 'idTarjeta' => $tarjeta]);

        $last_id = \DB::getPDO()->lastInsertId();

        return $last_id;
    }
    //Consultas de Graficas
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las veces que compraron al contado
    @param: na
    @return: Listados de facturas en la DB*/
    public function getClientesFactContados()
    {
        return \DB::table('factura')->join('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', \DB::raw('COUNT(factura.idFactura) as Cantidad'))->where('factura.idTPago', '=', 2)->groupBy('clientes.Nombre_Completo')->orderByRaw('Cantidad DESC')->limit(3)->get();

    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las veces que compraron al credito
    @param: na
    @return: Listados de facturas en la DB*/
    public function getClientesFactCredito()
    {
        return \DB::table('factura')->join('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', \DB::raw('COUNT(factura.idFactura) as Cantidad'))->where('factura.idTPago', '=', 1)->groupBy('clientes.Nombre_Completo')->orderByRaw('Cantidad DESC')->limit(3)->get();

    }
    /*Fn: Devuelve un listado de las facturas que han sido efectuadas por los cajeros
    @param: na
    @return: Listados de facturas en la DB*/
    public function getCajerosFact()
    {
        return \DB::table('factura')->join('empleados', 'empleados.idEmpleado', '=', 'factura.idEmpleado')->select(\DB::raw("CONCAT(empleados.Nombre, ' ', empleados.Apellido) as Cajero"), \DB::raw('COUNT(factura.idFactura) as Cantidad'))->where('empleados.idRol', '=', 1)->groupBy('Cajero')->orderByRaw('Cantidad DESC')->get();

    }
    /*Fn: Devuelve un listado de las facturas efectuadas por meses
    @param: na
    @return: Listados de facturas en la DB*/
    public function getFacturasMeses()
    {
        \DB::statement("SET lc_time_names = 'es_ES'");

        return \DB::table('factura')->select(\DB::raw("MONTH(Fecha) as IdMes"), \DB::raw("CONCAT(UCASE(LEFT(MONTHNAME(Fecha), 1)), SUBSTRING(MONTHNAME(Fecha), 2)) as Mes"), \DB::raw('COUNT(idFactura) as Cantidad'))->groupBy('IdMes','Mes')->orderByRaw('IdMes ASC')->get();

    }
    /*Fn: Devuelve un listado de las facturas efectuadas por dias
    @param: na
    @return: Listados de facturas en la DB*/
    public function getFacturasDias()
    {
        \DB::statement("SET lc_time_names = 'es_ES'");

        return \DB::table('factura')->select('Fecha', \DB::raw('COUNT(idFactura) as Cantidad'))->groupBy('Fecha')->orderByRaw('Fecha ASC')->get();

    }
    /*Fn: Devuelve un listado de las facturas efectuadas por meses
    @param: na
    @return: Listados de facturas en la DB*/
    public function getFacturasAño()
    {
        return \DB::table('factura')->select(\DB::raw("YEAR(Fecha) as Año"), \DB::raw('COUNT(idFactura) as Cantidad'))->groupBy('Año')->orderByRaw('Año ASC')->get();

    }
    /*Fn: Devuelve un listado de la cantidad de Comprar por Tipo de Pago
    @param: na
    @return: Listados de facturas en la DB*/
    public function getFacturasTipoPago()
    {
        return \DB::table('factura')->leftJoin('tipopago', 'tipopago.idTipoPago', '=', 'factura.idTPago')->select('tipopago.idTipoPago', 'tipopago.NombreTipoPago', \DB::raw('COUNT(factura.idFactura) as Cantidad'))->groupBy('tipopago.idTipoPago', 'tipopago.NombreTipoPago')->orderByRaw('tipopago.idTipoPago ASC')->get();

    }
    //Listados con detalles
    /*Fn: Devuelve un listado de las facturas que contengan las ventas realizadas por el cajero conectado
    @param: id del Empleado
    @return: Listados de facturas en la DB*/
    public function getFacturas($id)
    {
        return \DB::table('factura')->join('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->join('tipopago', 'tipopago.idTipoPago', '=', 'factura.idTPago')->select('factura.idFactura', 'factura.Fecha', 'clientes.Nombre_Completo', 'factura.Total_Pago', 'tipopago.NombreTipoPago')->where('factura.idEmpleado', '=', $id)->get();

    }
    /*Fn: Devuelve un listado de las facturas que contengan las ventas realizadas por el cajero conectado
    @param: id del Empleado
    @return: Listados de facturas en la DB*/
    public function getFactura($id)
    {
        return \DB::table('factura')->where('idFactura', '=', $id)->get();
    }
    /*Fn: Devuelve un Detalle de la compra por Medio del ID de la Factura
    @param: id de la Factura
    @return: Informacion de Detalle que se encuentra en la DB*/
    public function getdetalle($factura)
    {
        return \DB::table('detalles_pf')->join('productos', 'productos.idProducto', '=', 'detalles_pf.idProducto')->join('categorias', 'categorias.idCategoria', '=', 'productos.idCategoria')->select('productos.CodigoProducto', 'productos.NombreProducto', 'productos.Descripcion', 'categorias.NombreCategoria', 'detalles_pf.Cantidad', 'productos.PrecioPublico', 'detalles_pf.Precio')->where('idFactura', '=', $factura)->get();
    }
    /*Fn: Devuelve un Cliente por Medio del ID
    @param: id del Cliente
    @return: Informacion del Cliente que se encuentra en la DB*/
    public function getClienteID($id)
    {
        return \DB::table('clientes')->select('Nombre_Completo', 'Telefono')->where('id_cliente', '=', $id)->get();
    }
    /*Fn: Devuelve un Tipo de Pago por Medio del ID
    @param: id del Tipo de Pago
    @return: Informacion del Tipo de Pago que se encuentra en la DB*/
    public function getTipoPagoID($id)
    {
        return \DB::table('tipopago')->select('NombreTipoPago')->where('idTipoPago', '=', $id)->get();
    }
    /*Fn: Devuelve un Modo de Pago por Medio del ID
    @param: id del Modo de Pago
    @return: Informacion del Modo de Pago que se encuentra en la DB*/
    public function getModoPagoID($id)
    {
        return \DB::table('modopago')->select('nombre_pago')->where('idModoPago', '=', $id)->get();
    }
    /*Fn: Devuelve una Tarjeta por Medio del ID
    @param: id de la Tarjeta
    @return: Informacion de la Tarjeta que se encuentra en la DB*/
    public function getTarjetasID($id)
    {
        return \DB::table('tarjetas')->select('NombreTarjetas')->where('idTarjetas', '=', $id)->get();
    }
    /*Fn: Devuelve un Empleado por Medio del ID
    @param: id del Empleado
    @return: Informacion del Empleado que se encuentra en la DB*/
    public function getEmpleadoID($id)
    {
        return \DB::table('empleados')->select(\DB::raw("CONCAT(Nombre, ' ', Apellido) as Nombre_Completo"))->where('idEmpleado', '=', $id)->get();
    }
    //Reporte de Creditos / Contados
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado
    @param: na
    @return: Listados de facturas en la DB*/
    public function getContado()
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->where('factura.idTPago', '=', 2)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al credito
    @param: na
    @return: Listados de facturas en la DB*/
    public function getCredito()
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->where('factura.idTPago', '=', 1)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al credito
    @param: fecha inicial, fecha final
    @return: Listados de facturas en la DB*/
    public function getCreditoFechas($inicial, $final)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->whereBetween('factura.Fecha', [$inicial, $final])->where('factura.idTPago', '=', 1)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al credito
    @param: fecha inicial, fecha final, cliente
    @return: Listados de facturas en la DB*/
    public function getCreditoFechas2($inicial, $final, $cliente)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->whereBetween('factura.Fecha', [$inicial, $final])->where([
            ['factura.idTPago', '=', 1],
            ['clientes.id_cliente', '=', $cliente],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al credito
    @param: cliente
    @return: Listados de facturas en la DB*/
    public function getCreditoFechas3($cliente)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->where([
            ['factura.idTPago', '=', 1],
            ['clientes.id_cliente', '=', $cliente],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado
    @param: fecha inicial, fecha final
    @return: Listados de facturas en la DB*/
    public function getContadoFechas($inicial, $final)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->whereBetween('factura.Fecha', [$inicial, $final])->where('factura.idTPago', '=', 2)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado
    @param: fecha inicial, fecha final, modo de pago
    @return: Listados de facturas en la DB*/
    public function getContadoFechas2($inicial, $final, $modo)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->whereBetween('factura.Fecha', [$inicial, $final])->where([
            ['factura.idTPago', '=', 2],
            ['factura.idModoPago', '=', $modo],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado
    @param: modo de pago
    @return: Listados de facturas en la DB*/
    public function getContadoFechas3($modo)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->where([
            ['factura.idTPago', '=', 2],
            ['factura.idModoPago', '=', $modo],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado con tarjetas
    @param: modo de pago, tarjetas
    @return: Listados de facturas en la DB*/
    public function getContadoFechas4($modo, $tarjeta)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->where([
            ['factura.idTPago', '=', 2],
            ['factura.idModoPago', '=', $modo],
            ['factura.idTarjeta', '=', $tarjeta],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas contengan las compras al contado con tarjetas
    @param: fecha inicial, fecha final, modo de pago, tarjetas
    @return: Listados de facturas en la DB*/
    public function getContadoFechas5($inicial, $final, $modo, $tarjeta)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('modopago', 'modopago.idModoPago', '=', 'factura.idModoPago')->leftJoin('tarjetas', 'tarjetas.idTarjetas', '=', 'factura.idTarjeta')->select('clientes.Nombre_Completo', 'clientes.Telefono', 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago','modopago.nombre_pago', \DB::raw("IFNULL(tarjetas.NombreTarjetas,'No Aplica') as nombre_tarjeta"))->whereBetween('factura.Fecha', [$inicial, $final])->where([
            ['factura.idTPago', '=', 2],
            ['factura.idModoPago', '=', $modo],
            ['factura.idTarjeta', '=', $tarjeta],
        ])->get();
    }
    /*Fn: Devuelve un Empleado por Medio del ID
    @param: id del Empleado
    @return: Informacion del Empleado que se encuentra en la DB*/
    public function getEmpleadoCajero()
    {
        return \DB::table('empleados')->select('idEmpleado',\DB::raw("CONCAT(Nombre, ' ', Apellido) as Nombre_Completo"))->where('idRol', '=', 1)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas fueron hechas por los cajeros
    @param: na
    @return: Listados de facturas en la DB*/
    public function getCajero()
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('empleados', 'empleados.idEmpleado', '=', 'factura.idEmpleado')->select('clientes.Nombre_Completo', \DB::raw("CONCAT(empleados.Nombre, ' ', empleados.Apellido) as Nombre_Cajero"), 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->where('empleados.idRol', '=', 1)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas fueron hechas por los cajeros
    @param: fecha inicial, fecha final
    @return: Listados de facturas en la DB*/
    public function getCajeroFechas($inicial, $final)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('empleados', 'empleados.idEmpleado', '=', 'factura.idEmpleado')->select('clientes.Nombre_Completo', \DB::raw("CONCAT(empleados.Nombre, ' ', empleados.Apellido) as Nombre_Cajero"), 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->whereBetween('factura.Fecha', [$inicial, $final])->where('empleados.idRol', '=', 1)->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas fueron hechas por los cajeros
    @param: fecha inicial, fecha final, cajero
    @return: Listados de facturas en la DB*/
    public function getCajeroFechas2($inicial, $final, $cajero)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('empleados', 'empleados.idEmpleado', '=', 'factura.idEmpleado')->select('clientes.Nombre_Completo', \DB::raw("CONCAT(empleados.Nombre, ' ', empleados.Apellido) as Nombre_Cajero"), 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->whereBetween('factura.Fecha', [$inicial, $final])->where([
            ['empleados.idRol', '=', 1],
            ['empleados.idEmpleado', '=', $cajero],
        ])->get();
    }
    /*Fn: Devuelve un listado de los clientes cuyas facturas fueron hechas por los cajeros
    @param: cajero
    @return: Listados de facturas en la DB*/
    public function getCajeroFechas3($cajero)
    {
        return \DB::table('factura')->leftJoin('clientes', 'clientes.id_cliente', '=', 'factura.idCliente')->leftJoin('empleados', 'empleados.idEmpleado', '=', 'factura.idEmpleado')->select('clientes.Nombre_Completo', \DB::raw("CONCAT(empleados.Nombre, ' ', empleados.Apellido) as Nombre_Cajero"), 'factura.idFactura', 'factura.Fecha', 'factura.Total_Pago')->where([
            ['empleados.idRol', '=', 1],
            ['empleados.idEmpleado', '=', $cajero],
        ])->get();
    }
}
