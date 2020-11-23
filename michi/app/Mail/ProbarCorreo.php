<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ProbarCorreo extends Mailable
{

    public $nombre;
    public $correo;
    public $contraseña;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $correo, $contraseña)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("correos/bienvenida")
            ->from("pete.mendoza93@gmail.com")
            ->subject("Cambio de Contraseña");
    }


}