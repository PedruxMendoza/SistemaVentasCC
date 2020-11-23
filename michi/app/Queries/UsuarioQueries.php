<?php
//Especifico la ruta donde se encuentra este archivo
namespace App\Queries;
//Nombre de la clase
class UsuarioQueries{
//Metodos que llamaran a mis consultas DB
    //Usuarios
    /*Fn: Verifica el usuario ingresado
    @param: email o correo electronico
    @return: conteo de usuarios que se encuentra en la DB*/
    public function Verificar($email)
    {
        $user = \DB::table('users')->where('email', '=', $email)->get();
        return $user->count();
    }
    /*Fn: Devuelve el id del empleado por medio del correo
    @param: email o correo electronico
    @return: Id del Empleado en la DB*/    
    public function ObtenerId($email)
    {
        return \DB::table('users')->select('idEmpleado')->where('email', '=', $email)->get();
    }
    /*Fn: Devuelve un Empleado por Medio del ID
    @param: id del Empleado
    @return: Informacion del Empleado que se encuentra en la DB*/
    public function getEmpleadoID($id)
    {
        return \DB::table('empleados')->select(\DB::raw("CONCAT(Nombre, ' ', Apellido) as Nombre_Completo"))->where('idEmpleado', '=', $id)->get();
    }
    /*Fn: Modifica la Contraseña del Usuario
    @param: email o correo electronico, contraseña
    @return: Modificacion del Usuario en la DB*/
    public function CambiarContraseña($email, $pass)
    {
        return \DB::table('users')->where('email', '=', $email)->update(['password' => $pass]);
    }
    /*Fn: Modifica la Contraseña del Usuario
    @param: id del Usuario, contraseña
    @return: Modificacion del Usuario en la DB*/
    public function CambiarContraseña2($id, $pass)
    {
        return \DB::table('users')->where('id', '=', $id)->update(['password' => $pass]);
    } 
}