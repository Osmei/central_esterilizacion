<?php
require_once '../Repository/MaterialRepository.php';
require_once '../Commons/Exceptions/BadRequestMultipleException.php';
require_once '../Commons/Exceptions/UnauthorizedException.php';

class MaterialService
{
    private $repository;

    public function __construct() {
        $this->repository = new MaterialRepository();
    }

    public function getAll(): Array {
        return $this->repository->getAll();
    }

    public function get($id): ?Material {
        return $this->repository->get($id);
    }

    public function create($material): Material{
        $arrayExcepciones = Array();

        if($material->getPaciente() == null){
            array_push($arrayExcepciones, "El campo 'Paciente' no puede ser vacío");
        }
        if(!is_numeric($material->getNumeroHistoriaClinica())){
            array_push($arrayExcepciones, "El campo 'Número de Historia Clínica' debe ser numérico");
        }
        if($material->getDescripcionMaterial() == null){
            array_push($arrayExcepciones, "El campo 'Descripción Material' no puede ser vacío");
        }
        if($material->getProveedor() == null){
            array_push($arrayExcepciones, "El campo 'Proveedor' no puede ser vacío");
        }
        
        if(count($arrayExcepciones) > 0){
            throw new BadRequestMultipleException($arrayExcepciones);
        }
        
        return $this->repository->create($material);
    }

}