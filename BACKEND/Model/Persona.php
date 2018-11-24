<?php

class Persona implements JsonSerializable{

    private $id;
    private $nombre;
    private $apellido;
    private $mail;
    private $telefono;
    private $nroDocumento;
    private $tipoDocumento;
    private $esActivo;
    private $esUsuario;
    private $usuario;
    
    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getNombre(): string{
        return $this->nombre;
    }
 
    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }

    public function getApellido(): string{
        return $this->apellido;
    }

    public function setApellido(string $apellido): void{
        $this->apellido = $apellido;
    }

    public function getMail(): string{
        return $this->mail;
    }

    public function setMail(string $mail): void{
        $this->mail = $mail;
    }

    public function getTelefono(): int{
        return $this->telefono;
    }
    
    public function setTelefono(int $telefono): void{
        $this->telefono = $telefono;
    }

    public function getNroDocumento(): int{
        return $this->nroDocumento;
    }

    public function setNroDocumento(int $nroDocumento): void{
        $this->nroDocumento = $nroDocumento;
    }

    public function getTipoDocumento(): string{
        return $this->tipoDocumento;
    }

    public function setTipoDocumento(string $tipoDocumento): void{
        $this->tipoDocumento = $tipoDocumento;
    }
    
    public function getEsUsuario(): bool{
        return $this->esUsuario;
    }

    public function setEsUsuario(bool $esUsuario): void{
        $this->esUsuario = $esUsuario;
    }

    public function getEsActivo(): ?bool{
        return $this->esActivo;
    }

    public function setEsActivo(?bool $esActivo): void{
        $this->esActivo = $esActivo;
    }

    public function getUsuario(): Usuario{
        return $this->usuario;
    }
    
    public function setUsuario(Usuario $usuario): void{
        $this->usuario = $usuario;
    }

    public function jsonSerialize(): Array {
        return [
            'id'            => $this->id,
            'nombre'        => $this->nombre,
            'apellido'      => $this->apellido,
            'mail'          => $this->mail,
            'telefono'      => $this->telefono,
            'nroDocumento'  => $this->nroDocumento,
            'tipoDocumento' => $this->tipoDocumento,
            'esUsuario'     => $this->esUsuario,
            'activo'        => $this->esActivo,
            'usuario'       => $this->usuario
        ];
    }
}