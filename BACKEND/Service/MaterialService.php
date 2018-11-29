<?php
require_once '../Repository/MaterialRepository.php';

class MaterialService
{
    private $repository;

    public function __construct() {
        $this->repository = new MaterialRepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($empresaEsterilizadora): ?Material {
        return $this->repository->get($empresaEsterilizadora);
    }

    public function create($material): Material{
        return $this->repository->create($material);
    }

}