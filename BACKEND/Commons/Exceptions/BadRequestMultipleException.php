
<?php

class BadRequestMultipleException extends Exception {

    private $mensajes;

    public function __construct($messages) {
        $this->mensajes = $messages;
        
        parent::__construct("Errores: ");
    }

    public function getMensajes(){
        return $this->mensajes;
    }
 
    public function setMensajes($mensajes){
        $this->mensajes = $mensajes;
    }
}