<?php
require_once '../Repository/EmpresaEsterilizadoraRepository.php';

class EmpresaEsterilizadoraService
{
    private $repository;

    public function __construct() {
        $this->repository = new EmpresaEsterilizadoraRepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($empresaEsterilizadora): ?EmpresaEsterilizadora {
        return $this->repository->get($empresaEsterilizadora);
    }

}