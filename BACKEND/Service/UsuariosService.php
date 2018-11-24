<?php

require_once '../Repository/UsuarioRepository.php';

class UsuariosService{
    private $repository;

    public function __construct(){
        $this->repository = new UsuarioRepository();
    }

    public function getAll():Array{
        return $this->repository->getAll();
    }

    public function get(int $id): Usuario{
        return $this->repository->get($id);
    }

    public function create(Usuario $usuario): Usuario{
        return $this->create($usuario);
    }

    public function update(Usuario $usuario): void{        
        $this->update($usuario);
    }
}
?>