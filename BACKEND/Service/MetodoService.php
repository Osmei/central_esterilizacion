<?php
require_once '../Repository/MetodoRepository.php';

class MetodoService
{
    private $repository;

    public function __construct() {
        $this->repository = new MetodoRepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($metodo): ?Metodo {
        return $this->repository->get($metodo);
    }

}