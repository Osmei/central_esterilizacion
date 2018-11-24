<?php

require_once '../Repository/DeterminacionRepository.php';

class DeterminacionesService{
    private $repository;

    public function __construct(){
        $this->repository = new DeterminacionRepository();
    }

    public function getAll():Array{
        return $this->repository->getAll();
    }

    public function get(int $id): ?Determinacion{
        return $this->repository->get($id);
    }

    public function create(Determinacion $determinacion): Determinacion{
        return $this->repository->create($determinacion);
    }

    public function update(Determinacion $determinacion): void{        
        $this->repository->update($determinacion);
    }

    public function grilla() {        
        return $this->repository->grilla();
    }
}
?>