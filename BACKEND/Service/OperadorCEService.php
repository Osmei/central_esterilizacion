<?php
require_once '../Repository/OperadorCERepository.php';

class OperadorCEService
{
    private $repository;

    public function __construct() {
        $this->repository = new OperadorCERepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($operadorCE): ?OperadorCE {
        return $this->repository->get($operadorCE);
    }

}