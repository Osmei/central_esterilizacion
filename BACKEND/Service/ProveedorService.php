<?php
require_once '../Repository/ProveedorRepository.php';

class ProveedorService
{
    private $repository;

    public function __construct() {
        $this->repository = new ProveedorRepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($proveedor): ?Proveedor {
        return $this->repository->get($proveedor);
    }

}